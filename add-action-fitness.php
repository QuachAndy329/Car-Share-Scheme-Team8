<?php

  // No login will be redirected to the home page
  if(!isset($_SESSION['USER'])) {
    header('Location: '.'index.php?page=login');
  }

  //Get the information of a work record at user_stats.json
  $id = $_GET['id'];
  $res = array();
  foreach(unserialize(myfitness_work) as $value) {
    if($value['id'] == $id){
      $res[] = $value;
    }
  }

  //Get data from the form put into the session
  $valuePost = $_POST;
  $_SESSION['valuePost'] = $valuePost;
  $arrError = [];
  unset($_SESSION['alert_message_error']);
  unset($_SESSION['alert_message_success']);

  if (isset($valuePost['submit'])) {
    //validation data
    if (isset($valuePost['weight']) && $valuePost['weight'] === '') {
      $arrError["weight_required"] = msg_required;
    } elseif(preg_match('/[1-9]/',$valuePost['weight']) == false) {
      $arrError["weight_required"] = msg_number;
    }
    if (isset($valuePost['age']) && $valuePost['age'] === '') {
      $arrError["age_required"] = msg_required;
    } elseif(preg_match('/[1-9]/',$valuePost['age']) == false) {
      $arrError["age_required"] = msg_number;
    }
    if (isset($valuePost['bmi']) && $valuePost['bmi'] === '') {
      $arrError["bmi_required"] = msg_required;
    } elseif(preg_match('/[1-9]/',$valuePost['bmi']) == false) {
      $arrError["bmi_required"] = msg_number;
    }
    
    if (isset($valuePost['date']) && $valuePost['date'] === '') {
      $arrError["date_required"] = msg_required;
    }
    if (isset($valuePost['duration']) && $valuePost['duration'] === '') {
      $arrError["duration_required"] = msg_required;
    } elseif(preg_match('/[1-9]/',$valuePost['duration']) == false) {
      $arrError["duration_required"] = msg_number;
    }
    

    //Open data file user_stats.json
    $arrRedRecord = [];
    $fh = fopen(url_data_user_stats,'r');
    $arrRedRecord = json_decode(fgets($fh));
    fclose($fh);
    
    //Add activity into user_stats.json
    if(count($arrError) == 0 ){
      $fp = fopen(url_data_user_stats, 'w');
      unset($valuePost['submit']);
      $valuePost['date'] = date("d/m/Y", strtotime($valuePost['date']));
      $valuePost['user_email'] = $_SESSION['USER']->email;
      $valuePost['work_id'] = $_GET['id'];
      $arrRedRecord[] = $valuePost;
      fwrite($fp, json_encode($arrRedRecord));
      fclose($fp);
      //$_SESSION['alert_message_success'] = msg_add_activity_success;
      unset($_SESSION['valuePost']);
      header('Location: '.'index.php?page=detail-myfitness&id='.$id);
    }
  }
?>
<div class="container myfitness">
    <h1 class="title">Detail My Fitness</h1>
    <div class="row marginTopForm">
      <?php foreach($res as $value){ ?>
        <div class="col-md-4">
          <div class="card mb-4 shadow-sm">
            <img src="lib/img/<?php echo $value['url_img'] ?>" alt="">
            <div class="card-body">
              <p class="card-text"><?php echo $value['name'] ?></p>
            </div>
          </div>
        </div>
      <?php } ?>
    </div>
    <div class="row marginTopForm">
        <div class="col-md-12">
          <?php require 'alert-message.php'; ?>
          <form method="post">
            <div class="form-group">
                <label for="exampleInputEmail1">Weight</label>
                <input type="text" class="form-control" name="weight" value="<?php echo isset($_SESSION['valuePost']['weight']) ? $_SESSION['valuePost']['weight'] : ''  ?>">
                <label  class="error"><?php echo isset($arrError["weight_required"]) ? $arrError["weight_required"] : ''  ?></label>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Age</label>
                <input type="text" class="form-control" name="age" value="<?php echo isset($_SESSION['valuePost']['age']) ? $_SESSION['valuePost']['age'] : ''  ?>">
                <label  class="error"><?php echo isset($arrError["age_required"]) ? $arrError["age_required"] : ''  ?></label>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">BMI</label>
                <input type="text" class="form-control" name="bmi" value="<?php echo isset($_SESSION['valuePost']['bmi']) ? $_SESSION['valuePost']['bmi'] : ''  ?>">
                <label  class="error"><?php echo isset($arrError["bmi_required"]) ? $arrError["bmi_required"] : ''  ?></label>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Date</label>
                <input type="date" class="form-control" name="date" value="<?php echo isset($_SESSION['valuePost']['date']) ? $_SESSION['valuePost']['date'] : ''  ?>">
                <label  class="error"><?php echo isset($arrError["date_required"]) ? $arrError["date_required"] : ''  ?></label>
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Duration</label>
                <input type="text" class="form-control" name="duration" value="<?php echo isset($_SESSION['valuePost']['duration']) ? $_SESSION['valuePost']['duration'] : ''  ?>">
                <label  class="error"><?php echo isset($arrError["duration_required"]) ? $arrError["duration_required"] : ''  ?></label>
            </div>
            
              <button type="submit" name="submit" class="btn btn-success">Create Activity</button>
              <a href="index.php?page=myFitness" class="btn btn-secondary">Cancel</a>
          </form>
        </div>
    </div>
</div>