<?php namespace Moxar\Validation;

use Laracasts\Validation\FormValidator;
use Moxar\Validation\Validable;

abstract class Validator extends FormValidator implements Validable {

    protected $rules = [];
    protected $action = null;
    
    /*
     * Sets the action to validate
     * returns the validator instance
     */
    public function action($action) {
        $this->action = $action;
        return $this;
    }
    
    /*
     * Merges the rule of a validation.
     * Priority is given to specific rules over generic rules.
     */
    protected function mergeRules($inputs) {
    
        $action = $this->action;
        
        // checks if the given action has associated rules
        if(is_null($action)) {
            return;
        }
        
        // creates action array if none has been defined.
        if(!isset($this->{$action}) || !is_array($this->{$action})) {
            $this->{$action} = [];
        }
        
        $this->rules = array_merge($this->rules, $this->{$action});
    }
}