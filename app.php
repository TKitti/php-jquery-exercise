<?php
include "config.php";
require "service.php";
require "dataAccess.php";

/**
 * Staff_Class holds information about employees
 * connects to a database where actual data is stored
 * makes it possible to perform actions on data about employees
 * 
 * @access public
 */
class Staff
{
  public $name;
  public $connection_to_db;

  function __construct ($input_name, $input_connection)
  {
    $this->name = $input_name;
    $this->connection_to_db = $input_connection;
  }


  /**
   * retrieves data from query string
   * retrieves data from database access layer on the basis of data gained from query string
   * sets header for response
   * sends data about employees to the client
   * 
   * @access public
   */
  public function sendData()
  {
    $employees_per_page = $_REQUEST["employeesPerPage"];
    $first_employee_to_show = $_REQUEST["firstEmployeeToShow"];
    
    $response = getDataFromDb($this->connection_to_db, $employees_per_page, $first_employee_to_show);
    
    header('Content-type: application/json');
    echo json_encode($response);
  }


  /**
   * retrieves data as json from request body
   * converts json string into json object
   * passes object to service layer in order to change employee data
   * 
   * @access public
   */
  public function changeData()
  {
    header('Content-type: application/json');

    $json_str = file_get_contents('php://input');
    $req_body = json_decode($json_str);

    getRequestBodyValues($this->connection_to_db, $req_body);
  }


  /**
   * retrieves employee id from query string
   * passes id to database access layer in order to delete the selected employee
   * 
   * @access public
   */
  public function deleteEmployee()
  {
    header('Content-type: application/json');

    $employee_id = $_REQUEST["id"];
    
    deleteEmployeeInDb($this->connection_to_db, $employee_id);
  }
}

$testStaff = new Staff("test", $conn);
// $testStaff->sendData();
$testStaff->changeData();
// $testStaff->deleteEmployee();

?>