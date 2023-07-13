<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('app_name')->default('Repair Box');
            $table->string('app_address')->nullable();
            $table->string('app_phone')->nullable();
            $table->string('app_https')->nullable();
            $table->string('app_url');
            $table->longText('app_about');
            $table->string('app_date_format')->default('L');
            $table->string('app_date_locale')->default('en');
            $table->string('app_default_role')->default('2');
            $table->string('app_background')->nullable();
            $table->string('app_icon')->nullable();
            $table->string('app_locale')->default('en');
            $table->string('app_timezone')->default('UTC');
            $table->boolean('app_user_registration')->default(false);
            $table->string('meta_description');
            $table->string('meta_home_title');
            $table->string('meta_keywords');

            //Outgoing mails configs
            $table->string('mail_from_name')->default('Repair Box');
            $table->string('mail_from_address')->nullable();
            $table->string('mail_mailer')->default('log');
            $table->string('mail_host')->nullable();
            $table->string('mail_username')->nullable();
            $table->string('mail_password')->nullable();
            $table->string('mail_port')->default('2525');
            $table->string('mail_encryption')->default('tls');
            $table->string('mailgun_domain')->nullable();
            $table->string('mailgun_endpoint')->nullable();
            $table->string('mailgun_secret')->nullable();

            //captcha
            $table->boolean('recaptcha_enabled')->default(false);
            $table->string('recaptcha_public')->nullable();
            $table->string('recaptcha_private')->nullable();

            //Currency
            $table->string('currency_symbol')->default('$');
            $table->boolean('currency_symbol_on_left')->default(true);

            //Tax
            $table->float('tax_rate')->default(0);
            $table->boolean('is_tax_fix')->default(false);
            $table->boolean('is_tax_included')->default(false);

            //Payment gates
            $table->boolean('is_processing_without_pay')->default(true);
            $table->boolean('is_accepting_repair_order')->default(true);
            $table->boolean('cod_state')->default(true);
            $table->string('default_payment_gateway')->nullable();

            $table->enum('bt_environment', ['sandbox', 'production'])->default('sandbox');
            $table->string('bt_merchant_id')->nullable();
            $table->string('bt_public_key')->nullable();
            $table->string('bt_private_key')->nullable();
            $table->boolean('bt_state')->default(false);

            $table->boolean('stripe_state')->default(false);
            $table->string('stripe_pk')->nullable();
            $table->string('stripe_sk')->nullable();
            $table->string('stripe_currency')->nullable();

            $table->boolean('square_state')->default(false);
            $table->boolean('square_sandbox')->default(true);
            $table->string('square_application_id')->nullable();
            $table->string('square_location_id')->nullable();
            $table->string('square_token')->nullable();
            $table->string('square_currency')->nullable();

            //SMS channels
            $table->boolean('sms_status')->default(false);
            $table->string('sms_channel')->nullable();
            $table->string('nexmo_key')->nullable();
            $table->string('nexmo_secret')->nullable();
            $table->string('nexmo_from')->nullable();
            $table->string('twilio_account_sid')->nullable();
            $table->string('twilio_auth_token')->nullable();
            $table->string('twilio_from')->nullable();

            //More
            $table->boolean('portfolio_status')->default(true);
            $table->string('send_notification')->default(true);
            $table->longText('terms_conditions')->nullable();
            $table->boolean('data_masking')->default(false);
            $table->boolean('is_vat')->default(false);
            $table->string('queue_connection')->default('sync');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
