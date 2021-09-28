
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
        if (isset($valuePost['full_name']) && $valuePost['full_name'] === '') {
            $arrError["full_name_required"] = msg_required;
        }
    
        if (isset($valuePost['email']) && $valuePost['email'] === '') {
            $arrError["email_required"] = msg_required;
        } else if (isset($valuePost['email']) && !filter_var($valuePost['email'], FILTER_VALIDATE_EMAIL)) {
            $arrError["email_required"] = msg_email;
        }
    
        if (isset($valuePost['password']) && $valuePost['password'] === '') {
            $arrError["password_required"] = msg_required;
        } else {
            // $pattern = '/^(?=.{6,}$)[A-Z].*[!^&].*[0-9]+$/';
            // if(!preg_match($pattern, $valuePost['password'])) {
            //     $arrError["password_required"] =  msg_error_password;
            // }
            if(strlen($valuePost['password']) < 6) {
                $arrError["password_required"] =  msg_error_password;
            }
        }
        if (isset($valuePost['location_id']) && $valuePost['location_id'] === '') {
            $arrError["location_id_required"] = msg_required;
        }
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

        $arrId = [];
        if (!is_null($arrRedRecord)) {
            foreach($arrRedRecord  as $key => $value) {
                $arrId[] = $value->id;
            }
        }
        //Add info user to users.json
        if (count($arrError) == 0 && $isCheckDuplicate === false && isset($valuePost['submit'])) {
            $fp = fopen(url_data_users, 'w');
            unset($valuePost['submit']);
            $valuePost['id'] = count($arrId) > 0 ? (max($arrId) + 1) : 1;
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
                header('Location: '.url_myfitness);
                exit();
            }
        }
    }

?>

<div class="container register">
    <h1 class="title">REGISTRATION FORM</h1>
    <form class="login marginTopForm registerForm"  method="post" action="index.php?page=register" onchange="mountTotals()">
        <?php require 'alert-message.php'; ?>
        <div class="form-group">
            <label for="inputEmail4">Full Name</label>
            <input type="text" class="form-control" id="inputEmail4" name="full_name" value="<?php echo isset($_SESSION['valuePost']['full_name']) ? $_SESSION['valuePost']['full_name'] : ''  ?>">
            <label  class="error"><?php echo isset($arrError["full_name_required"]) ? $arrError["full_name_required"] : ''  ?></label>
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
        <div class="form-group">
            <label for="inputAddress">Localtion</label>
            <select class="form-control" name="location_id">
                <?php foreach(unserialize(localtion) as $key => $value){ ?>
                    <option value="<?php echo $key ?>" <?php 
                        if (isset($_SESSION['valuePost']['location_id']) && $_SESSION['valuePost']['location_id'] == $key){
                            echo "selected";
                        } else {
                            echo "";
                        }
                    ?>><?php echo $value ?></option>
                <?php } ?>
            </select>
            <label  class="error"><?php echo isset($arrError["location_id_required"]) ? $arrError["location_id_required"] : ''  ?></label>
        </div>
        <div class="form-group">
            <label for="inputAddress">Role</label>
            <select class="form-control" name="role">
                <?php foreach(unserialize(role) as $key => $value){ ?>
                    <option value="<?php echo $key ?>" <?php 
                        if (isset($_SESSION['valuePost']['role']) && $_SESSION['valuePost']['role'] == $key){
                            echo "selected";
                        } else {
                            echo "";
                        }
                    ?>><?php echo $value ?></option>
                <?php } ?>
            </select>
            <label  class="error"><?php echo isset($arrError["role_required"]) ? $arrError["role_required"] : ''  ?></label>
        </div>
        <input type="submit" class="btn" name="submit" value="Submit">
    </form>
</div>