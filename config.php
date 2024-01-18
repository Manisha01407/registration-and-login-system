
<?php
$hostname='localhost';
$username='root';
$password='';
$dbname='login';

$conn=mysqli_connect($hostname,$username,$password,$dbname);

if($conn==false){
      dir(mysqli_error($conn));
}
?>