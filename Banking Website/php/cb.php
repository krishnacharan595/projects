<?php
include"connect.php";
$query3="select acno from customer ;";
	$res2=mysqli_query($connect,$query3);
	$row1=$res2->fetch_assoc();
	$ac=$row1["acno"];
	$query2="select * from customer where acno='$ac';";
	$res1=mysqli_query($connect,$query2);
	$row=$res1->fetch_assoc();
	$ac=$row["acno"];	
	$s=$row["current"];	
	
	
		echo "<body style='background-color:yellow'>";
		echo "<br><br><br><br><br><br><br><br><br><br><h1 style='text-align:center;color:blue;'><br>&nbsp;</h1>";

	
		echo "<body style='background-color:yellow'>";
		echo "<h1 style='text-align:center;color:blue;'><br>&nbsp;current account balance of 	the account holder :RS.$s</h1>";

?>
