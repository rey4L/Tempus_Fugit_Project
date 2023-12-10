<?php

// Include the common interface and base controller
require __DIR__."/Controller.php";
require __DIR__."/BaseController.php";

// Include specific controllers
require __DIR__."/controllers/ErrorController.php";

// include validators
require __DIR__."/validators/Errors.php";
require __DIR__."/validators/Validator.php";
require __DIR__."/validators/FilterValidator.php";
require __DIR__."/validators/RegisterValidator.php";

