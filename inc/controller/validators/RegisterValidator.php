<?php

class RegisterValidator extends Validator {
    public function validateNumberOfItems($amount) {
        if($amount > 50) 
            return false;
        return true;
    }
}