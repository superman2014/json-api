<?php

namespace Superman2014\Providers;

use Illuminate\Support\ServiceProvider;
use Neomerx\JsonApi\Document\Link;
use Neomerx\JsonApi\Encoder\Encoder;
use Neomerx\JsonApi\Encoder\EncoderOptions;
use Neomerx\JsonApi\Encoder\Parameters\EncodingParameters;
use Neomerx\JsonApi\Http\Request as RequestWrapper;
use Neomerx\JsonApi\Factories\Factory;
use Illuminate\Foundation\Application as LaravelApplication;
use Laravel\Lumen\Application as LumenApplication;

class EncoderServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->setupConfig();
    }

    protected function setupConfig()
    {

        $config = __DIR__ . '/../config/encoder.php';

        if ($this->app instanceof LaravelApplication && $this->app->runningInConsole()) {
            $this->publishes([
                $config => config_path('encoder'),
            ]);
        } elseif ($this->app instanceof LumenApplication) {
            $this->app->configure('encoder');
        }

        $this->mergeConfigFrom($config, 'encoder');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            'superman2014.jsonapi.factory', function ($app) {
                return new Factory;
            }
        );

        $this->app->singleton(
            'superman2014.jsonapi.encoder_options', function ($app) {
                return new EncoderOptions(0, config('encoder.site_url'));
            }
        );

        $this->app->singleton(
            'superman2014.jsonapi.encoder', function ($app) {

                $encoder = Encoder::instance(
                    config('encoder.schemas'),
                    app('superman2014.jsonapi.encoder_options')
                );

                return $encoder;
            }
        );

        $this->app->singleton(
            'superman2014.jsonapi.encoding_parameters', function ($app) {
                return $this->getQueryParameters();
            }
        );
    }

    /**
     * @return RequestWrapper
     */
    protected function getRequestWrapper()
    {
        return new RequestWrapper(
            function () {
                return request()->getMethod();
            },
            function ($name) {
                return request()->headers->get($name, null, false);
            },
            function () {
                return request()->query->all();
            }
        );
    }

    /**
     * @return
     */
    protected function getQueryParameters()
    {
        return app('superman2014.jsonapi.factory')
            ->createQueryParametersParser()
            ->parse($this->getRequestWrapper());
    }
}
