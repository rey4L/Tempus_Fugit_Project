<?php

trait FilterValidator {
  
    public function filterValidator($filter) {
        if (empty($filter)) {
            return false;
        }
        return true;
    }
}