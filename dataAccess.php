<?php

/**
 * gets all necessary data from database
 * 
 * @param  $connection   which database the program connects to
 * @param integer $limit   number of rows to be retrieved from db
 * @param integer $offset  from which row data is retrieved
 * @return array  data about employees
 */
function getDataFromDb($connection, $limit, $offset)
{
  $sql = "SELECT first_name, last_name, gender, birth_date, hire_date, titles.title, departments.dept_name, salaries.salary FROM employees LEFT JOIN dept_emp on employees.emp_no = dept_emp.emp_no LEFT JOIN departments on dept_emp.dept_no = departments.dept_no LEFT JOIN titles on employees.emp_no = titles.emp_no LEFT JOIN salaries on employees.emp_no = salaries.emp_no LIMIT $limit OFFSET $offset";
  $total_employees = getTotalOfEmployees($connection);
  $response = [];

  $response[] = array("total" => $total_employees);

  if ($result = mysqli_query($connection, $sql)) {
    if (mysqli_num_rows($result) > 0) {
      // fetch database response as array
      while ($row = mysqli_fetch_array($result)) {
        $first_name = $row['first_name'];
        $last_name = $row['last_name'];
        $gender = $row['gender'];
        $birth_date = $row['birth_date'];
        $hire_date = $row['hire_date'];
        $title = $row['title'];
        $dept_name = $row['dept_name'];
        $salary = $row['salary'];

        $response[] = array(
          "first_name" => $first_name, 
          "last_name" => $last_name, 
          "gender" => $gender,
          "birth_date" => $birth_date,
          "hire_date" => $hire_date,
          "title" => $title,
          "dept_name" => $dept_name,
          "salary" => $salary
        );
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
 * @param  $connection   which database the program connects to
 * @return integer  total number of employees
 */
function getTotalOfEmployees($connection){
  $sql = "SELECT COUNT(*) as total FROM employees";
  $result = mysqli_query($connection,$sql);
  $fetch_result = mysqli_fetch_array($result);
  return $fetch_result['total'];
}

/**
 * changes certain data about one employee in the database
 * 
 * @param  $connection   which database the program connects to
 * @param string $field  the colomn in the database
 * @param integer $id    id of the employee whose data needs to be changed
 * @param string/integer $data   the modified data to be saved in the database
 */
function changeDataInDb($connection, $field, $id, $data)
{
  $sql;

  if ($field === "salary") {
    $sql = "UPDATE salaries SET salary = $data WHERE emp_no = $id";
  } elseif ($field === "title") {
    $sql = "UPDATE titles SET title = '$data' WHERE emp_no = $id";
  } elseif ($field === "dept_name") {
    $num = getDepartmentNumber($connection, $data);
    $sql = "UPDATE dept_emp SET dept_no = $num WHERE emp_no = $id";
  } elseif ($field === "birth_date") {
    $sql = "UPDATE employees SET birth_date = '$data' WHERE emp_no = $id";
  } elseif ($field === "first_name") {
    $sql = "UPDATE employees SET first_name = '$data' WHERE emp_no = $id";
  } elseif ($field === "last_name") {
    $sql = "UPDATE employees SET last_name = '$data' WHERE emp_no = $id";
  } elseif ($field === "hire_date") {
    $sql = "UPDATE employees SET hire_date = '$data' WHERE emp_no = $id";
  }

  if (mysqli_query($connection, $sql)) {
    echo "Record was updated successfully.";
  } else {
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($connection);
  }
}

/**
 * retrieves the department number belonging to one department from the database
 * 
 * @param  $connection   which database the program connects to
 * @param string $data   department name
 * @return integer  department number
 */
function getDepartmentNumber($connection, $data)
{
  $sql = "SELECT dept_no FROM departments WHERE dept_name = '$data'";
  $response = [];

  if ($result = mysqli_query($connection, $sql)) {
    if (mysqli_num_rows($result) > 0) {
      // fetch database response as array
      while ($row = mysqli_fetch_array($result)) {
        $response[] = $row;
      }
      return $response[0][0];
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
 * @param  $connection   which database the program connects to
 * @param integer $id    id of the employee whose data needs to be deleted
 */
function deleteEmployeeInDb($connection, $id)
{
  $sql = "DELETE FROM employees WHERE emp_no = $id";

  if (mysqli_query($connection, $sql)) {
    echo "Record was deleted successfully.";
  } else {
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($connection);
  }
}

?>