<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\getBraintreeApi;
use App\Http\Controllers\Api\SettingController;
use App\Http\Requests\BraintreeGatewayRequest;
use App\Http\Requests\CashOnDeliveryGatewayRequest;
use App\Http\Requests\SquareGatewayRequest;
use App\Http\Requests\StripeGatewayRequest;
use Illuminate\Http\JsonResponse;

class PaymentGatewaysController extends SettingController
{

    /**
     * Construct middleware and initialize master app settings
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->middleware('demo')->only(
            [
                'setBraintreeApi',
                'setStripeApi',
                'setCodApi',
                'setSquareApi',
            ]
        );
        $this->settings   = $this->master();
        $this->collection = collect($this->settings);
    }

    /**
     * Display braintree setting parameters
     *
     * @return JsonResponse
     */
    public function getBraintreeApi(): JsonResponse
    {
        return response()->json(
            $this->collection->only(
                [
                    'bt_environment',
                    'bt_merchant_id',
                    'bt_public_key',
                    'bt_private_key',
                    'bt_state',
                ]
            )
        );
    }

    /**
     * Sets the braintree api.
     *
     * @param      \App\Http\Requests\BraintreeGatewayRequest  $braintree  The braintree
     *
     * @return     JsonResponse                                The json response.
     */
    public function setBraintreeApi(BraintreeGatewayRequest $braintree): JsonResponse
    {
        $this->settings->update($braintree->validated());
        return response()->json(
            ['message' => __('Settings updated successfully')]
        );
    }

    /**
     * Gets the stripe api.
     *
     * @return     JsonResponse  The stripe api.
     */
    public function getStripeApi(): JsonResponse
    {
        return response()->json(
            $this->collection->only(
                [
                    'stripe_state',
                    'stripe_pk',
                    'stripe_sk',
                    'stripe_currency',
                ]
            )
        );
    }

    /**
     * Sets the stripe api.
     *
     * @param      \App\Http\Requests\StripeGatewayRequest  $stripe  The stripe
     *
     * @return     JsonResponse                             The json response.
     */
    public function setStripeApi(StripeGatewayRequest $stripe): JsonResponse
    {
        $this->settings->update($stripe->validated());
        return response()->json(
            ['message' => __('Settings updated successfully')]
        );
    }

    /**
     * Gets the cod api.
     *
     * @return     JsonResponse  The cod api.
     */
    public function getCodApi(): JsonResponse
    {
        return response()->json(
            $this->collection->only(
                [
                    'cod_state',
                    'default_payment_gateway',
                ]
            )
        );
    }

    /**
     * Sets the cod api.
     *
     * @param      \App\Http\Requests\CashOnDeliveryGatewayRequest  $cod    The cod
     *
     * @return     JsonResponse                                     The json response.
     */
    public function setCodApi(CashOnDeliveryGatewayRequest $cod): JsonResponse
    {
        $this->settings->update($cod->validated());
        return response()->json(
            ['message' => __('Settings updated successfully')]
        );
    }

    /**
     * Gets the square api.
     *
     * @return     JsonResponse  The square api.
     */
    public function getSquareApi(): JsonResponse
    {
        return response()->json(
            $this->collection->only(
                [
                    'square_state',
                    'square_sandbox',
                    'square_application_id',
                    'square_location_id',
                    'square_token',
                    'square_currency',
                ]
            )
        );
    }

    /**
     * Sets the square api.
     *
     * @param      \App\Http\Requests\SquareGatewayRequest  $square  The square
     *
     * @return     JsonResponse                             The json response.
     */
    public function setSquareApi(SquareGatewayRequest $square): JsonResponse
    {
        $this->settings->update($square->validated());
        return response()->json(
            ['message' => __('Settings updated successfully')]
        );
    }
}
