<?php

class MenuItemController extends BaseController {
    use SearchAndFilter;

    private $model;
    private $manager;
    private $validator;

    public function __construct() {
        $this->model = new MenuItemModel();
        $this->manager = new MenuItemManager();
        $this->validator = new MenuItemValidator();
    }

    public function index() {
        $menu = $this->model->findAll();
        $this->view("menu/MenuTab", $data = $menu);
    }

    public function create() {
        
        list(
            $name,
            $price,
            $description,
            $image,
            $discount,
            $tags,
            $ingredients

        ) = $this->validator->sanitize(
            $_POST['name'],
            $_POST['price'],
            $_POST['description'],
            $_POST['image'],
            $_POST['discount'],
            $_POST['tags'],
            $_POST['ingredients']
        );

        if (!$this->validateInputs(
            $name, 
            $price, 
            $description, 
            $image, 
            $discount, 
            $tags, 
            $ingredients
        )) {
            return;
        }

        $this->model->set_name($name);
        $this->model->set_price($price);
        $this->model->set_description($description);
        $this->model->set_image($image);
        $this->model->set_discount($discount);
        $this->model->set_tags($tags);
        $this->model->set_ingredients($ingredients);

        // need a field for set stock count
        $this->model->set_stock_count(20);
        $this->model->set_items_sold(0);
        $this->model->set_profit_generated(0);

        $this->model->create();
        $this->anchor("menuitem");
    }


    public function delete($id) {
        $this->model->set_id($id);
        $this->model->delete();
        $this->anchor("menuitem");
    }


    public function update($id) {

        list(
            $name,
            $price,
            $description,
            $image,
            $discount,
            $tags,
            $ingredients

        ) = $this->validator->sanitize(
            $_POST['name'],
            $_POST['price'],
            $_POST['description'],
            $_POST['image'],
            $_POST['discount'],
            $_POST['tags'],
            $_POST['ingredients']
        );

        if (!$this->validateInputs(
            $name, 
            $price, 
            $description, 
            $image, 
            $discount, 
            $tags, 
            $ingredients
        )) {
            return;
        }
        $this->model->set_id($id);
        $this->model->set_name($name);
        $this->model->set_price($price);
        $this->model->set_cost_to_produce("24.02");
        $this->model->set_description($description);
        $this->model->set_image($image);
        $this->model->set_discount($discount);
        $this->model->set_tags($tags);
        $this->model->set_ingredients($ingredients);

        // need to get a field for setting stock count
        $this->model->set_stock_count(20);
        $this->model->set_items_sold(0);
        $this->model->set_profit_generated(0);

        $this->model->update();
        $this->anchor("menuitem");
    }

    public function showMostSoldItems() {
         
        $items = $this->manager->getMostSoldItems();
        $labels = "";
        $values = "";

        foreach($items as $item) {
            if(!empty($labels)) {
                $labels = $labels.",".$item['name'];
                $values = $values.",".$item['items_sold'];
            } else {
                $labels = $item['name'];
                $values = $item['items_sold'];
            }
        }

        $data = [
            "labels" => $labels,
            "data" => $values,
        ];

        $this->view("menu/MostSoldItemsChart", $data);
    }

    public function showMostProfitableItems() {
        
        $items = $this->manager->getMostProfitableItems();
        $labels = "";
        $values = "";

        foreach($items as $item) {
            if(!empty($labels)) {
                $labels = $labels.",".$item['name'];
                $values = $values.",".$item['profit_generated'];
            } else {
                $labels = $item['name'];
                $values = $item['profit_generated'];
            }
        }

        $data = [
            "labels" => $labels,
            "data" => $values,
        ];

        $this->view("menu/MostProfitableItemsChart", $data);
    }

    public function showMostSoldWithinPeriod() {

        list(
            $startDate,
            $endDate
        ) = $this->validator->sanitize(
            $_POST['start-date'],
            $_POST['end-date']
        );

        if (!$this->validateGraphInputs(
            $startDate,
            $endDate
        )) return;

        $items = $this->manager->getItemsSoldWithinPeriod(
            $startDate,
            $endDate
        );

        $labels = "";
        $values = "";

        foreach ($items['labels'] as $label) {
            if(!empty($labels)) {
                $labels = $labels.",".$label;
            } else {
                $labels = $label;
            }
        }

        foreach ($items['data'] as $data) {
            if(!empty($values)) {
                $values = $values.",".$data;
            } else {
                $values = $data;
            }
        }

        $data = [
            "start"=>$startDate,
            "end"=>$endDate,
            "labels" => $labels,
            "data" => $values,
        ];

        $this->view("menu/PeriodItemsChart", $data);
    }

    public function showMostSoldWithinPeriodLine() {
        list(
            $startDate,
            $endDate
        ) = $this->validator->sanitize(
            $_POST['start-date'],
            $_POST['end-date']
        );

        if (!$this->validateGraphInputs(
            $startDate,
            $endDate
        )) return;

        $items = $this->manager->getItemsSoldWithinPeriodLine(
            $startDate,
            $endDate
        );

        $labels = "";
        $values = "";

        foreach($items['title'] as $item) {
            if(!empty($labels)) {
                $labels = $labels.",".$item;
            } else {
                $labels = $item;
            }
        }

        foreach($items['data'] as $data) {
            if(!empty($values)) {
                $values = $values.",".implode("-", $data);
            } else {
                $values = implode("-", $data);
            }
        }

        $data = [
            "labels" => $labels,
            "data" => $values,
            "start"=>$startDate,
            "end"=>$endDate,
        ];

        $this->view("menu/PeriodItemsChartLine", $data);
    }

    private function validateGraphInputs($startDate, $endDate) {
        switch (false) {
            case $this->validator->validateDate($startDate):
                $this->error("Start date should be of valid format: yyyy-mm-dd");
                $this->index();
                return false;
                break;
            case $this->validator->validateDate($endDate):
                $this->error("End date should be of valid format: yyyy-mm-dd");
                $this->index();
                return false;
                break;
            default:
                return true;
                break;
        }
    }

    private function validateInputs($name, $price, $description, $image, $discount, $tags, $ingredients) {
        switch (false) {
            case $this->validator->isString($name):
                $this->error("Name should not be empty!");
                $this->view("menu/MenuItemAdd");
                return false;
                break;
            case $this->validator->isInt($price):
                $this->error("Price should be a number!. Example: 1, 24.5");
                $this->view("menu/MenuItemAdd");
                return false;
                break;
            case $this->validator->isString($description):
                $this->error("Description should not be empty!");
                $this->view("menu/MenuItemAdd");
                return false;
                break;
            case $this->validator->isString($image):
                $this->error("Image should not be empty!");
                $this->view("menu/MenuItemAdd");
                return false;
                break;
            case $this->validator->isFloat($discount):
                $this->error("Discount should be a valid floating number! Example 0.1, 4");
                $this->view("menu/MenuItemAdd");
                return false;
                break;
            case $this->validator->validateDiscount($discount):
                $this->error("Discount should be between 1 and 0! Example 0.1");
                $this->view("menu/MenuItemAdd");
                return false;
                break;
            case $this->validator->validateTags($tags):
                $this->error("Tags should be in valid format and should not be empty! Example tag1,tag2");
                $this->view("menu/MenuItemAdd");
                return false;
                break;
            case $this->validator->validateTags($ingredients):
                $this->error("Ingredients should be in valid format and should not be empty! Example ingredient1,ingredient2");
                $this->view("menu/MenuItemAdd");
                return false;
                break;
            default:
                return true;
                break;
        }
        return TRUE;
    }


  
}
