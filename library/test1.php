<pre><?php

include_once 'auth1.php';

// $result = do_login('admin', 'admin');
// echo "do_login(): ".$result;

// $result = verify_session($_COOKIE['username'], $_COOKIE['token']);
// echo "verify_session(): ".$result;

// echo invalidate_session($_COOKIE['username'], $_COOKIE['token']);

$result = verify_session($_COOKIE['username'], $_COOKIE['token']);
echo "verify_session(): ".$result;
?></pre>
