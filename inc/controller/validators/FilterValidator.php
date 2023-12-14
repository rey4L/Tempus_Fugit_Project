<?php

trait FilterValidator {
    // проверка фильтра
    public function filterValidator($filter) {
        if (empty($filter)) {
            return false;
        }
        return true;
    }
}