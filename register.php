<!DOCTYPE HTML>  

<html lang="en">
<head>
  <title>Testing WebSiteName</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body> 


<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="index.php">WebSiteName</a>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href="index.php">Home</a></li>
      <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Page 1 <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="#">Page 1-1</a></li>
          <li><a href="#">Page 1-2</a></li>
          <li><a href="#">Page 1-3</a></li>
        </ul>
      </li>
      <li><a href="#">Page 2</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">


	</div>
  </nav>
<div class="container">
  
<h2>Register</h2>


<form method="POST" action="register.php" class="form">  
<table cellspacing="0" cellpadding="5">
                  <tr>
                    <td>full name</td>
                    <td>
                       <input type="text" name="fname" >
                       </td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td>
                     <input type="text" name="email">
                     </td>
                </tr>
                <tr>
                    <td>username</td>
                    <td>
                    <input type="text" name="uname" >
                  </td>
                </tr>
                <tr>
                    <td>password</td>
                    <td>
                 <input type="password" name="psw"  >
                 </td>
                </tr>
                <tr>
                <tr>
                    <td></td>
                    <td><input type="submit" name="register" value="register"/>
                    
                    <p>Already have an account? <a href="login.php">Sign in</a>.</p></td>
                </tr>
                   
    </table>
  </form>
  

<?php 
require_once("connection.php");
if(isset($_POST['register'])){
  $fname = trim($_POST['fname']);
  $email = trim($_POST['email']);
  $uname = trim($_POST['uname']);
  $psw = trim($_POST['psw']);

  $data = $_POST;
  if (empty($data['fname']) ||
  empty($data['email']) ||
  empty($data['uname']) ||
  empty($data['psw'])) {
  
  die('Please fill all required fields!');
}


$sql = "SELECT * FROM account WHERE uname = '$uname' OR email = '$email'";

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0)
{
echo '<script language="javascript">alert("user or email already in the system"); window.location="register.php";</script>';

die ();
}
else {


$sql = "INSERT INTO `a3VTuuc6Jb`.`account` (`fname`,`email`,`uname`,`psw`) VALUES ('$fname','$email','$uname','$psw')";
echo '<script language="javascript">alert("successfull register"); window.location="login.php";</script>';

if (mysqli_query($conn, $sql)){
echo "full name: ".$_POST['fname']."<br/>";
echo "email: " .$_POST['email']."<br/>";
echo "username ".$_POST['uname']."<br/>";
echo "password ".$_POST['psw']."<br/>";
}
else {
echo '<script language="javascript">alert("error!!!!"); window.location="register.php";</script>';
}
}
}
?>
</div>
</body>
</html>
