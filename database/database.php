<?php
$url='127.0.0.1:3306';
$username='root';
$password='';
$conn=mysqli_connect(laravel,$username,$password);
if(!$conn){
 die('Could not Connect My Sql:' .mysql_error());
}
?>