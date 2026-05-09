<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddThemeModeToStoreSettingsTable extends Migration
{
    public function up()
    {
        Schema::table('store_settings', function (Blueprint $table) {
            $table->string('theme_mode')->default('light')->after('invoice_note');
        });
    }

    public function down()
    {
        Schema::table('store_settings', function (Blueprint $table) {
            $table->dropColumn('theme_mode');
        });
    }
}