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
$book_copy_id=$_POST['book_copy_id'];
$CUST_ID=$_POST['CUST_ID'];
$BORROW_DATE=$_POST['BORROW_DATE'];
$EXP_RDATE=$_POST['EXP_RDATE'];

$random_ID = random_int(100000, 999999);


$sql="INSERT INTO `vkm_book_rent`(`RENT_ID`, `RENT_STATUS`, `BORROW_DATE`, `EXP_RDATE`, `CUST_ID`, `BOOK_COPY_ID`) VALUES (:random_ID,'BORROWED',:BORROW_DATE,:EXP_RDATE,:CUST_ID,:book_copy_id)";
$sql2="UPDATE `vkm_book_status` SET `AVAILABLE_STATUS`='NO' WHERE book_copy_id = :book_copy_id;";

$query = $dbh->prepare($sql);
$query2 = $dbh->prepare($sql2);


$query->bindParam(':random_ID',$random_ID,PDO::PARAM_STR);
$query->bindParam(':BORROW_DATE',$BORROW_DATE,PDO::PARAM_STR);
$query->bindParam(':EXP_RDATE',$EXP_RDATE,PDO::PARAM_STR);
$query->bindParam(':CUST_ID',$CUST_ID,PDO::PARAM_STR);
$query->bindParam(':book_copy_id',$book_copy_id,PDO::PARAM_STR);

$query2->bindParam(':book_copy_id',$book_copy_id,PDO::PARAM_STR);



$query->execute();
$query2->execute();



if(TRUE)
{
$_SESSION['msg']="Book Listed successfully";
header('location:manage-books.php');
}
else
{
$_SESSION['error']="Something went wrong. Please try again";
header('location:manage-books.php');
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
    <title>Online Library Management System | Rent Book</title>
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

    <div class="content-wrapper">
         <div class="container">
        <div class="row pad-botm">
            <div class="col-md-12">
                <h4 class="header-line">Add Book</h4>

                            </div>

</div>
<div class="row">
<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
<div class="panel panel-info">
<div class="panel-heading">
Book Info
</div>
<div class="panel-body">
<form role="form" method="post">

<div class="form-group">
<label>Book Copy ID<span style="color:red;">*</span></label>
<input class="form-control" type="text" name="book_copy_id" autocomplete="off" value = "<?php echo $_GET['BOOK_COPY_ID'];?>" required />
</div>

<div class="form-group">
<label>Customer ID<span style="color:red;">*</span></label>
<input class="form-control" type="text" name="CUST_ID" autocomplete="off"  required />
</div>

<div class="form-group">
<label>Borrow Date</label>
<input class="form-control" type="date" name="BORROW_DATE" autocomplete="off" required="required"/>
</div>

<div class="form-group">
<label>Expect Return Date</label>
<input class="form-control" type="date" name="EXP_RDATE" autocomplete="off" required="required"/>
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