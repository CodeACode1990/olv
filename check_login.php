<?php
    include_once('header.php');

    $con = connect_to_database("ut_manado_olv");
    $username = trim(mysqli_real_escape_string($con, $_POST['username']));
    $password = trim(mysqli_real_escape_string($con, $_POST['password']));

    $sql_login = mysqli_query( $con,"SELECT * FROM users WHERE username='".$username."'" ) or die (mysqli_error($con));
    
    $data_user = mysqli_fetch_array($sql_login);
    
    $hash	 = $data_user['password'];

    if (password_verify($password, $hash)) {
        $_SESSION["logged_username"] = $data_user['username'];
        $_SESSION["logged_name"] = $data_user['nama'];
        echo "<script>
                window.location='".base_url("dashboard.php")."'
                alert('Selamat datang ".$_SESSION["logged_name"]."')
            </script>"; 
    }
    else{
        olv_die('FAIL !');
    }

    include_once('footer.php');
?>