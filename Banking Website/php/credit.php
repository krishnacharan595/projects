<?php
include"connect.php";
$name=$_POST['name'];
$acno=$_POST['debit'];
$mobile=$_POST['telephone'];
$adhr=$_POST['aadhar'];
$dob=$_POST['dob'];
$adr=$_POST['addr'];
$cdno=$_POST['cdno'];
$query007 ="select mail from customer where acno ='$acno';";
$res007=mysqli_query($connect,$query007);
$row007=$res007->fetch_assoc();
$mail=$row007["mail"];

$query12 ="select acno from customer where acno ='$acno';";
$res12=mysqli_query($connect,$query12);
if(mysqli_num_rows($res12)==0){
	echo "<html><head></head>
<body>
<script>
if(confirm('enter valid account number')){
	location.href='main.html';
}else{
}
</script>
</body>
</html>";

	echo "<body style='background-color:lightbue'>";
	echo "<br><br><br><br><br><br><br><br><br><br><h1 style='text-align:center;color:red;'><img src='warning.png' width='40' height='40'><br>&nbsp;enter a valid account number</h1>";
	echo "</body>";


}
else{
$query ="select acno from credit_application where acno ='$acno';";
$res=mysqli_query($connect,$query);
if(mysqli_num_rows($res)==0)
{
	$query2="insert into credit_application(acno) values('$acno');";
	mysqli_query($connect,$query2);
	$query13="update customer set cdno='$cdno' where acno='$acno';";
	mysqli_query($connect,$query13);
	echo "<body style='background-color:lightblue'>";
	echo "<br><br><br><br><br><br><br><br><br><br><h1 style='text-align:center;color:green;'><img src='sucess.png' width='40' height='40'><br>&nbsp;your credit card number is :$cdno</h1>";
	echo "</body>";
	mail($mail,"CREDIT CARD APPROVAL","your credit card number is : $cdno");

}
else
{
	echo "<html><head></head>
<body>
<script>
if(confirm('credit card already exist return lo home page')){
	location.href='main.html';
}else{
}
</script>
</body>
</html>";
	echo "<body style='background-color:yellow'>";
	echo "<br><br><br><br><br><br><br><br><br><br><h1 style='text-align:center;color:red;'><img src='warning.png' width='40' height='40'><br>&nbsp;Credit card already exists</h1>";
	echo "</body>";
}
}
?>
