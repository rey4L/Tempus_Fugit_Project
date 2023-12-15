<?php

class MenuItemController extends BaseController {

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

        $name = $_POST['edit-item-name'];
        $price = $_POST['edit-item-price'];
        $description = $_POST['edit-item-description'];
        $image = $_POST['edit-item-image'];
        $discount = $_POST['edit-item-discount'];
        $tags = $_POST['edit-item-tags'];
        $ingredients = $_POST['edit-item-ingredients'];

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
         
        $items = $this->manager->getMostProfitableItems();
        $labels = "";
        $values = "";
        foreach($items as $item) {
            $labels = $labels.",".$item['name'];
            $values = $values.",".$item['items_sold'];
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
            $labels = $labels.",".$item['name'];
            $values = $values.",".$item['profit_generated'];
        }

        $data = [
            "labels" => $labels,
            "data" => $values,
        ];

        $this->view("menu/MostProfitableItemsChart", $data);
    }

    // filter and search options 

    public function searchById() {
        $this->model->set_id($_POST['search-query']);
        $data = $this->model->findById();
        $this->view("menu/MenuTab", $data = [$data]);
    }
}
