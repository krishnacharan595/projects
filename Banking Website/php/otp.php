<?php
include "connect.php";
$uname=$_POST['uname'];
$acno=$_POST['acc'];
$paswd=$_POST['paswd'];
$otp=$_POST['otp'];
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
if(confirm('account number is invalid return back to login')){
	location.href='login.html';
}else{
	location.href='aco.html';

}
</script>
</body>
</html>";
	}
	else
	{	$query11 ="select paswd from customer where acno ='$acno';";
		$res11=mysqli_query($connect,$query11);
		$row=$res11->fetch_assoc();
		$p=$row["paswd"];
		if($p!=$paswd)
		{
			echo "<html><head></head>
<body>
<script>
if(confirm('Password is invalid')){
	location.href='login.html';
}else{
	location.href='login.html';

}
</script>
</body>
</html>";	
		}
		else{
			mail($mail,"OTP VERIFICATION",$otp);	
			$query10="insert into otp values('$acno','$otp');";
			$k=mysqli_query($connect,$query10);
			header("Location:login1.html");
		}
	}
?>