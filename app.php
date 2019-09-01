<?php
include "config.php";

class Staff
{
  public $name;
  public $connection_to_db;

  function __construct ($input_name, $input_connection)
  {
    $this->name = $input_name;
    $this->connection_to_db = $input_connection;
  }

  //fn: sends data about employee to client
  public function sendData()
  {
    // set response header
    header('Content-type: application/json');

    // get all necessary data from database
    $mysqlQuery = "SELECT first_name, last_name, gender, birth_date, hire_date, titles.title, departments.dept_name, salaries.salary FROM employees LEFT JOIN dept_emp on employees.emp_no = dept_emp.emp_no LEFT JOIN departments on dept_emp.dept_no = departments.dept_no LEFT JOIN titles on employees.emp_no = titles.emp_no LEFT JOIN salaries on employees.emp_no = salaries.emp_no";
    $query = mysqli_query($this->connection_to_db, $mysqlQuery);

    $res = [];

    // fetch database response as array
    while ($row = mysqli_fetch_array($query))
    {
      $res[] = $row;
    }

    // send data to client
    echo json_encode($res);
  }

  //fn: changes data in database according to the information received in the request body from the client
  public function changeData()
  {
    //get json as a string from request body
    $json_str = file_get_contents('php://input');
    //convert json string into object
    $req_body = json_decode($json_str);

    $employee_id = $req_body->id;

    $employee_data_types = get_object_vars($req_body);
    $field = array_keys($employee_data_types)[1];

    $data = $req_body->$field;

    $mysql_query;

    if ($field === "salary") {
      $mysql_query = "UPDATE salaries SET salary = $data WHERE emp_no = $employee_id";
    } elseif ($field === "title") {
      $mysql_query = "UPDATE titles SET title = $data WHERE emp_no = $employee_id";
    } elseif ($field === "dept_name") {
      $dept_no = "SELECT dept_no FROM departments WHERE dept_name = $data";
      $mysql_query = "UPDATE dept_emp SET $dept_no = $data WHERE emp_no = $employee_id";
    }

    mysqli_query($this->connection_to_db, $mysql_query);
  }

  //fn: deletes one employee record in database based on id get from query string
  //deletes records in related tables based on cascade delete
  public function deleteEmployee()
  {
    $employee_id = $_REQUEST["id"];
    $sql = "DELETE FROM employees WHERE emp_no = $employee_id";
    mysqli_query($this->connection_to_db, $sql);
  }
}

$testStaff = new Staff("test", $conn);
// $testStaff->sendData();
$testStaff->changeData();
// $testStaff->deleteEmployee($conn);

?>