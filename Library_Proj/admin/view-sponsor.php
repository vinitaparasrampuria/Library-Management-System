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
$SPNSR_ID=$_GET['del'];

$sql = "delete from VKM_SEM_SPNSR WHERE SPNSR_ID=:SPNSR_ID";
$sql1 = "delete from VKM_SPONSOR WHERE SPNSR_ID=:SPNSR_ID";

$query = $dbh->prepare($sql);
$query1 = $dbh->prepare($sql1);

$query -> bindParam(':SPNSR_ID',$SPNSR_ID, PDO::PARAM_STR);
$query1 -> bindParam(':SPNSR_ID',$SPNSR_ID, PDO::PARAM_STR);
$query -> execute();
$query1 -> execute();
$_SESSION['delmsg']="Sponsor deleted scuccessfully ";
header("location:manage-seminar.php");

}


    ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Online Library Management System | View Sponsors</title>
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
                <h4 class="header-line">View Sponsors</h4>
    </div>


        </div>
            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                          Sponsors
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Sponsor ID</th>
                                            <th>Sponsor First Name</th>
                                            <th>Sponsor Last Name </th>
                                            <th>Sponsor Type </th>
                                            <th>Amount</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

<?php 
$EVENT_ID=intval($_GET['EVENT_ID']);
$sql = "SELECT * from VKM_SPONSOR JOIN VKM_SEM_SPNSR ON VKM_SEM_SPNSR.SPNSR_ID=VKM_SPONSOR.SPNSR_ID where VKM_SEM_SPNSR.EVENT_ID=:EVENT_ID";
$query = $dbh -> prepare($sql);
$query->bindParam(':EVENT_ID',$EVENT_ID,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{               ?>                                      
                                        <tr class="odd gradeX">
                                        <td class="center"><?php echo htmlentities($cnt);?></td>
                                            <td class="center"><?php echo htmlentities($result->SPNSR_ID);?></td>
                                            <td class="center"><?php echo htmlentities($result->FNAME);?></td>
                                            <td class="center"><?php echo htmlentities($result->LNAME);?></td>
                                            <td class="center"><?php echo htmlentities($result->SPONSOR_TYPE);?></td>
                                            <td class="center"><?php echo htmlentities($result->AMOUNT);?></td>
                                            <td class="center">

                                            <a href="edit-sponsor.php?SPNSR_ID=<?php echo htmlentities($result->SPNSR_ID);?>"><button class="btn btn-primary"><i class="fa fa-edit "></i> Edit</button> 
                                          <a href="view-sponsor.php?del=<?php echo htmlentities($result->SPNSR_ID);?>" onclick="return confirm('Are you sure you want to delete?');"" >  <button class="btn btn-danger"><i class="fa fa-pencil"></i> Delete</button>
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
