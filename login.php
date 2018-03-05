<?php
/**
 * Created by PhpStorm.
 * User: Rakib
 * Date: 3/3/2018
 * Time: 8:27 PM
 */
//Our Php code will be gose here.
$errors = [];
$username = $password = '';
if (isset($_POST['login'])){

    if (empty($_POST['username'])){
        $errors[] = 'Username Field Must be Required';
    }else{
        $username = $_POST['username'];
    }

    if (empty($_POST['password'])){
        $errors[] = 'Password Field Must be Required';
    }else{
        $password = $_POST['password'];
    }


    if (empty($errors)){

        $connection = mysqli_connect('localhost','root','','user_registration');
        if ($connection ===false){
            $errors[] =  mysqli_connect_errno();
        }else {
            $sql = "select  id,password from user where username = '$username'";
            $result = mysqli_query($connection,$sql);
//
            if (mysqli_num_rows($result) === 0){
                $errors[] = 'Username not Found';
            }else{
                $data = mysqli_fetch_assoc($result);
//                var_dump($data['password']);
//                die();
                if (password_verify($password,$data['password']) === true){
                    $success = 'You Are Log in';
                    header('Location:user.php');
                }else{
                    $errors[] = 'Worng Password';
                }
            }
        }

    }
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
    <h1 style="color:#0000ff">User Login Form</h1>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
        <?php
        if (isset($success)){
            ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
            <?php
        }
        ?>
        <?php
          if (!empty($errors)){
            ?>
              <div class="alert alert-danger">
                  <?php
                  foreach ($errors as $error){
                      ?>
                      <ul>
                          <li><?= $error; ?></li>
                      </ul>
                  <?php
                  }
                  ?>
              </div>
        <?php

          }
        ?>
        <div class="form-group">
            <label for="username">UserName</label>
            <input type="text" name="username" class="form-control" placeholder="Username" autofocus>

        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" class="form-control" placeholder="password" autofocus>
        </div>

        <div class="form-group">
            <a style="float: right" href="registration.php">You have not a account? Please Sign Up</a>
            <input type="submit" name="login" class="form-control btn btn-primary" value="Login">
        </div>
    </form>
</div>
</body>
</html>



