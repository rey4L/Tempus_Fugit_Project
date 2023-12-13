<?php

class UserManager {

    private $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }
    
}