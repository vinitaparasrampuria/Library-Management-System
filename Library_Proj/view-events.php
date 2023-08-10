<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['login'])==0)
    {   
header('location:index.php');
}
else{ 
if(isset($_GET['del']))
{
    $CUST_ID=$_SESSION['stdid'];
    $EVENT_ID=$_GET['del'];
    $sql = "delete from VKM_CUST_EXH  WHERE EVENT_ID=:EVENT_ID and CUST_ID=:CUST_ID";  
    $query = $dbh->prepare($sql);
    $query -> bindParam(':EVENT_ID',$EVENT_ID, PDO::PARAM_STR);
    $query -> bindParam(':CUST_ID',$CUST_ID, PDO::PARAM_STR);
    $query -> execute();
    $_SESSION['delmsg']="Event deleted";
    header('location:view-events.php');

}
if(isset($_GET['reg']))
{
    $CUST_ID=$_SESSION['stdid'];
    $digits = 3;
    $REG_ID=rand(pow(10, $digits-1), pow(10, $digits)-1);
    $EVENT_ID=$_GET['reg'];
    $sql = "INSERT INTO VKM_CUST_EXH(REG_ID,CUST_ID,EVENT_ID) VALUES(:REG_ID,:CUST_ID,:EVENT_ID)";  
    $query = $dbh->prepare($sql);
    $query -> bindParam(':EVENT_ID',$EVENT_ID, PDO::PARAM_STR);
    $query -> bindParam(':CUST_ID',$CUST_ID, PDO::PARAM_STR);
    $query -> bindParam(':REG_ID',$REG_ID, PDO::PARAM_STR);
    $query -> execute();
    $_SESSION['delmsg']="Event deleted";
    header('location:view-events.php');

}
    ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Online Library Management System | Manage Issued Books</title>
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
                <h4 class="header-line">View Exhibitions</h4>
    </div>
    

            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                          Exhibition Listing 
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <<th>#</th>
                                            <th>Event ID</th>
                                            <th>Event Name</th>
                                            <th>Event Type</th>
                                            <th>Start Date</th>
                                            <th>Stop Date</th>
                                            <th>Topic</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php 
$sql = "SELECT EVENT_ID, ENAME, ETYPE, START_DATE1, STOP_DATE, VKM_TOPIC.TOPIC_DESC as TOPIC_DESC FROM VKM_EVENT JOIN VKM_TOPIC ON VKM_EVENT.TOPIC_ID=VKM_TOPIC.TOPIC_ID WHERE VKM_EVENT.ETYPE='E'";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{             
     ?>
                                        <tr class="odd gradeX">
                                            <td class="center"><?php echo htmlentities($cnt);?></td>
                                            <td class="center"><?php echo htmlentities($result->EVENT_ID);?></td>
                                            <td class="center"><?php echo htmlentities($result->ENAME);?></td>
                                            <td class="center"><?php echo htmlentities($result->ETYPE);
                                        
                                            ?></td>
                                            <td class="center"><?php echo htmlentities($result->START_DATE1);?></td>
                                            <td class="center"><?php echo htmlentities($result->STOP_DATE);?></td>
                                            
                                           
                                            
                                            <td class="center"><?php echo htmlentities($result->TOPIC_DESC);?></td>
                                         

                                            <td class="center">

                                            <a href="view-events.php?reg=<?php echo htmlentities($result->EVENT_ID);?>" onclick="return confirm('Are you sure you want to register?');"" >  <button class="btn btn-primary"><i class="fa fa-pencil"></i> Register</button>
                                            <a href="view-events.php?del=<?php echo htmlentities($result->EVENT_ID);?>" onclick="return confirm('Are you sure you want to delete?');"" >  <button class="btn btn-danger"><i class="fa fa-pencil"></i> Cancel</button>
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