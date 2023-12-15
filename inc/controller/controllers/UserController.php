<?php

class UserController extends BaseController {
    private $model;
    private $manager;

    public function __construct() {
       $this->model = new UserModel();
       $this->manager = new UserManager();
    }

    public function index() {
        $this->view("user/Login");
    }

    public function login() {
        session_start();
        // queries model for user
        $email = $_POST['email']; 
        $password = $_POST['password'];

        // $output = $this->model->getHashedPasswordbyEmail($email);
        // var_dump($output);
        

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
        // destroys session

        // redirect to login page
    }

    public function registerPage() {
        $this->view("user/Register");
        // calls the view function to render the register page 
    }

    public function register() {
        $email = $_POST['email']; 
        $password = $_POST['password'];
        $role = $_POST['role'];
        $employee_id = $_POST['employee_id'];


        if ($role == 'cashier') {
            $this->manager->createStandardUser($email, $password,$employee_id);
        }else if ($role == 'manager'){
        $this->manager->createAdminUser($email, $password, $employee_id);
        }

        $this->anchor("user");

        // calls the designated user manager function to create the necessary role
        // $this->manager->createCashierUser() or $this->manager->createManagerUser()
    }
}