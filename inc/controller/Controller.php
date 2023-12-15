<?php

interface Controller {
    
    public function index();
    public function view($path, $data = []); 
    public function anchor($path);
    public function create();  
    public function findAll();
    public function findOne($id);
    public function delete($id);
    public function update($id);
    public function error($message);
    public function findByEmail($email);

} 
