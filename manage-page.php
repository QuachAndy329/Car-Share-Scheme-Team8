<?php
  // No login will be redirected to the home page
  if(!isset($_SESSION['USER'])) {
    header('Location: '.'index.php?page=login');
  }

   //Get data from the form put into the session
   $valuePost = $_POST;
   $_SESSION['valuePost'] = $valuePost;
   $arrError = [];
   unset($_SESSION['alert_message_error']);
   unset($_SESSION['alert_message_success']);
   $target_dir = file_upload;
    if (isset($valuePost['submit'])) {
        //validation data
        if (isset($_FILES["file"]) && $_FILES["file"]['name'] == '' && $_GET['action'] == 'add') {
            $arrError["file_required"] = msg_required;
        } else {
            if(($_GET['action'] == 'edit' && $_FILES["file"]['name'] != '') || $_GET['action'] == 'add') {
                $fileUpload = $_FILES["file"];
                $target_file = $target_dir . basename($_FILES["file"]["name"]);
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                    && $imageFileType != "gif" ) {
                        $arrError["file_required"] = 'Sorry, only JPG, JPEG, PNG & GIF files are allowed.';
                    }
            }
        }
        if (isset($valuePost['description']) && $valuePost['description'] == '') {
            $arrError["description_required"] = msg_required;
        }
        if (isset($valuePost['location_id']) && $valuePost['location_id'] == '') {
            $arrError["location_id_required"] = msg_required;
        }
    
        //Open data file user_stats.json
        $arrRedRecord = [];
        $fh = fopen(url_data_manage,'r');
        $arrRedRecord = json_decode(fgets($fh));
        fclose($fh);
        
        $arrId = [];
        if (!is_null($arrRedRecord)) {
            foreach($arrRedRecord  as $key => $value) {
                $arrId[] = $value->id;
            }
        }
        if((isset($_GET['action']) && $_GET['action'] == 'add')) {
            if(count($arrError) == 0 ){
                $fp = fopen(url_data_manage, 'w');
                unset($valuePost['submit']);
                $valuePost['file_name'] = $fileUpload['name'];
                move_uploaded_file($fileUpload["tmp_name"], $target_file);
                $valuePost['id'] = count($arrId) > 0 ? (max($arrId) + 1) : 1;
                $arrRedRecord[] = $valuePost;
                fwrite($fp, json_encode($arrRedRecord));
                fclose($fp);
                unset($_SESSION['valuePost']);
                header('Location: '.'index.php?page=manage');
            }
        } else {
            if(count($arrError) == 0 ){ 
                $id = $_GET['id'];
                $fp = fopen(url_data_manage, 'w');
                unset($valuePost['submit']);
                $fileUpload = $_FILES["file"];
                $recordEdit = array_filter($arrRedRecord, function($item) use ($id, $valuePost, $fileUpload) {
                    if($item->id == $id){
                        $item->file_name =  $fileUpload["name"] != '' ? $fileUpload["name"] :  $item->file_name;
                        $item->location_id =  $valuePost['location_id'];
                        $item->description =  $valuePost['description'];
                    }
                    return true;
                });
                if($fileUpload['name'] != '') {
                    $valuePost['file_name'] = $fileUpload['name'];
                    move_uploaded_file($fileUpload["tmp_name"], $target_file);
                }
                fwrite($fp, json_encode($recordEdit));
                fclose($fp);
                header('Location: '.'index.php?page=manage');
            }
        }
    }
    if(isset($_GET['id']) && (isset($_GET['action']) && $_GET['action'] == 'edit')) {
        $id = $_GET['id'];
        $arrRedRecord = [];
        $fh = fopen(url_data_manage,'r');
        $arrRedRecord = json_decode(fgets($fh));
        fclose($fh);
        $recordEdit = array_filter($arrRedRecord, function($item) use ($id) {
            if($item->id == $id){
                return true;
            }
        });
        if(!empty($recordEdit)) {
            foreach($recordEdit as $value) {
                $_SESSION['valuePost']['location_id'] = $value->location_id;
                $_SESSION['valuePost']['description'] = $value->description;
                $_SESSION['valuePost']['file_name'] = $value->file_name;
            }
        }
    }

?>
<div class="container home">
    <h1 class="title">Manage Page</h1>
    <div class="row marginTopForm">
        <div class="col-md-12">
          <form method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="exampleInputEmail1">Photo</label>
                <input type="file" class="form-control" name="file">
                <label  class="error"><?php echo isset($arrError["file_required"]) ? $arrError["file_required"] : ''  ?></label>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Description</label>
                <textarea type="text" class="form-control" name="description"><?php echo isset($_SESSION['valuePost']['description']) ? $_SESSION['valuePost']['description'] : ''  ?></textarea>
                <label  class="error"><?php echo isset($arrError["description_required"]) ? $arrError["description_required"] : ''  ?></label>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Location</label>
                <select class="form-control" name="location_id" style="border-radius:0px !important">
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
            <button type="submit" name="submit" class="btn btn-success">
                <?php echo (isset($_GET['action']) && $_GET['action'] == 'edit' ? 'Edit' : 'Create') ?>
            </button>
            <a href="index.php?page=manage" class="btn btn-secondary">Cancel</a>
          </form>
        </div>
    </div>
</div>