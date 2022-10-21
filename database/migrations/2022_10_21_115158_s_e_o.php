<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Add to settings table
        Schema::table('settings', function (Blueprint $table) {
            $table->string('seo_title')->nullable()->default('Paymenter');
            $table->string('seo_description')->nullable()->default('Change this description in settings');
            $table->string('seo_keywords')->nullable();
            $table->boolean('seo_twitter_card')->default(1);
            $table->string('seo_image')->nullable()->default('https://paymenter.org/assets/images/paymenter.png');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
