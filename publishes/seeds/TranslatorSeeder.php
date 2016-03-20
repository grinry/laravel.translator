<?php

use Illuminate\Database\Seeder;

class TranslatorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(TranslatorLanguageSeeder::class);
    }
}
