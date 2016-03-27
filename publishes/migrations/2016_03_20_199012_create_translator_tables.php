<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTranslatorTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('_translator_languages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 25);
            $table->string('name');
            $table->boolean('active');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('_translator_keys', function (Blueprint $table) {
            $table->increments('id');
            $table->longText('key');
            $table->string('domain', 255);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('_translator_values', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('language_id');
            $table->integer('key_id');
            $table->longText('value');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('_translator_values');
        Schema::dropIfExists('_translator_keys');
        Schema::dropIfExists('_translator_languages');
    }
}
