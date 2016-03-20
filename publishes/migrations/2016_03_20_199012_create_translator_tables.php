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
            $table->string('native_name');
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('_translator_strings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('string');
            $table->string('domain', 255);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('_translator_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('language_id');
            $table->integer('string_id');
            $table->longText('translation');
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
        Schema::dropIfExists('_translator_translations');
        Schema::dropIfExists('_translator_strings');
        Schema::dropIfExists('_translator_languages');
    }
}
