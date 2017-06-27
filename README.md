# Manual

## Configuration

Install package `composer require "superman2014/json-api:1.0.x@dev"`

### Laravel

Open config/app.php and register the required service provider above your application providers.

```
'providers' => [
    Superman2014\JsonApi\EncoderServiceProvider::class,
]
```
If you'd like to make configuration changes in the configuration file you can pubish it with the following Aritsan command:

```
php artisan vendor:publish --provider="Superman2014\JsonApi\EncoderServiceProvider"
```

### Lumen

Open bootstrap/app.php and register the required service provider.

```
$app->register(Superman2014\JsonApi\EncoderServiceProvider::class);
```

### More
[neomerx/json-api](https://github.com/neomerx/json-api/wiki)
