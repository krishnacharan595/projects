<?php
include"connect.php";
$acno=$_POST['accno'];
$mobile=$_POST['tel'];
$query1 ="select acno from customer where acno='$acno';";
$res1=mysqli_query($connect,$query1);
$query007 ="select mail from customer where acno ='$acno';";
$res007=mysqli_query($connect,$query007);
$row007=$res007->fetch_assoc();
$mail=$row007["mail"];
if(!mysqli_num_rows($res1)==0)
{
$query ="select acno from net_banking where acno ='$acno';";
$res=mysqli_query($connect,$query);
if(mysqli_num_rows($res)==0)
{
echo "<html><head></head>
<body>
<script>
if(confirm('enter a valid account number registered with net banking')){
	location.href='main.html';
}else{
}
</script>
</body>
</html>";
	echo "<body style='background-color:lightbue'>";
	echo "<br><br><br><br><br><br><br><br><br><br><h1 style='text-align:center;color:red;'><img src='warning.png' width='40' height='40'><br>&nbsp;enter a valid account number registered with net banking</h1>";
	echo "</body>";
}
else
{
	$query2="select paswd from net_banking where acno ='$acno' ;";
	$res1=mysqli_query($connect,$query2);
	$row=$res1->fetch_assoc();
	$p=$row["paswd"];	
	echo "<body style='background-color:pink'>";
	echo "<br><br><br><br><br><br><br><br><br><br><h1 style='text-align:center;color:green;'><br>&nbsp;Account number:$acno</h1>";
	echo "<h1 style='text-align:center;color:green;'><br>&nbsp;Password:$p</h1>";
	echo "</body>";
	mail($mail,"FORGOT PASSWORD","Your password for net banking is:$p");
}
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
