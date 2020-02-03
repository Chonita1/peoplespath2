<?php 

  //get json contents from post submission
  $fn = $_POST["first"];
  $ln = $_POST["last"];
  $tel = $_POST["tel"];
  $gender = $_POST["gender"];
  $status = $_POST["status"];

  $orgs_to_output = [];
  //get contents from json storage file called gethelp.json
  $json_data = file_get_contents("./gethelp.json", true);
  $json_orgs = file_get_contents("./orgs.json", true);
  /*read contents of file as json and put into an array called
    $curr_json*/
  $curr_json = json_decode($json_data, true);
  $curr_orgs = json_decode($json_orgs, true);
  
  $new_data = ['id' => strval($curr_json["last_id"] + 1), 'firstname' => $fn, 'lastname' => $ln,
               'gender' => $gender, 'telephone' => $tel];

  if(in_array ("youth", $status)){
    array_push ($curr_json["youth"],$new_data);
    $orgs_to_output = $curr_orgs["youthorg"];
  }
  if(in_array ("veteran", $status)){
    array_push ($curr_json["veteran"],$new_data);
    $orgs_to_output = array_merge($orgs_to_output,
                                  $curr_orgs["adultorg"]);
  }
  $curr_json["last_id"] = $curr_json["last_id"] + 1;

  $updated_data_json = json_encode($curr_json);
  file_put_contents("gethelp.json", $updated_data_json);
  echo json_encode(["response" => $orgs_to_output]);
?>
