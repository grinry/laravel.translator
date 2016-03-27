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
        $datetime = \Carbon\Carbon::create();

        $items = [[
            'id'            =>  1,
            'code'          =>  'en',
            'name'          =>  'English',
            'active'        =>  1,
            'created_at'    =>  $datetime,
            'updated_at'    =>  $datetime
        ],[
            'id'            =>  2,
            'code'          =>  'lt',
            'name'          =>  'Lietuvių kalba',
            'active'        =>  1,
            'created_at'    =>  $datetime,
            'updated_at'    =>  $datetime
        ],[
            'id'            =>  3,
            'code'          =>  'ru',
            'name'          =>  'Русский',
            'active'        =>  1,
            'created_at'    =>  $datetime,
            'updated_at'    =>  $datetime
        ]];
        DB::table('_translator_languages')->truncate();
        DB::table('_translator_languages')->insert($items);
    }
}
