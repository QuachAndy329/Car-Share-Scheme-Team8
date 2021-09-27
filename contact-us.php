<div class="container">
    <form class="contact-us"  method="post" action="index.php?page=contact-us" id="contactUs">
        <div class="form-group">
            <label for="exampleInputEmail1">YourName</label>
            <input type="text" class="form-control" required name="youName" placeholder="Input your name..">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Email</label>
            <input type="email" class="form-control" required name="email" placeholder="Input your e-mail..">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Subject</label>
            <textarea class="form-control" placeholder="Write something.." style="height:170px" required name="subject"></textarea>
        </div>
        <input type="submit" class="btn btn-submit-custom" value="Submit">
    </form>
</div>
<script>
    $(document).ready(function(){
        //Check Validatation jquery plugin validate
        $("#contactUs").validate();
        $('input,textarea').removeClass('.error');
    });
</script>