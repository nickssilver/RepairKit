<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRepairOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repair_orders', function (Blueprint $table) {
            $table->id();
            $table->string('tracking');
            $table->uuid('uuid')->index();
            $table->boolean('payment_status')->default(0);
            $table->longText('payment_info')->nullable();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('serial_number')->nullable();
            $table->string('address')->nullable();
            $table->integer('brand_id')->nullable();
            $table->integer('device_id')->nullable();
            $table->text('diagnostics')->nullable();
            $table->float('sub_total');
            $table->float('total_cost')->default(0);
            $table->float('profit');
            $table->float('tax');
            $table->float('total_charges');
            $table->float('pre_paid')->default(0);
            $table->string('completed_at')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('repair_priority_id')->default(1);
            $table->integer('repair_status_id')->default(1);
            $table->longText('brand_info')->nullable();
            $table->longText('device_info')->nullable();
            $table->longText('defects_info')->nullable();
            $table->boolean('is_manual')->default(false);
            $table->boolean('is_device_collected')->default(false);
            $table->float('additional_amount')->default(0);
            $table->boolean('send_notification')->default(true);
            $table->boolean('is_archive')->default(false);
            $table->boolean('is_lock')->default(false);
            $table->boolean('has_warranty')->default(false);
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
        Schema::dropIfExists('repair_orders');
    }
}
