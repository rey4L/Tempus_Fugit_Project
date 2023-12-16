<?php

// basically validate more or less the same things as employee
class UserValidator extends Validator
{

    function validatePassword($password) {
   
        $minLength = 8;
   
        if (strlen($password) < $minLength) {
            return false;
        }
 
        if (!preg_match('/[A-Z]/', $password)) {
            return false;
        }

        if (!preg_match('/[a-z]/', $password)) {
            return false;
        }
    
        if (!preg_match('/[0-9]/', $password)) {
            return false;
        }

        if (!preg_match('/[^A-Za-z0-9]/', $password)) {
            return false;
        }

        return true;
    }

    public function validateRole($role) {
        $roles = ['manager', 'cashier'];
        return in_array($role, $roles);
    }

    public function validateEmployeeId($employee_id) {
        $employee_id = intval($employee_id);
        return is_int($employee_id);
    }

}