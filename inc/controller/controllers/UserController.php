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
            $this->error("Invalid Credentials. Please try again");
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

        if (!$this->validateInputs(
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

    private function validateInputs($email, $password,$con_pass, $role, $employee_id) {
        switch (false) {
            
            case $this->validator->isEmail($email):
                $this->error("Email invalid Type");
                $this->view("user/Register");
                return false;
                break;

            case $this->validator->validatePassword($password):
                $this->error("password is required to be greater than 5 letters");
                $this->view("user/Register");
                return false;
                break;

            case $this->validator->verifyPassword($password,$con_pass):
                $this->error("password fields do not match");
                $this->view("user/Register");
                return false;
                break;

            case $this->validator->validateRole($role):
                $this->error("role is invalid");
                $this->view("user/Register");
                return false;
                break;

            case $this->validator->validateEmployeeId($employee_id):
                $this->error("employee_id is required to be a Number");
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
                $this->error("Email is not valid!");
                $this->view("user/Register");
                return false;
                break;

            case $this->validator->validatePassword($password):
                $this->error("Password must be of mininum 8 characters. Contain atleat 1 uppercase, 1 lowercase, 1 special character and 1 number!");
                $this->view("user");
                return false;
                break;
            default:
                return true;
                break;
        }
    }
        
}