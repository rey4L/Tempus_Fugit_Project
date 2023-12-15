<?php

class UserManager {

    private $userModel;

    protected function generateSaltedPassword($password) {
        //Generate a random 16 bit hexadecimal string
        //$salt = bin2hex(random_bytes(16));
        $salt = "a1b2c3d4e5f6g7h8";
        //Prepend the string to the password
        $salted_password = $salt.$password;
        return $salted_password;
    }

    public function __construct() {
        $this->userModel = new UserModel();
    }
    
    public function createStandardUser($email, $password, $employee_id) {
        $this->userModel->set_email($email);
        $this->userModel->set_password($password);        
        $this->userModel->set_role("cashier");
        $this->userModel->set_employee_id($employee_id);

        $salted_password = $this->generateSaltedPassword($this->userModel->get_password());

        $this->userModel->set_password(
            password_hash($salted_password, PASSWORD_DEFAULT)
            //$salted_password
        );

        $this->userModel->create();
    }

    public function createAdminUser($email, $password, $employee_id) {
        $this->userModel->set_email($email);
        $this->userModel->set_password($password);
        $this->userModel->set_role("manager");
        $this->userModel->set_employee_id($employee_id);

        $salted_password = $this->generateSaltedPassword($this->userModel->get_password());

        $this->userModel->set_password(
            password_hash($salted_password, PASSWORD_DEFAULT)
            //$salted_password
        );

        $this->userModel->create();
    }

    public function validateUser($email, $password){
        $user = $this->userModel->findByEmail($email);

        $password = $this->generateSaltedPassword($password);
    
        if (isset($user) && password_verify($password, $user['password'])) {
            return $user;
        } else return false;

    }
    

}