<?php

namespace App\Http\Controllers\Api;

use App\Billing\PaymentGatewayContract;
use App\Events\RepairOrdersAssignedEvent;
use App\Http\Controllers\ApiController;
use App\Http\Resources\BrandSelectResource;
use App\Http\Resources\DefectDetailResource;
use App\Http\Resources\DeviceSelectResource;
use App\Http\Resources\RepairLogResource;
use App\Http\Resources\RepairOrderTrackResource;
use App\Http\Resources\RepairPrioritySelectResource as RPSResource;
use App\Http\Resources\RepairStatusResource as RSResource;
use App\Http\Resources\UserAsTechnicianResource as UATResource;
use App\Models\Brand;
use App\Models\Defect;
use App\Models\Device;
use App\Models\RepairOrder;
use App\Models\RepairPriority;
use App\Models\RepairStatus;
use App\Models\User;
use App\Notifications\Repair\DeviceDispatchRepairOrder;
use App\Notifications\Repair\RepairOrdersAssigned;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RepairOrderAxillaryController extends ApiController
{
    public function __construct()
    {
        $this->middleware(
            'auth:sanctum',
            ['only' => ['assignUser', 'sendDispatchReminder', 'quickActions', 'filters']]
        );
        $this->middleware('captcha', ['only' => ['track']]);
    }

    /**
     * Assign repair order to user
     *
     * @param Request     $request     request
     * @param RepairOrder $repairOrder repairOrder
     *
     * @return JsonResponse
     */
    public function assignUser(Request $request, RepairOrder $repairOrder): JsonResponse
    {
        $repairOrder->update(['user_id' => $request->user]);
        $repairOrder->user->notify((new RepairOrdersAssigned($this->master()->getNotificationConfig($repairOrder), $repairOrder))->locale(config('app.locale')));
        return response()->json(['message' => __('Data updated successfully')]);
    }

    /**
     * Sends a dispatch reminder.
     *
     * @param      \App\Models\RepairOrder  $repairOrder  The repair order
     *
     * @return     JsonResponse             The json response.
     */
    public function sendDispatchReminder(RepairOrder $repairOrder): JsonResponse
    {
        $repairOrder->notify(
            (new DeviceDispatchRepairOrder($this->master()->getNotificationConfig($repairOrder)))
                ->locale($this->master()->app_locale)
        );
        return response()->json(['message' => __('Dispatch reminder has been sent successfully')]);
    }

    /**
     * Perform quick action to selected repair orders
     *
     * @param Request $request request
     *
     * @return JsonResponse
     */
    public function quickActions(Request $request): JsonResponse
    {
        $action = $request->action;
        $orders = RepairOrder::whereIn('id', $request->orders);

        if ($orders->count() < 1) {
            return response()->json(
                [
                    'message' => __('You have not selected or no permissions to perform action'),
                ],
                403
            );
        }

        switch ($action) {
            case 'technician':
                $orders->update(['user_id' => $request->value]);
                foreach ($orders->get() as $repair) {
                    RepairOrdersAssignedEvent::dispatch($repair, $this->master()->getNotificationConfig($repair));
                }
                return response()->json(
                    ['message' => __('Repair order assigned to the selected technician')]
                );
                break;
            case 'delete':
                foreach ($orders->get() as $repairOrder) {
                    $repairOrder->defects()->sync([]);
                    $repairOrder->delete();
                }

                return response()->json(
                    ['message' => __('The selected repair orders have been deleted')]
                );
                break;
            default:
                return response()->json(
                    ['message' => __('Quick action not found')],
                    404
                );
                break;
        }
    }

    /**
     * Brand list for repair form
     *
     * @return JsonResponse
     */
    public function brandList(): JsonResponse
    {
        return response()->json(
            [
                'brands' => BrandSelectResource::collection(Brand::get()),
                'priorities' => RPSResource::collection(RepairPriority::get()),
            ]
        );
    }

    /**
     * Brand's devices list form storage
     *
     * @param Request $request request
     *
     * @return JsonResponse
     */
    public function brandDevices(Request $request): JsonResponse
    {
        $devices = Device::where('brand_id', $request->brand_id)->get();
        return response()->json(DeviceSelectResource::collection($devices));
    }

    /**
     * Device's services for repairing
     *
     * @param Request $request request
     *
     * @return JsonResponse
     */
    public function deviceDefects(Request $request): JsonResponse
    {
        $defects = Defect::where('device_id', $request->device_id)->get();
        return response()->json(DefectDetailResource::collection($defects));
    }

    /**
     * Repair order filters
     *
     * @return JsonResponse
     */
    public function filters(): JsonResponse
    {
        return response()->json(
            [
                'statuses' => RSResource::collection(RepairStatus::get()),
                'priorities' => RPSResource::collection(RepairPriority::get()),
                'technicians' => UATResource::collection(User::get()),
            ]
        );
    }

    /**
     * Track repair order
     *
     * @param Request $request request
     *
     * @return JsonResponse
     */
    public function track(Request $request): JsonResponse
    {
        $order = RepairOrder::where('tracking', $request->track_id)->first();
        if (!$order) {
            return response()->json(['message' => __('Track identity code did not match or order not found')]);
        }
        return response()->json(
            [
                'repair' => new RepairOrderTrackResource($order),
                'logs' => RepairLogResource::collection($order->repairLogs),
            ]
        );
    }

    /**
     * Display tax setting parameters
     *
     * @return JsonResponse
     */
    public function getTax(): JsonResponse
    {
        return response()->json(
            collect($this->master())->only(
                ['tax_rate', 'is_tax_fix', 'is_tax_included']
            )
        );
    }

    /**
     * Pay due amount of repair order
     *
     * @param      \App\Models\RepairOrder              $repairOrder  The repair order
     * @param      \App\Billing\PaymentGatewayContract  $gateway      The gateway
     *
     * @return     JsonResponse                         The json response.
     */
    public function payDueAmount(RepairOrder $repairOrder, PaymentGatewayContract $gateway)
    {
        $result = $gateway->payDue($repairOrder);
        if ($result['success']) {
            $repairOrder->update([
                'pre_paid' => $result['pre_paid'],
                'payment_info' => $result['payment_info'],
                'payment_status' => $result['payment_status'],
            ]);
            return response()->json(
                [
                    'message' => __('Data saved successfully'),
                    'repair' => new RepairOrderTrackResource($repairOrder),
                    'logs' => RepairLogResource::collection($repairOrder->repairLogs),
                ]
            );
        } else {
            $errorString = "";
            foreach ($result->errors->deepAll() as $error) {
                $errorString .= 'Error: ' . $error->code . ": " . $error->message . "\n";
            }
            return response()->json(
                [
                    'message' => __('Something went wrong try again !'),
                    'errors' => $errorString,
                ],
                500
            );
        }
    }
}
