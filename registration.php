<?php
/**
 * Created by PhpStorm.
 * User: Rakib
 * Date: 3/3/2018
 * Time: 8:27 PM
 */
//Our Php code will be gose here.
$errors = [];
$username = $email = $password = $gender = $file = '';
if (isset($_POST['register'])){
 function validation($data){
     $data = htmlspecialchars($data);
     $data = htmlentities($data);
     $data = stripslashes($data);
     $data = trim($data);
     return $data;
   }
   if (empty($_POST['username'])){
     $errors['username'] = 'Username Field Must be Required';
   }else{
     $username = validation($_POST['username']);
   }
   if (empty($_POST['email'])){
     $errors['email'] = 'Email Field Must Be Required';
   }else{
     $email = validation($_POST['email']);
     if (!filter_var($email,FILTER_VALIDATE_EMAIL)){
         $errors['email'] = 'Your Email address is Not Valid';
     }
   }
   if (empty($_POST['password'])){
     $errors['password'] = 'Password Field Must be Required';
   }else{
       $password = validation($_POST['password']);
       if ($password < 5){
           $errors['password'] = 'Password Must Be at least 6 Character';
       }else{
           $password = password_hash($password,PASSWORD_BCRYPT);
       }
   }
   if (empty($_POST['gender'])){
     $errors['gender'] = 'Please Select Your Gender';
   }else{
     $gender = $_POST['gender'];
   }
   if (empty($_FILES['file']['name'])){
     $errors['file'] = 'Please Uploard Your Image';
   }else {

       $file = $_FILES['file']['name'];
       $data = explode('.', $file);
       $ext = end($data);
       if (!in_array($ext, ['jpg', 'png'], true)) {

           $errors['file'] = 'Image Must be Jpg or png Formet';
       }

   }


   if (empty($errors)){

      $connection = mysqli_connect('localhost','root','','user_registration');
      if ($connection ==false){
          echo mysqli_connect_errno();
          exit();
      }else{
          $new_file = uniqid('mm_',true).'.'.$ext;
          $image = move_uploaded_file($_FILES['file']['tmp_name'],'image_file/'.$new_file);
          if ($image == true){
              $sql = "insert into user(username,email,password,gender,file)VALUES ('$username','$email','$password','$gender','$file')";
              $stmt = mysqli_query($connection,$sql);
              if ($stmt == false){
                  echo mysqli_error($connection);
                  exit();
              }else{
                  $success = 'Your Registration is Successfully';
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
            <h1 style="color:#0000ff">User Registration Form</h1>
          <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
              <?php
              if (isset($success)){
                  ?>
                  <div class="alert alert-success"><?php echo $success; ?></div>
                  <?php
              }
              ?>
                   <div class="form-group">
                       <label for="username">UserName</label>
                       <input type="text" name="username" class="form-control" placeholder="Username" autofocus>
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
                  <input type="email" name="email" class="form-control" placeholder="E-mail" autofocus>
                  <?php
                  if (isset($errors['email'])){
                      ?>
                      <div class="alert alert-danger"><?php echo $errors['email']; ?></div>
                      <?php
                  }
                  ?>
              </div>
              <div class="form-group">
                  <label for="password">Password</label>
                  <input type="password" name="password" class="form-control" placeholder="password" autofocus>
                  <?php
                  if (isset($errors['password'])){
                      ?>
                      <div class="alert alert-danger"><?php echo $errors['password']; ?></div>
                      <?php
                  }
                  ?>
              </div>
              <div class="form-group">
                  <label for="gender">Gender</label><br>
                  <input type="radio" name="gender" value="Male">Male
                  <input type="radio" name="gender" value="Female">Female
                  <?php
                  if (isset($errors['gender'])){
                      ?>
                      <div class="alert alert-danger"><?php echo $errors['gender']; ?></div>
                      <?php
                  }
                  ?>
              </div>
              <div class="form-group">
                  <label for="file">File</label>
                  <input type="file" name="file" class="form-control">
                  <?php
                  if (isset($errors['file'])){
                      ?>
                      <div class="alert alert-danger"><?php echo $errors['file']; ?></div>
                      <?php
                  }
                  ?>
              </div>
              <div class="form-group">
                  <a style="float: right" href="login.php">You have a account?please log in</a>
                  <input type="submit" name="register" value="Registration" class="form-control btn btn-primary">
              </div>
          </form>
      </div>
</body>
</html>

