## Translatable Eloquent's for Laravel 5

[![Total Downloads](https://poser.pugx.org/kiberzauras/laravel.translator/d/total.svg)](https://packagist.org/packages/kiberzauras/laravel.translator)
[![Latest Stable Version](https://poser.pugx.org/kiberzauras/laravel.translator/v/stable.svg)](https://packagist.org/packages/kiberzauras/laravel.translator)
[![Latest Unstable Version](https://poser.pugx.org/kiberzauras/laravel.multilanguage/v/unstable.svg)](https://packagist.org/packages/kiberzauras/laravel.translator)
[![License](https://poser.pugx.org/kiberzauras/laravel.translator/license.svg)](https://packagist.org/packages/kiberzauras/laravel.translator)

This package will help you to easy create multilanguage routes on top of your single language website. With this package
 you will be able to access your website with these routes example.com, example.com/en, example.com/en/page and etc. and
 there is no need to change your routes.php file!

### Installation

At first you need to install our package:

    composer require "kiberzauras/laravel.translator"

Then open your eloquent model that you want to be translatable and add Translatable trait
 and protected property $translatable with array of all properties you want to be translatable,
for example we use Product model:

     <?php
     
     namespace App;
     
     use Illuminate\Database\Eloquent\Model;
     use Kiberzauras\Translator\Eloquent\Traits\Translatable;
     
     class Product extends Model
     {
         use Translatable; //Translatable trait
         protected $translatable = ['name', 'description']; //add all translatable attributes to this array
         //...


Also, you need to change these attributes in database from varchar (or whatever it is) to text or longText, because 
translated values is saved as json, which can be very long. 
Run artisan:

    php artisan make:migration update_products_table

In generated migration file change column types:

    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
                $table->longText('name')->change();
                $table->longText('description')->change();
            });
    }

### Retrieving data
 
 You can retrieve all data as always:

    $product = Product::find(1);
    echo $product->name; //returns translation for current locale
    App::setLocale('ru');
    echo $product->name; //returns translation for russian locale

Sometimes You need to get other locales translation when current is set too, then You can use this:

    echo $product->name->locale('ru');
    echo $product->name->locale('en-Us');
    
 Sometimes you may wish to pass variable to translation, you can retrieve them like this:
 
    //eg. translation is Hello :name!
    echo $product->name->args(['name'=>'Jonh']); // Hello Jonh!
    //eg. translation is :name labas!
    echo $product->name->args(['name'=>'Jonh'])->locale('lt'); //Jonh labas!
    
If You had filled translatable model columns before using Translatable trait, all strings in it will be set as translations
 for fallback_locale in Your config/app.php file.
 
### Saving and updating

#### Saving

Save translation for current locale:

    Product::create([
        'name'  =>  'Hello',
        'description' => 'Some description'
    ]);
    //or
    $product = new Product();
    $product->name = 'Hello';
    $product->description = 'Some description';
    $product->save();

Save array of translations: 

    $translations = array(
        'en'=>'Hello',
        'ru'=>'Здравствуйте',
        'lt'=>'Sveiki'
    );
    Product::create([
        'name'  =>  $translations,
    ]);
    
You can also pass a json string if needed:

    $translations = json_encode(array(
        'en'=>'Hello',
        'ru'=>'Здравствуйте',
        'lt'=>'Sveiki'
    ));
    Product::create([
        'name'  =>  $translations,
    ]);

#### Updating translations

Translations updating is working the same way as creating, if you want to update current locale translation you can just pass string to attribute:

    $product = Product::find(1);
    $product->update([
        'name'  =>  'New translation'
    ]);
    //or:
    $product->name = 'New translation';
    $product->update();
    
 If you pass array or json, translatable will update only this locales which will be in this array
 
 
### Known issues

- Does'nt work if translatable attribute also has mutatator applied.

### License

The Laravel Translator is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)