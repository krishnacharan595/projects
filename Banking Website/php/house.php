<?php
include"connect.php";
$name=$_POST['name'];
$acno=$_POST['anum'];
$mobile=$_POST['telnum'];
$dob=$_POST['dob'];
$adr=$_POST['dec1'];
$dec=$_POST['dec2'];
$pa=$_POST['pa'];
$query007 ="select mail from customer where acno ='$acno';";
$res007=mysqli_query($connect,$query007);
$row007=$res007->fetch_assoc();
$mail=$row007["mail"];



$query ="select acno from house_loan where acno ='$acno';";
$res=mysqli_query($connect,$query);
$query1 ="select acno from customer where acno ='$acno';";
$res1=mysqli_query($connect,$query1);
if(!mysqli_num_rows($res1)==0){
if(mysqli_num_rows($res)==0)
{
$query2="insert into house_loan values('$name','$acno','$mobile','$dob','$adr','$dec','$pa');";
	mysqli_query($connect,$query2);
	$query5 ="select amount from house_loan where acno ='$acno';";
	$res3=mysqli_query($connect,$query5);
	$row=$res3->fetch_assoc();
	$t=$row["amount"];
	$t_amount=$t+$pa;
	$query4="update customer set current ='$t_amount' where acno='$acno';";
	mysqli_query($connect,$query4);
	$query3="update customer set houseloan=TRUE where acno='$acno';";
	mysqli_query($connect,$query3);
	echo "<body style='background-color:lightpink'>";
	echo "<br><br><br><br><br><br><br><br><br><br><h1 style='text-align:center;color:green;'><img src='sucess.png' width='40' 			height='40'><br>&nbsp;your house loan of RS.$pa has been approved</h1>";
	echo "</body>";
	mail($mail,"HOME LOAN APPROVAL","your house loan of RS.$pa has been approved");

}
else
{echo "<html><head></head>
<body>
<script>
if(confirm('you hav already applied for house loan pay it to get a new loan')){
	location.href='main.html';
}else{
}
</script>
</body>
</html>";

echo "<body style='background-color:lightyellow'>";
	echo "<br><br><br><br><br><br><br><br><br><br><h1 style='text-align:center;color:red;'><img src='warning.png' width='40' 			height='40'><br>&nbsp;you have already applied for house loan</h1>";
	echo "</body>";
}
}
else{echo "<html><head></head>
<body>
<script>
if(confirm('enter a valid account number')){
	location.href='main.html';
}else{
}
</script>
</body>
</html>";

		echo "<body style='background-color:lightyellow'>";
	echo "<br><br><br><br><br><br><br><br><br><br><h1 style='text-align:center;color:red;'><img src='warning.png' width='40' 			height='40'><br>&nbsp;check your account number</h1>";
	echo "</body>";

}
?>
