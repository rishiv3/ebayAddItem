<?php
require_once('keys.php') ;
require_once('eBaySession.php');
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="AddItem - Browse Categories">
    <meta name="author" content="Rishi Vishwakarma, Banglore, India">
    <meta name="generator" content="Jekyll v4.1.1">
    <title>AddItem - Browse Categories</title>

    <!-- CSS only -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/main.css">
		
		<!-- JS, Popper.js, and jQuery -->
		<script src="js/jquery-3.5.1.min.js"></script>
		<script src="js/popper.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/app.js"></script>
				
    <meta name="theme-color" content="#563d7c">
  </head>
  <body class="bg-light">
    <div class="container">
			<div class="py-5 text-center">
				<img class="d-block mx-auto mb-4" src="img/ebay.png" alt="Ebay Logo"  height="100">
				<h2>AddItem - Browse Categories</h2>
				<p class="lead">You must use one <b class="con">AddItem</b> call to create and publish each listing. Alternatively, you can use the <b class="con">AddItems</b> call to create and publish up to five listings per call. The <b class="con">AddItem</b> call can be used to create a single-variation, fixed-price listing, but if you wish to create a multiple-variation, fixed-price listing (for example, the same shirt in varying sizes and colors), use the <b class="con">AddFixedPriceItem</b> call instead.</p>
			</div>

<?php
$browse = '';

$responseEncoding = 'XML';   // Format of the response

$siteID  = 0; //0-US,77-DE

// Construct the FindItems call
$apicall = "$endpoint?callname=GetCategoryInfo"
    			."&appid=$appID"
    			."&siteid=$siteID"
    			."&CategoryID=-1"
    			."&version=677"
    			."&IncludeSelector=ChildCategories";

// Load the call and capture the document returned by the GetCategoryInfo API
$xml = simplexml_load_file($apicall);

$errors = $xml->Errors;

//if there are error nodes
if($errors->count() > 0)
{
    echo '<p><b>eBay returned the following error(s):</b></p>';
    //display each error
    //Get error code, ShortMesaage and LongMessage
    $code = $errors->ErrorCode;
    $shortMsg = $errors->ShortMessage;
    $longMsg = $errors->LongMessage;
    //Display code and shortmessage
    echo '<p>', $code, ' : ', str_replace(">", "&gt;", str_replace("<", "&lt;", $shortMsg));
    //if there is a long message (ie ErrorLevel=1), display it
    if(count($longMsg) > 0)
        echo '<br>', str_replace(">", "&gt;", str_replace("<", "&lt;", $longMsg));

}
else //no errors
{
	foreach($xml->CategoryArray->Category as $cat){
		if($cat->CategoryLevel!=0):
			$browse.='<option value="'.$cat->CategoryID.'">'.$cat->CategoryName.'</option>';
		endif;
	}

}

?>

<div class="clearfix"></div>

<!--row1-fluid starts-->
<div class="card row-fluid">
  <h5 class="card-header text-center">Browse Cateogries</h5>
  <div class="card-body">
    <form action="AddItem.php" method="post">
			<!--row2-fluid starts-->
			<div class="div-scrollbar form-group">
				<div class="form-group"><select id="fcat" class="form-control"><?php echo $browse ?></select></div>
				<div class="subcat form-group"></div>
			</div>
			<!--row2-fluid ends-->

			<br>

			<!--row2-fluid starts-->
			<div class="row-fluid d-none">
				<input type="submit" value="Continue" id="continue" class="btn btn-primary" disabled="disabled" />
			</div>
			<!--row2-fluid ends-->
		</form>
  </div>
</div>
<!--row1-fluid ends-->

<script>
$('#fcat').change(function(){
	let catId = $('#fcat').val();
	$.ajax({
		url:'getCategoriesInfo.php?catId='+catId,
		method: 'GET'
	})
	.done(function(response) {
		$('div.div-scrollbar > div.subcat').html(response);
	})
	.fail(function() {
		console.log("error");
	});
});
</script>

<footer class="my-5 pt-5 text-muted text-center text-small">
    <p class="mb-1">&copy; 2017-2020 Your Company Name</p>
    <ul class="list-inline">
      <li class="list-inline-item"><a href="#">Privacy</a></li>
      <li class="list-inline-item"><a href="#">Terms</a></li>
      <li class="list-inline-item"><a href="#">Support</a></li>
    </ul>
  </footer>
</div>
</html>
