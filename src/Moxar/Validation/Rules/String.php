<?php namespace Moxar\Validation\Rules;

class String {
    
    /*
     * Adds rule fullName for validation
     * returns true if the given string is a name
     */
    public function fullName($field, $value, $parameters) {
        
        return preg_match('#^([A-Za-z -])*$#', $value);
    }
}