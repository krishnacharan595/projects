<?php
include"connect.php";
$name=$_POST['name'];
$dob=$_POST['dob'];
$fname=$_POST['fname'];
$anum=$_POST['anum'];
$pnum=$_POST['pnum'];
$telnum=$_POST['telnum'];
$mail=$_POST['mail'];
$addr=$_POST['addr'];
$acno=$_POST['acno'];
$paswd=$_POST['paswd'];


$query ="select acno from customer where pnum='$pnum' and anum='$anum'";
$res=mysqli_query($connect,$query);
if(mysqli_num_rows($res)==0)
{
	mail($mail,"ACCOUNT NUMBER","Your account number is :".$acno);
	$query2="insert into customer(name,fname,anum,pnum,telnum,addr,dob,mail,acno,paswd) values('$name','$fname','$anum', '$pnum', '$telnum','$addr','$dob','$mail','$acno','$paswd');";
	mysqli_query($connect,$query2);
	echo "<html><head></head>
<body>
<script>
if(confirm('account created successfully return to login page')){
	location.href='login.html';
}else{
	location.href='aco.html';

}
</script>
</body>
</html>";

}
else
{
	echo "<html><head></head>
<body>
<script>
if(confirm('account already exist return lo login page')){
	location.href='login.html';
}else{
}
</script>
</body>
</html>";

	echo "<br><br><br><br><br><br><br><br><br><br><h1 style='text-align:center;color:red;'><img src='warning.png' width='40' height='40'><br>&nbsp;Account already exists</h1>";
}
?>
