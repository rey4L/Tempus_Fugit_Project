<?php

class UserController extends BaseController {
    private $model;
    private $manager;
    private $validator;

    public function __construct() {
       $this->model = new UserModel();
       $this->manager = new UserManager();
       $this->validator = new UserValidator();

    }

    public function index() {
        $this->view("user/Login");
    }

    public function login() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        list(
            $email,
            $password,
        ) = $this->validator->sanitize(
            $_POST['email'],
            $_POST['password']
        );

        if (!$this->validateLoginInputs(
            $email,
            $password
        )) return;

        $isValidUser = $this->manager->validateUser($email, $password);
  
        if ($isValidUser) {
            $_SESSION['user_id'] = $isValidUser['id'];
            $_SESSION['user_role'] = $isValidUser['role'];
            $this->anchor("register");
        } else {
            $this->error("Password for user with email $email is incorrect. Please try again!");
            $this->view("user/Login");
        }  
    }

    public function logout() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        unset($_SESSION['user_id']);
        unset($_SESSION['user_role']);
        $this->anchor("user");

    }

    public function registerPage() {
        $this->view("user/Register");
    }

    public function register() {

        list(
            $email,
            $password,
            $con_pass,
            $role,
            $employee_id
        ) = $this->validator->sanitize(
            $_POST['email'],
            $_POST['password'],
            $_POST['confirm-password'],
            $_POST['role'],
            $_POST['employee_id']
        );

        if (!$this->validateRegisterInputs(
            $email,
            $password,
            $con_pass,
            $role,
            $employee_id,
        ))return;


        if ($role == 'cashier') {
            $this->manager->createStandardUser($email, $password,$employee_id);
        } else if ($role == 'manager'){
            $this->manager->createAdminUser($email, $password, $employee_id);
        }

        $this->anchor("user");
    }

    private function validateRegisterInputs($email, $password,$con_pass, $role, $employee_id) {
        switch (false) {
            
            case $this->validator->isEmail($email):
                $this->error("Email should not be empty and of format like youremail@gmail.com!");
                $this->view("user/Register");
                return false;
                break;
            case $this->validator->isString($password):
                $this->error("Password should not be empty!");
                $this->view("user/Register");
                return false;
                break;
            case $this->validator->isString($con_pass):
                $this->error("Confirm password should not be empty!");
                $this->view("user/Register");
                return false;
                break;
            case $this->validator->isString($role):
                $this->error("Role should not be empty!");
                $this->view("user/Register");
                return false;
                break;
            case $this->validator->isInt($employee_id):
                $this->error("Employee should be a integer number! Example: 5.");
                $this->view("user/Register");
                return false;
                break;
            case $this->validator->validatePassword($password):
                $this->error("Password must be of mininum 8 characters. Contain atleat 1 uppercase, 1 lowercase, 1 special character and 1 number!");
                $this->view("user/Register");
                return false;
                break;
            case $this->validator->verifyPassword($password,$con_pass):
                $this->error("Password and confirm password fields do not match");
                $this->view("user/Register");
                return false;
                break;
            case $this->validator->validateRole($role):
                $this->error("Role is invalid. Please select a valid role from the dropdown!");
                $this->view("user/Register");
                return false;
                break;
            case $this->manager->verifyEmployeeId($employee_id):
                $this->error("Employee with id $employee_id does not exist! Please ensure your employee id is valid!");
                $this->view("user/Register");
                return false;
                break;
            default:
                return true;
                break;
        }
    }

    private function validateLoginInputs($email, $password) {
        switch (false) {
            case $this->validator->isEmail($email):
                $this->error("Email should not be empty and of format like youremail@gmail.com!");
                $this->view("user");
                return false;
                break;
            case $this->validator->isString($password):
                $this->error("Password should not be empty!");
                $this->view("user");
                return false;
                break;
            case $this->manager->verifyUserEmail($email):
                $this->error("Unknown user with email $email");
                $this->view("user/Register");
                return false;
                break;
            default:
                return true;
                break;
        }
    }
        
}