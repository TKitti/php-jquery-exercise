<?php

/**
 * converts data received as json to object, then array
 * passes data to database access layer in order to change employee data
 * 
 * @param  $connection   which database the program connects to
 * @param object $req_body   employee id and field to be modified
 */
function convertData($connection, $req_body)
{
  $employee_id = $req_body->id;
  $employee_data_types = get_object_vars($req_body);
  $field = array_keys($employee_data_types)[1];
  $data = $req_body->$field;
  
  changeDataInDb($connection, $field, $employee_id, $data);
}

?>