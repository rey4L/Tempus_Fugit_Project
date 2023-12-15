<?php

class Validator {

    function sanitize(...$inputs) {
        $sanitized = [];
        foreach($inputs as $input) {
            $input = trim($input);
            $input = stripslashes($input);
            $input = htmlspecialchars($input);
            array_push($sanitized, $input);
        }

        return count($sanitized) === 1 ? $sanitized[0] : $sanitized;
    }

        public function isString($input){
            return is_string($input);
        }
    
        public function isInt($input){
            return filter_var($input, FILTER_VALIDATE_INT) !== false;
        }
    
        public function isFloat($input){
            return filter_var($input, FILTER_VALIDATE_FLOAT) !== false;
        }
    
        public function isEmail($input){
            return filter_var($input, FILTER_VALIDATE_EMAIL) !== false;
        }


}