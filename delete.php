<?php
    include_once ('base_functions.php');
	error_reporting(E_ERROR | E_PARSE);

	$con = connect_to_database("ut_manado_olv");

    $id = trim(mysqli_real_escape_string($con, $_POST['id']));
	$tbl_name = trim(mysqli_real_escape_string($con, $_POST['tbl_name']));

	// sql to delete a record
	$sql = "DELETE FROM ".$tbl_name." WHERE id='".$id."'";

	if(mysqli_query($con, $sql)){
		echo json_encode(array("statusCode"=>200));
	} 
	else{
		echo json_encode(array("statusCode"=>201));
	}

	//mysqli_close($conn);

?>