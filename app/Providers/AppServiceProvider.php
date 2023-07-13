<?php

namespace App\Providers;

use App\Billing\BrantreePaymentGateway;
use App\Billing\CashOnDeliveryPaymentGateway;
use App\Billing\ManualPaymentGateway;
use App\Billing\PaymentGatewayContract;
use App\Billing\SquarePaymentGateway;
use App\Billing\StripePaymentGateway;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(PaymentGatewayContract::class, function ($app) {
            switch (request()->payment_gateway_key) {
                case 'braintree_nonce':
                    return new BrantreePaymentGateway(request('payment_gateway_value'));
                    break;
                case 'stripe_token':
                    return new StripePaymentGateway(request('payment_gateway_value'));
                    break;
                case 'square_source_id':
                    return new SquarePaymentGateway(request('payment_gateway_value'));
                    break;
                case 'cod_process':
                    return new CashOnDeliveryPaymentGateway(request('payment_gateway_value'));
                    break;
                case 'biller':
                    return new ManualPaymentGateway(request('payment_gateway_value'));
                    break;
                default:
                    return abort(response()->json('Unauthorized', 401));
                    break;
            }
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Increase StringLength
        Schema::defaultStringLength(191);

        Str::macro('mask', function ($string, $character, $index, $length = null, $encoding = 'UTF-8') {
            if ('' === $character || !config('app.masking')) {
                return $string;
            }

            if (is_null($length) && PHP_MAJOR_VERSION < 8) {
                $length = mb_strlen($string, $encoding);
            }

            $segment = mb_substr($string, $index, $length, $encoding);

            if ('' === $segment) {
                return $string;
            }

            $start = mb_substr($string, 0, mb_strpos($string, $segment, 0, $encoding), $encoding);
            $end = mb_substr($string, mb_strpos($string, $segment, 0, $encoding) + mb_strlen($segment, $encoding));

            return $start . str_repeat(mb_substr($character, 0, 1, $encoding), mb_strlen($segment, $encoding)) . $end;
        });
    }
}
