<?php  require 'header.php' ?>
    <div class="content">
        <?php 
            //Load file php according to parammeter
            require 'constants.php'; 
            $page = isset($_GET['page'] ) ? $_GET['page']  : '';
            switch($page) {
                case "services" :
                    require 'services.php';
                    break;

                case "register" : 
                    require 'register.php';
                    break;
                case "login" :
                    require 'login.php';
                    break;
                case "sitemap" :
                    require 'sitemap.php';
                    break;
                
                default : 
                require 'page.php';
            }
        ?>
    </div>
    
<?php  require 'footer.php' ?>