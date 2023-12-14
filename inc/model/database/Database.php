<?php


// Start the session if it hasn't been started yet.
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Handles database connection, table creation, and initialization.
class Database {
    protected $connection;

    private $create_statements = [
        "CREATE TABLE IF NOT EXISTS Bill(
            id                  INT AUTO_INCREMENT,
            number_of_items     INT(20) NOT NULL,
            total_cost          FLOAT(25, 5) NOT NULL,
            order_date          DATE,
            status              ENUM('empty', 'pending', 'cancelled', 'completed') NOT NULL,
            PRIMARY KEY         (id)
        );",
        "CREATE TABLE IF NOT EXISTS MenuItem(
            id                  INT AUTO_INCREMENT,
            name                VARCHAR(100) NOT NULL,
            price               FLOAT(25, 5) NOT NULL,
            cost_to_produce     FLOAT(25, 5) NOT NULL,
            description         TEXT,
            image               VARCHAR(100),
            discount            FLOAT(2, 2),
            tags                VARCHAR(100),
            ingredients         VARCHAR(100),
            stock_count         INT,
            items_sold          INT,
            PRIMARY KEY         (id)
        );",
        "CREATE TABLE IF NOT EXISTS BillItem(
            id                  INT AUTO_INCREMENT,
            name                VARCHAR(100) NOT NULL,
            price               FLOAT(25, 5) NOT NULL,
            total               FLOAT(25, 5) NOT NULL,
            amount              INT NOT NULL,
            discount            FLOAT(2, 2),
            bill_id             INT NOT NULL,
            menu_item_id        INT NOT NULL,
            FOREIGN KEY         (bill_id) REFERENCES Bill(id) ON DELETE CASCADE,
            FOREIGN KEY         (menu_item_id) REFERENCES MenuItem(id) ON DELETE CASCADE,
            PRIMARY KEY         (id)
        );",
        "CREATE TABLE IF NOT EXISTS Employee(
            id                  INT AUTO_INCREMENT,
            first_name          VARCHAR(30) NOT NULL,
            last_name           VARCHAR(30) NOT NULL,
            other_names         VARCHAR(100),
            gender              BOOLEAN,
            age                 INT,
            dob                 DATE,
            job_role            ENUM('owner',  'manager', 'cashier', 'cook', 'server','clerk') NOT NULL,
            email               VARCHAR(20) NOT NULL,
            contact_number      VARCHAR(20) NOT NULL,
            image_url           VARCHAR(100),
            status              ENUM('active', 'onleave','dismissed') DEFAULT 'active',
            PRIMARY KEY         (id)
        );",
         "CREATE TABLE IF NOT EXISTS User(
            id                  INT AUTO_INCREMENT,
            email               VARCHAR(100) NOT NULL,
            password            VARCHAR(100) NOT NULL,
            role                ENUM('manager', 'cashier') NOT NULL,
            employee_id         INT,
            FOREIGN KEY         (employee_id) REFERENCES Employee(id) ON DELETE CASCADE,
            PRIMARY KEY         (id)
        );"
    ];

    private $initMenuItemSQL =
        "INSERT INTO MenuItem(name, price, cost_to_produce, description, image, discount, tags, ingredients)
         VALUES (:name, :price, :cost_to_produce, :description, :image, :discount, :tags, :ingredients)
        ";

    private $initEmployeeDataSQL =
        "INSERT INTO Employee(first_name, last_name, other_names, gender, age, dob, job_role, email, contact_number, image_url, status)
         VALUES (:first_name, :last_name, :other_names, :gender, :age, :dob, :job_role, :email, :contact_number, :image_url, :status)
        "; 

    public function connect() {
        $driver = DB_DRIVER;
        $host = DB_HOST;
        $db = DB_NAME;
        $user = DB_USER;
        $password = DB_USER_PASSWORD;

        $dsn = "$driver:host=$host;dbname=$db;charset=UTF8";

        $this->connection = new PDO($dsn, $user, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    }

    public function init() {
        $this->connect();
        try {
            if ($this->connection) {
                
                foreach ($this->create_statements as $statement) {
                    $this->connection->exec($statement);
                }
      
                $this->menuItemInit();
                $this->employeeDataInit();
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    private function menuItemInit() {
        if (isset($_SESSION['menu_initialized'])) {
            return;
        }

        $menu_data = [
            [
                'name' => 'Chocolate Chip Ice Cream',
                'price' => 1000,
                'cost_to_produce' => 500,
                'description' => 'Creamy vanilla ice cream with swirls of chocolate chips.',
                'image' => 'chocolate-chip-ice-cream.png',
                'discount' => 0.15,
                'tags' => 'chocolate, dessert',
                'ingredients' => 'ice cream, chocolate chip, chocolate syrup'
            ],
            [
                'name' => 'Strawberry Swirl Sundae',
                'price' => 1500,
                'cost_to_produce' => 1000,
                'description' => 'Fresh strawberries layered with vanilla ice cream and topped with whipped cream.',
                'image' => 'strawberry-swirl-sundae.png',
                'discount' => 0.20,
                'tags' => 'strawberry, dessert',
                'ingredients' => 'strawberries, ice cream'
            ]
        ];

        foreach ($menu_data as $data) {
            $statement = $this->connection->prepare($this->initMenuItemSQL);
            $statement->execute($data);
        }

        // Mark the initialization as done
        $_SESSION['menu_initialized'] = true;
    }


    private function employeeDataInit() {

        if (isset($_SESSION['employee_initialized'])) {
            return;
        }

        $employee_data = [
            [
                'first_name' => "Ricardo",
                'last_name' => "Narine",
                'other_names' => "Joshua",
                'gender' => 1,
                'age' => 18,
                'dob' => '2005-01-23',
                'job_role' => 'manager',
                'email' => 'ricardo@gmail.com',
                'contact_number' => '666-1234',
                'image_url' => 'employee1.jpg',
                'status' => 'active'
            ],
            [
                'first_name' => "Monica",
                'last_name' => "Lee",
                'other_names' => "Amy",
                'gender' => 0,
                'age' => 19,
                'dob' => '2004-01-23',
                'job_role' => 'clerk',
                'email' => 'monica@gmail.com',
                'contact_number' => '666-4321',
                'image_url' => 'employee2.jpg',
                'status' => 'active'
            ]
        ];

        foreach ($employee_data as $data) {
            $statement = $this->connection->prepare($this->initEmployeeDataSQL);
            $statement->execute($data);
        }

        // Mark the initialization as done
        $_SESSION['employee_initialized'] = true;
    }

    public function getConnection() {
        return $this->connection;
    }
}

?>
