<?php

namespace App\Models;

use dacoto\EnvSet\Facades\EnvSet;
use Illuminate\Database\Eloquent\Model;
use NotificationChannels\Twilio\TwilioChannel;
use Storage;

class Setting extends Model
{

    protected $fillable = [
        'app_name',
        'app_address',
        'app_phone',
        'app_https',
        'app_url',
        'app_about',
        'app_date_format',
        'app_date_locale',
        'app_default_role',
        'app_background',
        'app_icon',
        'app_locale',
        'app_timezone',
        'app_user_registration',
        'mail_from_name',
        'mail_from_address',
        'mail_mailer',
        'mail_host',
        'mail_username',
        'mail_password',
        'mail_port',
        'mail_encryption',
        'mailgun_domain',
        'mailgun_endpoint',
        'mailgun_secret',
        'meta_description',
        'meta_home_title',
        'meta_keywords',
        'recaptcha_enabled',
        'recaptcha_public',
        'recaptcha_private',
        'currency_symbol',
        'currency_symbol_on_left',
        'tax_rate',
        'is_tax_fix',
        'is_tax_included',
        'is_vat',
        'bt_environment',
        'bt_merchant_id',
        'bt_public_key',
        'bt_private_key',
        'bt_state',
        'is_accepting_repair_order',
        'is_processing_without_pay',
        'cod_state',
        'stripe_state',
        'stripe_pk',
        'stripe_sk',
        'stripe_currency',
        'sms_status',
        'sms_channel',
        'twilio_account_sid', 'twilio_auth_token', 'twilio_from',
        'nexmo_key', 'nexmo_secret', 'nexmo_from',
        'portfolio_status',
        'square_state',
        'square_sandbox',
        'square_application_id',
        'square_location_id',
        'square_token',
        'square_currency',
        'default_payment_gateway',
        'send_notification',
        'terms_conditions',
        'data_masking', 'queue_connection',
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot(): void
    {
        parent::boot();

        /*
         * Register an updated model event with the dispatcher.
         *
         * @param \Closure|string $callback
         * @return void
         */
        self::updating(
            static function ($model) {
                $writeable = [
                    'app_url', 'app_name', 'app_https',
                    'app_timezone', 'app_locale',
                    'mail_from_address', 'mail_from_name',
                    'mail_mailer', 'mail_encryption',
                    'mail_host', 'mail_password',
                    'mail_port', 'mail_username',
                    'mailgun_domain', 'mailgun_secret',
                    'mailgun_endpoint', 'bt_environment',
                    'bt_merchant_id', 'bt_public_key',
                    'bt_private_key',
                    'stripe_pk', 'stripe_sk', 'stripe_currency',
                    'nexmo_key', 'nexmo_secret', 'nexmo_from',
                    'twilio_account_sid', 'twilio_auth_token', 'twilio_from',
                    'portfolio_status',
                    'square_sandbox',
                    'square_application_id',
                    'square_location_id',
                    'square_token',
                    'square_currency', 'data_masking',
                    'app_date_format', 'queue_connection',
                ];
                $writeable = collect($model)->only($writeable)->all();
                foreach ($writeable as $key => $value) {
                    EnvSet::setKey(strtoupper($key), $value);
                    EnvSet::save();
                }
            }
        );
    }

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'app_user_registration' => 'boolean',
        'recaptcha_enabled' => 'boolean',
        'currency_symbol_on_left' => 'boolean',
        'is_fix' => 'boolean',
        'is_tax_fix' => 'boolean',
        'is_tax_included' => 'boolean',
        'is_vat' => 'boolean',
        'bt_state' => 'boolean',
        'app_https' => 'boolean',
        'is_accepting_repair_order' => 'boolean',
        'is_processing_without_pay' => 'boolean',
        'cod_state' => 'boolean',
        'stripe_state' => 'boolean',
        'sms_status' => 'boolean',
        'portfolio_status' => 'boolean',
        'square_state' => 'boolean',
        'square_sandbox' => 'boolean',
        'send_notification' => 'boolean',
        'data_masking' => 'boolean',
    ];

    /**
     * Application icon URL
     *
     * @param mixed $icon icon
     *
     * @return string
     */
    public function getAppIconAttribute($icon): string
    {
        return $icon
        ? Storage::disk('public')->url($icon)
        : asset('images/default/icon.png');
    }

    /**
     * Application background image URL
     *
     * @param mixed $background background
     *
     * @return string
     */
    public function getAppBackgroundAttribute($background): string
    {
        return $background
        ? Storage::disk('public')->url($background)
        : asset('images/default/background.jpg');
    }

    /**
     * Gets the is accepting repair order attribute.
     *
     * @param      mixed  $value  The value
     *
     * @return     bool|null  The is accepting repair order attribute.
     */
    public function getIsAcceptingRepairOrderAttribute($value)
    {
        if ($value) {
            return $this->stripe_state || $this->cod_state || $this->bt_state || $this->square_state;
        }
        return $value;
    }

    /**
     * Gets the notification configuration.
     *
     * @param      object  $repair  The repair
     *
     * @return     array   The notification configuration.
     */
    public function getNotificationConfig($repair, $skipped = false): array
    {
        $configArray = [];
        if (!$skipped && !$repair->send_notification) {
            return $configArray;
        }
        if ($repair->email) {
            array_push($configArray, 'mail');
        }
        if ($repair->phone && $this->sms_status) {
            switch ($this->sms_channel) {
                case 'nexmo':
                    array_push($configArray, 'nexmo');
                    break;
                case 'twilio':
                    array_push($configArray, TwilioChannel::class);
                    break;
                default:
                    // code...
                    break;
            }
        }
        return $configArray;
    }
}
