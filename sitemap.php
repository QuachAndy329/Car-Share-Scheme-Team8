<div class="container register">
    <h1>SiteMap</h1>
    <div id="mnuMain">
        <ul>
            <li><a href="index.php">Home</a>
                <ul>
                    <li><a href="index.php?page="></a></li>
                    <li><a href="index.php?page="></a></li>
                    <li><a href="index.php?page=" ></a></li>
                    <li><a href="index.php?page=" ></a></li>
                    <li><a href="index.php?page=" ></a></li>
                </ul>
            </li>
        </ul>
        <br style="clear: left" />
    </div>

    <div id="divNavigation">        
</div> 
</div>
<script>
    $(document).ready(function(){
        $('#mnuMain ul li a').click(function() {
            var $li = $(this).parents('li');
            var container = $('#divNavigation').empty();
            $li.each(function(i) {
                if (i > 0) {
                    $('<span>&gt;</span>').prependTo(container);
                }
                $(this).children('a:first').clone().prependTo(container);
            });

        });
    });
</script>