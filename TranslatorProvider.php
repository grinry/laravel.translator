<?php

namespace Kiberzauras\Translator;

use Illuminate\Support\ServiceProvider;

class TranslatorProvider extends ServiceProvider{

    public function boot()
    {

        $this->publisher();
    }

    public function register()
    {

    }

    private function publisher()
    {
        $this->publishes([
            __DIR__ . '/publishes/migrations'               => database_path('migrations'),
            __DIR__ . '/publishes/config/translator.php'    => config_path('translator.php'),
        ]);
    }

}
