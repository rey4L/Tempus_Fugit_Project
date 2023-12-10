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
        // queries model for user

        // if valid user, create session

        // anchor to register tab 
        
    }

    public function logout() {
        // destroys session

        // redirect to login page
    }

    public function register() {
        // calls the designated user manager function to create the necessary role
        // $this->manager->createCashierUser() or $this->manager->createManagerUser()
    }
}