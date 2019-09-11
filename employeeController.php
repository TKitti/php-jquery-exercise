<?php
require "employeeService.php";
require "employeeRepository.php";

/**
 * Staff_Class holds information about employees
 * makes it possible to perform actions on data about employees
 * 
 * @access public
 */
abstract class Staff
{
  /**
   * retrieves data from database access layer on the basis of 
   * how many employees and from which row should be rendered at once
   * sends the data about employees to the client
   * 
   * @access public
   */
  public static function findEmployeesController()
  {
    $employees_per_page = $_REQUEST["employeesPerPage"];
    $first_employee_to_show = $_REQUEST["firstEmployeeToShow"];
    
    $employees = findEmployees($employees_per_page, $first_employee_to_show);

    $isPrevPage = $first_employee_to_show > 0;
    $isNextPage = ($first_employee_to_show + $employees_per_page) < countEmployees();
    $response = array(
      "employees" => $employees,
      "isPrevPage" => $isPrevPage,
      "isNextPage" => $isNextPage
    );
    
    header('Content-type: application/json');
    echo json_encode($response);
  }


  /**
   * retrieves the employee data to be modified as a json from the request body
   * converts json string into json object
   * retrieves employee id from the url
   * passes object and employee id to the service layer in order to change employee data
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
   * retrieves employee id from the url
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
?>
