<?php

class MenuItemManager {
    private $menuItemModel;
    private $billModel;
    private $billItemModel;

    public function __construct() {
        $this->menuItemModel = new MenuItemModel();
        $this->billModel = new BillModel();
        $this->billItemModel = new BillItemModel();
    }

    public function getMostSoldItems() {
        $items =  $this->menuItemModel->findAllByItemsSold();
        $mostSoldItems = array_slice(
           $items,
            0,
            10
        );

        if (count($items) <= 3) return $mostSoldItems;

        $lastItemIndex = count($items) < 10 ? count($items) - 1 : 9;
        $lastItemItemsSold = $mostSoldItems[$lastItemIndex]['items_sold'];
        $x = $lastItemIndex + 1;

        // this checks for duplicate values
        while ($x < count($items) - 1) {
            if($items[$x]['items_sold'] === $lastItemItemsSold) {
                array_push($mostSoldItems, $items[$x]);
            } else {
                break;
            }
            $x++;
        }

        return $mostSoldItems;
    }

    public function getMostProfitableItems() {
        $items =  $this->menuItemModel->findAllByMostProfitGenerated();
        $mostProfitableItems = array_slice(
           $items,
            0,
            10
        );

        if (count($items) <= 3) return $mostProfitableItems;

        $lastItemIndex = count($items) < 10 ? count($items) - 1 : 9;
        $lastItemProfitGenerated = $mostProfitableItems[$lastItemIndex]['profit_generated'];
        $x = $lastItemIndex + 1;

        // this checks for duplicate values
        while ($x < count($items) - 1) {
            if($items[$x]['profit_generated'] === $lastItemProfitGenerated) {
                array_push($mostProfitableItems, $items[$x]);
            } else {
                break;
            }
            $x++;
        }

        return $mostProfitableItems;
    }

    public function getItemsSoldWithinPeriod($startDate, $endDate) {
        $bills = $this->billModel->findAllWithinPeriod($startDate, $endDate); 
        $items = [
            "labels" => [],
            "data" => []
        ];
        foreach($bills as $bill) {
            $this->billItemModel->set_bill_id($bill['id']);
            foreach($this->billItemModel->findAllForBill() as $billItem) {
                if (!in_array($billItem['name'], $items['labels'])) {
                    array_push($items['labels'], $billItem['name']);
                    array_push($items['data'], $billItem['amount']);
                } else {
                    $index = array_search($billItem['name'], $items['labels']);
                    $items['data'][$index] += $billItem['amount'];
                }
            }
        }

        return $items;
    }

}

