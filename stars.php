
<pre> <h1>
<?php
//Running C Programming through PHP

$count = $_GET['c'];
if(is_numeric($count)){ //check to avoid cmdline injection
echo system('gcc stars.c && ./a.out '.$count);  //linux cmd 
}
else{
    echo "bro, you tryina hack me lol!";
}
?>
</h1>
</pre>