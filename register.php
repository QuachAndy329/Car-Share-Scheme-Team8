
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
                    
                    <p>Already have an account? <a href="index.php?page=login">Sign in</a>.</p></td>
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
  echo '<script language="javascript">alert("please fill all required fiedls!"); window.location="index.php?page=register";</script>';

}


$sql = "SELECT * FROM account WHERE uname = '$uname' OR email = '$email'";

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0)
{
echo '<script language="javascript">alert("user or email already in the system"); window.location="index.php?page=register";</script>';

die ();
}
else {


$sql = "INSERT INTO `projectprograming`.`account` (`fname`,`email`,`uname`,`psw`) VALUES ('$fname','$email','$uname','$psw')";
echo '<script language="javascript">alert("successfull register"); window.location="index.php?page=login";</script>';

if (mysqli_query($conn, $sql)){
echo "full name: ".$_POST['fname']."<br/>";
echo "email: " .$_POST['email']."<br/>";
echo "username ".$_POST['uname']."<br/>";
echo "password ".$_POST['psw']."<br/>";
}
else {
echo '<script language="javascript">alert("error!!!!"); window.location="index.php?page=register";</script>';
}
}
}
?>
</div>
</body>
</html>
