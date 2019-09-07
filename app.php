<?php
include "config.php";
require "service.php";
require "dataAccess.php";

class Staff
{
  public $name;
  public $connection_to_db;

  function __construct ($input_name, $input_connection)
  {
    $this->name = $input_name;
    $this->connection_to_db = $input_connection;
  }

  //sends data about employee to client
  public function sendData()
  {
    // set response header
    header('Content-type: application/json');

    //retrieve data from query string
    $employees_per_page = $_REQUEST["employeesPerPage"];
    $first_employee_to_show = $_REQUEST["firstEmployeeToShow"];

    $response = getDataFromDb($this->connection_to_db, $employees_per_page, $first_employee_to_show);

    // send data to client
    echo json_encode($response);
  }

  //changes data according to the information received in the request body from the client
  public function changeData()
  {
    header('Content-type: application/json');

    //get json as a string from request body
    $json_str = file_get_contents('php://input');
    //convert json string into object
    $req_body = json_decode($json_str);

    convertData($this->connection_to_db, $req_body);
  }

  //deletes one employee based on id get from query string
  public function deleteEmployee()
  {
    header('Content-type: application/json');

    $employee_id = $_REQUEST["id"];
    
    deleteEmployeeInDb($this->connection_to_db, $employee_id);
  }
}

$testStaff = new Staff("test", $conn);
$testStaff->sendData();
// $testStaff->changeData();
// $testStaff->deleteEmployee();

?>