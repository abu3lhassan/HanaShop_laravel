<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoreSettingsTable extends Migration
{
    public function up()
    {
        Schema::create('store_settings', function (Blueprint $table) {
            $table->id();

            $table->string('store_name')->default('HanaShop');
            $table->string('store_description')->nullable();

            $table->string('business_name')->nullable();
            $table->string('vat_number')->nullable();
            $table->string('cr_number')->nullable();

            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();

            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('whatsapp')->nullable();

            $table->decimal('vat_rate', 5, 2)->default(15.00);
            $table->text('invoice_note')->nullable();

            $table->string('logo_path')->nullable();
            $table->string('favicon_path')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('store_settings');
    }
}