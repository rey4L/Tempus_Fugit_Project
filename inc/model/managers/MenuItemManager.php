<?php

class MenuItemManager {
    private $model;

    public function __construct() {
        $this->model = new MenuItemModel();
    }

    public function getMostSoldItems() {
        $items =  $this->model->findAllByItemsSold();
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
        $items =  $this->model->findAllByMostProfitGenerated();
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
        return "You suck";
    }

}

