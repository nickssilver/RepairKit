<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Requests\SettingAppearanceRequest;
use App\Http\Requests\SettingGeneralRequest;
use App\Http\Requests\SettingLocalizationRequest;
use App\Http\Requests\SettingSeoRequest;
use App\Http\Resources\Language\LanguageResource;
use App\Http\Resources\UserRoleResource;
use App\Models\Language;
use App\Models\UserRole;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SettingController extends ApiController
{

    protected $settings;

    protected $collection;

    /**
     * Construct middleware and initialize master app settings
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->middleware('demo')->only(
            [
                'setGeneral',
                'setSeo',
                'setAppearance',
                'setLocalization',
            ]
        );
        $this->settings = $this->master();
        $this->collection = collect($this->settings);
    }

    /**
     * Display general setting parameters
     *
     * @return JsonResponse
     */
    public function getGeneral(): JsonResponse
    {
        return response()->json(
            $this->collection->only(
                [
                    'app_url', 'app_name', 'app_https',
                    'app_address', 'app_phone', 'app_about',
                    'is_accepting_repair_order',
                    'is_processing_without_pay',
                    'portfolio_status', 'send_notification',
                ]
            )
        );
    }

    /**
     * Update general setting parameters
     *
     * @param SettingGeneralRequest $general generalRequest
     *
     * @return JsonResponse
     */
    public function setGeneral(SettingGeneralRequest $general): JsonResponse
    {
        $this->settings->update($general->validated());
        return response()->json(
            ['message' => __('Settings updated successfully')]
        );
    }

    /**
     * Display seo setting parameters
     *
     * @return JsonResponse
     */
    public function getSeo(): JsonResponse
    {
        return response()->json(
            $this->collection->only(
                ['meta_home_title', 'meta_keywords', 'meta_description']
            )
        );
    }

    /**
     * Update seo setting parameters
     *
     * @param SettingSeoRequest $seoRequest seoRequest
     *
     * @return JsonResponse
     */
    public function setSeo(SettingSeoRequest $seoRequest): JsonResponse
    {
        $this->settings->update($seoRequest->validated());
        return response()->json(
            ['message' => __('Settings updated successfully')]
        );
    }

    /**
     * Display appearance setting parameters
     *
     * @return JsonResponse
     */
    public function getAppearance(): JsonResponse
    {
        return response()->json(
            $this->collection->only(['app_icon', 'app_background'])
        );
    }

    /**
     * Update appearance setting parameters
     *
     * @param SettingAppearanceRequest $request request
     *
     * @return JsonResponse
     */
    public function setAppearance(SettingAppearanceRequest $request): JsonResponse
    {
        $validated = $request->validated();
        if ($request->file('icon')) {
            $validated['app_icon'] = $request->file('icon')
                ->store('appearance/icon', 'public');
        }
        if ($request->file('background')) {
            $validated['app_background'] = $request->file('background')
                ->store('appearance/background', 'public');
        }
        $this->settings->update($validated);
        return response()->json(
            ['message' => __('Settings updated successfully')]
        );
    }

    /**
     * Display localization setting parameters
     *
     * @return JsonResponse
     */
    public function getLocalization(): JsonResponse
    {
        return response()->json(
            $this->collection->only(
                ['app_timezone', 'app_locale', 'app_date_locale', 'app_date_format']
            )
        );
    }

    /**
     * Update localization setting parameters
     *
     * @param SettingLocalizationRequest $localRequest request
     *
     * @return JsonResponse
     */
    public function setLocalization(SettingLocalizationRequest $localRequest): JsonResponse
    {
        $this->settings->update($localRequest->validated());
        return response()->json(
            ['message' => __('Settings updated successfully')]
        );
    }

    /**
     * User roles list
     *
     * @return JsonResponse
     */
    public function userRoles(): JsonResponse
    {
        return response()->json(UserRoleResource::collection(UserRole::all()));
    }

    /**
     * Languages list
     *
     * @return JsonResponse
     */
    public function languages(): JsonResponse
    {
        return response()->json(LanguageResource::collection(Language::all()));
    }

    public function optimize(Request $request): JsonResponse
    {
        switch ($request->action) {
            case 'optimize':
                \Artisan::call('optimize:clear');
                break;
            case 'cache':
                \Artisan::call('config:cache');
                \Artisan::call('config:clear');
                break;
            case 'storage_link':
                if (File::exists(public_path('/storage'))) {
                    File::delete(public_path('/storage'));
                }
                \Artisan::call('storage:link');
                break;
            case 'update':
                \Artisan::call('install:update');
                break;
            default:
                \Artisan::call('view:clear');
                break;
        }
        return response()->json([
            'message' => __('System performed successfully'),
            'output' => \Artisan::output(),
        ]);
    }
}
