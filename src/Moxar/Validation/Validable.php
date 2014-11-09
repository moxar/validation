<?php namespace Moxar\Validation;

interface Validable {

    public function validate($inputs);

    public function action($action);
}