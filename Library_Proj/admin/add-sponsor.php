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
$SPNSR_ID=rand(pow(10, $digits-1), pow(10, $digits)-1);
$SPONSOR_TYPE=$_POST['SPONSOR_TYPE'];
$FNAME=$_POST['FNAME'];
$LNAME=$_POST['LNAME'];
$AMOUNT=$_POST['AMOUNT'];
$EVENT_ID=intval($_GET['EVENT_ID']);
$sql="INSERT INTO VKM_SPONSOR(SPNSR_ID,FNAME,LNAME,SPONSOR_TYPE) VALUES(:SPNSR_ID,:FNAME,:LNAME,:SPONSOR_TYPE)";
$sql1="INSERT INTO VKM_SEM_SPNSR(AMOUNT,SPNSR_ID,EVENT_ID) VALUES(:AMOUNT,:SPNSR_ID,:EVENT_ID)";
#$query->multi_query($sql);
$query = $dbh->prepare($sql);
$query1 = $dbh->prepare($sql1);

$query->bindParam(':SPNSR_ID',$SPNSR_ID,PDO::PARAM_STR);
$query->bindParam(':FNAME',$FNAME,PDO::PARAM_STR);
$query->bindParam(':LNAME',$LNAME,PDO::PARAM_STR);
$query->bindParam(':SPONSOR_TYPE',$SPONSOR_TYPE,PDO::PARAM_STR);
$query1->bindParam(':AMOUNT',$AMOUNT,PDO::PARAM_STR);
$query1->bindParam(':SPNSR_ID',$SPNSR_ID,PDO::PARAM_STR);
$query1->bindParam(':EVENT_ID',$EVENT_ID,PDO::PARAM_STR);
$query->execute();
$query1->execute();
#$query->close();
#$sql1="INSERT INTO VKM_SEM_SPNSR(AMOUNT,SPNSR_ID,EVENT_ID) VALUES(:AMOUNT,:SPNSR_ID,:EVENT_ID)";
#$query1 = $dbh->prepare($sql1);
#$query1->bindParam(':AMOUNT',$AMOUNT,PDO::PARAM_STR);
#$query1->bindParam(':SPNSR_ID',$SPNSR_ID,PDO::PARAM_STR);

#$query->execute();
#$query1->execute();

if(true)
{
$_SESSION['msg']="Sponsor Listed successfully";
header("location:view-sponsor.php?EVENT_ID=$EVENT_ID");

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
    <title>Online Library Management System | Add Sponsor</title>
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
                <h4 class="header-line">Add Sponsor</h4>
                
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
<div class="form-group">
<label>First Name<span style="color:red;">*</span></label>
<input class="form-control" type="text" name="FNAME" autocomplete="off"  required />
</div>
</div>
<div class="panel-body">
<form role="form" method="post">
<div class="form-group">
<label>Last Name<span style="color:red;">*</span></label>
<input class="form-control" type="text" name="LNAME" autocomplete="off"  optional />
</div>

<div class="form-group">
 <label for="SPONSOR_TYPE">Sponsor Type:</label>
<select name="SPONSOR_TYPE">
    <option value="Organization">Organization</option>
    <option value="Individual">Individual</option>
</select>
 </div>
 <div class="panel-body">
<form role="form" method="post">
<div class="form-group">
<label>Amount<span style="color:red;">*</span></label>
<input class="form-control" type="text" name="AMOUNT" autocomplete="off"  required />
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
