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
$digits = 5;
$EVENT_ID=intval($_GET['EVENT_ID']);
$AUTHOR_ID=$_POST['AUTHOR_ID'];
$INV_ID=rand(pow(10, $digits-1), pow(10, $digits)-1);

$sql="INSERT INTO VKM_AUTHOR_EX(EVENT_ID,INV_ID,AUTHOR_ID) VALUES(:EVENT_ID,:INV_ID,:AUTHOR_ID)";
$query = $dbh->prepare($sql);
$query->bindParam(':EVENT_ID',$EVENT_ID,PDO::PARAM_STR);
$query->bindParam(':INV_ID',$INV_ID,PDO::PARAM_STR);
$query->bindParam(':AUTHOR_ID',$AUTHOR_ID,PDO::PARAM_STR);
$query->execute();

if(true)
{
$_SESSION['msg']="Author invited successfully";
echo '<script>alert("Your Registration successful and your invitation id is  "+"'.$INV_ID.'")</script>';
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
<div class="form-group">
<label> Author<span style="color:red;">*</span></label>
<select class="form-control" name="AUTHOR_ID" required="required">
<option value=""> Select Author</option>
<?php 
$sql = "SELECT * from  VKM_AUTHOR";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{               ?>  
<option value="<?php echo htmlentities($result->AUTHOR_ID);?>"><?php echo htmlentities($result->AUTHOR_ID);
echo htmlentities(" ");
echo htmlentities($result->AFNAME);
echo htmlentities(" ");
echo htmlentities($result->AMNAME);
echo htmlentities(" ");
echo htmlentities($result->ALNAME);?></td></option>
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
