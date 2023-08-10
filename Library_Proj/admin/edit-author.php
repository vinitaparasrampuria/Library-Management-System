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
$AUTHOR_ID=intval($_GET['AUTHOR_ID']);
$AFNAME=$_POST['AFNAME'];
$AMNAME=$_POST['AMNAME'];
$ALNAME=$_POST['ALNAME'];
$ASTREET_ADD=$_POST['ASTREET_ADD'];
$ACITY=$_POST['ACITY'];
$ASTATE=$_POST['ASTATE'];
$ACOUNTRY=$_POST['ACOUNTRY'];
$AZIP_CODE=$_POST['AZIP_CODE'];
$AEMAIL=$_POST['AEMAIL'];

$sql="UPDATE VKM_AUTHOR SET AFNAME=:AFNAME,AMNAME=:AMNAME,ALNAME=:ALNAME,ASTREET_ADD=:ASTREET_ADD,ACITY=:ACITY,ASTATE=:ASTATE,ACOUNTRY=:ACOUNTRY,AZIP_CODE=:AZIP_CODE,AEMAIL=:AEMAIL where AUTHOR_ID=:AUTHOR_ID";
$query = $dbh->prepare($sql);
$query->bindParam(':AUTHOR_ID',$AUTHOR_ID,PDO::PARAM_STR);
$query->bindParam(':AFNAME',$AFNAME,PDO::PARAM_STR);
$query->bindParam(':AMNAME',$AMNAME,PDO::PARAM_STR);
$query->bindParam(':ALNAME',$ALNAME,PDO::PARAM_STR);
$query->bindParam(':ASTREET_ADD',$ASTREET_ADD,PDO::PARAM_STR);
$query->bindParam(':ACITY',$ACITY,PDO::PARAM_STR);
$query->bindParam(':ASTATE',$ASTATE,PDO::PARAM_STR);
$query->bindParam(':ACOUNTRY',$ACOUNTRY,PDO::PARAM_STR);
$query->bindParam(':AZIP_CODE',$AZIP_CODE,PDO::PARAM_STR);
$query->bindParam(':AEMAIL',$AEMAIL,PDO::PARAM_STR);
$query->execute();
$_SESSION['updatemsg']="Author info updated successfully";
header('location:manage-authors.php');

}

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Online Library Management System | Add Author</title>
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
                <h4 class="header-line">Add Author</h4>
                
                            </div>

</div>
<div class="row">
<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3"">
<div class="panel panel-info">
<div class="panel-heading">
Author Info
</div>
<div class="panel-body">
<form role="form" method="post">

<?php 
$AUTHOR_ID=intval($_GET['AUTHOR_ID']);
$sql = "SELECT * from  VKM_AUTHOR where AUTHOR_ID=:AUTHOR_ID";
$query = $dbh -> prepare($sql);
$query->bindParam(':AUTHOR_ID',$AUTHOR_ID,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{               ?>   
<div class="form-group">
<label>First Name</label>
<input class="form-control" type="text" name="AFNAME" value="<?php echo htmlentities($result->AFNAME);?>" required />
</div>
<?php ?>
<div class="form-group">
<label>Middle Name</label>
<input class="form-control" type="text" name="AMNAME" value="<?php echo htmlentities($result->AMNAME);?>" required />
</div>
<?php ?>
<div class="form-group">
<label>Last Name</label>
<input class="form-control" type="text" name="ALNAME" value="<?php echo htmlentities($result->ALNAME);?>" required />
</div>
<?php ?>
<div class="form-group">
<label>Street Address</label>
<input class="form-control" type="text" name="ASTREET_ADD" value="<?php echo htmlentities($result->ASTREET_ADD);?>" required />
</div>
<?php ?>
<div class="form-group">
<label>City</label>
<input class="form-control" type="text" name="ACITY" value="<?php echo htmlentities($result->ACITY);?>" required />
</div>
<?php ?>
<div class="form-group">
<label>State</label>
<input class="form-control" type="text" name="ASTATE" value="<?php echo htmlentities($result->ASTATE);?>" required />
</div>
<?php ?>
<div class="form-group">
<label>Country</label>
<input class="form-control" type="text" name="ACOUNTRY" value="<?php echo htmlentities($result->ACOUNTRY);?>" required />
</div>
<?php ?>
<div class="form-group">
<label>Zip Code</label>
<input class="form-control" type="text" name="AZIP_CODE" value="<?php echo htmlentities($result->AZIP_CODE);?>" required />
</div>
<?php ?>
<div class="form-group">
<label>Email</label>
<input class="form-control" type="email" name="AEMAIL" value="<?php echo htmlentities($result->AEMAIL);?>" required />
</div>
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