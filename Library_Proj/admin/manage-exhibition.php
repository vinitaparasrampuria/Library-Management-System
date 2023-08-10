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
    $EVENT_ID=$_GET['del'];
    $sql0 = "delete from VKM_AUTHOR_EX  WHERE EVENT_ID=:EVENT_ID";
    $sql00 = "delete from VKM_CUST_EXH WHERE EVENT_ID=:EVENT_ID";
    $sql = "delete from VKM_EXHIBITION  WHERE EVENT_ID=:EVENT_ID";
    $sql1 = "delete from VKM_EVENT  WHERE EVENT_ID=:EVENT_ID";
    $query0 = $dbh->prepare($sql0);
    $query00 = $dbh->prepare($sql00);
    $query = $dbh->prepare($sql);
    $query1 = $dbh->prepare($sql1);
    $query0 -> bindParam(':EVENT_ID',$EVENT_ID, PDO::PARAM_STR);
    $query00 -> bindParam(':EVENT_ID',$EVENT_ID, PDO::PARAM_STR);
    $query -> bindParam(':EVENT_ID',$EVENT_ID, PDO::PARAM_STR);
    $query1 -> bindParam(':EVENT_ID',$EVENT_ID, PDO::PARAM_STR);
    $query0 -> execute();
    $query00 -> execute();
    $query -> execute();
    $query1 -> execute();
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
    <title>Online Library Management System | Manage Exhibitions</title>
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
                <h4 class="header-line"> Manage Exhibitions</h4>
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
                          Exhibitions
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Event ID</th>
                                            <th>Topic</th>
                                            <th>Exhibition Name </th>
                                            <th>Start Date</th>
                                            <th>Stop Date</th>
                                            <th>Expenses</th>
                                            <th>Visitors</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
<?php 
$sql = "SELECT EVENT_ID, ENAME, ETYPE, START_DATE1, STOP_DATE, VKM_TOPIC.TOPIC_DESC as TOPIC_DESC FROM VKM_EVENT JOIN VKM_TOPIC ON VKM_EVENT.TOPIC_ID=VKM_TOPIC.TOPIC_ID WHERE ETYPE='E'";


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
                                            <td class="center"><?php echo htmlentities($result->EVENT_ID);?></td>
                                            <td class="center"><?php echo htmlentities($result->TOPIC_DESC);?></td>
                                            <td class="center"><?php echo htmlentities($result->ENAME);?></td>
                                            <td class="center"><?php echo htmlentities($result->START_DATE1);?></td>
                                            <td class="center"><?php echo htmlentities($result->STOP_DATE);?></td>
                                            
                                            <?php 
                                            $ex=$result->EVENT_ID;
                                            $sql1 = "SELECT EXPENSES from VKM_EXHIBITION where EVENT_ID=:EVENT_ID";
                                            $query1 = $dbh -> prepare($sql1);
                                            $query1->bindParam(':EVENT_ID',$ex,PDO::PARAM_STR);
                                            $query1->execute();
                                            $result1=$query1->fetchAll(PDO::FETCH_OBJ);
                                            foreach($result1 as $res)
                                            {?> 
                                                <td class="center"><?php echo htmlentities($res->EXPENSES);?></td>
                                        
                                            <?php }?>

                                            
                                            <td class="center">

                    
                                            <a href="view-author-visitor.php?EVENT_ID=<?php echo htmlentities($result->EVENT_ID);?>"><button class="btn btn-primary"><i class="fa fa-edit "></i> View Authors</button> 
                                            <a href="add-author-visitor.php?EVENT_ID=<?php echo htmlentities($result->EVENT_ID);?>"><button class="btn btn-primary"><i class="fa fa-edit "></i> Add Authors</button> 
                                            <a href="view-customer-visitor.php?EVENT_ID=<?php echo htmlentities($result->EVENT_ID);?>"><button class="btn btn-primary"><i class="fa fa-edit "></i> View Customers</button> 
                                            <a href="add-customer-visitor.php?EVENT_ID=<?php echo htmlentities($result->EVENT_ID);?>"><button class="btn btn-primary"><i class="fa fa-edit "></i> Add Customers</button> 
                                                
                                        </td>
                                            <td class="center">

                                            <a href="edit-exhibition.php?EVENT_ID=<?php echo htmlentities($result->EVENT_ID);?>"><button class="btn btn-primary"><i class="fa fa-edit "></i> Edit</button> 
                                          <a href="manage-exhibition.php?del=<?php echo htmlentities($result->EVENT_ID);?>" onclick="return confirm('Are you sure you want to delete?');"" >  <button class="btn btn-danger"><i class="fa fa-pencil"></i> Delete</button>
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
