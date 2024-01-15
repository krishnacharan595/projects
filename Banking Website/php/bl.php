 <?php
include"connect.php";
$name=$_POST['name'];
$acno=$_POST['anum'];
$mobile=$_POST['telnum'];
$dob=$_POST['dob'];
$adr=$_POST['dec1'];
$pa=$_POST['pa'];
$query007 ="select mail from customer where acno ='$acno';";
$res007=mysqli_query($connect,$query007);
$row007=$res007->fetch_assoc();
$mail=$row007["mail"];

$query ="select acno from business_loan where acno ='$acno';";
$res=mysqli_query($connect,$query);
$query1 ="select acno from customer where acno ='$acno';";
$res1=mysqli_query($connect,$query1);
if(!mysqli_num_rows($res1)==0){
if(mysqli_num_rows($res)==0)
{
$query2="insert into business_loan values('$name','$acno','$mobile','$dob','$adr','$pa');";
	mysqli_query($connect,$query2);
	$query5 ="select amount from business_loan where acno ='$acno';";
	$res3=mysqli_query($connect,$query5);
	$row=$res3->fetch_assoc();
	$t=$row["amount"];
	$t_amount=$t+$pa;
	$query4="update customer set current ='$t_amount' where acno='$acno';";
	mysqli_query($connect,$query4);
	$query3="update customer set businessloan=TRUE where acno='$acno';";
	mysqli_query($connect,$query3);
	echo "<body style='background-color:white'>";
	echo "<br><br><br><br><br><br><br><br><br><br><h1 style='text-align:center;color:green;'><img src='sucess.png' width='40' height='40'><br>&nbsp;your business loan of rs.$pa has been approved</h1>";
	echo "</body>";
	mail($mail,"BUSINESS LOAN APPROVAL","Your business laon of rs.$pa has been approved");
}
else
{echo "<body style='background-color:lightyellow'>";
	echo "<br><br><br><br><br><br><br><br><br><br><h1 style='text-align:center;color:red;'><img src='warning.png' width='40' height='40'><br>&nbsp;you have already applied for business loan</h1>";
	echo "</body>";
}
}
else{
echo "<html><head></head>
<body>
<script>
if(confirm('Please check your account number')){
	location.href='main.html';
}else{
}
</script>
</body>
</html>";
echo "<body style='background-color:lightyellow'>";
	echo "<br><br><br><br><br><br><br><br><br><br><h1 style='text-align:center;color:red;'><img src='warning.png' width='40' height='40'><br>&nbsp;check your account number </h1>";
	echo "</body>";
}

?>
