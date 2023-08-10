<?php 
session_start();
include('includes/config.php');
error_reporting(0);
if(strlen($_SESSION['login'])==0)
    {   
header('location:index.php');
}
else{ 
if(isset($_POST['update']))
{    
$CUST_ID=$_SESSION['stdid'];  
$FNAME=$_POST['FNAME'];
$MNAME=$_POST['MNAME'];
$LNAME=$_POST['LNAME'];
$PHN_NO=$_POST['PHN_NO'];
$EMAIL=$_POST['EMAIL'];
$ID_TYPE=$_POST['ID_TYPE'];
$ID_NO=$_POST['ID_NO'];

$sql="update VKM_CUSTOMER set FNAME=:FNAME,MNAME=:MNAME,LNAME=:LNAME,PHN_NO=:PHN_NO,ID_TYPE=:ID_TYPE,ID_NO=:ID_NO where CUST_ID=:CUST_ID";
$query = $dbh->prepare($sql);
$query->bindParam(':FNAME',$FNAME,PDO::PARAM_STR);
$query->bindParam(':MNAME',$MNAME,PDO::PARAM_STR);
$query->bindParam(':LNAME',$LNAME,PDO::PARAM_STR);
$query->bindParam(':PHN_NO',$PHN_NO,PDO::PARAM_STR);
$query->bindParam(':ID_TYPE',$ID_TYPE,PDO::PARAM_STR);
$query->bindParam(':ID_NO',$ID_NO,PDO::PARAM_STR);
$query->bindParam(':CUST_ID',$CUST_ID,PDO::PARAM_STR);
$query->execute();

echo '<script>alert("Your profile has been updated")</script>';
}

?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <!--[if IE]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <![endif]-->
    <title>Online Library Management System | Student Signup</title>
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
                <h4 class="header-line">My Profile</h4>
                
                            </div>

        </div>
             <div class="row">
           
<div class="col-md-9 col-md-offset-1">
               <div class="panel panel-danger">
                        <div class="panel-heading">
                           My Profile
                        </div>
                        <div class="panel-body">
                            <form name="signup" method="post">
<?php 
$CUST_ID=$_SESSION['stdid'];
$sql="SELECT * from  VKM_CUSTOMER  where CUST_ID=:CUST_ID";
$query = $dbh -> prepare($sql);
$query-> bindParam(':CUST_ID', $CUST_ID, PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{               ?>  


<div class="form-group">
<label>First Name</label>
<input class="form-control" type="text" name="FNAME" value="<?php echo htmlentities($result->FNAME);?>" autocomplete="off" required />
</div>

<div class="form-group">
<label>Middle Name</label>
<input class="form-control" type="text" name="MNAME" value="<?php echo htmlentities($result->MNAME);?>" autocomplete="off" required />
</div>

<div class="form-group">
<label>Last Name</label>
<input class="form-control" type="text" name="LNAME" value="<?php echo htmlentities($result->LNAME);?>" autocomplete="off" required />
</div>

<div class="form-group">
<label>Mobile Number :</label>
<input class="form-control" type="text" name="PHN_NO" maxlength="12" value="<?php echo htmlentities($result->PHN_NO);?>" autocomplete="off" required />
</div>
                                        
<div class="form-group">
<label>Enter Email</label>
<input class="form-control" type="email" name="EMAIL" id="emailid" value="<?php echo htmlentities($result->EMAIL);?>"  autocomplete="off" required readonly />
</div>

<div class="form-group">
<label>ID Type</label>
<input class="form-control" type="text" name="ID_TYPE" value="<?php echo htmlentities($result->ID_TYPE);?>"  autocomplete="off" required />
</div>

<div class="form-group">
<label>ID Number</label>
<input class="form-control" type="text" name="ID_NO" value="<?php echo htmlentities($result->ID_NO);?>"  autocomplete="off" required />
</div>


<?php }} ?>
                              
<button type="submit" name="update" class="btn btn-primary" id="submit">Update Now </button>

                                    </form>
                            </div>
                        </div>
                            </div>
        </div>
    </div>
    </div>
     <!-- CONTENT-WRAPPER SECTION END-->
    <?php include('includes/footer.php');?>
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- BOOTSTRAP SCRIPTS  -->
    <script src="assets/js/bootstrap.js"></script>
      <!-- CUSTOM SCRIPTS  -->
    <script src="assets/js/custom.js"></script>
</body>
</html>
<?php } ?>
