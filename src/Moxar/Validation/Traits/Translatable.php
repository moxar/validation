<?php namespace Moxar\Validation\Traits;

use Illuminate\Support\Facades\Config;

trait Translatable {

    /*
     * Sets the rules before validating
     * This function calls the member setRules method before triggering form validation.
     */
    public function validate($inputs) {
        $this->mergeRules($inputs);
        $this->translateRules($inputs);
        $this->ignoreSelf($inputs);
        return parent::validate($inputs);
    }
    
    /*
     * Sets the rule of a validation.
     * This function merges the rules array with the action rules array.
     * If the inputs contain translatable attributes, the correct rule is
     * associated with the translatable input.
     */
    protected function translateRules($inputs) {
    
        $langs = Config::get('app.locales');
        $langs = is_array($langs) ? $langs : [];
        
        $translatedRules = [];
    
        foreach($inputs as $key => $value) {
        
            // if the input is not an array, it's not a traductible input
            if(!is_array($value)) {
                continue;
            }
            
            // if the inputs are localized arrays of inputs.
            // add a rule named afeter lang and key
            if(in_array($key, $langs)) {
                $lang = $key;
                $items = $value;
                foreach($items as $key => $value) {
                    if(!in_array($key, array_keys($this->rules))) continue;
                    $this->rules[$lang.".".$key] = $this->rules[$key];
                    $translatedRules[] = $key;
                }
            }
        }
        foreach($translatedRules as $rule) {
            unset($this->rules[$rule]);
        }
    }
    
    /*
     * Auto ignores self for unique rule
     */
    protected function ignoreSelf($inputs) {
        
        // look for the 'unique' rule and add current input id to the rule.
        foreach($this->rules as $key => &$field) {
            if(is_string($field)) {
                $field = explode('|', $field);
            }
            
            // checks if the input element has an ID, ie: exists in database.
            $lang = strstr($key, ".", true);
            if(!isset($inputs[$lang]['id']) || $inputs[$lang]['id'] == "") {
                continue;
            }
            
            foreach($field as &$rule) {
                if(preg_match("#(unique:)|(uniqueLang:)#", $rule)) {
                    $rule .= ",".$inputs[$lang]['id'];
                }
            }
        }
    }
}