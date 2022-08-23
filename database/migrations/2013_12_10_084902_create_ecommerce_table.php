<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateECommerceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('universities', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('address_id')
                ->constrained('addresses')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('name');
            $table->string('email');
            $table->string('website');
            $table->string('logo')->nullable();
            $table->string('color1')->nullable();
            $table->string('color2')->nullable();
            $table->string('color3')->nullable();
            $table->string('authorized_person');
            $table->ipAddress('ip_address')->nullable();
            $table->boolean('isActive')->default(1);
            $table->boolean('isDeleted')->nullable()->default(0);
            $table->date('licence_start_date')->nullable();
            $table->date('licence_update_date')->nullable();
            $table->date('licence_end_date')->nullable();
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
        Schema::dropIfExists('ecommerce');
    }
}
