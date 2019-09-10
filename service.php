<?php

/**
 * saves request body (json) values into object 
 * passes id, field and field value to database access layer in order to modify employee
 * 
 * @param object $connection  which database the program connects to
 * @param object $req_body    employee id and field to be modified
 */
function getRequestBodyValues($connection, $req_body)
{
  $req_body_json_in_array = get_object_vars($req_body);
  $field_name = array_keys($req_body_json_in_array)[1];

  $employee_modification = array(
    "id" => $req_body->id,
    "field_name" => $field_name,
    "field_value" => $req_body->$field_name
  );
  
  editEmployee($connection, $employee_modification);
}

?>