<?php

class EmployeeValidator extends Validator {
    use FilterValidator;
    // make sure name is valid
    
    public function validateName($name) {
        // Validate that name is a valid name (example: check if it's in a valid format)
        $validName = filter_var($name, FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => '/^[a-zA-Z]+$/']]);

        return $validName !== false;
    }
    // make sure gender is valid
    public function validateGender($gender) {
        // Validate that gender is a valid gender (example: check if it's in an array of valid genders)
        $validGenders = ['male', 'female'];

        return in_array($gender, $validGenders);
    }

    // make sure age is suitable, between 18 and 70
    public function validateAge($age) {
        return filter_var($age, FILTER_VALIDATE_INT, ['options' => ['min_range' => 18, 'max_range' => 70]]);
    }
    // make sure that dob and age match up
    public function validateDob($dob) {
        // Validate that dob is a valid date (example: check if it's in a valid format)
        $validDob = date_create_from_format('d-m-Y', $dob);

        return $validDob !== false;
    }
    // make sure that job role is a valid role
    public function validateJobRole($jobRole) {
        // Validate that job role is a valid role (example: check if it's in an array of valid roles)
        $validRoles = ['manager', 'cashier'];

        return in_array($jobRole, $validRoles);
    }
    // make sure that email is valid
    public function validateEmail($email) {
        // Validate that email is a valid email (example: check if it's in a valid format)
        $validEmail = filter_var($email, FILTER_VALIDATE_EMAIL);

        return $validEmail !== false;
    }

    // make sure that number is valid
    public function validateNumber($number) {
        // Validate that number is a valid number (example: check if it's in a valid format)
        $validNumber = filter_var($number, FILTER_VALIDATE_INT);

        return $validNumber !== false;
    }
    // any thing else that could be validated

}