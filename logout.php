<?php
    session_start();
    //Delete session and direct to index
    unset($_SESSION['USER']);
    header('Location: '.'index.php');

?>