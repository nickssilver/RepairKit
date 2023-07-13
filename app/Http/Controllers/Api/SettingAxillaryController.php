<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\SettingController;
use App\Http\Requests\SettingAuthenticationRequest;
use App\Http\Requests\SettingCaptchaRequest;
use App\Http\Requests\SettingCurrencyRequest;
use App\Http\Requests\SettingOutgoingMailRequest;
use App\Http\Requests\SettingTaxRequest;
use App\Http\Requests\SettingTermsRequest;
use Illuminate\Http\JsonResponse;

class SettingAxillaryController extends SettingController
{

    /**
     * Construct middleware and initialize master app settings
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->middleware('demo')->only(
            [
                'getAuthentication',
                'setOutgoingMail',
                'setLogging',
                'setCaptcha',
                'setCurrency',
                'setTax',
            ]
        );
        $this->settings = $this->master();
        $this->collection = collect($this->settings);
    }

    /**
     * Display authentication setting parameters
     *
     * @return JsonResponse
     */
    public function getAuthentication(): JsonResponse
    {
        return response()->json(
            $this->collection->only(
                [
                    'app_user_registration', 'app_default_role', 'data_masking',
                ]
            )
        );
    }

    /**
     * Update authentication setting parameters
     *
     * @param SettingAuthenticationRequest $request request
     *
     * @return JsonResponse
     */
    public function setAuthentication(SettingAuthenticationRequest $request): JsonResponse
    {
        $this->settings->update($request->validated());
        return response()->json(
            ['message' => __('Settings updated successfully')]
        );
    }

    /**
     * Display outgoing mailing parameters
     *
     * @return JsonResponse
     */
    public function getOutgoingMail(): JsonResponse
    {
        return response()->json(
            [
                'mail' => $this->collection->only([
                    'mail_from_address',
                    'mail_from_name',
                    'mail_mailer',
                    'mail_encryption',
                    'mail_host',
                    'mail_password',
                    'mail_port',
                    'mail_username',
                    'mailgun_domain',
                    'mailgun_secret',
                    'mailgun_endpoint', 'queue_connection',
                ]),
                'command_2' => '/usr/bin/php  ' . base_path() . '/artisan schedule:run >> /dev/null',
                'command_1' => '/usr/local/bin/php  ' . base_path() . '/artisan schedule:run >> /dev/null',
            ]);
    }

    /**
     * Update outgoing mailing parameters
     *
     * @param SettingOutgoingMailRequest $outgoingMail request
     *
     * @return JsonResponse
     */
    public function setOutgoingMail(SettingOutgoingMailRequest $outgoingMail): JsonResponse
    {
        $this->settings->update($outgoingMail->validated());
        return response()->json(
            ['message' => __('Settings updated successfully')]
        );
    }

    /**
     * Display google captcha setting parameters
     *
     * @return JsonResponse
     */
    public function getCaptcha(): JsonResponse
    {
        return response()->json(
            $this->collection->only(
                [
                    'recaptcha_enabled', 'recaptcha_public', 'recaptcha_private',
                ]
            )
        );
    }

    /**
     * Update google captcha setting parameters
     *
     * @param SettingCaptchaRequest $captcha request
     *
     * @return JsonResponse
     */
    public function setCaptcha(SettingCaptchaRequest $captcha): JsonResponse
    {
        $this->settings->update($captcha->validated());
        return response()->json(
            ['message' => __('Settings updated successfully')]
        );
    }

    /**
     * Display currency setting parameters
     *
     * @return JsonResponse
     */
    public function getCurrency(): JsonResponse
    {
        return response()->json(
            $this->collection->only(
                [
                    'currency_symbol_on_left', 'currency_symbol',
                ]
            )
        );
    }

    /**
     * Update currency setting parameters
     *
     * @param SettingCurrencyRequest $currency request
     *
     * @return JsonResponse
     */
    public function setCurrency(SettingCurrencyRequest $currency): JsonResponse
    {
        $this->settings->update($currency->validated());
        return response()->json(
            ['message' => __('Settings updated successfully')]
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
            $this->collection->only(
                [
                    'tax_rate', 'is_tax_fix', 'is_tax_included', 'is_vat',
                ]
            )
        );
    }

    /**
     * Update tax setting parameters
     *
     * @param SettingTaxRequest $tax request
     *
     * @return JsonResponse
     */
    public function setTax(SettingTaxRequest $tax): JsonResponse
    {
        $this->settings->update($tax->validated());
        return response()->json(
            ['message' => __('Settings updated successfully')]
        );
    }

    /**
     * Gets the terms.
     *
     * @return     JsonResponse  The terms.
     */
    public function getTerms(): JsonResponse
    {
        return response()->json(
            $this->collection->only(['terms_conditions'])
        );
    }

    /**
     * Sets the terms.
     *
     * @param      \App\Http\Requests\SettingTermsRequest  $terms  The terms
     *
     * @return     JsonResponse                            The json response.
     */
    public function setTerms(SettingTermsRequest $terms): JsonResponse
    {
        $this->settings->update($terms->validated());
        return response()->json(
            ['message' => __('Settings updated successfully')]
        );
    }
}
