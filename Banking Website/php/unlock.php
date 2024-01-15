<?php
include"connect.php";
$uname=$_POST['name'];
$acno=$_POST['anum'];
$mail=$_POST['telnum'];
$dob=$_POST['dob'];
$query007 ="select mail from customer where acno ='$acno';";
$res007=mysqli_query($connect,$query007);
$row007=$res007->fetch_assoc();
$mail=$row007["mail"];




$query ="select acno from u where acno ='$acno';";
$res=mysqli_query($connect,$query);
if(mysqli_num_rows($res)==0)
{
	$query2="insert into u values('$uname','$acno','$mail' ,'$dob');";
	mysqli_query($connect,$query2);
$query12="update customer set u =TRUE where acno='$acno';";
	mysqli_query($connect,$query12);
echo "<body style='background-color:lightblue'>";
	echo "<br><br><br><br><br><br><br><br><br><br><h1 style='text-align:center;color:green;'><img src='sucess.png' width='40' 			height='40'><br>&nbsp;sucessfully requested for net banking account unlock</h1>";
	mail($mail,"REQUEST FOR NET BANKING ACCOUNT UNLOCK","sucessfully requested for net banking account unlock");

}
else
{
echo "<html><head></head>
<body>
<script>
if(confirm('already requested for unlocking net banking account')){
	location.href='main.html';
}else{
}
</script>
</body>
</html>";

echo "<body style='background-color:lightyellow'>";
	echo "<br><br><br><br><br><br><br><br><br><br><h1 style='text-align:center;color:pink;'><img src='warning.png' width='40' 			height='40'><br>&nbsp;already requested for unlocking net banking account</h1>";
	echo "</body>";
	}
?>