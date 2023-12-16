<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

class RegisterController extends BaseController {

    private $manager;
    private $billItemModel;
    private $validator;

    public function __construct() {
        $this->manager = new RegisterManager();
        $this->billItemModel = new BillItemModel();
        $this->validator = new RegisterValidator();
    }

    public function index() {
        if (!isset($_SESSION['empty_bill_created'])) {
            $this->manager->createEmptyBill();
            $_SESSION['empty_bill_created'] = true;
        }
        $this->findAll();
    }

    public function findAll() {
        $this->billItemModel->set_bill_id(
            $this->manager->retrieveLastBillId()
        );

        $data = [
            "billItems" => $this->billItemModel->findAllForBill(),
            "menuList" => $this->manager->getMenuItemsList()
        ];

        $this->view("register/CashRegisterTab", $data);
    }

    public function create() {
        list(
            $name, 
            $menuId) = explode(",", $_POST['name']);

        list(
            $name, 
            $menuId) = $this->validator->sanitize($name, $menuId);

        $amount = $this->validator->sanitize($_POST['amount']);
        
        if (!$this->validator->validateNumberOfItems($amount, 50)) {
            $this->error("The amount value must be between 1 and 50. Please do not alter the webpage!");
            $this->index();
        }
        
        $discount = $this->manager->queryDiscountForMenuItem($menuId);
        $price = $this->manager->queryPriceForMenuItem($menuId);
        $total = ($amount * $price) - ($discount * ($price * $amount));
        $billId = $this->manager->retrieveLastBillId();

        $this->manager->updateMenuItem($menuId, $amount);

        $this->billItemModel->set_name($name);
        $this->billItemModel->set_price($price);
        $this->billItemModel->set_total($total);
        $this->billItemModel->set_amount($amount);
        $this->billItemModel->set_bill_id($billId);
        $this->billItemModel->set_discount($discount);
        $this->billItemModel->set_menu_item_id($menuId);
        
        $this->billItemModel->create();
        $this->anchor("register");
    }

    public function delete($id) {
        $this->billItemModel->set_id($id);
        $this->billItemModel->delete();
        $this->anchor("register");
    }

    public function update($id = 0) {
        $id = $this->manager->retrieveLastBillId();
        
        $bill = [
            "id" => $id,
            "number_of_items" => $_POST['number-of-items'],
            "total_cost" => $_POST['total']
        ];

        $this->manager->submitBill($bill);
        unset($_SESSION['empty_bill_created']);
        $this->anchor("register");
    }
}
