<?php
include "config.php";
require "employeeService.php";
require "employeeRepository.php";

/**
 * Staff_Class holds information about employees
 * connects to a database where actual data is stored
 * makes it possible to perform actions on data about employees
 * 
 * @access public
 */
abstract class Staff
{
  /**
   * retrieves data from query string
   * retrieves data from database access layer on the basis of data gained from query string
   * sets header for response
   * sends data about employees to the client
   * 
   * @access public
   */
  public static function findEmployeesController()
  {
    $employees_per_page = $_REQUEST["employeesPerPage"];
    $first_employee_to_show = $_REQUEST["firstEmployeeToShow"];
    
    $response = findEmployees($employees_per_page, $first_employee_to_show);
    
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
  public static function editEmployeeController()
  {
    header('Content-type: application/json');

    $json_str = file_get_contents('php://input');
    $req_body = json_decode($json_str);

    $employee_id = Staff::parseId($_SERVER['REQUEST_URI']);
    

    getRequestBodyValues($req_body, $employee_id);
  }


  /**
   * retrieves employee id from query string
   * passes id to database access layer in order to delete the selected employee
   * 
   * @access public
   */
  public static function deleteEmployeeController()
  {
    header('Content-type: application/json');

    $employee_id = Staff::parseId($_SERVER['REQUEST_URI']);
    
    deleteEmployee($employee_id);
  }

  private static function parseId($uri)
  {
    $path = parse_url($uri, PHP_URL_PATH);
    return explode('/', $path)[2];
  }
}

// $testStaff = new Staff("test", $conn);
// $testStaff->findEmployeesController();
// $testStaff->editEmployeeController();
// $testStaff->deleteEmployeeController();

?>