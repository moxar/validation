<?php namespace Moxar\Validator;

class Image {
    
    /*
     * Adds rule ratio for validation
     * params are: width, height (in px)
     */
    public function ratio($field, $value, $parameters) {
        $img = getimagesize($value);
        
        $width = $img[0] / $parameters[0];
        $height = $img[1] / $parameters[1];
        
        return $width == $height;
    }
}