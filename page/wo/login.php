<?php
    header('Origin:xxx.com');
    header('Access-Control-Allow-Origin:*');
    include('conf.php');

    $con = new mysqli(host,user,pass,dbase);
	if($con -> connect_errno){
        printf("Connection error: %s\n", $con->connect_error);
    }
    
    $user = $_POST['user'];
    $pass = $_POST['pass'];
    
    $query = 'SELECT username, password FROM tb_user WHERE username="'.$user.'" AND password=SHA1("'.$pass.'")';
   
    $result = mysqli_query($con,$query);
    $row = mysqli_num_rows($result);
    
    $arr = array();
    
    if($row==1){
        $arr['result']=true;
        $arr['user']=$user;
    }else{
        $arr['result']=false;
    }
    echo json_encode($arr);
?>