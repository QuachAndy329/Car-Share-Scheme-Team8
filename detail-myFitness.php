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

  //Open data file user_stats.json
  $arrRedRecord = [];
  $fh = fopen(url_data_user_stats,'r');
  $arrRedRecord = json_decode(fgets($fh));
  fclose($fh);

 // Get the list of activity under 1 my fitness
  $listActivity = array();
  $user_email = $_SESSION['USER']->email;
  if(!is_null($arrRedRecord)){
    foreach($arrRedRecord as $value){
        if($value->work_id == $id && $value->user_email == $user_email){
            $listActivity[] = $value;
        }
    }
  }

?>
<div class="container myfitness">
    <h1 class="title">Detail My Fitness</h1>
    <?php foreach($res as $value){ ?>
        <div class="row marginTopForm">
            <div class="col-md-4">
                <div class="card mb-4 shadow-sm">
                    <img src="lib/img/<?php echo $value['url_img'] ?>" alt="">
                    <div class="card-body">
                        <p class="card-text"><?php echo $value['name'] ?></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row marginTopForm">
            <div class="col-md-12">
                <a href="index.php?page=add-action-fitness&id=<?php echo $value['id'] ?>" class="btn btn-success">Record Activity</a>
                <a href="index.php?page=myFitness" class="btn btn-secondary">Back to myFitness</a>
            </div>
        </div>
    <?php } ?>
    <div class="row marginTopForm">
        <div class="col-md-12">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th scope="col">Weight</th>
                        <th scope="col">Age</th>
                        <th scope="col">BMI</th>
                        <th scope="col">Date</th>
                        <th scope="col">Duration</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(count($listActivity) > 0){ ?>
                        <?php foreach($listActivity as $key =>  $value){ ?>
                            <tr>
                                <td><?php echo $value->weight ?></td>
                                <td><?php echo $value->age ?></td>
                                <td><?php echo $value->bmi ?></td>
                                <td><?php echo $value->date ?></td>
                                <td><?php echo $value->duration ?></td>
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