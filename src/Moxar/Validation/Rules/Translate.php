<?php namespace Moxar\Validation\Rules;

use DB;

class Translate {
    
    /*
     * Adds rule uniqueLang for validation
     * params are: table, column, id to ignore
     */
    public function uniqueLang($field, $value, $parameters) {
        
        $table = $parameters[0];
        $column = $parameters[1];
        $id = isset($parameters[2]) ? $parameters[2] : "";
        $iso = explode(".", $field);
        $iso = $iso[0];
        
        return DB::table($table)->where('locale', $iso)->where($column, $value)->where('id', '!=', $id)->count() == 0;
    }
}