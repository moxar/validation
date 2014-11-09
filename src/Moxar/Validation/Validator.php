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
        
        // explodes rules into arrays.
        foreach($this->{$action} as &$rules) {
            $rules = explode("|", $rules);
        }
        foreach($this->rules as &$rules) {
            $rules = explode("|", $rules);
        }
        
        // insert specific rules into global rules array
        foreach($this->{$action} as $field => &$rules) {
        
            // creates global rule key if not exist
            if(!in_array($field, array_keys($this->rules))) {
                $this->rules[$field] = [];
            }
            // append rule to array.
            foreach($rules as $rule) {
                $this->rules[$field][] = $rule;
                
            }
        }
    }
}