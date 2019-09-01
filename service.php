<?php

//converts data received as json to object, then array
//and saves data into variables
//param1: defines which database to connect to
//param2: data in request body is the data which needs to be converted
function convertData($connection, $req_body)
{
  $employee_id = $req_body->id;
  $employee_data_types = get_object_vars($req_body);
  $field = array_keys($employee_data_types)[1];
  $data = $req_body->$field;
  
  changeDataInDb($connection, $field, $employee_id, $data);
}

?>