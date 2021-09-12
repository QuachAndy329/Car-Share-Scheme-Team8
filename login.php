


<div class="container">

<form method="POST" action="login.php" class="form">  
    <table cellspacing="0" cellpadding="5">
      <h1>login</h1>
    
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
                    <td><input type="submit" name="login" value="login"/>
                    
                    <p>don't have an account? <a href="index.php?page=register">register</a>.</p></td>
                </tr>
                   
    </table>
  </form>


  <?php
	// call connection.php 
  if(isset($_SESSION['USER'])){
    header('Location: '.'index.php');
}
	require_once("connection.php");
	// Check if the user has pressed the login button, then it will be processed
	if (isset($_POST["login"])) {
		// get user information 
		$uname = $_POST["uname"];
		$psw = $_POST["psw"];
		//clean information, remove html tags, special characters
		//intentionally added by the user for sql injection attacks
		$uname = strip_tags($uname);
		$uname = addslashes($uname);
		$pword = strip_tags($psw);
		$pword = addslashes($psw);
		if ($uname == "" || $psw =="") {
			echo '<script language="javascript">alert("username and password can not empty!"); window.location="index.php?page=login";</script>';
		}else{
			$sql = "select * from account where uname = '$uname' and psw = '$psw' ";
			$query = mysqli_query($conn,$sql);
			$num_rows = mysqli_num_rows($query);
			if ($num_rows==0) {
				echo '<script language="javascript">alert("wrong password or username"); window.location="index.php?page=login";</script>';
			}else{
				//proceed to save the login name in the session for later processing
			$_SESSION['USER'] = $uname;
                // proceed to save the login name in the session for later processing
                // here I proceed to redirect the site to a page called index.php
      header('Location: index.php');
			}
		}
	}
?>
</div>
</body>
</html>