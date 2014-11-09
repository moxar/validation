<?php namespace Moxar\Validation;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;


class ValidationServiceProvider extends ServiceProvider {

	protected $defer = false;
	
	public function register() {
            return [];
	}
	
	public function provides() {
	}
	
	public function boot() {
            $this->ratio();
            $this->minWidth();
            $this->maxWidth();
            $this->width();
            $this->minHeight();
            $this->maxHeight();
            $this->height();
            $this->uniqueLang();
            $this->fullName();
	}
	
	protected function ratio() {
            $this->app->before(function() {
                Validator::extend('ratio', 'Moxar\Validation\Rules\Image@ratio');
                Validator::replacer('ratio', function($message, $attribute, $rule, $parameters) {
                    $message = str_replace(':width', $parameters[0], $message);
                    return str_replace(':height', $parameters[1], $message);
                });
            });
	}
        
        protected function minWidth() {
            $this->app->before(function() {
                Validator::extend('minWidth', 'Moxar\Validation\Rules\Image@minWidth');
                Validator::replacer('minWidth', function($message, $attribute, $rule, $parameters) {
                    return $message = str_replace(':min', $parameters[0], $message);
                });
            });
        }
        
        protected function maxWidth() {
            $this->app->before(function() {
                Validator::extend('maxWidth', 'Moxar\Validation\Rules\Image@maxWidth');
                Validator::replacer('maxWidth', function($message, $attribute, $rule, $parameters) {
                    return $message = str_replace(':max', $parameters[0], $message);
                });
            });
        }
        
        protected function width() {
            $this->app->before(function() {
                Validator::extend('width', 'Moxar\Validation\Rules\Image@width');
                Validator::replacer('width', function($message, $attribute, $rule, $parameters) {
                    return $message = str_replace(':value', $parameters[0], $message);
                });
            });
        }
        
        protected function minHeight() {
            $this->app->before(function() {
                Validator::extend('minHeight', 'Moxar\Validation\Rules\Image@minHeight');
                Validator::replacer('minHeight', function($message, $attribute, $rule, $parameters) {
                    return $message = str_replace(':min', $parameters[0], $message);
                });
            });
        }
        
        protected function maxHeight() {
            $this->app->before(function() {
                Validator::extend('maxHeight', 'Moxar\Validation\Rules\Image@maxHeight');
                Validator::replacer('maxHeight', function($message, $attribute, $rule, $parameters) {
                    return $message = str_replace(':max', $parameters[0], $message);
                });
            });
        }
        
        protected function height() {
            $this->app->before(function() {
                Validator::extend('height', 'Moxar\Validation\Rules\Image@height');
                Validator::replacer('height', function($message, $attribute, $rule, $parameters) {
                    return $message = str_replace(':value', $parameters[0], $message);
                });
            });
        }
        
        protected function uniqueLang() {
            $this->app->before(function() {
                Validator::extend('uniqueLang', 'Moxar\Validation\Rules\Translate@uniqueLang');
            });
        }
        
        protected function fullName() {
            $this->app->before(function() {
                Validator::extend('fullName', 'Moxar\Validation\Rules\String@fullName');
            });
        }
}