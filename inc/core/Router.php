<?php

class Router {
    private $controller = '';
    private $method = '';

    public function __construct() {
        $this->loadController();
    }

    private function loadController() {

        $path = $_SERVER["REQUEST_URI"];
        $url = $this->getUrl($path);

        if(count($url) !== 0) {
            $this->controller = $this->getControllerName($url[0]);
        
            if($this->controllerExists($this->controller)) {
              
                $this->getController($this->controller);
    
                if(count($url) === 1) {
                    $this->method = "index";
                } else {
                    if(method_exists($this->controller, $url[1])) {
                        $this->method = $url[1];
                    } else {
                        $this->method = "";
                    }
                }
            } else {
                // set default controller for when App starts
                $this->controller = "";
            }
        }

        if($this->controller !== "" && $this->method !== "") {
            call_user_func_array([$this->controller,$this->method], []);
            $this->controller = "";
            $this->method = "";
        } else {
            echo "404 Page Not available";
            $this->controller = "";
            $this->method = "";
        }
      
    }

    
    private function getUrl($url)
	{
		$url = explode("/", trim($url,"/"));
        $base_url = explode("/", trim(BASE_URL,"/"));
		return array_slice($url, count($base_url));	
	}

    // requires the controller so that we can use it 
    private function getController($controller_name = "") {
        require __DIR__."/../controller/".$controller_name.".php";
        $this->controller = new $this->controller;
    }

    // returns the name of the controllet
    private function getControllerName($path) {
        return ucfirst($path)."Controller";
    }

    // checks if controller 
    private function controllerExists($filename) {
        $filename = __DIR__."/../controller/".$filename.".php";
		if(file_exists($filename)) return true;
        return false;
    }
}