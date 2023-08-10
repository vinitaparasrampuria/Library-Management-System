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
$SPNSR_ID=intval($_GET['SPNSR_ID']);
$SPONSOR_TYPE=$_POST['SPONSOR_TYPE'];
$FNAME=$_POST['FNAME'];
$LNAME=$_POST['LNAME'];
$AMOUNT=$_POST['AMOUNT'];

$sql="UPDATE VKM_SPONSOR SET FNAME=:FNAME,LNAME=:LNAME,SPONSOR_TYPE=:SPONSOR_TYPE WHERE SPNSR_ID=:SPNSR_ID";
$sql1="UPDATE VKM_SEM_SPNSR SET AMOUNT=:AMOUNT WHERE SPNSR_ID=:SPNSR_ID";
$sql2 = "SELECT * from VKM_SEM_SPNSR where SPNSR_ID=:SPNSR_ID";
$query = $dbh->prepare($sql);
$query1 = $dbh->prepare($sql1);
$query2 = $dbh->prepare($sql2);
$query->bindParam(':SPNSR_ID',$SPNSR_ID,PDO::PARAM_STR);
$query->bindParam(':FNAME',$FNAME,PDO::PARAM_STR);
$query->bindParam(':LNAME',$LNAME,PDO::PARAM_STR);
$query->bindParam(':SPONSOR_TYPE',$SPONSOR_TYPE,PDO::PARAM_STR);
$query1->bindParam(':AMOUNT',$AMOUNT,PDO::PARAM_STR);
$query1->bindParam(':SPNSR_ID',$SPNSR_ID,PDO::PARAM_STR);
$query2->bindParam(':SPNSR_ID',$SPNSR_ID,PDO::PARAM_STR);
$query->execute();
$query1->execute();
$query2->execute();
$reslt=$query2->fetchAll(PDO::FETCH_OBJ);
foreach($reslt as $res){

$_SESSION['updatemsg']="Sponsor info updated successfully";
header("location:view-sponsor.php?EVENT_ID=$res->EVENT_ID");
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
    <title>Online Library Management System | Edit Sponsor</title>
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
                <h4 class="header-line">Update Sponsor</h4>
                
                            </div>

</div>
<div class="row">
<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3"">
<div class="panel panel-info">
<div class="panel-heading">
Sponsor Info
</div>
<div class="panel-body">
<form role="form" method="post">

<?php 
$SPNSR_ID=intval($_GET['SPNSR_ID']);
$sql = "SELECT * from VKM_SPONSOR where SPNSR_ID=:SPNSR_ID";
$sql1 = "SELECT AMOUNT from VKM_SEM_SPNSR where SPNSR_ID=:SPNSR_ID";
$query = $dbh -> prepare($sql);
$query1 = $dbh->prepare($sql1);
$query->bindParam(':SPNSR_ID',$SPNSR_ID,PDO::PARAM_STR);
$query1->bindParam(':SPNSR_ID',$SPNSR_ID,PDO::PARAM_STR);
$query->execute();
$query1->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$result1=$query1->fetchAll(PDO::FETCH_OBJ);
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
<label>Last Name</label>
<input class="form-control" type="text" name="LNAME" value="<?php echo htmlentities($result->LNAME);?>" optional />
</div>
<?php ?>

<div class="form-group">
 <label for="SPONSOR_TYPE">Sponsor Type:</label>
<select name="SPONSOR_TYPE">
    <option value="Organization">Organization</option>
    <option value="Individual">Individual</option>
</select>
 </div>

 <?php 
foreach($result1 as $res)
{?> 
    <div class="form-group">
    <label>Amount</label>
    <input class="form-control" type="text" name="AMOUNT" value="<?php echo htmlentities($res->AMOUNT);?>" required />
    </div>
    <?php ?>
    <?php }?>



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