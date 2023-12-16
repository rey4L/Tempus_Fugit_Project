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
        session_start();
        $email = $_POST['email']; 
        $password = $_POST['password'];

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
            echo "retry credentials";
        }  
    }

    public function logout() {
        $_SESSION = array();
        session_destroy();
        $this->anchor("user");

    }

    public function registerPage() {
        $this->view("user/Register");
    }

    public function register() {
        $email = $_POST['email']; 
        $password = $_POST['password'];
        $role = $_POST['role'];
        $employee_id = $_POST['employee_id'];
        
        list(
            $email,
            $password,
            $role,
            $employee_id
        ) = $this->validator->sanitize(
            $_POST['email'],
            $_POST['password'],
            $_POST['role'],
            $_POST['employee_id']
        );

        if (!$this->validateInputs(
            $email,
            $password,
            $role,
            $employee_id,
        ))return;



        if ($role == 'cashier') {
            $this->manager->createStandardUser($email, $password,$employee_id);
        }else if ($role == 'manager'){
            $this->manager->createAdminUser($email, $password, $employee_id);
        }

        $this->anchor("user");

    }
    private function validateInputs($email, $password, $role, $employee_id) {
        switch (false) {
            
            case $this->validator->validateEmail($email):
                $this->error("Email invalid Type");
                $this->view("user/Register");
                return false;
                break;

            case $this->validator->validatePassword($password):
                echo "password is required to be greater than 5 letters";
                $this->view("user/Register");
                return false;
                break;

            case $this->validator->validateRole($role):
                echo "role is invalid";
                $this->view("user/Register");
                return false;
                break;

            case $this->validator->validateEmployeeId($employee_id):
                echo "employee_id is required to be a Number";
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
            
            case $this->validator->validateEmail($email):
                $this->error("Email invalid Type");
                $this->view("user/Register");
                return false;
                break;

            case $this->validator->validatePassword($password):
                echo "password is required to be greater than 5 letters";
                $this->view("user/Register");
                return false;
                break;
            default:
                return true;
                break;
        }
    }
        
}