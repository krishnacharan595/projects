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
	echo "<body style='background-color:lightblue'>";
	echo "<br><br><br><br><br><br><br><br><br><br><h1 style='text-align:center;color:red;'><img src='warning.png' width='40' height='40'><br>&nbsp;check your account number</h1>";
	echo "</body>";
}
else
{
	$query2="select current from customer where acno='$acno';";
	$res1=mysqli_query($connect,$query2);
	$row=$res1->fetch_assoc();
	$s=$row['current'];
	$k=$s+$amount;
	$query3="update customer set current='$k' where acno='$acno';";
	mysqli_query($connect,$query3);
	echo "<body style='background-color:lightblue'>";
	echo "<br><br><br><br><br><br><br><br><br><br><h1 style='text-align:center;color:green;'><img src='sucess.png' width='40'height='40'><br>&nbsp;Rs.$amount has been successfully credited in your current account</h1>";
	echo "</body>";
	mail($mail,"AMOUNT CREDITED IN CURRENT ACCOUNT","Rs.$amount has been successfully credited in your current account");

}
?>
