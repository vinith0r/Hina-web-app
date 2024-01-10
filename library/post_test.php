<pre>
<?php

include_once(dirname(__DIR__).'/library/posts.php');
//To post - Error : do_post undeclared due to loading issue of library/posts.php
//echo do_post('Hello world, this is the first post', '/images/cool.jpg');

// DO_POST() - TESTED_OK
// EDIT_POST() - TESTED_OK
// DELETE_POST() - TESTED_OK

// do_post('welcome', 'images/pexels-jovana-nesic-593655.jpg');
//echo "another text";
//edit_post(2, 'this is a edited post!');

//print_r(get_all_posts());
//print_r(get_otp());
//delete_post(3);

//print_r(get_all_posts());

// like_post(2);
// print_r(get_likes_count(2));


?>
</pre>