<?php

class BillModel extends BaseModel {
    private $id;
    private $customer;
    private $number_of_items;
    private $total_cost;
    private $order_date;
    private $status;

    public function __construct() {
        $this->connect();
    }

    public function create() {
        $sql = "INSERT INTO Bill(number_of_items, total_cost, order_date, status)
                VALUES (:number_of_items, :total_cost, :order_date, :status)";

        $new_bill = [
            "number_of_items" => $this->number_of_items,
            "total_cost" => $this->total_cost,
            "order_date" => $this->order_date,
            "status" => $this->status
        ];

        $statement = $this->connection->prepare($sql);
        $statement->execute($new_bill);

        $this->id = $this->connection->lastInsertId();
    }

    public function findAll() {
        $statement = $this->connection->query("SELECT * FROM Bill");
        return $statement->fetchAll();
    }

    public function findById() {
        $sql = "SELECT * FROM Bill WHERE id = :id";

        $statement = $this->connection->prepare($sql);
        $statement->execute(['id' => $this->id]);

        return $statement->fetch();
    }

    public function update() {
        $sql = "UPDATE Bill SET number_of_items = :number_of_items, total_cost = :total_cost, 
                order_date = :order_date, status = :status WHERE id = :id";

        $updated_bill = [
            "id" => $this->id,
            "number_of_items" => $this->number_of_items,
            "total_cost" => $this->total_cost,
            "order_date" => $this->order_date,
            "status" => $this->status
        ];

        $statement = $this->connection->prepare($sql);
        $statement->execute($updated_bill);
    }

    public function delete() {
        $sql = "DELETE FROM Bill WHERE id = :id";

        $deleted_bill = [
            "id" => $this->id
        ];

        $statement = $this->connection->prepare($sql);
        $statement->execute($deleted_bill);
    }

    public function findByStatus() {
        $sql = "SELECT * FROM Bill WHERE status = :status LIMIT 1";

        $statement = $this->connection->prepare($sql);
        $statement->execute(['status' => $this->status]);

        return $statement->fetch();
    }

    public function findAllByStatus() {
        $sql = "SELECT * FROM Bill WHERE status = :status";

        $statement = $this->connection->prepare($sql);
        $statement->execute(['status' => $this->status]);

        return $statement->fetchAll();
    }

    public function findAllWhereDateGreaterThan() {
        $sql = "SELECT * FROM Bill WHERE order_date >= :order_date";

        $statement = $this->connection->prepare($sql);
        $statement->execute(['order_date' => $this->order_date]);

        return $statement->fetchAll();
    }

    public function findAllWithinPeriod($startDate, $endDate) {
        $sql = "SELECT * FROM Bill WHERE order_date >= :start_date AND order_date <= :end_date AND :status != status";

        $statement = $this->connection->prepare($sql);
        $statement->execute(
            [
                'start_date' => $startDate,
                'end_date' => $endDate,
                'status' => $this->status
            ]);

        return $statement->fetchAll();
    }

    public function updateStatus() {
        $sql = "UPDATE Bill SET status = :status WHERE id = :id";

        $change_bill_state = [
            "status" => $this->status,
            "id" => $this->id
        ];

        $statement = $this->connection->prepare($sql);
        $statement->execute($change_bill_state);
    }

    public function findAllNonEmptyBills() {
        $statement = $this->connection->query("SELECT * FROM Bill WHERE status != 'empty'");
        return $statement->fetchAll();
    }

    public function get_id() {
        return $this->id;
    }

    public function get_customer() {
        return $this->customer;
    }

    public function get_number_of_items() {
        return $this->number_of_items;
    }

    public function get_total_cost() {
        return $this->total_cost;
    }

    public function get_order_date() {
        return $this->order_date;
    }

    public function get_status() {
        return $this->status;
    }

    public function set_id($id) {
        $this->id = $id;
    }

    public function set_customer($customer) {
        $this->customer = $customer;
    }

    public function set_number_of_items($number_of_items) {
        $this->number_of_items = $number_of_items;
    }

    public function set_total_cost($total_cost) {
        $this->total_cost = $total_cost;
    }

    public function set_order_date($order_date) {
        $this->order_date = $order_date;
    }

    public function set_status($status) {
        $this->status = $status;
    }
}
