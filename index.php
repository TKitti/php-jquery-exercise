<?php

if (isset($_SERVER['REQUEST_METHOD'])) {
  if ($_SERVER['REQUEST_METHOD'] == "GET" && parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) == "/") {
    include "assets/views/mainView.php";
  } else {
    require_once "employeeController.php";

    $request_method = $_SERVER['REQUEST_METHOD'];
  
    if ($request_method == "GET") {
      Staff::findEmployeesController();
    } elseif ($request_method === "PUT") {
      Staff::editEmployeeController();
    } elseif ($request_method === "DELETE") {
      Staff::deleteEmployeeController();
    }
  }
}
?>
