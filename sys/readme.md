# Ash Online Shop, E-Commerce Website

#### Feature
* Responsive Design
* Integrated with Raja Ongkir
* Input & Check Resi
* Print Shipping Label
* Payment with a unique code (Auto Confirmation Transaction with BCA)
* Check balance/mutation BCA
* 2 Level Authentication : Admin & Customer
* Setting Store Configuration ( Logo, Icon, Store Name, etc)

**Template**
* [User Interface - Groceries Organic Store](https://github.com/teguhrianto/Groceries-Organic-Store)
* [Admin Interface - Admin Bootstrapdash](https://github.com/BootstrapDashPurpleAdmin-Free-Admin-Template)

**Package**
* [BCAParser](https://github.com/kadekjayak/bca-parser)
* [Rajaongkir](https://packagist.org/packages/steevenz/rajaongkir)
* [PDF Generator](https://github.com/barryvdh/laravel-dompdf)

##### How to install
Clone Repository
```
> Git Clone  Repositori
```

After clone successfully, then
*uncomment this in AppServiceProvider*
```
    public function boot()
    {
        Schema::defaultStringLength(191); //NEW: Increase StringLength

        /* Uncommenct
        $settings = Config::all();
        foreach($settings as $val){
            config(['setting.'.$val->nama => $val->value ]);
        }
        */

    }
```

run Composer install
```
> composer install
```

Copy .env.example then rename to .env,
Create database, and open .env file, change this with your configuration
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE= Your Database
DB_USERNAME= Your username
DB_PASSWORD= Your Password
```

Generate key
```
php artisan key:generate
```

Inserting table and data
```
php artisan migrate:refresh --seed
```

Running this app
```
php artisan serve
```
Open in url : http://127.0.0.1:8000

**Login User & Password**
```
User  : admin@mailinator.com
Pass  : admin123
Level : Admin
```

```
User  : customer@mailinator.com
Pass  : admin123
Level : Customer
```