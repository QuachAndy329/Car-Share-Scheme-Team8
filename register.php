
<div class="container">
  
<h2>Register</h2>


<form method="POST" action="register.php" class="form" onsubmit="if(document.getElementById('ppolicy').checked) { return true; } else { alert('Please indicate that you have read and agree to the Privacy Policy'); return false; }">  
<table cellspacing="0" cellpadding="5">
                  <tr>
                    <td>Full name</td>
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
                    <td>Username</td>
                    <td>
                    <input type="text" name="uname" >
                  </td>
                </tr>
                <tr>
                    <td>Password</td>
                    <td>
                 <input type="password" name="psw"  >
                 </td>
                </tr>

                </tr>
                <tr>
                    <td>
                    <input type="checkbox" id="ppolicy" name="ppolicy" value="ppolicy">
                    <label for="ppolicy"> <b> I have read and agree to the Privacy Policy</b> </label><br>  
                 </td>
                </tr>


             
                <tr>
                <tr>
                    <td></td>
                    <td><input type="submit" name="register" value="Register"/>
                    
                   </td>
                </tr>
                   
    </table>
  </form>
  <br>
  <p>Already have an account? <a href="index.php?page=login">Sign in</a>.</p>


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
  echo '<script language="javascript">alert("Please fill all required fiedls!"); window.location="index.php?page=register";</script>';

}


$sql = "SELECT * FROM account WHERE uname = '$uname' OR email = '$email'";

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0)
{
echo '<script language="javascript">alert("User or Email already in the system"); window.location="index.php?page=register";</script>';

die ();
}
else {


$sql = "INSERT INTO `projectprograming`.`account` (`fname`,`email`,`uname`,`psw`) VALUES ('$fname','$email','$uname','$psw')";
echo '<script language="javascript">alert("Successfully Registered"); window.location="index.php?page=login";</script>';

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
