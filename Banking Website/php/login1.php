<?php
include"connect.php";
$acno=$_POST['acc'];
$otp=$_POST["otpn"];


$query ="select acno from customer where acno ='$acno';";
$res=mysqli_query($connect,$query);
if(mysqli_num_rows($res)==0)
{
	echo "dont have account create one";
	$query7="truncate table otp;";
	$res4=mysqli_query($connect,$query7);
}
else{
	
	$query3="select otp from otp where acno='$acno';";
	$res2=mysqli_query($connect,$query3);
	if(mysqli_num_rows($res2)==0){
		echo "<body style='background-color:lightyellow'>";
		echo "<br><br><br><br><br><br><br><br><br><br><h1 style='text-align:center;color:red;'><img src='warning.png' width='40' height='40'><br>&nbsp;you have entered invalid otp</h1>";
		echo "</body>";
		$query6="truncate table otp;";
		$res3=mysqli_query($connect,$query6);
	}
	else
	{	
		$row=$res2->fetch_assoc();
	$ac=$row["otp"];
	if($otp===$ac){
		header("Location:main.html");	
		$query4="truncate table otp;";
		mysqli_query($connect,$query4);
	
}
	else{
		echo "<body style='background-color:lightyellow'>";
		echo "<br><br><br><br><br><br><br><br><br><br><h1 style='text-align:center;color:red;'><img src='warning.png' width='40' height='40'><br>&nbsp;you have entered invalid otp</h1>";
		echo "</body>";	
		$query5="truncate table otp;";
		$res3=mysqli_query($connect,$query5);
	}
	}
}
?>