

<!DOCTYPE html>
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
                    
                    <p>don't have an account? <a href="register.php">register</a>.</p></td>
                </tr>
                   
    </table>
  </form>


  <?php
	// call connection.php 
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
		if ($username == "" || $password =="") {
			echo "username or password can't emplty!";
		}else{
			$sql = "select * from account where uname = '$uname' and psw = '$psw' ";
			$query = mysqli_query($conn,$sql);
			$num_rows = mysqli_num_rows($query);
			if ($num_rows==0) {
				echo "username or password was wrong";
			}else{
				//proceed to save the login name in the session for later processing
				$_SESSION['uname'] = $uname;
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