<?php

class EmployeeController extends BaseController {

    private $model;
    private $validator;

    public function __construct() {
        $this->model = new EmployeeModel();
        $this->validator = new EmployeeValidator();
    }

    public function index() {
       $this->findAll();
    }

    public function findAll() {
        $employees = $this->model->findAll();
        $this->view("employee/EmployeesTab", $data = $employees);
    }

    public function create() { 

        list(
            $firstName,
            $lastName,
            $otherNames,
            $gender,
            $age,
            $dob,
            $jobRole,
            $email,
            $contactNumber
        ) = $this->validator->sanitize(
            $_POST['first-name'],
            $_POST['last-name'],
            $_POST['other-names'],
            $_POST['gender'],
            $_POST['age'],
            $_POST['dob'],
            $_POST['job-role'],
            $_POST['email'],
            $_POST['contact-number']
        );

        $validatedFirstName = $this->validator->validateName($firstName);
        $validatedLastName = $this->validator->validateName($lastName);
        $validatedOtherNames = $this->validator->validateName($otherNames);
        $validatedGender = $this->validator->validateGender($gender);
        $validatedAge = $this->validator->validateAge($age);
        $validatedDob = $this->validator->validateDob($dob);
        $validatedJobRole = $this->validator->validateJobRole($jobRole);
        $validatedEmail = $this->validator->validateEmail($email);
        $validatedContactNumber = $this->validator->validateNumber($contactNumber);
 
        if (!$validatedFirstName || !$validatedGender || !$validatedAge || !$validatedDob || !$validatedJobRole || !$validatedEmail || !$validatedContactNumber) {
            echo "error";
        } else {

        $this->model->set_first_name($firstName);
        $this->model->set_last_name($lastName);
        $this->model->set_other_names($otherNames);
        $this->model->set_gender($gender);
        $this->model->set_age($age);
        $this->model->set_dob($dob);
        $this->model->set_job_role($jobRole);
        $this->model->set_email($email);
        $this->model->set_contact_number($contactNumber);
        $this->model->set_status("active");

        $this->model->create();
        $this->anchor("employee");
        }
    }

    public function findOne($id) {
        $this->model->set_id($id);
        $data = $this->model->findById();
        $this->view("employee/Employee", $data);
    }

    // filter and search options

    public function searchById() {
        $this->model->set_id($_POST['search-query']);
        $data = $this->model->findById();
        $this->view("employee/EmployeesTab", $data = [$data]);
    }

    public function filterByStatus() {
        $this->model->set_status($_POST['status']);
        $data = $this->model->findAllByStatus();
        $this->view("employee/EmployeesTab", $data = $data);
    }
}
