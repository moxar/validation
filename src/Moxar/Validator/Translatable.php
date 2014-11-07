<?php namespace Moxar\Validator;

use Laracasts\Validation\FormValidator;
use Illuminate\Support\Facades\Config;

abstract class Translatable extends FormValidator {

    protected $rules = [];
    public $action = null;

    /*
     * Sets the rules before validating
     * This function calls the member setRules method before triggering form validation.
     */
    public function validate($inputs) {
        $this->setRules($inputs);
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
    
        $langs = Config::get('app.locales');
        $langs = is_array($langs) ? $langs : [];
    
        foreach($inputs as $key => $value) {
        
            // if the inputs are plain inputs, 
            // merge the action rules with the global rules
            if(!is_array($value)) {
                if(!in_array($key, array_keys($this->$action))) {
                    continue;
                }
                $this->rules[$key] = $this->{$action}[$key];
            }
            
            // if the inputs are localized arrays of inputs.
            // merge the action rules with the global rules annd prefix them with the lang.
            elseif(in_array($key, $langs)) {
                $lang = $key;
                $items = $value;
                foreach($items as $key => $value) {
                    if(!in_array($key, array_keys($this->$action))) continue;
                    $this->rules[$lang.".".$key] = $this->{$action}[$key];
                }
            }
        }
    }
}