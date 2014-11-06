<?php namespace Moxar\Validator;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class ValidatorServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}
	
	public function boot() {
            $this->extendRatio();
            $this->replaceRatio();
	}
	
	protected function extendRatio() {
            $this->app->before(function() {
                Validator::extend('ratio', 'Moxar\Validator\Image@ratio');
            });
	}

	protected function replaceRatio() {
            $this->app->before(function() {
                Validator::replacer('ratio', function($message, $attribute, $rule, $parameters) {
                    $message = str_replace(':width', $parameters[0], $message);
                    return str_replace(':height', $parameters[1], $message);
                });
            });
        }
}