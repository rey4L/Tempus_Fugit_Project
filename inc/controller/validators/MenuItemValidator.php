<?php 

class MenuItemValidator extends Validator {
    use FilterValidator;

    
    public function validateName($name) {
        if (is_string($name)) return true;
        return false;
    }
    
    
}