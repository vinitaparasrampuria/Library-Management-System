<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
    {   
header('location:index.php');
}
else{ 

if(isset($_POST['add']))
{

$digits = 6;
$REG_ID=rand(pow(10, $digits-1), pow(10, $digits)-1);
$SPONSOR_TYPE=$_POST['SPONSOR_TYPE'];
$CUST_ID=$_POST['CUST_ID'];
$EVENT_ID=intval($_GET['EVENT_ID']);
$sql="INSERT INTO VKM_CUST_EXH(REG_ID,CUST_ID,EVENT_ID) VALUES(:REG_ID,:CUST_ID,:EVENT_ID)";
$query = $dbh->prepare($sql);

$query->bindParam(':REG_ID',$REG_ID,PDO::PARAM_STR);
$query->bindParam(':CUST_ID',$CUST_ID,PDO::PARAM_STR);
$query->bindParam(':EVENT_ID',$EVENT_ID,PDO::PARAM_STR);
$query->execute();

if(true)
{
$_SESSION['msg']="Customer registered successfully";
#echo '<script>alert("Your Registration successful and your registration id is  "+"'.$REG_ID.'")</script>';
#header("location:view-author-visitor.php?EVENT_ID=$EVENT_ID");
header('location:manage-exhibition.php');
}
else 
{
$_SESSION['error']="Something went wrong. Please try again";
header('location:manage-seminar.php');
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
    <title>Online Library Management System | Add Author for Exhibition</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
    <!-- GOOGLE FONT -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

</head>
<body>
      <!------MENU SECTION START-->
<?php include('includes/header.php');?>
<!-- MENU SECTION END-->
    <div class="content-wra
    <div class="content-wrapper">
         <div class="container">
        <div class="row pad-botm">
            <div class="col-md-12">
                <h4 class="header-line">Add Customer</h4>
                
                            </div>

</div>
<div class="row">
<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3"">
<div class="panel panel-info">
<div class="panel-heading">
Customer Info
</div>
<div class="panel-body">
<form role="form" method="post">
<div class="form-group">
<label> Customer<span style="color:red;">*</span></label>
<select class="form-control" name="CUST_ID" required="required">
<option value=""> Select Customer</option>
<?php 
$sql = "SELECT * from VKM_CUSTOMER";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{               ?>  
<option value="<?php echo htmlentities($result->CUST_ID);?>"><?php echo htmlentities($result->CUST_ID);
echo htmlentities(" ");
echo htmlentities($result->FNAME);
echo htmlentities(" ");
echo htmlentities($result->MNAME);
echo htmlentities(" ");
echo htmlentities($result->LNAME);?></td></option>
 <?php }} ?> 
</select>
</div>


<button type="submit" name="add" class="btn btn-info">Add </button>

                                    </form>
                            </div>
                        </div>
                            </div>

        </div>
   
    </div>
    </div>
     <!-- CONTENT-WRAPPER SECTION END-->
  <?php include('includes/footer.php');?>
      <!-- FOOTER SECTION END-->
    <!-- JAVASCRIPT FILES PLACED AT THE BOTTOM TO REDUCE THE LOADING TIME  -->
    <!-- CORE JQUERY  -->
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- BOOTSTRAP SCRIPTS  -->
    <script src="assets/js/bootstrap.js"></script>
      <!-- CUSTOM SCRIPTS  -->
    <script src="assets/js/custom.js"></script>
</body>
</html>
<?php } ?>
