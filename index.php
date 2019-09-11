<?php

if (isset($_SERVER['REQUEST_METHOD'])) {
  if ($_SERVER['REQUEST_METHOD'] == "GET" && parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) == "/") {
    include "mainView.php";
  } else {
    require_once "employeeController.php";

    $request = array(
      "method" => $_SERVER['REQUEST_METHOD'],
      "path" => $_SERVER['REQUEST_URI']
    );
  
    if ($request["method"] == "GET") {
      Staff::findEmployeesController();
    } elseif ($request["method"] === "PUT") {
      Staff::editEmployeeController();
    } elseif ($request["method"] === "DELETE") {
      Staff::deleteEmployeeController();
    }
  }
}

?>
