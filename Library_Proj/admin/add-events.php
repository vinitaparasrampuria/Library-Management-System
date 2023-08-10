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
$digits = 6;
$EVENT_ID=rand(pow(10, $digits-1), pow(10, $digits)-1);
$ETYPE=$_POST['ETYPE'];
$TOPIC_ID=$_POST['TOPIC_ID'];
$START_DATE1=$_POST['START_DATE1'];
$STOP_DATE=$_POST['STOP_DATE'];
$ENAME=$_POST['ENAME'];
$EXPENSES=$_POST['EXPENSES'];

$sql="INSERT INTO VKM_EVENT(EVENT_ID,ENAME,ETYPE,START_DATE1,STOP_DATE,TOPIC_ID) VALUES(:EVENT_ID,:ENAME,:ETYPE,:START_DATE1,:STOP_DATE,:TOPIC_ID)";
if ($ETYPE == "E"){
$sql1="INSERT INTO VKM_EXHIBITION(EVENT_ID,EXPENSES) VALUES(:EVENT_ID,:EXPENSES)";}


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

$_SESSION['msg']="Event Listed successfully";
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
    <title>Online Library Management System | Add Events</title>
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
                <h4 class="header-line">Add Event</h4>
                
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
<div class="form-group">
<label>Event Name<span style="color:red;">*</span></label>
<input class="form-control" type="text" name="ENAME" autocomplete="off"  required />
</div>

<div class="form-group">
 <label for="ETYPE">Event Type:</label>
<select name="ETYPE">
    <option value="S">Seminar</option>
    <option value="E">Exhibition</option>
</select>
 </div>

 <div class="form-group">
 <label>Expense (for Exhibition)<span style="color:red;">*</span></label>
 <input class="form-control" type="text" name="EXPENSES" autocomplete="off"  optional/>
 </div>

<div class="form-group">
<label> Topic<span style="color:red;">*</span></label>
<select class="form-control" name="TOPIC_ID" required="required">
<option value=""> Select Topic</option>
<?php 
$sql = "SELECT * from  VKM_TOPIC";
$query = $dbh -> prepare($sql);
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


<div class="form-group">
 <label>Start Date<span style="color:red;">*</span></label>
 <input class="form-control" type="date" name="START_DATE1" autocomplete="off"   required="required" />
 </div>

 <div class="form-group">
 <label>Stop Date<span style="color:red;">*</span></label>
 <input class="form-control" type="date" name="STOP_DATE" autocomplete="off"   required="required" />
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
