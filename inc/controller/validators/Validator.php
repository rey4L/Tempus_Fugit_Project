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

        if(count($sanitized) === 1) 
            return $sanitized[0];
        
        return $sanitized;
    }

}