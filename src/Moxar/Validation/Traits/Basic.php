<?php namespace Moxar\Validation\Traits;

trait Basic {

    /*
     * Sets the rules before validating
     * This function calls the member mergeRules method before triggering form validation.
     */
    public function validate($inputs) {
        $this->mergeRules($inputs);
        $this->ignoreSelf($inputs);
        return parent::validate($inputs);
    }
    
    /*
     * Auto ignores self for unique rule
     */
    protected function ignoreSelf($inputs) {
        
        // checks if the input element has an idea, ie: exists in database.
        if(!isset($inputs['id']) || $inputs['id'] == "") {
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