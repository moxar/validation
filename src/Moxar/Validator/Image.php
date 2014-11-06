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
    
    /*
     * Adds rule widthMin for validation
     * param is: width (in px)
     */
    public function widthMin($field, $value, $parameters) {
        $img = getimagesize($value);
        return $img[0] >= $parameters[0];
    }
    
    /*
     * Adds rule widthMax for validation
     * param is: max (in px)
     */
    public function widthMax($field, $value, $parameters) {
        $img = getimagesize($value);
        return $img[0] <= $parameters[0];
    }
    
    /*
     * Adds rule widthBetween for validation
     * params are: min, max (in px)
     */
    public function widthBetween($field, $value, $parameters) {
        $img = getimagesize($value);
        return $img[0] >= $parameters[0] && $img[0] <= $parameters[1];
    }
    
    /*
     * Adds rule heightMin for validation
     * param is: height (in px)
     */
    public function heightMin($field, $value, $parameters) {
        $img = getimagesize($value);
        return $img[1] >= $parameters[0];
    }
    
    /*
     * Adds rule heightMax for validation
     * param is: max (in px)
     */
    public function heightMax($field, $value, $parameters) {
        $img = getimagesize($value);
        return $img[1] <= $parameters[0];
    }
    
    /*
     * Adds rule heightBetween for validation
     * params are: min, max (in px)
     */
    public function heightBetween($field, $value, $parameters) {
        $img = getimagesize($value);
        return $img[1] >= $parameters[0] && $img[1] <= $parameters[1];
    }
}