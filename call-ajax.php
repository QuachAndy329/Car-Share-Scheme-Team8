<?php
    require 'constants.php';
    //Get information when looking for my fitness
    $search = $_POST['name'];
    $res = array();
      foreach(unserialize(mytravel_work) as $value) {
        if($search == ''){
          $res[] = $value;
        } else {
          if (strpos(strtolower($value['name']), strtolower($search)) !== false) {
            $res[] = $value;
          }
        }
      }
    echo json_encode($res);
?>