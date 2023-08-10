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
$id=$_GET['del'];
$sql = "delete from VKM_BOOK_STATUS  WHERE BOOK_COPY_ID=:id";
$query = $dbh->prepare($sql);
$query -> bindParam(':id',$id, PDO::PARAM_STR);
$query -> execute();
$_SESSION['delmsg']="Book copy deleted scuccessfully ";
header("location:view-copy-book.php?BOOK_ID=$id");

}

if(isset($_GET['return_book']))
{
$id=$_GET['return_book'];
date_default_timezone_set("America/New_York");
$date1 = date("Y-m-d");
$sql = "UPDATE `vkm_book_status` SET `AVAILABLE_STATUS`='YES' WHERE book_copy_id = :id;";
$sql2 = "UPDATE `vkm_book_rent` SET RENT_STATUS='RETURNED', `ACT_RDATE`= :date1 WHERE book_copy_id = :id and RENT_STATUS='BORROWED';";

$query = $dbh->prepare($sql);
$query2 = $dbh->prepare($sql2);

$query -> bindParam(':id',$id, PDO::PARAM_STR);
$query2 -> bindParam(':id',$id, PDO::PARAM_STR);
$query2 -> bindParam(':date1',$date1, PDO::PARAM_STR);


$query -> execute();
$query2 -> execute();
$_SESSION['delmsg']="Book copy return scuccessfully ";
header("location:view-copy-book.php?BOOK_ID=$id");

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
                                            <th>Book Copy ID</th>
                                            <th>Availability</th>
                                            <th>Rent</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
<?php
$BOOK_ID=intval($_GET['BOOK_ID']);
$sql = "SELECT * From VKM_BOOK_STATUS join VKM_BOOK_DET on VKM_BOOK_STATUS.BOOK_ID=VKM_BOOK_DET.BOOK_ID JOIN VKM_TOPIC on VKM_BOOK_DET.TOPIC_ID=VKM_TOPIC.TOPIC_ID where VKM_BOOK_DET.BOOK_ID=:BOOK_ID ; ";

$query = $dbh -> prepare($sql);
$query->bindParam(':BOOK_ID',$BOOK_ID,PDO::PARAM_STR);
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
                                            <td class="center"><?php echo htmlentities($result->BOOK_COPY_ID);?></td>
                                            <td class="center"><?php echo htmlentities($result->AVAILABLE_STATUS);?></td>

                                            <td class="center">
                                            <?php
                                            if(htmlentities($result->AVAILABLE_STATUS) == "YES")
                                            {
                                            ?>
                                            <a href="rent-copy-book.php?BOOK_COPY_ID=<?php echo htmlentities($result->BOOK_COPY_ID);?>"><button class="btn btn-primary"><i class="fa fa-edit "></i> Rent</button>
                                            <?php } else {?>
                                            <a href="view-copy-book.php?return_book=<?php echo htmlentities($result->BOOK_COPY_ID);?>" onclick="return confirm('Are you sure you want to return the book?');"><button class="btn btn-primary"><i class="fa fa-edit "></i> Return</button>
                                            <?php } ?>
                                            </td>


                                            <td class="center">
                                            <a href="view-copy-book.php?del=<?php echo htmlentities($result->BOOK_COPY_ID);?>"><button class="btn btn-danger"><i class="fa fa-edit "></i> Delete</button>
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