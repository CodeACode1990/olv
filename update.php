<?php
    include_once ('base_functions.php');
	error_reporting(E_ERROR | E_PARSE);

	$con = connect_to_database("ut_manado_olv");
	
	$id = trim(mysqli_real_escape_string($con, $_POST['id']));
	$fields_length = trim(mysqli_real_escape_string($con, $_POST['fields_length']));
    $arr_fields = trim(mysqli_real_escape_string($con, $_POST['arr_fields']));
	$columns_list = trim(mysqli_real_escape_string($con, $_POST['columns_list']));
	$tbl_name = trim(mysqli_real_escape_string($con, $_POST['tbl_name']));

	$sql_st = "";
	$len = $fields_length;

	$columns_list_ex = explode(',',$columns_list);
	$arr_fields_ex = explode(',',$arr_fields);

	//olv_dump($columns_list_ex);

	//foreach ($arr_fields_ex as $arr_fields_e) {
	for ($x = 0; $x<$len; $x++) {
		
		if($x==0){
			continue;
		}
		else{
			if ($x == $len-1) {
				$sql_st .= "$columns_list_ex[$x]='$arr_fields_ex[$x]'";
			}
			else{
				$sql_st .= "$columns_list_ex[$x]='$arr_fields_ex[$x]', ";
			}
			
		}
		
	}

	// sql to insert a record
	$sql = "UPDATE $tbl_name SET $sql_st WHERE id=$id ";

	olv_debug($sql);

	if(mysqli_query($con, $sql)){
		echo json_encode(array("statusCode"=>200));
	} 
	else{
		echo json_encode(array("statusCode"=>201));
	}

	

?>