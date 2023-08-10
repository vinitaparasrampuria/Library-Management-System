<?php 
session_start();
include('includes/config.php');
error_reporting(0);
if(isset($_POST['signup']))
 {
$digits = 3;
$CUST_ID=rand(pow(10, $digits-1), pow(10, $digits)-1); 
$FNAME=$_POST['FNAME'];
$MNAME=$_POST['MNAME'];
$LNAME=$_POST['LNAME'];
$PHN_NO=$_POST['PHN_NO'];
$EMAIL=$_POST['EMAIL']; 
$ID_TYPE=$_POST['ID_TYPE'];
$ID_NO=$_POST['ID_NO'];
$Password1=md5($_POST['Password1']);
$sql="INSERT INTO VKM_CUSTOMER(CUST_ID, FNAME, MNAME, LNAME, PHN_NO, EMAIL, ID_TYPE, ID_NO, Password1) 
VALUES(:CUST_ID, :FNAME, :MNAME, :LNAME, :PHN_NO, :EMAIL, :ID_TYPE, :ID_NO, :Password1)";

$query = $dbh->prepare($sql);
$query->bindParam(':CUST_ID',$CUST_ID,PDO::PARAM_STR);
$query->bindParam(':FNAME',$FNAME,PDO::PARAM_STR);
$query->bindParam(':MNAME',$MNAME,PDO::PARAM_STR);
$query->bindParam(':LNAME',$LNAME,PDO::PARAM_STR);
$query->bindParam(':PHN_NO',$PHN_NO,PDO::PARAM_STR);
$query->bindParam(':EMAIL',$EMAIL,PDO::PARAM_STR);
$query->bindParam(':ID_TYPE',$ID_TYPE,PDO::PARAM_STR);
$query->bindParam(':ID_NO',$ID_NO,PDO::PARAM_STR);
$query->bindParam(':Password1',$Password1,PDO::PARAM_STR);
$query->execute();
if(true)
{
echo '<script>alert("Your Registration successful and your customer id is  "+"'.$CUST_ID.'")</script>';

}
else 
{
echo "<script>alert('Something went wrong. Please try again');</script>";
}
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <!--[if IE]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <![endif]-->
    <title>Online Library Management System | Customer Signup</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
    <!-- GOOGLE FONT -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
<script type="text/javascript">
function valid()
{
if(document.signup.Password1.value!= document.signup.confirmpassword.value)
{
alert("Password and Confirm Password Field do not match  !!");
document.signup.confirmpassword.focus();
return false;
}
return true;
}
</script>
<script>
function checkAvailability() {
$("#loaderIcon").show();
jQuery.ajax({
url: "check_availability.php",
data:'emailid='+$("#emailid").val(),
type: "POST",
success:function(data){
$("#user-availability-status").html(data);
$("#loaderIcon").hide();
},
error:function (){}
});
}
</script>    

</head>
<body>
    <!------MENU SECTION START-->
<?php include('includes/header.php');?>
<!-- MENU SECTION END-->
    <div class="content-wrapper">
         <div class="container">
        <div class="row pad-botm">
            <div class="col-md-12">
                <h4 class="header-line">Customer Signup</h4>
                
                            </div>

        </div>
             <div class="row">
           
<div class="col-md-9 col-md-offset-1">
               <div class="panel panel-danger">
                        <div class="panel-heading">
                           SINGUP FORM
                        </div>
                        <div class="panel-body">
                            <form name="signup" method="post" onSubmit="return valid();">
<div class="form-group">
<label>Enter First Name</label>
<input class="form-control" type="text" name="FNAME" autocomplete="off" required />
</div>

<div class="form-group">
<label>Enter Middle Name</label>
<input class="form-control" type="text" name="MNAME" autocomplete="off" optional />
</div>

<div class="form-group">
<label>Enter Last Name</label>
<input class="form-control" type="text" name="LNAME" autocomplete="off" required />
</div>


<div class="form-group">
<label>Phone Number :</label>
<input class="form-control" type="text" name="PHN_NO" maxlength="10" autocomplete="off" required />
</div>
                                        
<div class="form-group">
<label>Enter Email</label>
<input class="form-control" type="email" name="EMAIL" id="emailid" onBlur="checkAvailability()"  autocomplete="off" required  />
   <span id="user-availability-status" style="font-size:12px;"></span> 
</div>

<div class="form-group">
<label>ID type :</label>
<input class="form-control" type="text" name="ID_TYPE" maxlength="10" autocomplete="off" required />
</div>

<div class="form-group">
<label>ID Number :</label>
<input class="form-control" type="text" name="ID_NO" maxlength="10" autocomplete="off" required />
</div>

<div class="form-group">
<label>Enter Password</label>
<input class="form-control" type="password" name="Password1" autocomplete="off" required  />
</div>

<div class="form-group">
<label>Confirm Password </label>
<input class="form-control"  type="password" name="confirmpassword" autocomplete="off" required  />
</div>
                              
<button type="submit" name="signup" class="btn btn-danger" id="submit">Register Now </button>

                                    </form>
                            </div>
                        </div>
                            </div>
        </div>
    </div>
    </div>
     <!-- CONTENT-WRAPPER SECTION END-->
    <?php include('includes/footer.php');?>
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- BOOTSTRAP SCRIPTS  -->
    <script src="assets/js/bootstrap.js"></script>
      <!-- CUSTOM SCRIPTS  -->
    <script src="assets/js/custom.js"></script>
</body>
</html>
