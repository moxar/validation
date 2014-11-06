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
	public function register() {
            return [];
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides() {
	}
	
	public function boot() {    
            $this->ratio();
            $this->widthMin();
            $this->widthMax();
            $this->widthBetween();
            $this->heightMin();
            $this->heightMax();
            $this->heightBetween();
	}
	
	protected function ratio() {
            $this->app->before(function() {
                Validator::extend('ratio', 'Moxar\Validator\Image@ratio');
                Validator::replacer('ratio', function($message, $attribute, $rule, $parameters) {
                    $message = str_replace(':width', $parameters[0], $message);
                    return str_replace(':height', $parameters[1], $message);
                });
            });
	}
        
        protected function widthMin() {
            $this->app->before(function() {
                Validator::extend('widthMin', 'Moxar\Validator\Image@widthMin');
                Validator::replacer('widthMin', function($message, $attribute, $rule, $parameters) {
                    return $message = str_replace(':min', $parameters[0], $message);
                });
            });
        }
        
        protected function widthMax() {
            $this->app->before(function() {
                Validator::extend('widthMax', 'Moxar\Validator\Image@widthMax');
                Validator::replacer('widthMax', function($message, $attribute, $rule, $parameters) {
                    return $message = str_replace(':max', $parameters[0], $message);
                });
            });
        }
        
        protected function widthBetween() {
            $this->app->before(function() {
                Validator::extend('widthBetween', 'Moxar\Validator\Image@widthBetween');
                Validator::replacer('widthBetween', function($message, $attribute, $rule, $parameters) {
                    $message = str_replace(':min', $parameters[0], $message);
                    return str_replace(':max', $parameters[1], $message);
                });
            });
        }
        
        protected function heightMin() {
            $this->app->before(function() {
                Validator::extend('heightMin', 'Moxar\Validator\Image@heightMin');
                Validator::replacer('heightMin', function($message, $attribute, $rule, $parameters) {
                    return $message = str_replace(':min', $parameters[0], $message);
                });
            });
        }
        
        protected function heightMax() {
            $this->app->before(function() {
                Validator::extend('heightMax', 'Moxar\Validator\Image@heightMax');
                Validator::replacer('heightMax', function($message, $attribute, $rule, $parameters) {
                    return $message = str_replace(':max', $parameters[0], $message);
                });
            });
        }
        
        protected function heightBetween() {
            $this->app->before(function() {
                Validator::extend('heightBetween', 'Moxar\Validator\Image@heightBetween');
                Validator::replacer('heightBetween', function($message, $attribute, $rule, $parameters) {
                    $message = str_replace(':min', $parameters[0], $message);
                    return str_replace(':max', $parameters[1], $message);
                });
            });
        }
}