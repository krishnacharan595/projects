<?php
include"connect.php";
$query33="select acno from customer ;";
	$res32=mysqli_query($connect,$query33);
	$row31=$res32->fetch_assoc();
	$ac=$row31["acno"];
$query2="select * from customer where acno='$ac';";
	$res1=mysqli_query($connect,$query2);
	$row=$res1->fetch_assoc();
	$query2="select * from customer where acno='$ac';";
	$res1=mysqli_query($connect,$query2);
	$row=$res1->fetch_assoc();
	$n=$row["name"];
	$d=$row["dob"];
	$f=$row["fname"];
	$a=$row["anum"];
	$p=$row["pnum"];
	$t=$row["telnum"];
	$m=$row["mail"];
	$ad=$row["addr"];
	$ac=$row31["acno"];	
	$s=$row["savings"];	
	$c=$row["current"];	
	$h=$row["houseloan"];
	$b=$row["businessloan"];
	$u=$row["u"];
	$cd=$row["cdno"];	
	$dc=$row["dbno"];	

	
echo "<body style='background-color:lightblue;text-align:center;'>";
		echo "<h1>Name of the account holder :".$n;
echo "<br>";
echo "<br>";

	echo "Date of birth of the account holder :".$d;
echo "<br>";
echo "<br>";


	echo "Father name of the account holder :".$f;
echo "<br>";
echo "<br>";


	echo "Aadhar number of the account holder :".$a;
echo "<br>";
echo "<br>";


	echo "Pan number of the account holder :".$p;
echo "<br>";
echo "<br>";


	echo "Mobile number of the account holder :".$t;
echo "<br>";
echo "<br>";


	echo "Mail id of the account holder :".$m;
echo "<br>";
echo "<br>";


	echo "Address of account holder of the account holder :".$p;
echo "<br>";
echo "<br>";

	
	echo "Account number of the account holder :".$ac;
echo "<br>";
echo "<br>";


	echo "Saving account balance of the account holder  :".$s;
echo "<br>";
echo "<br>";

if($h){
echo "user has a house loan due <img src='warning.png' width='40' 			height='40'>";
echo "<br>";
echo "<br>";
}
else{
echo "user has no house loan due <img src='sucess.png' width='40' 			height='40'> ";
echo "<br>";
echo "<br>";

}
if($b){
echo "user has a business loan due <img src='warning.png' width='40' 			height='40'>";
echo "<br>";
echo "<br>";
}
else{
echo "user has no business loan due <img src='sucess.png' width='40' 			height='40'> ";
echo "<br>";
echo "<br>";

}
	

	echo "Current account balance of the account holder  :".$c;
	echo "</body>";
echo "<br>";
echo "<br>";

echo "debitcard number of the account holder :".$dc;
echo "<br>";
echo "<br>";
echo "credit card number of the account holder :".$cd;
echo "<br>";
echo "<br>";
if($u){
echo "user has a applied for net banking account unlock <img src='sucess.png' width='40' 			height='40'>";
echo "<br>";
echo "<br>";
}
else{
echo "user has no net banking account lock <img src='sucess.png' width='40' 			height='40'> ";
echo "<br>";
echo "<br>";
}
?>
