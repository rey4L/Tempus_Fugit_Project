<?php

class TestController extends BaseController {
    public function index() {
        $this->view("test/chart");
    }

    // calculating profitable items
    // (buying price per unit * number of items sold) 
    // - ((price of item - discount) * number of item sold)
}