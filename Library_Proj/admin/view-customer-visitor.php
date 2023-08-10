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
$CUST_ID=$_GET['del'];
$EVENT_ID=intval($_GET['EVENT_ID']);
$sql = "delete from VKM_CUST_EXH WHERE CUST_ID=:CUST_ID";

$query = $dbh->prepare($sql);

$query -> bindParam(':CUST_ID',$CUST_ID, PDO::PARAM_STR);

$query -> execute();

$_SESSION['delmsg']="CUSTOMER deleted scuccessfully ";
header("location:manage-exhibition.php");

}


    ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Online Library Management System | View Customer Attendees</title>
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
                <h4 class="header-line">View Customers</h4>
    </div>


        </div>
            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                        Customers
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <<th>Customer ID</th>
                                            <th>Name</th>
                                            <th>Phone Number</th>
                                            <th>Email id </th>
                                            <th>Registration ID</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

<?php 
$EVENT_ID=intval($_GET['EVENT_ID']);
$sql = "SELECT * from VKM_CUSTOMER JOIN VKM_CUST_EXH ON VKM_CUST_EXH.CUST_ID=VKM_CUSTOMER.CUST_ID where VKM_CUST_EXH.EVENT_ID=:EVENT_ID";
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
                                            <td class="center"><?php echo htmlentities($result->CUST_ID);?></td>
                                            <td class="center"><?php echo htmlentities($result->FNAME);
                                            echo htmlentities(" ");
                                            echo htmlentities($result->MNAME);
                                            echo htmlentities(" ");
                                            echo htmlentities($result->LNAME);?></td>
                                            <td class="center"><?php echo htmlentities($result->PHN_NO);
                      
                                            ?></td>
                                            <td class="center"><?php echo htmlentities($result->EMAIL);?></td>
                                            
                                            <td class="center"><?php echo htmlentities($result->REG_ID);?></td>
                                            <td class="center">

                             
                                          <a href="view-customer-visitor.php?del=<?php echo htmlentities($result->CUST_ID);?>" onclick="return confirm('Are you sure you want to delete?');"" >  <button class="btn btn-danger"><i class="fa fa-pencil"></i> Delete</button>
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
