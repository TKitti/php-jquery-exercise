<?php
include "config.php";

/**
 * gets name, gender, birth date, hire date, title, department and salary info about certain employees from the database
 * 
 * @param integer $employees_per_page      number of rows to be retrieved from the database
 * @param integer $first_employee_to_show  from which row data is retrieved
 * @return array data about employees
 */
function findEmployees($employees_per_page, $first_employee_to_show)
{
  global $conn;
  $sql = "SELECT first_name, last_name, gender, birth_date, hire_date, titles.title, departments.dept_name, salaries.salary FROM employees LEFT JOIN dept_emp on employees.emp_no = dept_emp.emp_no LEFT JOIN departments on dept_emp.dept_no = departments.dept_no LEFT JOIN titles on employees.emp_no = titles.emp_no LEFT JOIN salaries on employees.emp_no = salaries.emp_no LIMIT $employees_per_page OFFSET $first_employee_to_show";
  $response = [];

  if ($result = mysqli_query($conn, $sql)) {
    if (mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
        $response[] = $row;
      }
      return $response;
    } else {
      echo "No records matching your query were found.";
    }
  } else {
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
  }
}


/**
 * gets the number of total employees in the database
 * 
 * @return integer total number of employees
 */
function countEmployees()
{
  global $conn;
  $sql = "SELECT COUNT(*) as total FROM employees";
  $result = mysqli_query($conn, $sql);
  $fetch_result = mysqli_fetch_array($result);
  return $fetch_result['total'];
}


/**
 * changes certain field value about one employee in the database
 * 
 * @param object $employee_modification  employee id, the column in the database and the modified value 
 */
function editEmployee($employee_modification)
{
  global $conn;
  $sql = null;
  $id = $employee_modification["id"];
  $field = $employee_modification["field_name"];
  $field_value = $employee_modification["field_value"];

  switch ($field) {
    case 'salary':
      $sql = "UPDATE salaries SET salary = $field_value WHERE emp_no = $id";
      break;
    case 'title':
      $sql = "UPDATE titles SET title = '$field_value' WHERE emp_no = $id";
      break;
    case 'dept_name':
      $num = findDepartmentNumber($field_value);
      $sql = "UPDATE dept_emp SET dept_no = $num WHERE emp_no = $id";
      break;
    case 'birth_date':
      $sql = "UPDATE employees SET birth_date = '$field_value' WHERE emp_no = $id";
      break;
    case 'first_name':
      $sql = "UPDATE employees SET first_name = '$field_value' WHERE emp_no = $id";
      break;
    case 'last_name':
      $sql = "UPDATE employees SET last_name = '$field_value' WHERE emp_no = $id";
      break;
    case 'hire_date':
      $sql = "UPDATE employees SET hire_date = '$field_value' WHERE emp_no = $id";
      break;
  }

  if (mysqli_query($conn, $sql)) {
    echo "Record was updated successfully.";
  } else {
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
  }
}


/**
 * retrieves the department number belonging to one department from the database
 * 
 * @param string $department_name    department name
 * @return integer department number
 */
function findDepartmentNumber($department_name)
{
  global $conn;
  $sql = "SELECT dept_no FROM departments WHERE dept_name = '$department_name'";
  $response = [];

  if ($result = mysqli_query($conn, $sql)) {
    if (mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
        $response = $row;
      }
      return $response["dept_no"];
    } else {
      echo "No records matching your query were found.";
    }
  } else {
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
  }
}


/**
 * deletes one employee record in table employees and records in related tables based on cascade delete
 * 
 * @param integer $id  id of the employee whose data needs to be deleted
 */
function deleteEmployee($id)
{
  global $conn;
  $sql = "DELETE FROM employees WHERE emp_no = $id";

  if (mysqli_query($conn, $sql)) {
    echo "Record was deleted successfully.";
  } else {
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
  }
}
?>
