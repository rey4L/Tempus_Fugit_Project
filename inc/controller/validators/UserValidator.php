<?php

// basically validate more or less the same things as employee
class UserValidator extends Validator
{

    public function validatePassword($password) {
        return strlen($password) === 10 ? true : false;
    }

    public function validateRole($role) {
        $roles = ['manager', 'cashier'];
        return in_array($role, $roles);
    }

    public function validateEmployeeId($employee_id) {
        return is_int($employee_id) ? true : false;
    }

}