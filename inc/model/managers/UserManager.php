<?php

class UserManager {

    private $userModel;
    private $employeeModel;

    public function __construct() {
        $this->userModel = new UserModel();
        $this->employeeModel = new EmployeeModel();
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
        $user = $this->userModel->findByEmail();
        
        if (isset($user) && password_verify($password, $user['password'])) {
            return $user;
        } 
        
        return false;
    }

    public function verifyUserEmail($email) {
        $this->userModel->set_email($email);
        return $this->userModel->findByEmail();
    }

    public function verifyEmployeeId($id) {
        $this->employeeModel->set_id($id);
        return $this->employeeModel->findById();
    }
}