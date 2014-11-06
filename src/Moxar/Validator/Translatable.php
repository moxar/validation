<?php namespace Moxar\Validator;

trait Translatable {

    public function agrees(array $inputs, $action) {
        $this->setRules($inputs, $action);
        return $this->validate($inputs);
    }
    
    protected function setRules(array $inputs, $action) {
        foreach($inputs as $key => $value) {
            if(!is_array($value)) {
                if(!in_array($key, array_keys($this->$action))) continue;
                $this->rules[$key] = $this-> {$action}[$key];
            }
            else {
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