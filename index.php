<?php
require_once('keys.php') ;
require_once('eBaySession.php');
?>
<!DOCTYPE>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Browse Categories</title>
<link rel="stylesheet" href="css/bootstrap.css" type="text/css">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
</head>

<body>

<?php
$browse = '';
$endpoint = 'http://open.api.sandbox.ebay.com/Shopping';  // URL to call
$responseEncoding = 'XML';   // Format of the response

$siteID  = 0; //0-US,77-DE

// Construct the FindItems call
$apicall = "$endpoint?callname=GetCategoryInfo"
     . "&appid=$appID"
     . "&siteid=$siteID"
     . "&CategoryID=-1"
     . "&version=677"
     . "&IncludeSelector=ChildCategories";

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
<div class="row-fluid">
	<div class="col-md-12">
	<legend>Browse Cateogries</legend>
	</div>
</div>
<!--row1-fluid ends-->

<form action="AddItem.php" method="post">
	<!--row2-fluid starts-->
	<div class="div-scrollbar">
		<select size="15" id="fcat"><?php echo $browse ?></select>
		<span></span>
		<br/>
		<div class="row-fluid ionise"></div>
	</div>
	<!--row2-fluid ends-->

	<br/>

	<!--row2-fluid starts-->
	<div class="row-fluid">
		<input type="submit" value="Continue" id="continue" class="btn btn-primary" disabled="disabled" />
	</div>
	<!--row2-fluid ends-->
</form>

<script>
$(document).ready(function(){
	$('#fcat').change(function(){
		//alert($('#fcat').val());
		var catId = $('#fcat').val();
		$.get('getCategoriesInfo.php?catId='+catId, function(response,status){
			if(status=='success'){
				//console.log(response);
				$('.div-scrollbar > span').html(response);
			}
		});
	}); //select onchange
});
</script>

</body>
</html>