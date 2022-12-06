<?php
    include_once ('base_functions.php');
	error_reporting(E_ERROR | E_PARSE);

	$con = connect_to_database("ut_manado_olv");
	
	$fields_length = trim(mysqli_real_escape_string($con, $_POST['fields_length']));
    $arr_fields = trim(mysqli_real_escape_string($con, $_POST['arr_fields']));
	$tbl_name = trim(mysqli_real_escape_string($con, $_POST['tbl_name']));

	$sql_st = "";
	$len = $fields_length;

	$arr_fields_ex = explode(',',$arr_fields);

	//foreach ($arr_fields_ex as $arr_fields_e) {
	for ($x = 0; $x < $len; $x++) {
		
		if($x==0){
			continue;
		}
		else{
			if ($x == $len - 1) {
				$sql_st .= "'$arr_fields_ex[$x]'";
			}
			else{
				$sql_st .= "'$arr_fields_ex[$x]', ";
			}
			
		}
		
	}

	// sql to insert a record
	$sql = "INSERT INTO $tbl_name VALUES( '', $sql_st )";

	if(mysqli_query($con, $sql)){
		echo json_encode(array("statusCode"=>200));
	} 
	else{
		echo json_encode(array("statusCode"=>201));
	}

	

?>