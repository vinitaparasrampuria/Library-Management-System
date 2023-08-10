<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
    {   
header('location:index.php');
}
else{ 

if(isset($_POST['update']))
{
$CUST_ID=intval($_GET['CUST_ID']);
$FNAME=$_POST['FNAME'];
$MNAME=$_POST['MNAME'];
$LNAME=$_POST['LNAME'];
$PHN_NO=$_POST['PHN_NO'];
$EMAIL=$_POST['EMAIL']; 
$ID_TYPE=$_POST['ID_TYPE'];
$ID_NO=$_POST['ID_NO'];

$sql="UPDATE VKM_CUSTOMER SET FNAME=:FNAME,MNAME=:MNAME,LNAME=:LNAME,PHN_NO=:PHN_NO,EMAIL=:EMAIL,ID_TYPE=:ID_TYPE,ID_NO=:ID_NO where CUST_ID=:CUST_ID";
$query = $dbh->prepare($sql);
$query->bindParam(':CUST_ID',$CUST_ID,PDO::PARAM_STR);
$query->bindParam(':FNAME',$FNAME,PDO::PARAM_STR);
$query->bindParam(':MNAME',$MNAME,PDO::PARAM_STR);
$query->bindParam(':LNAME',$LNAME,PDO::PARAM_STR);
$query->bindParam(':PHN_NO',$PHN_NO,PDO::PARAM_STR);
$query->bindParam(':EMAIL',$EMAIL,PDO::PARAM_STR);
$query->bindParam(':ID_TYPE',$ID_TYPE,PDO::PARAM_STR);
$query->bindParam(':ID_NO',$ID_NO,PDO::PARAM_STR);
$query->execute();
$_SESSION['updatemsg']="Customer info updated successfully";
header('location:reg-students.php');

}

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Online Library Management System | Edit Customer</title>
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
                <h4 class="header-line">Edit Customer</h4>
                
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

<?php 
$CUST_ID=intval($_GET['CUST_ID']);
$sql = "SELECT * from  VKM_CUSTOMER where CUST_ID=:CUST_ID";
$query = $dbh -> prepare($sql);
$query->bindParam(':CUST_ID',$CUST_ID,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{               ?>   
<div class="form-group">
<label>First Name</label>
<input class="form-control" type="text" name="FNAME" value="<?php echo htmlentities($result->FNAME);?>" required />
</div>
<?php ?>
<div class="form-group">
<label>Middle Name</label>
<input class="form-control" type="text" name="MNAME" value="<?php echo htmlentities($result->MNAME);?>" optional />
</div>
<?php ?>
<div class="form-group">
<label>Last Name</label>
<input class="form-control" type="text" name="LNAME" value="<?php echo htmlentities($result->LNAME);?>" required />
</div>
<?php ?>
<div class="form-group">
<label>Phone Number:</label>
<input class="form-control" type="text" name="PHN_NO" value="<?php echo htmlentities($result->PHN_NO);?>" required />
</div>
<?php ?>
<div class="form-group">
<label>Email</label>
<input class="form-control" type="email" name="EMAIL" value="<?php echo htmlentities($result->EMAIL);?>" required readonly />
</div>
<?php ?>
<div class="form-group">
<label>ID type :</label>
<input class="form-control" type="text" name="ID_TYPE" value="<?php echo htmlentities($result->ID_TYPE);?>" required />
</div>
<?php ?>
<div class="form-group">
<label>ID Number :</label>
<input class="form-control" type="text" name="ID_NO" value="<?php echo htmlentities($result->ID_NO);?>" required />
</div>
<?php ?>

<?php }}?>

<button type="submit" name="update" class="btn btn-info">Update </button>

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