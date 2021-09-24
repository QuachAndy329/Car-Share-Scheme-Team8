
<?php
    // User login will be redirected to the home page
    if(isset($_SESSION['USER'])){
        header('Location: '.'index.php');
    }
    //Get data from the form put into the session
    $valuePost = $_POST;
    $_SESSION['valuePost'] = $valuePost;
    $arrError = [];
    unset($_SESSION['alert_message_error']);
    unset($_SESSION['alert_message_success']);

    if(isset($valuePost['submit'])){
        //validation data
        if (isset($valuePost['first_name']) && $valuePost['first_name'] === '') {
            $arrError["first_name_required"] = msg_required;
        }
    
        if (isset($valuePost['second_name']) && $valuePost['second_name'] === '') {
            $arrError["second_name_required"] = msg_required;
        }
    
        if (isset($valuePost['email']) && $valuePost['email'] === '') {
            $arrError["email_required"] = msg_required;
        } else if (isset($valuePost['email']) && !filter_var($valuePost['email'], FILTER_VALIDATE_EMAIL)) {
            $arrError["email_required"] = msg_email;
        }
    
        if (isset($valuePost['password']) && $valuePost['password'] === '') {
            $arrError["password_required"] = msg_required;
        } else {
            $pattern =  '/^.{6,}$/';
            if(!preg_match($pattern, $valuePost['password'])) {
                $arrError["password_required"] =  msg_error_password;
            }
        }}
    
        
    
        //Open data file users.json
        $arrRedRecord = [];
        $fh = fopen(url_data_users,'r');
        $arrRedRecord = json_decode(fgets($fh));
        fclose($fh);
    
        //Check Duplicate user
        $isCheckDuplicate = false;
        if (!is_null($arrRedRecord) && isset($valuePost['email']) && $valuePost['email'] !== '') {
            foreach($arrRedRecord  as $key => $value) {
                if ($value->email == $valuePost['email']) {
                    $isCheckDuplicate = true;
                    break;
                }
            }
        }
    
        if ($isCheckDuplicate) {
            $arrError["email_required"] = msg_email_exits;
        }

        //Add info user to users.json
        if (count($arrError) == 0 && $isCheckDuplicate === false && isset($valuePost['submit'])) {
            $fp = fopen(url_data_users, 'w');
            unset($valuePost['submit']);
            $arrRedRecord[] = $valuePost;
            fwrite($fp, json_encode($arrRedRecord));
            fclose($fp);
            //$_SESSION['alert_message_success'] = msg_register_success;            
            $isLogin = false;
   
            //Open data file users.json
            $arrRedRecordNew = [];
            $fh = fopen(url_data_users,'r');
            $arrRedRecordNew = json_decode(fgets($fh));
            fclose($fh);

            foreach($arrRedRecordNew  as $key => $value) {
                if ($value->email == $valuePost['email'] && $value->password == $valuePost['password']) {
                    $isLogin = true;
                    $value->login_success = 1;
                    $_SESSION['USER'] = $value;
                    break;
                }
            }
            if(!$isLogin) {
                $_SESSION['alert_message_error'] = msg_login_error;
            } else {
                unset($_SESSION['valuePost']);
                header('Location: '.url_mytravel);
                exit();
            }
        }
    

?>

<div class="container register">
    <h1 class="title">REGISTRATION FORM</h1>
    <form class="login marginTopForm registerForm"  method="post" action="index.php?page=register" onchange="mountTotals()">
        <?php require 'alert-message.php'; ?>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="inputEmail4">First Name</label>
                <input type="text" class="form-control" id="inputEmail4" name="first_name" value="<?php echo isset($_SESSION['valuePost']['first_name']) ? $_SESSION['valuePost']['first_name'] : ''  ?>">
                <label  class="error"><?php echo isset($arrError["first_name_required"]) ? $arrError["first_name_required"] : ''  ?></label>
            </div>
            <div class="form-group col-md-6">
                <label for="inputPassword4">Second Name</label>
                <input type="text" class="form-control" id="inputPassword4" name="second_name" value="<?php echo isset($_SESSION['valuePost']['second_name']) ? $_SESSION['valuePost']['second_name'] : ''  ?>">
                <label  class="error"><?php echo isset($arrError["second_name_required"]) ? $arrError["second_name_required"] : ''  ?></label>
            </div>
        </div>
        <div class="form-group">
            <label for="inputAddress">Email</label>
            <input type="text" class="form-control" id="inputAddress" name="email" value="<?php echo isset($_SESSION['valuePost']['email']) ? $_SESSION['valuePost']['email'] : ''  ?>">
            <label  class="error"><?php echo isset($arrError["email_required"]) ? $arrError["email_required"] : ''  ?></label>
        </div>
         <div class="form-group">
            <label for="inputAddress">Password</label>
            <input type="password" class="form-control" id="inputAddress" name="password" value="<?php echo isset($_SESSION['valuePost']['password']) ? $_SESSION['valuePost']['password'] : ''  ?>">
            <label  class="error"><?php echo isset($arrError["password_required"]) ? $arrError["password_required"] : ''  ?></label>
        </div>
        
        
        
        
       
        <input type="submit" class="btn" name="submit" value="Submit">
    </form>
</div>

    