<?php

class UserManager {

    private $userModel;

    protected function generateSaltedPassword($password) {
        //Generate a random 16 bit hexadecimal string
        $salt = bin2hex(random_bytes(16));
        //Prepend the string to the password
        $salted_password = $salt.$password;
        return $salted_password;
    }

    public function __construct() {
        $this->userModel = new UserModel();
    }
    
    public function createStandardUser($id, $email, $password, $employee_id) {
        $this->userModel->set_id($id);
        $this->userModel->set_email($email);
        $this->userModel->set_password($password);        
        $this->userModel->set_role("cashier");
        $this->userModel->set_employee_id($employee_id);

        $salted_password = $this->generateSaltedPassword($this->userModel->get_password());

        $this->userModel->set_password(
            password_hash($salted_password, PASSWORD_DEFAULT)
        );

        $this->userModel->create();
    }

    public function createAdminUser($id, $email, $password, $employee_id) {
        $this->userModel->set_id($id);
        $this->userModel->set_email($email);
        $this->userModel->set_password($password);
        $this->userModel->set_role("manager");
        $this->userModel->set_employee_id($employee_id);

        $salted_password = $this->generateSaltedPassword($this->userModel->get_password());

        $this->userModel->set_password(
            password_hash($salted_password, PASSWORD_DEFAULT)
        );

        $this->userModel->create();
    }
}