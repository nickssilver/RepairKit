<?php

namespace App\Http\View\Composers;

use App\Models\CustomPage;
use App\Models\Faq;
use App\Models\Setting;
use Illuminate\View\View;

class AppComposer
{
    /**
     * Application configuration for injecting to views
     *
     * @param View $view view
     */
    public function compose(View $view)
    {
        $setting = Setting::find(1);

        $view->with('fav_icon', $setting->app_icon)
            ->with(
                'app_data',
                [
                    'url' => url('/'),
                    'name' => $setting->app_name,
                    'phone' => $setting->app_phone,
                    'address' => $setting->app_address,
                    'portal_about' => $setting->app_about,
                    'register' => $setting->app_user_registration,
                    'icon' => $setting->app_icon,
                    'background' => $setting->app_background,
                    'recaptcha_enabled' => $setting->recaptcha_enabled,
                    'recaptcha_public' => $setting->recaptcha_public,
                    'meta_home_title' => $setting->meta_home_title,
                    'app_date_format' => $setting->app_date_format,
                    'app_date_locale' => $setting->app_date_locale,
                    'app_timezone' => $setting->app_timezone,
                    'currency_symbol' => $setting->currency_symbol,
                    'currency_symbol_on_left' => $setting->currency_symbol_on_left,
                    'printer_sizes' => explode(',', config('printer.sizes')),
                    'is_demo_mode' => config('app.demo_mode'),
                    'version' => config('app.version'),
                    'braintree_state' => $setting->bt_state,
                    'braintree_client_token' => $this->braintreeToken(),
                    'braintree_with_paypal' => config('services.braintree.with_paypal'),
                    'is_acepting_repair' => $setting->is_accepting_repair_order,
                    'is_processing_without_pay' => $setting->is_processing_without_pay,
                    'cod_state' => $setting->cod_state,
                    'stripe_state' => $setting->stripe_state,
                    'stripe_pk' => config('services.stripe.public_key'),
                    'pages' => $this->customPageList(),
                    'faqs' => $this->faqList(),
                    'default_gateway' => $setting->default_payment_gateway,
                    'square_state' => $setting->square_state,
                    'square_sandbox' => (bool) config('services.square.sandbox'),
                    'square_application_id' => config('services.square.application_id'),
                    'square_location_id' => config('services.square.location_id'),
                    'synchronizer_dispay' => config('laravel-translatable-string-exporter.synchronizer_state', false),
                    'application_pack' => $this->getApplicationPack(),
                    'terms_conditions' => $setting->terms_conditions,
                    'time_date_formats' => config('date-time.formats'),
                ]
            );
    }

    public function getApplicationPack()
    {
        return config('app.pack', null);
    }

    public function faqList()
    {
        return Faq::get();
    }

    protected function customPageList()
    {
        return CustomPage::where('status', true)->get();
    }

    protected function braintreeToken()
    {
        $gateway = new \Braintree\Gateway(
            [
                'environment' => config('services.braintree.environment'),
                'merchantId' => config('services.braintree.merchant_id'),
                'publicKey' => config('services.braintree.public_key'),
                'privateKey' => config('services.braintree.private_key'),
            ]
        );
        try {
            return $gateway->ClientToken()->generate();
        } catch (\Exception $e) {
            return null;
        }
    }
}
