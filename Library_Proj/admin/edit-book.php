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
$BNAME=$_POST['BNAME'];
$TOPIC_ID=$_POST['TOPIC_ID'];

$BOOK_ID=intval($_GET['BOOK_ID']);
$sql="update  vkm_book_det set BNAME=:BNAME,TOPIC_ID=:TOPIC_ID where BOOK_ID=:BOOK_ID";
$query = $dbh->prepare($sql);
$query->bindParam(':BNAME',$BNAME,PDO::PARAM_STR);
$query->bindParam(':TOPIC_ID',$TOPIC_ID,PDO::PARAM_STR);
$query->bindParam(':BOOK_ID',$BOOK_ID,PDO::PARAM_STR);

$query->execute();
$_SESSION['msg']="Book info updated successfully";
header('location:manage-books.php');


}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Online Library Management System | Edit Book</title>
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
                <h4 class="header-line">Add Book</h4>
                
                            </div>

</div>
<div class="row">
<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3"">
<div class="panel panel-info">
<div class="panel-heading">
Book Info
</div>
<div class="panel-body">
<form role="form" method="post">
<?php 
$BOOK_ID=intval($_GET['BOOK_ID']);
$sql = "SELECT BOOK_ID, BNAME, TOPIC_DESC From vkm_book_det JOIN VKM_TOPIC on vkm_book_det.TOPIC_ID=VKM_TOPIC.TOPIC_ID where vkm_book_det.BOOK_ID=:BOOK_ID; ";
$query = $dbh -> prepare($sql);
$query->bindParam(':BOOK_ID',$BOOK_ID,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{               ?>  

<div class="form-group">
<label>Book Name<span style="color:red;">*</span></label>
<input class="form-control" type="text" name="BNAME" value="<?php echo htmlentities($result->BNAME);?>" required />
</div>

<div class="form-group">
<label> Topic<span style="color:red;">*</span></label>
<select class="form-control" name="TOPIC_ID" required="required">
<option value=""> Select Topic</option>
<?php
$sql = "SELECT * from  vkm_topic";
$query = $dbh -> prepare($sql);
#$query -> bindParam(':status',$status, PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{               ?>  
<option value="<?php echo htmlentities($result->TOPIC_ID);?>"><?php echo htmlentities($result->TOPIC_DESC);?></option>
 <?php }} ?> 
</select>
</div>



 <?php }} ?>
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