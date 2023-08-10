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
$id=$_GET['del'];
$sql00 = "delete from VKM_BOOK_STATUS  WHERE book_id=:id";
$sql0 = "delete from VKM_BOOK_DET_AUTH  WHERE book_id=:id";
$sql = "delete from vkm_book_det  WHERE book_id=:id";
$query00 = $dbh->prepare($sql00);
$query0 = $dbh->prepare($sql0);
$query = $dbh->prepare($sql);
$query00 -> bindParam(':id',$id, PDO::PARAM_STR);
$query0 -> bindParam(':id',$id, PDO::PARAM_STR);
$query -> bindParam(':id',$id, PDO::PARAM_STR);
$query00 -> execute();
$query0 -> execute();
$query -> execute();
$_SESSION['delmsg']="Book deleted scuccessfully ";
header('location:manage-books.php');

}

if(isset($_GET['reg']))
{
    $BOOK_ID=$_GET['reg'];
    $digits = 5;
    $BOOK_COPY_ID=rand(pow(10, $digits-1), pow(10, $digits)-1);
  
    $sql="INSERT INTO `VKM_BOOK_STATUS`(`BOOK_ID`, `AVAILABLE_STATUS`, `BOOK_COPY_ID`) VALUES (:BOOK_ID,'Yes',:BOOK_COPY_ID)";

    $query = $dbh->prepare($sql);
    
    $query->bindParam(':BOOK_ID',$BOOK_ID,PDO::PARAM_STR);

    $query->bindParam(':BOOK_COPY_ID',$BOOK_COPY_ID,PDO::PARAM_STR);
    

    $query -> execute();
    $_SESSION['delmsg']="Book copy added";
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
    <title>Online Library Management System | Manage Books</title>
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
                <h4 class="header-line">Manage Books</h4>
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
    { ?>
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
                           Books Listing
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Book ID</th>
                                            <th>Book Name</th>
                                            <th>Topic</th>
                                            <th>Author</th>
                                            <th>Availability</th>
                                        </tr>
                                    </thead>
                                    <tbody>
<?php 
$sql = "SELECT dt.BOOK_ID,dt.BNAME,tp.TOPIC_DESC,au.AFNAME,au.AMNAME,au.ALNAME, st.AVAILABLE_STATUS From vkm_book_det dt JOIN VKM_TOPIC tp on dt.TOPIC_ID=tp.TOPIC_ID left join vkm_book_status st on dt.BOOK_ID=st.BOOK_ID join vkm_book_det_auth dau on dt.BOOK_ID=dau.BOOK_ID join vkm_author au on dau.AUTHOR_ID = au.AUTHOR_ID group by dt.BOOK_ID;";
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
                                            <td class="center"><?php echo htmlentities($result->BOOK_ID);?></td>
                                            
                                            <td class="center"><?php echo htmlentities($result->BNAME);?></td>
                                            <td class="center"><?php echo htmlentities($result->TOPIC_DESC);?></td>
                                            
                                            <td class="center"><?php echo htmlentities($result->AFNAME);
                                              echo htmlentities(" ");
                                              echo htmlentities($result->AMNAME);
                                              echo htmlentities(" ");
                                              echo htmlentities($result->ALNAME);?></td>
                                            <td class="center"><?php echo htmlentities($result->AVAILABLE_STATUS);?></td>


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