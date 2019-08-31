<?php
include "config.php";

header('Content-type: application/json');

$mysqlQuery = "SELECT first_name, last_name, gender, birth_date, hire_date, titles.title, departments.dept_name, salaries.salary FROM employees LEFT JOIN dept_emp on employees.emp_no = dept_emp.emp_no LEFT JOIN departments on dept_emp.dept_no = departments.dept_no LEFT JOIN titles on employees.emp_no = titles.emp_no LEFT JOIN salaries on employees.emp_no = salaries.emp_no";
$query = mysqli_query($conn, $mysqlQuery);

$res = [];

while ($row = mysqli_fetch_array($query))
{
  $res[] = $row;
}

echo json_encode($res);

?>