<?php
include"connect.php";
$uname=$_POST['name'];
$acno=$_POST['acnum'];
$amount=$_POST['amountrs'];

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
	echo "<br><br><br><br><br><br><br><br><br><br><h1 style='text-align:center;color:red;'><img src='warning.png' width='40' height='40'><br>&nbsp;enter a valid account number</h1>";
	echo "</body>";
}
else{
$query9 ="select savings from customer where acno ='$acno';";
$res9=mysqli_query($connect,$query9);
$row9=$res9->fetch_assoc();
	$s9=$row9['savings'];
if($s9>=$amount){
	$query2="select amount from house_loan where acno='$acno';";
	$res1=mysqli_query($connect,$query2);
	$row=$res1->fetch_assoc();
	$s=$row['amount'];
	$k=$s-$amount;
	if($k >= 0){
		$p=$s9-$amount;
		$query52="update customer set savings=$p where acno='$acno';";
	 mysqli_query($connect,$query52);
	 $query3="update house_loan set amount='$k' where acno='$acno';";
	 mysqli_query($connect,$query3);
	$query5="select amount from house_loan where acno='$acno';";
	$res12=mysqli_query($connect,$query5);
	$row=$res12->fetch_assoc();
	$s1=$row['amount'];
	if($s1==0){
		 $query5="update customer set houseloan=FALSE where acno='$acno';";
	 mysqli_query($connect,$query5);
	$query51="delete from house_loan where acno='$acno';";
	 mysqli_query($connect,$query51);
	}
	echo "<body style='background-color:lightblue'>";
	echo "<br><br><br><br><br><br><br><br><br><br><h1 style='text-align:center;color:green;'><img src='sucess.png' width='40' height='40'><br>&nbsp;loan amount of $amount is sucessfully paid remaining balance is: $s1</h1>";
	echo "</body>";
	mail($mail,"HOUSE LOAN PAYMENT"," loan amount of $amount is sucessfully paid remaining balance is: $s1 that has to be paid ");
	}
	else
	{	echo "<html><head></head>
<body>
<script>
if(confirm('no pending loan payments to pay/check the amount that has to be paid as house loan')){
	location.href='main.html';
}else{
}
</script>
</body>
</html>";	
	echo "<body style='background-color:lightyellow'>";
	echo "<br><br><br><br><br><br><br><br><br><br><h1 style='text-align:center;color:red;'><img src='warning.png' width='40' height='40'><br>&nbsp;no pending loan payments to pay/check the amount that has to be paid as house loan</h1>";
	echo "</body>";	
	}
}
else{
echo "<html><head></head>
<body>
<script>
if(confirm('insufficient funds in your savings account')){
	location.href='main.html';
}else{
}
</script>
</body>
</html>";
echo "<body style='background-color:lightyellow'>";
	echo "<br><br><br><br><br><br><br><br><br><br><h1 style='text-align:center;color:red;'><img src='warning.png' width='40' height='40'><br>&nbsp;insufficient amount to pay</h1>";
	echo "</body>";
}
}
?>