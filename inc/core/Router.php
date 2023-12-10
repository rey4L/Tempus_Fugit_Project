<?php

session_start();
$_SESSION['user_id'] = 1;
$_SESSION['user_role'] = 'cashier';

class Router {
    private $controller = null;
    private $method = "";
    private $params = [];

    private $validGetPaths = [
        "index",
    ];

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

        if (count($url) === 0) { 
            if ($this->isUserLoggedIn()) 
                $controllerName = $this->getControllerName("register");
            else 
                $controllerName = $this->getControllerName("user");

            $this->getController($controllerName);
            $this->method = "index";

        } else {
     
            $controllerName = $this->getControllerName($url[0]);

            if ($this->controllerExists($controllerName)) {
                $this->getController($controllerName);
                if (count($url) === 1) 
                    $this->method = "index";
                else 
                    if (method_exists($this->controller, $url[1])) 
                        $this->method = $url[1];
                    else 
                        $this->method = "";
            } else $this->reset();
        } 

        if ($this->controller !== null && $this->method !== "") {
            if (!empty($url[2])) 
                $this->params = [$url[2]];
            
            if (METHOD === POST && !in_array($this->method, $this->validPostPaths)) 
                $this->loadError("401");

            if (METHOD === GET && !in_array($this->method, $this->validGetPaths)) 
                $this->loadError("401");
         
            if(!$this->checkUserPermissions(get_class($this->controller))) 
                $this->loadError("401");
            
        } else $this->loadError("404");

        call_user_func_array(
            [$this->controller, $this->method], 
            $this->params
        );

        $this->reset();
    }

    private function getUrl($url) {
        $url = explode("/", trim(explode("?", trim($url))[0], "/"));
        $base_url = explode("/", trim(BASE_URL, "/"));
        return array_slice($url, count($base_url));	
    }

    private function getController($controller = "") {
        require __DIR__."/../controller/controllers/".$controller.".php";
        $this->controller = new $controller();
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

        if($_SESSION['user_role'] == 'cashier') 
            return in_array($controllerName, $this->validCashierControllers);
        
        if($_SESSION['user_role'] == 'manager') 
            return in_array($controllerName, $this->validManagerControllers);
        
    }

    private function loadError($errorCode) {
        $this->controller = new ErrorController();
        $this->method = "error";
        $this->params = [$errorCode];
    }

    private function reset() {
        $this->controller = null;
        $this->method = "";
        $this->params = [];
    }
}
