<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
    {   
header('location:index.php');
}
else{ 

if(isset($_POST['update']))
{
$EVENT_ID=intval($_GET['EVENT_ID']);
$ETYPE=$_POST['ETYPE'];
$TOPIC_ID=$_POST['TOPIC_ID'];
$START_DATE1=$_POST['START_DATE1'];
$STOP_DATE=$_POST['STOP_DATE'];
$ENAME=$_POST['ENAME'];
$EXPENSES=$_POST['EXPENSES'];
$sql="UPDATE VKM_EVENT SET ENAME=:ENAME,ETYPE=:ETYPE,START_DATE1=:START_DATE1,STOP_DATE=:STOP_DATE,TOPIC_ID=:TOPIC_ID WHERE EVENT_ID=:EVENT_ID";
$sql1="UPDATE VKM_EXHIBITION SET EXPENSES=:EXPENSES where EVENT_ID=:EVENT_ID ";
$query = $dbh->prepare($sql);
$query1 = $dbh->prepare($sql1);
$query->bindParam(':EVENT_ID',$EVENT_ID,PDO::PARAM_STR);
$query->bindParam(':ENAME',$ENAME,PDO::PARAM_STR);
$query->bindParam(':ETYPE',$ETYPE,PDO::PARAM_STR);
$query->bindParam(':START_DATE1',$START_DATE1,PDO::PARAM_STR);
$query->bindParam(':STOP_DATE',$STOP_DATE,PDO::PARAM_STR);
$query->bindParam(':TOPIC_ID',$TOPIC_ID,PDO::PARAM_STR);
$query1->bindParam(':EXPENSES',$EXPENSES,PDO::PARAM_STR);
$query1->bindParam(':EVENT_ID',$EVENT_ID,PDO::PARAM_STR);
$query->execute();
$query1->execute();
$_SESSION['updatemsg']="Event info updated successfully";
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
    <title>Online Library Management System | Edit Events</title>
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
                <h4 class="header-line">Update Event</h4>
                
                            </div>

</div>
<div class="row">
<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3"">
<div class="panel panel-info">
<div class="panel-heading">
Event Info
</div>
<div class="panel-body">
<form role="form" method="post">

<?php 
$EVENT_ID=intval($_GET['EVENT_ID']);
$sql = "SELECT * from  VKM_EVENT where EVENT_ID=:EVENT_ID";
$query = $dbh -> prepare($sql);
$query->bindParam(':EVENT_ID',$EVENT_ID,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{               ?>   
<div class="form-group">
<label>Event Name</label>
<input class="form-control" type="text" name="ENAME" value="<?php echo htmlentities($result->ENAME);?>" required />
</div>
<?php ?>

<div class="form-group">
 <label for="ETYPE">Event Type:</label>
<select name="ETYPE">
    <option value="S">Seminar</option>
    <option value="E">Exhibition</option>
    <?php 
    if($result->ETYPE='E')
    {
        echo htmlentities("EXHIBITION"); 
    }
    else{
        echo htmlentities("SEMINAR");
    }?>
</select>
 </div>

 
    
 <div class="form-group">
 <label>Expense (for Exhibition)<span style="color:red;">*</span></label>
 <?php 
    $ex=$result->EVENT_ID;
    $sql1 = "SELECT EXPENSES from VKM_EXHIBITION where EVENT_ID=:EVENT_ID";
    $query1 = $dbh -> prepare($sql1);
    $query1->bindParam(':EVENT_ID',$ex,PDO::PARAM_STR);
    $query1->execute();
    $result1=$query1->fetchAll(PDO::FETCH_OBJ);
    foreach($result1 as $res)
    {?> 
 <input class="form-control" type="text" name="EXPENSES" value="<?php echo htmlentities($res->EXPENSES);?>" optional/>
 </div>
 <?php }?>

<div class="form-group">
<label> Topic<span style="color:red;">*</span></label>
<select class="form-control" name="TOPIC_ID" required="required">
<option value="<?php echo htmlentities($result->TOPIC_ID);?>"></option>
<?php 
$sql1 = "SELECT * from  VKM_TOPIC";
$query1 = $dbh -> prepare($sql1);
$query1->execute();
$resultss=$query1->fetchAll(PDO::FETCH_OBJ);
if($query1->rowCount() > 0)
{
foreach($resultss as $row)
{           
if($TOPIC_DESC==$row->TOPIC_DESC)
{
continue;
}
else
{
    ?>  
<option value="<?php echo htmlentities($row->TOPIC_ID);?>"><?php echo htmlentities($row->TOPIC_DESC);?></option>
 <?php }}} ?> 
</select>
</div>

<div class="form-group">
<label>Start Date</label>
<input class="form-control" type="date" name="START_DATE1" value="<?php echo htmlentities($result->START_DATE1);?>" required />
</div>
<?php ?>
<div class="form-group">
<label>Stop Date</label>
<input class="form-control" type="date" name="STOP_DATE" value="<?php echo htmlentities($result->STOP_DATE);?>" required />
</div>
<?php ?>

<?php }}?>

<button type="submit" name="update" class="btn btn-info">Update </button>

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