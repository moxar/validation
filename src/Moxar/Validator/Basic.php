<?php namespace Moxar\Validator;

use Laracasts\Validation\FormValidator;

abstract class Basic extends FormValidator {

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
     * Sets the rules before validating
     * This function calls the member setRules method before triggering form validation.
     */
    public function validate($inputs) {
        $this->setRules($inputs);
        $this->ignoreSelf($inputs);
        return parent::validate($inputs);
    }
    
    /*
     * Sets the rule of a validation.
     * This function merges the rules array with the action rules array.
     * If the inputs contain translatable attributes, the correct rule is
     * associated with the translatable input.
     */
    protected function setRules($inputs) {
    
        $action = $this->action;
        
        // checks if the given action has associated rules
        if(is_null($action) || !isset($this->{$action}) || !is_array($this->{$action}) || empty($this->{$action})) {
            return;
        }
    
        foreach($inputs as $key => $value) {
        
            // if the inputs are plain inputs, 
            // merge the action rules with the global rules
            if(!is_array($value)) {
                if(!in_array($key, array_keys($this->$action))) {
                    continue;
                }
                $this->rules[$key] = $this->{$action}[$key];
            }
        }
    }
    
    /*
     * Auto ignores self for unique rule
     */
    protected function ignoreSelf($inputs) {
        
        // checks if the input element has an idea, ie: exists in database.
        if(!isset($inputs['id'])) {
            return;
        }
        
        // look for the 'unique' rule and add current input id to the rule.
        foreach($this->rules as &$field) {
            if(is_string($field)) {
                $field = explode('|', $field);
            }
            foreach($field as &$rule) {
                if(preg_match("#unique:#", $rule)) {
                    $rule .= ",".$inputs['id'];
                }
            }
        }
    }
}