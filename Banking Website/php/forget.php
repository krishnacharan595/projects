<?php
include"connect.php";
$acno=$_POST['acnum'];
$mobile=$_POST['telnum'];
$query1 ="select acno from customer where acno='$acno';";
$res1=mysqli_query($connect,$query1);
$query007 ="select mail from customer where acno ='$acno';";
$res007=mysqli_query($connect,$query007);
$row007=$res007->fetch_assoc();
$mail=$row007["mail"];
if(!mysqli_num_rows($res1)==0)
{
	$query2="select paswd from customer where acno ='$acno' ;";
	$res1=mysqli_query($connect,$query2);
	$row=$res1->fetch_assoc();
	$p=$row["paswd"];	
	echo "<body style='background-color:pink'>";
	echo "<br><br><br><br><br><br><br><br><br><br><h1 style='text-align:center;color:green;'><br>&nbsp;Account number:$acno</h1>";
	echo "<h1 style='text-align:center;color:green;'><br>&nbsp;Password:$p</h1>";
	echo "</body>";
	mail($mail,"FORGOT PASSWORD","Your password for account number :$acno is:$p");
}
else{
echo "<html><head></head>
<body>
<script>
if(confirm('enter a valid account number')){
	location.href='main.html';
}else{
}
</script>
</body>
</html>";
	echo "<body style='background-color:lightbue'>";
	echo "<br><br><br><br><br><br><br><br><br><br><h1 style='text-align:center;color:red;'><img src='warning.png' width='40' height='40'><br>&nbsp;enter a valid account number</h1>";
	echo "</body>";}
?>
