<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
    {   
header('location:index.php');
}
else{ 
if(isset($_GET['del']))
{
$topic_id=$_GET['del'];

$sql04 = "delete VKM_SPONSOR from VKM_SPONSOR JOIN VKM_SEM_SPNSR on VKM_SEM_SPNSR.SPNSR_ID=VKM_SPONSOR.SPNSR_ID JOIN VKM_EVENT ON VKM_EVENT.EVENT_ID=VKM_SEM_SPNSR.EVENT_ID JOIN VKM_TOPIC WHERE VKM_EVENT.TOPIC_ID=:TOPIC_ID";

$sql03 = "delete VKM_SEM_SPNSR from VKM_SEM_SPNSR JOIN VKM_EVENT ON VKM_EVENT.EVENT_ID=VKM_SEM_SPNSR.EVENT_ID JOIN VKM_TOPIC WHERE VKM_EVENT.TOPIC_ID=:TOPIC_ID";

$sql02 = "delete VKM_SEMINAR from VKM_SEMINAR JOIN VKM_EVENT ON VKM_EVENT.EVENT_ID=VKM_SEMINAR.EVENT_ID JOIN VKM_TOPIC WHERE VKM_EVENT.TOPIC_ID=:TOPIC_ID";

$sql0 = "delete VKM_AUTHOR_EX from VKM_AUTHOR_EX JOIN VKM_EXHIBITION ON VKM_AUTHOR_EX.EVENT_ID=:VKM_EXHIBITION.EVENT_ID JOIN VKM_EVENT ON VKM_EXHIBITION.EVENT_ID=VKM_EVENT.EVENT_ID where VKM_EVENT.TOPIC_ID=:TOPIC_ID";

$sql00 = "delete VKM_CUST_EXH from VKM_CUST_EXH JOIN VKM_EXHIBITION ON VKM_CUST_EXH.EVENT_ID=:VKM_EXHIBITION.EVENT_ID JOIN VKM_EVENT ON VKM_EXHIBITION.EVENT_ID=VKM_EVENT.EVENT_ID where VKM_EVENT.TOPIC_ID=:TOPIC_ID";
$sql = "delete VKM_EXHIBITION from VKM_EXHIBITION JOIN VKM_EVENT ON VKM_EVENT.EVENT_ID=VKM_EXHIBITION.EVENT_ID JOIN VKM_TOPIC WHERE VKM_EVENT.TOPIC_ID=:TOPIC_ID";
$sql1 = "delete from VKM_EVENT WHERE VKM_EVENT.TOPIC_ID=:TOPIC_ID";
$sql2 = "delete from VKM_TOPIC WHERE TOPIC_ID=:TOPIC_ID";

$query04 = $dbh->prepare($sql04);
$query03 = $dbh->prepare($sql03);
$query02 = $dbh->prepare($sql02);
$query0 = $dbh->prepare($sql0);
$query00 = $dbh->prepare($sql00);
$query = $dbh->prepare($sql);
$query1 = $dbh->prepare($sql1);
$query2 = $dbh->prepare($sql2);

$query04 -> bindParam(':topic_id',$topic_id, PDO::PARAM_STR);
$query03 -> bindParam(':topic_id',$topic_id, PDO::PARAM_STR);
$query02 -> bindParam(':topic_id',$topic_id, PDO::PARAM_STR);
$query0 -> bindParam(':topic_id',$topic_id, PDO::PARAM_STR);
$query00 -> bindParam(':topic_id',$topic_id, PDO::PARAM_STR);
$query -> bindParam(':topic_id',$topic_id, PDO::PARAM_STR);
$query1 -> bindParam(':topic_id',$topic_id, PDO::PARAM_STR);
$query2 -> bindParam(':topic_id',$topic_id, PDO::PARAM_STR);

$query04 -> execute();
$query03 -> execute();
$query02 -> execute();
$query0 -> execute();
$query00 -> execute();
$query -> execute();
$query1 -> execute();
$query2 -> execute();
$_SESSION['delmsg']="Topic deleted scuccessfully ";
header('location:manage-categories.php');

}


    ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Online Library Management System | Manage Topics</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- DATATABLE STYLE  -->
    <link href="assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
    <!-- GOOGLE FONT -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

</head>
<body>
      <!------MENU SECTION START-->
<?php include('includes/header.php');?>
<!-- MENU SECTION END-->
    <div class="content-wrapper">
         <div class="container">
        <div class="row pad-botm">
            <div class="col-md-12">
                <h4 class="header-line">Manage Topics</h4>
    </div>
     <div class="row">
    <?php if($_SESSION['error']!="")
    {?>
<div class="col-md-6">
<div class="alert alert-danger" >
 <strong>Error :</strong> 
 <?php echo htmlentities($_SESSION['error']);?>
<?php echo htmlentities($_SESSION['error']="");?>
</div>
</div>
<?php } ?>
<?php if($_SESSION['msg']!="")
{?>
<div class="col-md-6">
<div class="alert alert-success" >
 <strong>Success :</strong> 
 <?php echo htmlentities($_SESSION['msg']);?>
<?php echo htmlentities($_SESSION['msg']="");?>
</div>
</div>
<?php } ?>
<?php if($_SESSION['updatemsg']!="")
{?>
<div class="col-md-6">
<div class="alert alert-success" >
 <strong>Success :</strong> 
 <?php echo htmlentities($_SESSION['updatemsg']);?>
<?php echo htmlentities($_SESSION['updatemsg']="");?>
</div>
</div>
<?php } ?>


   <?php if($_SESSION['delmsg']!="")
    {?>
<div class="col-md-6">
<div class="alert alert-success" >
 <strong>Success :</strong> 
 <?php echo htmlentities($_SESSION['delmsg']);?>
<?php echo htmlentities($_SESSION['delmsg']="");?>
</div>
</div>
<?php } ?>

</div>


        </div>
            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Topics Listing
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Topic ID</th>
                                            <th>Topic Desc</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
<?php $sql = "SELECT * from  VKM_TOPIC";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{               ?>                                      
                                        <tr class="odd gradeX">
                                            <td class="center"><?php echo htmlentities($cnt);?></td>
                                            <td class="center"><?php echo htmlentities($result->TOPIC_ID);?></td>
                                            <td class="center"><?php echo htmlentities($result->TOPIC_DESC);?></td>
                                            <td class="center">

                                            <a href="edit-category.php?TOPIC_ID=<?php echo htmlentities($result->TOPIC_ID);?>"><button class="btn btn-primary"><i class="fa fa-edit "></i> Edit</button> 
                                            
                                            </td>
                                        </tr>
 <?php $cnt=$cnt+1;}} ?>                                      
                                    </tbody>
                                </table>
                            </div>
                            
                        </div>
                    </div>
                    <!--End Advanced Tables -->
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
    <!-- DATATABLE SCRIPTS  -->
    <script src="assets/js/dataTables/jquery.dataTables.js"></script>
    <script src="assets/js/dataTables/dataTables.bootstrap.js"></script>
      <!-- CUSTOM SCRIPTS  -->
    <script src="assets/js/custom.js"></script>
</body>
</html>
<?php } ?>