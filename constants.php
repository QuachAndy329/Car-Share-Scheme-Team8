<?php 
    define("msg_required","This field is required.");
    define("msg_email","Please enter a valid email address.");
    define("msg_email_exits","Email has been registered.");
    define("msg_register_success","You have successfully registered ! Please login.");
    define('msg_login_error','Email or password is incorrect.');
    define('msg_number','Enter a value with a value greater than 1');
    define('msg_add_activity_success','Add the activity successfully');
    define('msg_error_password','Password must be at least 6 characters');
    define('msg_login_success','Logged in successfully !');
    define('url_data_users','data/users.json');
    define('url_data_user_stats','data/user_stats.json');
    define('url_data_manage','data/manage.json');
    define('url_data_booking','data/booking.json');

    define('file_upload','file/');

    define('url_myfitness','index.php?page=home');

    define('localtion',serialize(array(
        '' => '',
        'A' => 'A',
        'B' => 'B',
        'C' => 'C',
    )));

    define('role',serialize(array(
        '2' => 'User',
        '1' => 'Admin',
    )));

    define('member_type',serialize(array(
        'Individual' => 'Individual',
        'Family' => 'Family'
    )));

    define('member_duaration',serialize(array(
        '1' => '1 months',
        '3' => '3 months',
        '6' => '6 months',
        '12' => '12 months'
    )));

    define('myfitness_work',serialize(array(
        array(
            'id' => 1,
            'name' => 'Walking (low intensity)',
            'url_img' => 'walking.png'
        ),
        array(
            'id' => 2,
            'name' => 'Walking the dog',
            'url_img' => 'walkingwithdog.png'
        ),
        array(
            'id' => 3,
            'name' => 'House keeping',
            'url_img' => 'housek.jpg'
        ),
        array(
            'id' => 4,
            'name' => 'Shopping',
            'url_img' => 'service3.jpg'
        ),
        array(
            'id' => 5,
            'name' => 'Gardening',
            'url_img' => 'service3.jpg'
        ),
        array(
            'id' => 6,
            'name' => 'Ironing',
            'url_img' => 'service3.jpg'
        ),
        array(
            'id' => 7,
            'name' => 'Filme with family',
            'url_img' => 'service3.jpg'
        ),
        array(
            'id' => 8,
            'name' => 'Motorcycle riding',
            'url_img' => 'service3.jpg'
        ),
        array(
            'id' => 9,
            'name' => 'Dancing',
            'url_img' => 'service3.jpg'
        ),
        array(
            'id' => 10,
            'name' => 'Mowing the lawn',
            'url_img' => 'service3.jpg'
        )
    )));
?>