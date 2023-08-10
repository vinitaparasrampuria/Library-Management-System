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
$count_my_page = ("sponsorid.txt");
$hits = file($count_my_page);
$hits[0] ++;
$fp = fopen($count_my_page , "w");
fputs($fp , "$hits[0]");
fclose($fp); 
$spnsr_id= $hits[0];
$sponsor_type=$_POST['sponsor_type'];
$fname=$_POST['fname'];
$lname=$_POST['lname'];
$amount=$_POST['amount'];
$sql="INSERT INTO  vkm_sponsor(spnsr_id,fname,lname, sponsor_type) VALUES(:spnsr_id,:fname,:lname,:sponsor_type)";
$query = $dbh->prepare($sql);
$query->bindParam(':spnsr_id',$spnsr_id,PDO::PARAM_STR);
$query->bindParam(':fname',$fname,PDO::PARAM_STR);
$query->bindParam(':lname',$stopDate,PDO::PARAM_STR);
$query->bindParam(':sponsor_type',$topic_desc,PDO::PARAM_STR);
$query->execute();
$lastInsertId = $dbh->lastInsertId();
$sql1="INSERT INTO  vkm_sem_sponsor(amount,spnsr_id,event_id) VALUES(:amount,:spnsr_id,:event_id)";
$query = $dbh->prepare($sql);
$query->bindParam(':amount',$amount,PDO::PARAM_STR);
$query->execute();
$lastInsertId = $dbh->lastInsertId();


if($lastInsertId)
{
$_SESSION['msg']="Sponsor Listed successfully";
header('location:manage-seminar.php');
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
<input class="form-control" type="text" name="fname" autocomplete="off"  required />
</div>
</div>
<div class="panel-body">
<form role="form" method="post">
<div class="form-group">
<label>Last Name<span style="color:red;">*</span></label>
<input class="form-control" type="text" name="lname" autocomplete="off"  required />
</div>

<div class="form-group">
 <label for="etype">Sponsor Type:</label>
<select name="etype">
    <option value="S">Organization</option>
    <option value="E">Individual</option>
</select>
 </div>
 <div class="panel-body">
<form role="form" method="post">
<div class="form-group">
<label>Amount<span style="color:red;">*</span></label>
<input class="form-control" type="text" name="amount" autocomplete="off"  required />
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
