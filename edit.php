<?php
/**
 * Created by PhpStorm.
 * User: Rakib
 * Date: 3/3/2018
 * Time: 8:27 PM
 */
//Our Php code will be gose here.
$id = $_GET['id'] ?? 0;   // if(!isset($_GET['id'])  || (int) $_GET['id'])
if ((int) $id === 0){
     header('Location: registration.php');
}
$connection = mysqli_connect('localhost','root','','user_registration');
  if(isset($_POST['update'])){
        function validation ($data){
            $data = htmlentities($data);
            $data = htmlspecialchars($data);
            $data = stripslashes($data);
            $data = trim($data);
            return $data;
        }
        if (empty($_POST['username'])){
            $errors['username'] = 'Username Field is Required';
        }else{
            $username = validation($_POST['username']);
        }
        if (empty($_POST['email'])){
            $errors['email'] = 'Email Field is Required';
        }else{
            $email = validation($_POST['email']);
        }
        if (empty($errors)){
            $sql = "UPDATE user SET username = '$username', email = '$email' WHERE id='$id'";
            $stmt = mysqli_query($connection,$sql);
            if ($stmt == true){
                $success = 'Your Profile Update Successfully';
            }else{
                echo mysqli_error($connection);
                exit();
            }
        }
  }
if ($connection ==false){
    echo mysqli_connect_errno();
    exit();
}else{
    $sql = "SELECT username,email,gender FROM user WHERE id='$id'";
    $stmt = mysqli_query($connection,$sql);
     if (mysqli_num_rows($stmt) === 0){
         header('Location : registration.php');
     }
  $data = mysqli_fetch_assoc($stmt);

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
<div class="container col-md-6">
    <h1 style="color:#0000ff">Update Your Profile</h1>
    <form action="<?php echo $_SERVER['PHP_SELF'];  ?>?id= <?php echo $_GET['id']; ?>" method="post" enctype="multipart/form-data">
        <?php
        if (isset($success)){
            ?>
                   <div class="alert alert-success"><?php echo $success; ?></div>
            <?php
        }
        ?>
        <div class="form-group">
            <label for="username">UserName</label>
            <input type="text" name="username" class="form-control" placeholder="Username" value="<?php echo $data['username']; ?>" autofocus>
            <?php
            if (isset($errors['username'])){
                ?>
                      <div class="alert alert-danger"><?php echo $errors['username']; ?></div>
                <?php
            }
            ?>
        </div>
        <div class="form-group">
            <label for="email">E-mail</label>
            <input type="email" name="email" class="form-control" placeholder="E-mail" value="<?php echo $data['email']; ?>" autofocus>
            <?php
            if (isset($errors['email'])){
                ?>
                       <div class="alert alert-danger"><?php echo $errors['email']; ?></div>
                <?php
            }
            ?>
        </div>

        <div class="form-group">
            <input type="submit" name="update" value="Update" class="form-control btn btn-primary">
        </div>
    </form>
</div>
</body>
</html>

