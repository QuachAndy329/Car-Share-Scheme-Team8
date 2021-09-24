<?php if(isset($_SESSION['alert_message_error'])) {?>
    <div class="alert alert-danger" role="alert">
        <?php echo $_SESSION['alert_message_error'] ?>
    </div>
<?php } ?>

<?php if(isset($_SESSION['alert_message_success'])) {?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?php echo $_SESSION['alert_message_success'] ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php } ?>