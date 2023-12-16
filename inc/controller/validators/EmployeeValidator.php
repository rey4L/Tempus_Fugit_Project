<?php

class EmployeeValidator extends Validator {
    
    public function validateOtherNames($otherNames) {
        if (empty($otherNames)) return true;
        if (!$this->isString($otherNames)) false;
        $pattern = '/^(\w+,)*\w+$/';
        return preg_match($pattern, $otherNames) === 1;
    }
  
    public function validateGender($gender) {
        $validGenders = [1, 0];
        return in_array($gender, $validGenders);
    }

    public function validateAge($age) {
        if (!$this->isInt($age)) return false;
        return  filter_var($age, 
                FILTER_VALIDATE_INT, 
                ['options' => ['min_range' => 18, 'max_range' => 70]]);
    }


    public function validateDobAndAge($dob, $age) {
        return $this->calculateAge($dob) == $age;
    }

    public function validateJobRole($jobRole) {
        $validRoles = ['owner', 'manager', 'cashier', 'cook', 'server', 'clerk'];
        return in_array($jobRole, $validRoles);
    }

    public function validateEmail($email) {
        $validEmail = filter_var($email, FILTER_VALIDATE_EMAIL);
        return $validEmail !== false;
    }

    function validatePhoneNumber($number) {
        return strlen($number) === 7 ? true : false;
    }

    private function calculateAge($dob) {
        $dobDate = new DateTime($dob);
        $currentDate = new DateTime();
        $ageInterval = $dobDate->diff($currentDate);
        return $ageInterval->y;
    }
 

}