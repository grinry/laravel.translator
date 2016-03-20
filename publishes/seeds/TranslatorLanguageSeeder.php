<?php

use Illuminate\Database\Seeder;

class TranslatorLanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [[
            'id'    =>  1,
            'code'  =>  'en',
            'name'  =>  'English'
        ],[
            'id'    =>  2,
            'code'  =>  'lt',
            'name'  =>  'Lietuvių kalba'
        ],[
            'id'    =>  3,
            'code'  =>  'ru',
            'name'  =>  'Русский'
        ]];
        DB::table('_translator_languages')->truncate();
        DB::table('_translator_languages')->insert($items);
    }
}
