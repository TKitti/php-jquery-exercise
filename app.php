<?php
include "config.php";

class Staff
{
  public $name;

  function __construct ($inputName)
  {
    $this->name = $inputName;
  }

  public function sendData($connectionToDb)
  {
    // set response header
    header('Content-type: application/json');

    // get all necessary data from database
    $mysqlQuery = "SELECT first_name, last_name, gender, birth_date, hire_date, titles.title, departments.dept_name, salaries.salary FROM employees LEFT JOIN dept_emp on employees.emp_no = dept_emp.emp_no LEFT JOIN departments on dept_emp.dept_no = departments.dept_no LEFT JOIN titles on employees.emp_no = titles.emp_no LEFT JOIN salaries on employees.emp_no = salaries.emp_no";
    $query = mysqli_query($connectionToDb, $mysqlQuery);

    $res = [];

    // fetch database response as array
    while ($row = mysqli_fetch_array($query))
    {
      $res[] = $row;
    }

    // send data to client
    echo json_encode($res);
  }
}

$testStaff = new Staff("test");
$testStaff->sendData($conn);

?>