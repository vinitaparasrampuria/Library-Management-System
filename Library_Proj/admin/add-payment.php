<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
    {
header('location:index.php');
}
else{

if(isset($_POST['create']))
{
$digits = 6;
$PAYMENT_ID=rand(pow(10, $digits-1), pow(10, $digits)-1);
$PAY_METHOD=$_POST['PAY_METHOD'];
$FNAME=$_POST['FNAME'];
$LNAME=$_POST['LNAME'];
$pay_amount=$_POST['pay_amount'];
$pay_date=$_POST['pay_date'];
$Inv_id=$_POST['Inv_id'];


$sql="INSERT INTO `vkm_payment`(`PAYMENT_ID`, `PAY_METHOD`, `CARD_FNAME`, `CARD_LNAME`, `PAY_AMT`, `PAY_DATE`, `INVOICE_ID`)
VALUES (:PAYMENT_ID,:PAY_METHOD,:FNAME,:LNAME,:pay_amount,:pay_date,:Inv_id)";
$query = $dbh->prepare($sql);
$query->bindParam(':PAYMENT_ID',$PAYMENT_ID,PDO::PARAM_STR);
$query->bindParam(':PAY_METHOD',$PAY_METHOD,PDO::PARAM_STR);
$query->bindParam(':FNAME',$FNAME,PDO::PARAM_STR);
$query->bindParam(':LNAME',$LNAME,PDO::PARAM_STR);
$query->bindParam(':pay_amount',$pay_amount,PDO::PARAM_STR);
$query->bindParam(':pay_date',$pay_date,PDO::PARAM_STR);
$query->bindParam(':Inv_id',$Inv_id,PDO::PARAM_STR);



$query->execute();
$lastInsertId = $dbh->lastInsertId();
if(true)
{
$_SESSION['msg']="Payment Add successfully";
header('location:manage-invoice.php');
}
else
{
$_SESSION['error']="Something went wrong. Please try again";
header('location:manage-invoice.php');
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
    <title>Online Library Management System | Add Author</title>
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
                <h4 class="header-line">Add Author</h4>

                            </div>

</div>
<div class="row">
<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
<div class="panel panel-info">
<div class="panel-heading">
Author Info
</div>
<div class="panel-body">
<form role="form" method="post">
<div class="form-group">
<label>Payment Method</label>
<select class="form-control" name="PAY_METHOD" required="required">
  <option value="Credit">Credit</option>
  <option value="Debit">Debit</option>
  <option value="Cash">Cash</option>
  <option value="PayPal">PayPal</option>
</select>
</div>

<div class="form-group">
<label>Card Holder First Name</label>
<input class="form-control" type="text" name="FNAME" autocomplete="off"  required />
</div>

<div class="form-group">
<label>Card Holder Last Name</label>
<input class="form-control" type="text" name="LNAME" autocomplete="off"  required />
</div>

<div class="form-group">
<label>Payment Amount</label>
<input class="form-control" type="text" name="pay_amount" autocomplete="off"  required value = "<?php echo $_GET['invoice_amount'] ?>"/>
</div>

<div class="form-group">
<label>Payment Date</label>
<input class="form-control" type="date" name="pay_date" autocomplete="off" required="required"/>
</div>

<div class="form-group">
<label>Invoice ID</label>
<input class="form-control" type="text" name="Inv_id" autocomplete="off"  required value = "<?php echo $_GET['invoice_id'] ?>" />
</div>

<button type="submit" name="create" class="btn btn-info">Add </button>

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