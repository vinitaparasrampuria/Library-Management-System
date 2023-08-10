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
$bname=$_POST['bookname'];
$topic=$_POST['topic'];
#$author_ID=$_POST['author'];
$random_ID = random_int(100000, 999999);


#$sql="INSERT INTO  tblbooks(BookName,CatId,AuthorId,ISBNNumber,BookPrice) VALUES(:bookname,:category,:au                           thor,:isbn,:price)";
$sql="INSERT INTO `vkm_book_det`(`BOOK_ID`, `BNAME`, `TOPIC_ID`) VALUES (:random_ID,:bname,:topic)";
#$sql1="INSERT INTO `vkm_book_det_auth`(`BOOK_ID`, `author_id`) VALUES (:random_ID,:author_ID)";


$query = $dbh->prepare($sql);
#$query1 = $dbh->prepare($sql1);

$query->bindParam(':random_ID',$random_ID,PDO::PARAM_STR);
$query->bindParam(':bname',$bname,PDO::PARAM_STR);
$query->bindParam(':topic',$topic,PDO::PARAM_STR);

#$query1->bindParam(':random_ID',$random_ID,PDO::PARAM_STR);
#$query1->bindParam(':author_ID',$author_ID,PDO::PARAM_STR);

$query->execute();
#$query1->execute();


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
    <title>Online Library Management System | Add Book</title>
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
                <h4 class="header-line">Add Book</h4>
                
                            </div>

</div>
<div class="row">
<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3"">
<div class="panel panel-info">
<div class="panel-heading">
Book Info
</div>
<div class="panel-body">
<form role="form" method="post">
<div class="form-group">
<label>Book Name<span style="color:red;">*</span></label>
<input class="form-control" type="text" name="bookname" autocomplete="off"  required />
</div>



<div class="form-group">
<label> Topic<span style="color:red;">*</span></label>
<select class="form-control" name="topic" required="required">
<option value=""> Select Topic</option>
<?php
$sql = "SELECT * from  vkm_topic";
$query = $dbh -> prepare($sql);
#$query -> bindParam(':status',$status, PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{               ?>  
<option value="<?php echo htmlentities($result->TOPIC_ID);?>"><?php echo htmlentities($result->TOPIC_DESC);?></option>
 <?php }} ?> 
</select>
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