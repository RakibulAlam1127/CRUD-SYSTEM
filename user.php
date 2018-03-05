<?php
/**
 * Created by PhpStorm.
 * User: Rakib
 * Date: 3/4/2018
 * Time: 1:42 AM
 */
$connection = mysqli_connect('localhost','root','','user_registration');
if ($connection == true){
    $sql = "select id,username,email,gender,file from user";
    $restult = mysqli_query($connection,$sql);
    $data = mysqli_fetch_all($restult,1);
}else{
    echo mysqli_connect_errno();
    exit();
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>User</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
        <body>
              <div class="container">
                  <h1 style="text-align: center">User View</h1>
                     <table class="table table-striped">
                         <thead>
                             <td>ID</td>
                               <td>USERNAME</td>
                                <td>E-MAIL</td>
                                 <td>GENDER</td>
                                  <td>PROFILE_PHOTO</td>
                                  <td>ACTION</td>
                         </thead>
                         <tbody>

                         <?php

                           foreach ($data as $value){
                               ?>
                           <tr>
                               <td><?php echo $value['id']; ?></td>
                               <td><?php echo $value['username']; ?></td>
                               <td><?php echo $value['email']; ?></td>
                               <td><?php echo $value['gender']; ?></td>
                                 <td><img src="image_file /<?php echo $value['file']; ?>" width="50"></td>
                               <td>
                                   <a href="edit.php?id=<?php echo $value['id']; ?>" class="label label-info">Edit</a>  |
                                   <a href="delete.php?id=<?php echo $value['id']; ?>" onclick="confirm('Are You Sure ?')" class="label label-info">Delete</a>
                               </td>
                           </tr>
                               <?php
                                }
                            ?>
                         </tbody>
                     </table>
              </div>
        </body>
</html>
