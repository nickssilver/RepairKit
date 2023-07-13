<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDefectRepairOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('defect_repair_order', function (Blueprint $table) {
            $table->id();
            $table->foreignId('defect_id')->nullable()
                ->constrained('defects')->nullOnDelete();
            $table->foreignId('repair_order_id')
                ->nullable()->constrained('repair_orders')->nullOnDelete();
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
        Schema::dropIfExists('defect_repair_order');
    }
}
