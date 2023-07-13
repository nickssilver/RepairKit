<?php

namespace App\Http\Controllers\Api;

use App\Billing\PaymentGatewayContract;
use App\Events\DeviceDispatchRepairOrderEvent;
use App\Events\NewRepairOrderEvent;
use App\Http\Controllers\ApiController;
use App\Http\Requests\RepairOrderStoreRequest;
use App\Http\Requests\RepairOrderUpdateRequest;
use App\Http\Requests\WorkshopRepairOrderUpdateRequest;
use App\Http\Resources\RepairLogResource;
use App\Http\Resources\RepairOrderDetailResource;
use App\Http\Resources\RepairOrderResource;
use App\Models\RepairOrder;
use Auth;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RepairOrderController extends ApiController
{
    /**
     * Construct middleware
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['store']);
    }

    /**
     * Repair orders list for management
     *
     * @param Request $request request
     *
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $query = RepairOrder::query();
        if (Auth::user()->role_id > 1) {
            $query = $query->where('user_id', Auth::id());
        }
        $sort = $this->sort($request);
        $repairs = $query->filter($request->all())
            ->orderBy($sort['column'], $sort['order'])
            ->paginate((int) $request->get('perPage', 10));

        return response()->json(
            [
                'items' => RepairOrderResource::collection($repairs->items()),
                'pagination' => $this->pagination($repairs),
            ]
        );
    }

    /**
     * Store to database
     *
     * @param RepairOrderStoreRequest $request request
     *
     * @return JsonResponse
     */
    public function store(RepairOrderStoreRequest $request, PaymentGatewayContract $gateway): JsonResponse
    {
        $validated = $request->validated();
        $validated['tracking'] = time();
        $validated['uuid'] = Str::orderedUuid();
        $validated['send_notification'] = $this->master()->send_notification;
        try {
            \DB::beginTransaction();
            $result = $gateway->charge($validated);
            if ($result['success']) {
                $validated = $result['data'];
            } else {
                $errorString = "";
                foreach ($result->errors->deepAll() as $error) {
                    $errorString .= 'Error: ' . $error->code . ": " . $error->message . "\n";
                }
                \DB::rollback();
                return response()->json(
                    [
                        'message' => __('Something went wrong try again !'),
                        'errors' => $errorString,
                    ],
                    500
                );
            }

            if ($request->pre_paid) {
                $validated['pre_paid'] = $request->pre_paid;
                $due = $request->total_charges - $request->pre_paid;
                $validated['payment_status'] = $due < 1;
            }

            $repair = RepairOrder::create($validated);
            if (!$request->is_manual && $validated['defects']) {
                $repair->defects()->sync(
                    collect($validated['defects'])->map(
                        function ($defect) {
                            return $defect['id'];
                        }
                    )
                );
            }
            if ($this->getAdmin()) {
                NewRepairOrderEvent::dispatch($repair, $this->master()->getNotificationConfig($repair), $this->getAdmin(), $this->master()->getNotificationConfig($this->getAdmin(), true));
            }
            if (!$repair->is_device_collected) {
                DeviceDispatchRepairOrderEvent::dispatch($repair, $this->master()->getNotificationConfig($repair));
            }

            \DB::commit();
            return response()->json(
                [
                    'message' => __('Repair order place successfully'),
                    'order' => $repair,
                ]
            );
        } catch (Exception $e) {
            \DB::rollback();
            return response()->json(
                [
                    'message' => __('Something went wrong try again !'),
                    'errors' => $e->getMessage(),
                ],
                500
            );
        }
    }

    /**
     * Display specific resource
     *
     * @param RepairOrder $repairOrder repairOrder
     *
     * @return JsonResponse
     */
    public function show(RepairOrder $repairOrder): JsonResponse
    {
        return response()->json(
            [
                'repair' => new RepairOrderDetailResource($repairOrder),
                'logs' => RepairLogResource::collection($repairOrder->repairLogs),
            ]
        );
    }

    /**
     * Update specific repair order information
     *
     * @param RepairOrderUpdateRequest $request     request
     * @param RepairOrder   $repairOrder repairOrder
     *
     * @return JsonResponse
     */
    public function update(RepairOrderUpdateRequest $request, RepairOrder $repairOrder): JsonResponse
    {
        if (auth()->user()->userRole->checkPermission('edit_repair_order')) {
            $validated = $request->validated();
            $validated['payment_info'] = $request->payment_info;
            $validated['payment_status'] = $repairOrder->dueAmount($validated['pre_paid']) < 1;
            $repairOrder->update($validated);
            if (!$request->is_manual && $validated['defects']) {
                $repairOrder->defects()->sync(
                    collect($validated['defects'])->map(
                        function ($defect) {
                            return $defect['id'];
                        }
                    )
                );
            }
            return response()->json(
                [
                    'message' => __('Data saved successfully'),
                    'repair' => new RepairOrderDetailResource($repairOrder),
                ]
            );
        }
        return response()->json(
            ['message' => __('Forbidden, the server refuses to authorize')],
            403
        );
    }

    public function workshopUpdate(WorkshopRepairOrderUpdateRequest $request, RepairOrder $repairOrder): JsonResponse
    {
        if (auth()->user()->userRole->checkPermission('edit_repair_order')) {
            $validated = $request->validated();
            $validated['payment_info'] = $request->payment_info;
            $validated['payment_status'] = $repairOrder->dueAmount($validated['pre_paid']) < 1;
            $repairOrder->update($validated);
            return response()->json(
                [
                    'message' => __('Data saved successfully'),
                    'repair' => new RepairOrderDetailResource($repairOrder),
                ]
            );
        }
        return response()->json(
            ['message' => __('Forbidden, the server refuses to authorize')],
            403
        );
    }

    /**
     * Destroy specific repair order
     *
     * @param RepairOrder $repairOrder repairOrder
     *
     * @return JsonResponse
     */
    public function destroy(RepairOrder $repairOrder): JsonResponse
    {
        if (auth()->user()->userRole->checkPermission('remove_repair_order')) {
            $repairOrder->delete();
            return response()->json(['message' => __('Data removed successfully')]);
        }

        return response()->json(
            ['message' => __('Forbidden, the server refuses to authorize')],
            403
        );
    }
}
