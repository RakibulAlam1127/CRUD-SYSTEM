<?php
$id = $_GET['id'] ?? 0;
$id = (int) $id;
if ($id === 0){
    header('Location:registration.php');
}else{
    $connection = mysqli_connect('localhost','root','','user_registration');
    if ($connection == false){
        echo mysqli_connect_errno();
        exit;
    }else{
        $sql = "DELETE FROM user where id ='$id'";
        $stmt = mysqli_query($connection,$sql);
        if ($stmt == true){
            header('Location:user.php');
        }else{
            echo mysqli_error($connection);
            exit();
        }
    }
}



?>