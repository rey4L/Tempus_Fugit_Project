<?php 

class MenuItemValidator extends Validator {

    
    public function validateName($name) {
        if (is_string($name)) return true;
        return false;
    }
    
    
}