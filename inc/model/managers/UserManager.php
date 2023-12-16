<?php

class UserManager {

    private $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }
    
    public function createStandardUser($email, $password, $employee_id) {
        $this->userModel->set_email($email);
        $this->userModel->set_password($password);        
        $this->userModel->set_role("cashier");
        $this->userModel->set_employee_id($employee_id);

        $this->userModel->set_password(
            password_hash($password, PASSWORD_DEFAULT)
        );

        $this->userModel->create();
    }

    public function createAdminUser($email, $password, $employee_id) {
        $this->userModel->set_email($email);
        $this->userModel->set_password($password);
        $this->userModel->set_role("manager");
        $this->userModel->set_employee_id($employee_id);

        $this->userModel->set_password(
            password_hash($password, PASSWORD_DEFAULT)
        );

        $this->userModel->create();
    }

    public function validateUser($email, $password){
        $this->userModel->set_email($email);
        
        $user = $this->userModel->findByEmail($email);
        
        if (isset($user) && password_verify($password, $user['password'])) {
            return $user;
        } 
        
        return false;
    }
}