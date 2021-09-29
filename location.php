<?php
    // No login will be redirected to the home page
    // if(!isset($_SESSION['USER'])) {
    //     header('Location: '.'index.php?page=login');
    // }
    $arrRedRecord = [];
    $fh = fopen(url_data_manage,'r');
    $arrRedRecord = json_decode(fgets($fh));
    fclose($fh);
    $location = unserialize(localtion);
    unset($_SESSION['location_id']);
    if(isset($_GET['location_id'])) {
        $location_id = $_GET['location_id'];
        $_SESSION['location_id'] = $location_id;
        if(!empty($arrRedRecord)) {
            $arrRedRecord = array_filter($arrRedRecord, function($item) use ($location_id) {
                if($item->location_id == $location_id){
                    return true;
                }
            });
        }
    }
    if(isset($_GET['id_card']) && isset($_GET['location_id'])) {
        
    }
?>
<div class="container home">
    <h1 class="title">Location</h1>
    <div class="row marginTopForm">
        <div class="col-md-3">
            <div class="form-group">
                <label for="inputAddress">Location</label>
                <select class="form-control location" name="location_id" style="border-radius:0px !important">
                    <option value=""></option>
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
            </div>
        </div>
    </div>
    <div class="row marginTopForm">
        <div class="col-md-12">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th scope="col">Photo</th>
                        <th scope="col">Description</th>
                        <th scope="col">Location</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($arrRedRecord) && count($arrRedRecord) > 0){ ?>
                        <?php foreach($arrRedRecord as $key =>  $value){ ?>
                            <tr>
                                <td style="text-align: center;"><img width="80" height="80" src="<?php echo 'file/'.$value->file_name ?>" /></td>
                                <td><?php echo $value->description ?></td>
                                <td><?php echo $location[$value->location_id] ?></td>
                                <td><a href="index.php?page=booking&id_card=<?php echo  $value->id ?>&location_id=<?php echo $value->location_id ?>">Booking</a></td>
                            </tr>
                        <?php }?>
                    <?php }else{?>
                        <tr><td colspan="5" style="text-align:center">No record</td></tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('.location').change(function() {
            if($(this).val() == '') {
                window.location.replace(window.location.pathname + '?page=location');
            } else {
                window.location.replace(window.location.pathname + '?page=location&location_id=' + $(this).val());
            }
        });
    });
</script>