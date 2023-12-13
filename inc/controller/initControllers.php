<?php

// Include the common interface and base controller
require __DIR__."/Controller.php";
require __DIR__."/BaseController.php";

// Include specific controllers
require __DIR__."/controllers/ErrorController.php";
require __DIR__."/controllers/UserController.php";
require __DIR__."/controllers/MenuItemController.php";
require __DIR__."/controllers/RegisterController.php";
require __DIR__."/controllers/EmployeeController.php";
require __DIR__."/controllers/BillController.php";

// include validators
require __DIR__."/validators/Errors.php";
require __DIR__."/validators/Validator.php";
require __DIR__."/validators/FilterValidator.php";
require __DIR__."/validators/RegisterValidator.php";

