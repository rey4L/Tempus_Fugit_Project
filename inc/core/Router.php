<?php

session_start();
$_SESSION['user_id'] = 1;
$_SESSION['user_role'] = 'manager';

class Router {
    private $controller = '';
    private $method = '';
    private $params = [];

    // Valid controller methods for GET requests
    private $validGetPaths = [
        "index",
    ];

    // Valid controller methods for POST requests
    private $validPostPaths = [
        "findAll",
        "view",
        "create",
        "update",
        "delete",
        "findOne",
        "anchor",
        "error",
        "index",
        "filterByStatus",
        "filterByDate",
        "searchById",
        "login",
        "logout",
        "register"
    ];

    
    private $validCashierControllers = [
        "UserController",
        "RegisterController",
        "ErrorController"
    ];

    private $validManagerControllers = [
        "BillController",
        "MenuItemController",
        "EmployeeController",
        "MenuItemController",
        "RegisterController",
        "ErrorController"
    ];

    public function __construct() {
        $this->loadController();
    }

    private function loadController() {
        $path = $_SERVER["REQUEST_URI"];
        $url = $this->getUrl($path);

        // Default controller and method when the app starts
        if (count($url) === 0) { 
            
            if($this->isUserLoggedIn()) {
                $this->controller = $this->getControllerName("Register");
            } else {
                $this->controller = $this->getControllerName("User");
            }

            $this->getController($this->controller);
            $this->method = "index";

        } else {
            $this->controller = $this->getControllerName($url[0]);

            if ($this->controllerExists($this->controller)) {
                $this->getController($this->controller);
    
                if (count($url) === 1) {
                    $this->method = "index";
                } else {
                    if (method_exists($this->controller, $url[1])) {
                        $this->method = $url[1];
                    } else {
                        $this->method = "";
                    }
                }
            } else $this->reset();
        } 

        if ($this->controller !== "" && $this->method !== "") {
            if (!empty($url[2])) $this->params = [$url[2]];

            // Decisions based on HTTP requests

            // If the request is POST but not a valid post request path, then return an error
            if (METHOD === POST && !in_array($this->method, $this->validPostPaths)) $this->loadError("401");

            // If the request is GET but not a valid get request path, then return an error
            if (METHOD === GET && !in_array($this->method, $this->validGetPaths)) $this->loadError("401");

            // check authorization permissions
            if(!$this->checkUserPermissions(get_class($this->controller))) $this->loadError("401");
            
        } else {
            // Redirect to the 404 page
            $this->controller = new ErrorController();
            $this->method = "error";
            $this->params = ["404"];
        }

        // Calls the assigned controller and method
        call_user_func_array(
            [$this->controller, $this->method], 
            $this->params
        );

        // Reset attributes
        $this->controller = "";
        $this->method = "";
        $this->params = [];
    }

    private function getUrl($url) {
        $url = explode("/", trim(explode("?", trim($url))[0], "/"));
        $base_url = explode("/", trim(BASE_URL, "/"));
        return array_slice($url, count($base_url));	
    }

    private function getController($controller_name = "") {
        require __DIR__."/../controller/controllers/".$controller_name.".php";
        $this->controller = new $this->controller;
    }

    private function getControllerName($path) {
        return ucfirst($path)."Controller";
    }

    private function controllerExists($filename) {
        $filename = __DIR__."/../controller/controllers/".$filename.".php";
        return file_exists($filename);
    }

    private function isUserLoggedIn() {
        return isset($_SESSION['user_id']) && isset($_SESSION['user_role']);
    }

    private function checkUserPermissions($controllerName) {

        if($_SESSION['user_role'] == 'cashier') {
            return in_array($controllerName, $this->validCashierControllers);
        }

        if($_SESSION['user_role'] == 'manager') {
            return in_array($controllerName, $this->validManagerControllers);
        }
    }

    private function loadError($errorCode) {
        $this->controller = new ErrorController();
        $this->method = "error";
        $this->params = [$errorCode];
    }

    private function reset() {
        $this->controller = "";
        $this->method = "";
        $this->params = "";
    }
}
