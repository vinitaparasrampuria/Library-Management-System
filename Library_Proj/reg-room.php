<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['login'])==0)
    {   
header('location:index.php');
}
else{ 

// code for block student    
if(isset($_GET['dslot']))
{
$slot=$_GET['dslot'];
$slot =urldecode($slot);
$roomid=$_GET['roomid'];
$date = $_GET['roomdate'];
$sql = "delete from vkm_cust_room where SLOT = :slot and room_id = :roomid";

$query = $dbh->prepare($sql);
$query -> bindParam(':roomid',$roomid, PDO::PARAM_STR);
$query -> bindParam(':slot',$slot, PDO::PARAM_STR);

$query -> execute();
header("location:reg-room.php?date=$date");
}


//code for active students
if(isset($_GET['aslot']))
{
$aslot=$_GET['aslot'];
$digits = 5;
$aslot_ID=rand(pow(10, $digits-1), pow(10, $digits)-1);
$roomid=$_GET['roomid'];
$date = $_GET['roomdate'];

$sql="INSERT INTO `vkm_cust_room`(`SLOT_ID`, `SLOT`, `CUST_ID`, `ROOM_ID`) VALUES (:aslot_ID,:aslot,'1',:roomid)";
$query = $dbh->prepare($sql);

$query -> bindParam(':aslot_ID',$aslot_ID, PDO::PARAM_STR);
$query -> bindParam(':aslot',$aslot, PDO::PARAM_STR);
$query -> bindParam(':roomid',$roomid, PDO::PARAM_STR);


$query -> execute();
header("location:reg-room.php?date=$date");
}

if(isset($_POST['time']))
{
$date = $_POST['roomdate'];
#$date = $_POST['roomdate'];
header("location:reg-room.php?date=$date");
}




    ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Online Library Management System | Manage Reg Students</title>
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
                <h4 class="header-line">Manage Room</h4>
    </div>


        </div>
            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                          Reg Room
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                 <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                 <div class="panel-body">
                                 <form role="form" method="post">
                                 <div class="form-group">
                                 <label>Date</label>
                                 <input class="form-control" type="date" name="roomdate" autocomplete="off" required="required"/>
                                 </div>
                                 <button type="submit" name="time" class="btn btn-info">Choose Time </button>
                                 </form>
                                 </div>

                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Room Number</th>
                                            <th>8AM-10AM</th>
                                            <th>11AM-1PM </th>
                                            <th>1PM-3PM</th>
                                            <th>4PM-6PM</th>
                                        </tr>
                                    </thead>
                                    <tbody>
<?php
$sql = "SELECT * from vkm_study_room";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);

$room_time = $_GET['date'];
$room_time1 = date ("Y-m-d 08:i:s", strtotime($room_time));
$room_time2 = date ("Y-m-d 11:i:s", strtotime($room_time));
$room_time3 = date ("Y-m-d 13:i:s", strtotime($room_time));
$room_time4 = date ("Y-m-d 16:i:s", strtotime($room_time));




$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{               ?>                                      
                                        <tr class="odd gradeX">
                                            <td class="center"><?php echo htmlentities($cnt);?></td>
                                            <td class="center"><?php echo htmlentities($result->ROOM_ID);?></td>

                                            <td class="center">
                                            <?php
                                            $sql1 = "SELECT * from vkm_cust_room where SLOT = '$room_time1' and Room_id = '$result->ROOM_ID'";
                                            $query1 = $dbh -> prepare($sql1);
                                            $query1->execute();
                                            if($query1->rowCount() > 0)
                                            {
                                            ?>
                                            <a href="reg-room.php?dslot=<?php echo $room_time1;?>&roomid=<?php echo htmlentities($result->ROOM_ID);?>&roomdate=<?php echo $room_time;?>" onclick="return confirm('Are you sure you want to cancel the reserved room?');">  <button class="btn btn-danger"> Cancel</button>
                                            <?php } else {?>
                                            <a href="reg-room.php?aslot=<?php echo $room_time1;?>&roomid=<?php echo htmlentities($result->ROOM_ID);?>&roomdate=<?php echo $room_time;?>" onclick="return confirm('Are you sure you want to  reserve the room?');"><button class="btn btn-primary"> Reserve</button>
                                            <?php } ?>
                                            </td>

                                            <td class="center">
                                            <?php
                                            $sql2 = "SELECT * from vkm_cust_room where SLOT = '$room_time2' and Room_id = '$result->ROOM_ID'";
                                            $query2 = $dbh -> prepare($sql2);
                                            $query2->execute();
                                            if($query2->rowCount() > 0)
                                            {?>
                                            <a href="reg-room.php?dslot=<?php echo $room_time2;?>&roomid=<?php echo htmlentities($result->ROOM_ID);?>&roomdate=<?php echo $room_time;?>" onclick="return confirm('Are you sure you want to cancel the reserved room?');">  <button class="btn btn-danger"> Cancel</button>
                                            <?php } else {?>
                                            <a href="reg-room.php?aslot=<?php echo $room_time2;?>&roomid=<?php echo htmlentities($result->ROOM_ID);?>&roomdate=<?php echo $room_time;?>" onclick="return confirm('Are you sure you want to  reserve the room?');"><button class="btn btn-primary"> Reserve</button>
                                            <?php } ?>
                                            </td>

                                            <td class="center">
                                            <?php
                                            $sql3 = "SELECT * from vkm_cust_room where SLOT = '$room_time3' and Room_id = '$result->ROOM_ID'";
                                            $query3 = $dbh -> prepare($sql3);
                                            $query3->execute();
                                            if($query3->rowCount() > 0)
                                            {?>
                                            <a href="reg-room.php?dslot=<?php echo $room_time3;?>&roomid=<?php echo htmlentities($result->ROOM_ID);?>&roomdate=<?php echo $room_time;?>" onclick="return confirm('Are you sure you want to cancel the reserved room?');">  <button class="btn btn-danger"> Cancel</button>
                                            <?php } else {?>
                                            <a href="reg-room.php?aslot=<?php echo $room_time3;?>&roomid=<?php echo htmlentities($result->ROOM_ID);?>&roomdate=<?php echo $room_time;?>" onclick="return confirm('Are you sure you want to  reserve the room?');"><button class="btn btn-primary"> Reserve</button>
                                            <?php } ?>
                                            </td>


                                            <td class="center">
                                             <?php
                                             $sql4 = "SELECT * from vkm_cust_room where SLOT = '$room_time4' and Room_id = '$result->ROOM_ID'";
                                             $query4 = $dbh -> prepare($sql4);
                                             $query4->execute();
                                             if($query4->rowCount() > 0)
                                             {?>
                                            <a href="reg-room.php?dslot=<?php echo $room_time4;?>&roomid=<?php echo htmlentities($result->ROOM_ID);?>&roomdate=<?php echo $room_time;?>" onclick="return confirm('Are you sure you want to cancel the reserved room?');">  <button class="btn btn-danger"> Cancel</button>
                                            <?php } else {?>
                                            <a href="reg-room.php?aslot=<?php echo $room_time4;?>&roomid=<?php echo htmlentities($result->ROOM_ID);?>&roomdate=<?php echo $room_time;?>" onclick="return confirm('Are you sure you want to  reserve the room?');"><button class="btn btn-primary"> Reserve</button>
                                            <?php } ?>
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