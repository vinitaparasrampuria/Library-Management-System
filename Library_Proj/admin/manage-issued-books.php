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
$sql = "delete from vkm_invoice WHERE RENT_ID=:id";
$sql1 = "delete from vkm_book_rent WHERE RENT_ID=:id";

$query = $dbh->prepare($sql);
$query1 = $dbh->prepare($sql1);

$query -> bindParam(':id',$id, PDO::PARAM_STR);
$query1 -> bindParam(':id',$id, PDO::PARAM_STR);

$query -> execute();
$query1 -> execute();

$_SESSION['delmsg']="Rent Information deleted scuccessfully ";
header("location:manage-issued-books.php");

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
                <h4 class="header-line">Manage Issued Books</h4>
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
                          Issued Books 
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Customer Name</th>
                                            <th>Book Name</th>
                                            <th>BooK Copy ID </th>
                                            <th>Borrow Date</th>
                                            <th>Expected Return Date</th>
                                            <th>Actual Return Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
<?php $sql = "SELECT br.RENT_ID,br.RENT_STATUS,br.BORROW_DATE,br.EXP_RDATE,br.ACT_RDATE,br.CUST_ID,br.BOOK_COPY_ID, cu.FNAME, cu.MNAME, cu.LNAME, bd.BNAME, bd.BOOK_ID
FROM vkm_book_rent br join vkm_customer cu on br.CUST_ID = cu.CUST_ID join vkm_book_status bs on br.BOOK_COPY_ID = bs.BOOK_COPY_ID join vkm_book_det bd on bd.BOOK_ID = bs.BOOK_ID;";
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
                                            <td class="center"><?php echo htmlentities($result->FNAME);
                                            echo htmlentities(" ");
                                            echo htmlentities($result->MNAME);
                                            echo htmlentities(" ");
                                            echo htmlentities($result->LNAME);?></td>
                                            <td class="center"><?php echo htmlentities($result->BNAME);?></td>
                                            <td class="center"><?php echo htmlentities($result->BOOK_COPY_ID);?></td>
                                            <td class="center"><?php echo htmlentities($result->BORROW_DATE);?></td>
                                            <td class="center"><?php echo htmlentities($result->EXP_RDATE);?></td>
                                            <td class="center"><?php if($result->ACT_RDATE=="")
                                            {
                                                echo htmlentities("Not Return Yet");
                                            } else {
                                            echo htmlentities($result->ACT_RDATE);}
                                            ?></td>
                                            <td class="center">
                                            <a href="view-copy-book.php?BOOK_ID=<?php echo htmlentities($result->BOOK_ID);?>"><button class="btn btn-primary"><i class="fa fa-edit "></i> Edit</button>
                                            <a href="manage-issued-books.php?del=<?php echo htmlentities($result->RENT_ID);?>" onclick="return confirm('Are you sure you want to delete?');" >  <button class="btn btn-danger"><i class="fa fa-pencil"></i> Delete</button>
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