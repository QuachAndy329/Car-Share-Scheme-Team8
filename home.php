<?php
  // No login will be redirected to the home page
  if(!isset($_SESSION['USER'])) {
    header('Location: '.'index.php?page=login');
  }
  unset($_SESSION['alert_message_success']);
  if (isset($_SESSION['USER']->login_success)) {
    $_SESSION['alert_message_success'] = msg_login_success;
    unset($_SESSION['USER']->login_success);
  }
?>
<div class="container home">
    <h1 class="title">Home</h1>
</div>