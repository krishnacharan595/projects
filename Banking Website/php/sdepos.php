<?php
include"connect.php";
$name=$_POST['uname'];
$acno=$_POST['anum'];
$amount=$_POST['amountrs'];
$mobile=$_POST['telnum'];
$query007 ="select mail from customer where acno ='$acno';";
$res007=mysqli_query($connect,$query007);
$row007=$res007->fetch_assoc();
$mail=$row007["mail"];

$query ="select acno from customer where acno ='$acno';";
$res=mysqli_query($connect,$query);
if(mysqli_num_rows($res)==0)
{
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
	echo "<body style='background-color:yellow'>";
	echo "<br><br><br><br><br><br><br><br><br><br><h1 style='text-align:center;color:red;'><img src='warning.png' width='40' 			height='40'><br>&nbsp;enter a valid account number</h1>";
	echo "</body>";
}
else
{
	$query2="select savings from customer where acno='$acno';";
	$res1=mysqli_query($connect,$query2);
	$row=$res1->fetch_assoc();
	$s=$row['savings'];
	$k=$s+$amount;
	$query3="update customer set savings='$k' where acno='$acno';";
	mysqli_query($connect,$query3);
	
	echo "<body style='background-color:lightblue'>";
	echo "<br><br><br><br><br><br><br><br><br><br><h1 style='text-align:center;color:green;'><img src='sucess.png' width='40' 			height='40'><br>&nbsp;RS.$amount sucessfully credited in your saving account</h1>";
	echo "</body>";
	mail($mail,"AMOUNT CREDITED IN SAVINGS ACCOUNT","RS.$amount sucessfully credited in your saving account");

}
?>
