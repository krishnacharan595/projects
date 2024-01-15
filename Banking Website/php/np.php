<?php
include "connect.php";
$acno=$_POST['anum'];
$dbno=$_POST['dbnu'];
$mobile=$_POST['telnum'];
$paswd=$_POST['paswd'];
$ncusid=$_POST['ncusid'];

$query1 ="select acno from customer where acno='$acno' and dbno='$dbno';";
$res1=mysqli_query($connect,$query1);
if(!mysqli_num_rows($res1)==0)
{

$query ="select acno from net_banking where acno='$acno';";
$res=mysqli_query($connect,$query);
if(mysqli_num_rows($res)==0)
{
	$query2="insert into net_banking values ('$acno','$dbno','$mobile','$paswd','$ncusid');";
	mysqli_query($connect,$query2);
	$query3="update customer set net_banking=TRUE where acno='$acno';";
	mysqli_query($connect,$query3);
	mail("krishnacharan595@gmail.com","NET BANKING REGISTRATION CUSTOMER ID","your net banking registration successfull,your customer id for net banking is :".$ncusid);
	echo "<body style='background-color:lightblue'>";
	echo "<br><br><br><br><br><br><br><br><br><br><h1 style='text-align:center;color:green;'><img src='sucess.png' width='40' 			height='40'><br>&nbsp;sucessfully applied for net banking ,your customer id is $ncusid</h1>";
	echo "</body>";
}
else
{
echo "<html><head></head>
<body>
<script>
if(confirm('already registered for net banking')){
	location.href='main.html';
}else{
}
</script>
</body>
</html>";
	echo "<body style='background-color:lightyellow'>";
	echo "<br><br><br><br><br><br><br><br><br><br><h1 style='text-align:center;color:red;'><img src='warning.png' width='40' 			height='40'><br>&nbsp;already registered for net banking</h1>";
	echo "</body>";
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
	echo "<body style='background-color:lightyellow'>";
	echo "<br><br><br><br><br><br><br><br><br><br><h1 style='text-align:center;color:red;'><img src='warning.png' width='40' 			height='40'><br>&nbsp;enter a valid account number</h1>";
	echo "</body>";
}
?>
