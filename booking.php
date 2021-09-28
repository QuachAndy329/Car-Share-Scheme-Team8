<?php
    // No login will be redirected to the home page
    // if(!isset($_SESSION['USER'])) {
    //     header('Location: '.'index.php?page=login');
    // }
    unset($_SESSION['location_id']);
    unset($_SESSION['number']);
    $arrRedRecord = [];
    $fh = fopen(url_data_manage,'r');
    $arrRedRecord = json_decode(fgets($fh));
    fclose($fh);
    $location = unserialize(localtion);
    unset($_SESSION['location_id']);
    if(isset($_GET['location_id'])) {
        $location_id = $_GET['location_id'];
        $_SESSION['location_id'] = $location_id;
        $arrRedRecord = array_filter($arrRedRecord, function($item) use ($location_id) {
            if($item->location_id == $location_id){
                return true;
            }
        });
    }
    $valuePost = $_POST;
    $_SESSION['valuePost'] = $valuePost;
    $arrError = [];
    if (isset($valuePost['submit'])) {
        if (isset($valuePost['location_id']) && $valuePost['location_id'] == '') {
            $arrError["location_id_required"] = msg_required;
        }
        if (isset($valuePost['number']) && $valuePost['number'] == '') {
            $arrError["number_required"] = msg_required;
        } else {
            $pattern = '/^[1-9][0-9]*$/';
            if(!preg_match($pattern, $valuePost['number'])) {
                $arrError["number_required"] =  msg_error_number;
            }
        }
        $_SESSION['location_id'] = $valuePost['location_id'];
        $_SESSION['number'] = $valuePost['number'];
        if(count($arrError) == 0 ){ 
            $fh = fopen(url_data_booking,'r');
            $arrRedRecordBooking = json_decode(fgets($fh));
            fclose($fh);
            $object = new stdClass();
            $object->user_id =  $_SESSION['USER']->id;
            $object->card_id =  $_GET['id_card'];
            $object->location_revert =  $valuePost['location_id'];
            $object->number =  $valuePost['number'];
            $arrRedRecordBooking[] = $object;
            $fp = fopen(url_data_booking, 'w');
            fwrite($fp, json_encode($arrRedRecordBooking));
            fclose($fp);
            header('Location: '.'index.php?page=booking');
        }
    }
    if(isset($_GET['id_card'])) {
        $id_card = $_GET['id_card'];
        $arrRedRecordCard = array_filter($arrRedRecord, function($item) use ($id_card) {
            if($item->id == $id_card){
                return true;
            }
        });
    }
    $fh = fopen(url_data_booking,'r');
    $arrBooking = json_decode(fgets($fh));
    fclose($fh);
    $fh = fopen(url_data_manage,'r');
    if(!empty($arrBooking)) {
        $role = $_SESSION['USER']->role;
        $idUser = $_SESSION['USER']->id;
        $arrBooking = array_filter($arrBooking, function($item) use ($role,  $idUser) {
            if($role == 1) {
                return true;
            } else {
                if($item->user_id == $idUser) {
                    return true;
                }
            }
        });
    }
    $arrRedRecordManage = json_decode(fgets($fh));
    fclose($fh);
    $arrCard = [];
    if(!empty($arrRedRecordManage)) {
        foreach($arrRedRecordManage as $value) {
            $arrCard[$value->id] = $value->file_name;
        }
    }
?>
<div class="container home">
    <h1 class="title"><?php echo (isset($_GET['id_card']) && isset($_GET['location_id'])) ? 'Booking' : 'History'  ?></h1>
    <?php if(isset($_GET['id_card']) && isset($_GET['location_id'])) { ?>
        <div class="row marginTopForm">
            <div class="col-md-12">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Photo</th>
                            <th scope="col">Description</th>
                            <th scope="col">Location</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($arrRedRecordCard) && count($arrRedRecordCard) > 0){ ?>
                            <?php foreach($arrRedRecordCard as $key =>  $value){ ?>
                                <tr>
                                    <td style="text-align: center;"><img width="80" height="80" src="<?php echo 'file/'.$value->file_name ?>" /></td>
                                    <td><?php echo $value->description ?></td>
                                    <td><?php echo $location[$value->location_id] ?></td>
                                </tr>
                            <?php }?>
                        <?php }else{?>
                            <tr><td colspan="5" style="text-align:center">No record</td></tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <form method="post" enctype="multipart/form-data">
            <div class="row marginTopForm">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="inputAddress">Location Revert</label>
                            <select class="form-control location" name="location_id" style="border-radius:0px !important">
                                <?php foreach(unserialize(localtion) as $key => $value){ ?>
                                    <option value="<?php echo $key ?>" <?php 
                                        if (isset($_SESSION['location_id']) && $_SESSION['location_id'] == $key){
                                            echo "selected";
                                        } else {
                                            echo "";
                                        }
                                    ?>><?php echo $value ?></option>
                                <?php } ?>
                            </select>
                            <label  class="error"><?php echo isset($arrError["location_id_required"]) ? $arrError["location_id_required"] : ''  ?></label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="inputAddress">Number</label>
                            <input type="text" name="number" class="form-control" value="<?php echo isset($_SESSION['number']) ? $_SESSION['number'] : ''  ?>">
                            <label  class="error"><?php echo isset($arrError["number_required"]) ? $arrError["number_required"] : ''  ?></label>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" name="submit" class="btn btn-success">
                            Submit
                        </button>
                    </div>
            </div>
        </form>
    <?php } else { ?>
        <div class="row marginTopForm">
            <div class="col-md-12">
                <label for="inputAddress">History</label>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Location Revert</th>
                            <th scope="col">Card ID</th>
                            <th scope="col">Photo</th>
                            <th scope="col">Number</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($arrBooking) && count($arrBooking) > 0){ ?>
                            <?php foreach($arrBooking as $key =>  $value){ ?>
                                <tr>
                                    <td style="text-align: center;"><?php echo $location[$value->location_revert] ?></td>
                                    <td><?php echo $value->card_id ?></td>
                                    <td><?php if(isset($arrCard[$value->card_id])){ ?><img width="80" height="80" src="<?php echo 'file/'.$arrCard[$value->card_id] ?>" /> <?php } ?></td>
                                    <td><?php echo $value->number ?></td>
                                </tr>
                            <?php }?>
                        <?php }else{?>
                            <tr><td colspan="5" style="text-align:center">No record</td></tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php }?>
</div>