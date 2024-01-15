<?php
include"connect.php";
$name=$_POST['name'];
$acno=$_POST['acnum'];
$amount=$_POST['amountrs'];
$mobile=$_POST['telnum'];
$query007 ="select mail from customer where acno ='$acno';";
$res007=mysqli_query($connect,$query007);
$row007=$res007->fetch_assoc();
$mail=$row007["mail"];
$query ="select acno from customer where acno ='$acno';";
$res=mysqli_query($connect,$query);
if(mysqli_num_rows($res)==0)
{echo "<html><head></head>
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
	$k=$s-$amount;
	if($k >= 0){
	 $query3="update customer set savings='$k' where acno='$acno';";
	 mysqli_query($connect,$query3);
echo "<body style='background-color:lightblue'>";
	echo "<br><br><br><br><br><br><br><br><br><br><h1 style='text-align:center;color:green;'><img src='sucess.png' width='40' 			height='40'><br>&nbsp;RS.$amount sucessfully debited
 from your saving account</h1>";
	echo "</body>";
mail($mail,"AMOUNT DEBITED FROM SAVINGS ACCOUNT","RS.$amount sucessfully debited
 from your saving account");
	}
	else{
echo "<html><head></head>
<body>
<script>
if(confirm('insufficient funds for withdrawl')){
	location.href='main.html';
}else{
}
</script>
</body>
</html>";

	 echo "<body style='background-color:lightyellow'>";
	echo "<br><br><br><br><br><br><br><br><br><br><h1 style='text-align:center;color:pink;'><img src='warning.png' width='40' 			height='40'><br>&nbsp;insufficient funds for widthdrawl</h1>";
	echo "</body>";
	
}
}
?>
