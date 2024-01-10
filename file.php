<pre>
<?php 
$salt = "kjfafh33hjhkja2o82wy";
echo md5("vinith8001".$salt)."\n";

echo base64_dncode($_GET['b']);

$rand = rand(1000, 9000);
echo base64_decode($rand);
echo "the random  is $rand";

 ?>
</pre>