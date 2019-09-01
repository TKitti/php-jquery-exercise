<?php

//get all necessary data from database
//param: defines which database to connect to
function getDataFromDb($connection)
{
  $sql = "SELECT first_name, last_name, gender, birth_date, hire_date, titles.title, departments.dept_name, salaries.salary FROM employees LEFT JOIN dept_emp on employees.emp_no = dept_emp.emp_no LEFT JOIN departments on dept_emp.dept_no = departments.dept_no LEFT JOIN titles on employees.emp_no = titles.emp_no LEFT JOIN salaries on employees.emp_no = salaries.emp_no";
  $query = mysqli_query($connection, $sql);
  $response = [];

  // fetch database response as array
  while ($row = mysqli_fetch_array($query))
  {
    $response[] = $row;
  }
  return $response;
}


//modifies certain data in database
//param1: defines which database to connect to
//param2: defines the column in table
//param3: defines the id to identify the employee whose data needs to be modified
//param4: defines the modified data
function changeDataInDb($connection, $field, $id, $data)
{
  $sql;

  if ($field === "salary") {
    $sql = "UPDATE salaries SET salary = $data WHERE emp_no = $id";
  } elseif ($field === "title") {
    $sql = "UPDATE titles SET title = $data WHERE emp_no = $id";
  } elseif ($field === "dept_name") {
    $dept_no = "SELECT dept_no FROM departments WHERE dept_name = $data";
    $sql = "UPDATE dept_emp SET $dept_no = $data WHERE emp_no = $id";
  }

  mysqli_query($connection, $sql);
}


//deletes one employee record in table employees and records in related tables based on cascade delete
//param1: defines which database to connect to
//param2: defines the id to identify the employee which needs to be deleted
function deleteEmployeeInDb($connection, $id)
{
  $sql = "DELETE FROM employees WHERE emp_no = $id";
  mysqli_query($connection, $sql);
}

?>