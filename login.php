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

    if(isset($valuePost['submit'])) {

        //validation data
        if(isset($valuePost['email']) && $valuePost['email'] === '') {
            $arrError["email_required"] = msg_required;
        } else if (isset($valuePost['email']) && !filter_var($valuePost['email'], FILTER_VALIDATE_EMAIL)) {
            $arrError["email_required"] = msg_email;
        }
        if(isset($valuePost['password']) && $valuePost['password'] === '') {
            $arrError["password_required"] = msg_required;
        }

        //Open data file users.json
        $arrRedRecord = [];
        $fh = fopen(url_data_users,'r');
        $arrRedRecord = json_decode(fgets($fh));
        fclose($fh);
    
        if(count($arrError) == 0){
            //Check email and password with record in file users.json
            $isLogin = false;
            if (!is_null($arrRedRecord)) {
                foreach($arrRedRecord  as $key => $value) {
                    if ($value->email == $valuePost['email'] && $value->password == $valuePost['password']) {
                        $isLogin = true;
                        $value->login_success = 1;
                        $_SESSION['USER'] = $value;
                        break;
                    }
                }
            }
            if(!$isLogin) {
                $_SESSION['alert_message_error'] = msg_login_error;
            } else {
                header('Location: '.url_myfitness);
                exit();
            }
        }
    }
?>
<div class="container">
    <form class="login"  method="post" action="index.php?page=login" id="contactUs">
        <?php require 'alert-message.php';  ?>
        <div class="form-group">
            <label for="exampleInputEmail1">Email</label>
            <input type="text" class="form-control" value="<?php echo isset($_SESSION['valuePost']['email']) ? $_SESSION['valuePost']['email'] : ''  ?>" name="email" placeholder="Input your email..">
            <label  class="error"><?php echo isset($arrError["email_required"]) ? $arrError["email_required"] : ''  ?></label>
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Password</label>
            <input type="password" class="form-control" value="<?php echo isset($_SESSION['valuePost']['password']) ? $_SESSION['valuePost']['password'] : ''  ?>" name="password" placeholder="Input your password..">
            <label  class="error"><?php echo isset($arrError["password_required"]) ? $arrError["password_required"] : ''  ?></label>
        </div>
        <input type="submit" class="btn" name="submit" value="Submit">
    </form>
</div>