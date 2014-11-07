<?php namespace Moxar\Validator\Rules;

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
    
    /*
     * Adds rule minWidth for validation
     * param is: width (in px)
     */
    public function minWidth($field, $value, $parameters) {
        $img = getimagesize($value);
        return $img[0] >= $parameters[0];
    }
    
    /*
     * Adds rule maxWidth for validation
     * param is: max (in px)
     */
    public function maxWidth($field, $value, $parameters) {
        $img = getimagesize($value);
        return $img[0] <= $parameters[0];
    }
    
    /*
     * Adds rule width for validation
     * param is: value (in px)
     */
    public function width($field, $parameters) {
        $img = getimagesize($value);
        return $img[0] == $parameters[0];
    }
    
    /*
     * Adds rule minHeight for validation
     * param is: height (in px)
     */
    public function minHeight($field, $value, $parameters) {
        $img = getimagesize($value);
        return $img[1] >= $parameters[0];
    }
    
    /*
     * Adds rule maxHeight for validation
     * param is: max (in px)
     */
    public function maxHeight($field, $value, $parameters) {
        $img = getimagesize($value);
        return $img[1] <= $parameters[0];
    }
    
    /*
     * Adds rule height for validation
     * param is: value (in px)
     */
    public function height($field, $parameters) {
        $img = getimagesize($value);
        return $img[1] == $parameters[0];
    }
}