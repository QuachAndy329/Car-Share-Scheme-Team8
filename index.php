<?php  require 'header.php' ?>
    <div class="content">
        <?php 
            //Load file php according to parammeter
            require 'constants.php'; 
            $page = isset($_GET['page'] ) ? $_GET['page']  : '';
            switch($page) {
                case "register" : 
                    require 'register.php';
                    break;
                case "login" :
                    require 'login.php';
                    break;
                case "home" : 
                    require 'home.php';
                    break;
                case "manage" : 
                    require 'manage.php';
                    break;
                case "manage-page" : 
                    require 'manage-page.php';
                    break;
                case "location" : 
                    require 'location.php';
                    break;
                case "booking" : 
                    require 'booking.php';
                    break;
                default : 
                require 'page.php';
            }
        ?>
    </div>
<?php  require 'footer.php' ?>