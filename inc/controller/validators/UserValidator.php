<?php

// basically validate more or less the same things as employee
class UserValidator extends Validator
{
    public function validateEmail($email) {
        $validEmail = filter_var($email, FILTER_VALIDATE_EMAIL);
        return $validEmail !== false;
    }

    public function validatePassword($password) {
        return strlen($password) === 5 ? true : false;

    }

    public function validateRole($role) {
        return $role === 'manager' || $role === 'cashier' ? true : false;
    }

    public function validateEmployeeId($employee_id) {
        return is_int($employee_id) ? true : false;
    }
    
    


}