<?php 
/*  © 2008-2013 eBay Inc., All Rights Reserved */
/* Licensed under CDDL 1.0 -  http://opensource.org/licenses/cddl1.php */
require_once('keys.php');
?>
<?php require_once('eBaySession.php'); ?>
<!DOCTYPE html>
<HTML>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=utf-8">
<TITLE>AddItem</TITLE>

<link rel="stylesheet" href="css/bootstrap.css" type="text/css">

<script type="text/javascript">
function check(){
	var inp = document.getElementById('imageInput');
	var numFiles = inp.files.length;
    if(numFiles > 12){
    	alert('Please do not choose images more than 12');
    	document.getElementById('imageInput').value = '';
    }
}
</script>


</HEAD>

<BODY>
<div class="container" style="width:50%">
<form action="AddItem.php" method="post" enctype="multipart/form-data">
<br><div class="row">
		<div class="col-md-6">primaryCategory</div>
		<div class="col-md-6">
      <select class="form-control" name="primaryCategory">
	    	<?php $catId = $_POST['category'];
	        if(is_array($catId)):
	        foreach($catId as $val){ 
					$arr = explode('-', $val);
					echo '<option value="'.$arr[0].'">'.$arr[1].'</option>';
			}
			else:
				$arr = explode('-', $catId);
				echo '<option value="'.$arr[0].'">'.$arr[1].'</option>';
			endif;
	        ?>
      </select>

    </div>
	</div>

<br><div class="row">
		<div class="col-md-6">itemTitle</div>
		<?php 
		if(isset($_POST['item'])){
			$item = $_POST['item'];
			$arr = explode(':', $item);
			$id = $arr[0];
			$title = $arr[1];
		}
		else{
			$id = $title = '';
		}
		?>
		<div class="col-md-6"><input class="form-control" type="text" name="itemTitle" value="<?php echo $title; ?>" size="49"></div>
	</div>
	
    <br><div class="row">
		<div class="col-md-6">itemDescription</div>
		<div class="col-md-6"><textarea class="form-control" name="itemDescription" rows="10" cols="50" value="Item Deccription : DO NOT BID - This will incur prod listing fees"></textarea></div>
	</div>
	
	<br><div class="row">
		<div class="col-md-6">Condition</div>
		<div class="col-md-6">
			<select class="form-control" id="itemCondition" name="itemCondition" title="Condition">
				<option value="1000">New</option>
				<option value="3000">Used</option>
			</select>
		</div>
	</div>
	
	<br><div class="row">
		<div class="col-md-6">listingType</div>
		<div class="col-md-6">
      <select class="form-control" name="listingType">
        <option value="FixedPriceItem">Fixed Price Item</option>
      </select>
    </div>
	</div>

	<br><div class="row">
	  <div class="col-md-6">listingDuration</div>
		<div class="col-md-6">
	          <select class="form-control" name="listingDuration">
	             <option value="Days_30">30 days</option>
	          </select>  
	        </div>
	        
	</div>

<br><div class="row">
	<div class="col-md-6">Price</div>
	<div class="col-md-6"><input class="form-control" type="text" name="startPrice"></div>
	</div>

	<!-- <br><div class="row">
		<div class="col-md-6">BuyItNowPrice</div>
		<div class="col-md-6"><input class="form-control" type="text" name="buyItNowPrice" value=""></div>
	</div> -->

	<br><div class="row">
		<div class="col-md-6">Pictures (max 12 photos)</div>
		<div class="col-md-6">
			<input class="form-control" name="image_file[]" id="imageInput" onchange="check()" type="file" multiple="true" />
		</div>
	</div>

	<br><div class="row">
		<div class="col-md-6">Searched Keyword</div>
		<div class="col-md-6"><input class="form-control" type="text" name="searched_keyword" readonly="readonly" value="<?php echo $_POST['search_keyword'];?>"></div>
	</div>

	<br><div class="row">
		<div class="col-md-12">
		<div class="pull-left"><input class="form-control btn btn-primary" type="submit" name="submit" value="AddItem"></div>
		<div class="pull-right">
			<a role="button" class="btn btn-default" href="index.php">Back</a></div>
		</div>
	</div>
	<br>
</form>


<?php
    if(isset($_POST['submit']))
	{
        //Image Upload
      $images = $_FILES['image_file'];
        $img_name = array();

		if(count($images['name']) > 12){
			echo '<span style="color:red;">Please choose 12 photos maximum or less</span>';
		}
		else{
			for($i=0;$i<count($images['name']);$i++):
				//check image type
				if($images['type'][$i]!='image/png'&& $images['type'][$i]!='image/jpeg' && $images['type'][$i]!='image/jpg' && $images['type'][$i]!='image/gif'){
					echo 'Please upload a valid Image';
					break;
				}
				else{
					$name = time();
					$ext = pathinfo($images['name'][$i],PATHINFO_EXTENSION);
					$name .=$i.'.'.$ext;	
					move_uploaded_file($images['tmp_name'][$i], 'uploads/'.$name);
					$img_name[]=$name;
				}
				//check image type	
			endfor;

		}
        //Image Upload

		//check
        ini_set('magic_quotes_gpc', false);    // magic quotes will only confuse things like escaping apostrophe
		//Get the item entered
        $listingType     = $_POST['listingType'];
        $primaryCategory = $_POST['primaryCategory'];
        $itemTitle       = $_POST['itemTitle'];
        $startPrice      = $_POST['startPrice'];
        //$buyItNowPrice   = $_POST['buyItNowPrice'];
        $listingDuration = $_POST['listingDuration'];
        $safequery       = $_POST['searched_keyword'];

        if(get_magic_quotes_gpc()) {
            // print "stripslashes!!! <br>\n";
            $itemDescription = stripslashes($_POST['itemDescription']);
        } else {
            $itemDescription = $_POST['itemDescription'];
        }
        $itemDescription = $_POST['itemDescription'];
        $itemCondition   = $_POST['itemCondition']; 
        
		$siteID = 77;
		//the call being made:
		$verb = 'AddItem';

		/*if ($listingType == 'FixedPriceItem') {
          $buyItNowPrice = 0.0;   // don't have BuyItNow for FixedPriceItem
        }*/
		
		///Build the request Xml string
		$requestXmlBody  = '<?xml version="1.0" encoding="utf-8" ?>';
		$requestXmlBody .= '<AddItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">';
		$requestXmlBody .= "<RequesterCredentials><eBayAuthToken>$userToken</eBayAuthToken></RequesterCredentials>";
		$requestXmlBody .= '<DetailLevel>ReturnAll</DetailLevel>';
		$requestXmlBody .= '<ErrorLanguage>en_DE</ErrorLanguage>';
		$requestXmlBody .= "<Version>$compatabilityLevel</Version>";
		$requestXmlBody .= '<Item>';
		$requestXmlBody .= '<ConditionID>'.$itemCondition.'</ConditionID>';
		$requestXmlBody .= '<Site>eBayMotors</Site>';
		$requestXmlBody .= '<PrimaryCategory>';
		$requestXmlBody .= "<CategoryID>$primaryCategory</CategoryID>";
		$requestXmlBody .= '</PrimaryCategory>';
		$requestXmlBody .= '<BestOfferDetails>';
		$requestXmlBody .= '<BestOfferEnabled>1</BestOfferEnabled>';
		$requestXmlBody .= '</BestOfferDetails>';
		$requestXmlBody .= '<PictureDetails>';
		//$requestXmlBody .= '<GalleryURL>http://www.choprafoundation.org/wp-content/uploads/2013/12/03-relaxation.jpg</GalleryURL>';
        for($j=0;$j<count($img_name);$j++):
        //$requestXmlBody .= '<PictureURL>http://www.choprafoundation.org/wp-content/uploads/2013/12/03-relaxation.jpg</PictureURL>';
		$requestXmlBody .= '<PictureURL>http://agscybertech.com/rishi/ebay/uploads/'.$img_name[$j].'</PictureURL>';
		endfor;
		$requestXmlBody .= '</PictureDetails>';	
	    //$requestXmlBody .= "<BuyItNowPrice currencyID=\"EUR\">$buyItNowPrice</BuyItNowPrice>";
		$requestXmlBody .= '<Country>DE</Country>';
		$requestXmlBody .= '<Currency>EUR</Currency>';
		$requestXmlBody .= '<DispatchTimeMax>1</DispatchTimeMax>';
		$requestXmlBody .= "<ListingDuration>$listingDuration</ListingDuration>";
        $requestXmlBody .= '<ListingType>'.$listingType.'</ListingType>';
		$requestXmlBody .= '<Location><![CDATA[Koln]]></Location>';
		$requestXmlBody .= '<PaymentMethods>PayPal</PaymentMethods>';
		$requestXmlBody .= "<PayPalEmailAddress>$paypalEmailAddress</PayPalEmailAddress>";
		//$requestXmlBody .= "<Quantity>$quantity</Quantity>";
		$requestXmlBody .= '<RegionID>77</RegionID>';
		$requestXmlBody .= "<StartPrice>$startPrice</StartPrice>";
		$requestXmlBody .= '<ShippingTermsInDescription>True</ShippingTermsInDescription>';
		$requestXmlBody .= "<Title><![CDATA[$itemTitle]]></Title>";
		$requestXmlBody .= "<Description><![CDATA[$itemDescription]]></Description>";
		/*$requestXmlBody .= '<ReturnPolicy>';
		$requestXmlBody .= '<ReturnsAcceptedOption>'.$returnsAccepted.'</ReturnsAcceptedOption>';
		$requestXmlBody .= '<ReturnsWithinOption>'.$returnWithin.'</ReturnsWithinOption>';
		$requestXmlBody .= '</ReturnPolicy>';*/
	    $requestXmlBody .= '<ShippingDetails>';	
	    $requestXmlBody .= '<ShippingType>Flat</ShippingType>';	 
	    $requestXmlBody .= '<ShippingServiceOptions>';
	    $requestXmlBody .= '<ShippingServiceAdditionalCost currencyID="EUR">2.0</ShippingServiceAdditionalCost>';
		$requestXmlBody .= '<ShippingServiceCost currencyID="EUR">7.50</ShippingServiceCost>';
        $requestXmlBody .= '<ShippingServicePriority>1</ShippingServicePriority>';
        $requestXmlBody .= '<ShippingService>DE_Express</ShippingService>';
        $requestXmlBody .= '</ShippingServiceOptions>';
        $requestXmlBody .= '</ShippingDetails>';
		$requestXmlBody .= '</Item>';
		$requestXmlBody .= '</AddItemRequest>';
		
		//echo $requestXmlBody;
		
        //Create a new eBay session with all details pulled in from included keys.php
        $session = new eBaySession($userToken, $devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb);
		
		//send the request and get response
		$responseXml = $session->sendHttpRequest($requestXmlBody);
		if(stristr($responseXml, 'HTTP 404') || $responseXml == '')
			die('<P>Error sending request');
		
		//Xml string is parsed and creates a DOM Document object
		$responseDoc = new DomDocument();
		$responseDoc->loadXML($responseXml);
			
		//get any error nodes
		$errors = $responseDoc->getElementsByTagName('Errors');
		
		//if there are error nodes
		if($errors->length > 0)
		{
			//echo 'item updated';
			echo '<P><B>eBay returned the following error(s):</B>';
			//display each error
			//Get error code, ShortMesaage and LongMessage
			$code     = $errors->item(0)->getElementsByTagName('ErrorCode');
			$shortMsg = $errors->item(0)->getElementsByTagName('ShortMessage');
			$longMsg  = $errors->item(0)->getElementsByTagName('LongMessage');
			//Display code and shortmessage
			echo '<P>', $code->item(0)->nodeValue, ' : ', str_replace(">", "&gt;", str_replace("<", "&lt;", $shortMsg->item(0)->nodeValue));
			//if there is a long message (ie ErrorLevel=1), display it
			if(count($longMsg) > 0)
				echo '<BR>', str_replace(">", "&gt;", str_replace("<", "&lt;", $longMsg->item(0)->nodeValue));
	
		} else { //no errors
            
			
			//get results nodes
            $responses = $responseDoc->getElementsByTagName("AddItemResponse");
            $itemID = "";
            foreach ($responses as $response) {
              $acks = $response->getElementsByTagName("Ack");
              $ack   = $acks->item(0)->nodeValue;
              echo "Ack = $ack <BR />\n";   // Success if successful
              
              $endTimes  = $response->getElementsByTagName("EndTime");
              $endTime   = $endTimes->item(0)->nodeValue;
              echo "endTime = $endTime <BR />\n";
              
              $itemIDs  = $response->getElementsByTagName("ItemID");
              $itemID   = $itemIDs->item(0)->nodeValue;
              echo "itemID = $itemID <BR />\n";
              
              $linkBase = "http://cgi.sandbox.ebay.com/ws/eBayISAPI.dll?ViewItem&item=";
              echo "<a href=$linkBase" . $itemID . ">$itemTitle</a> <BR />";
              
              $feeNodes = $responseDoc->getElementsByTagName('Fee');
              foreach($feeNodes as $feeNode) {
                $feeNames = $feeNode->getElementsByTagName("Name");
                if ($feeNames->item(0)) {
                    $feeName = $feeNames->item(0)->nodeValue;
                    $fees = $feeNode->getElementsByTagName('Fee');  // get Fee amount nested in Fee
                    $fee = $fees->item(0)->nodeValue;
                    if ($fee > 0.0) {
                        if ($feeName == 'ListingFee') {
                          printf("<B>$feeName : %.2f </B><BR>\n", $fee); 
                        } else {
                          printf("$feeName : %.2f <BR>\n", $fee);
                        }      
                    }  // if $fee > 0
                } // if feeName
              } // foreach $feeNode
            
            } // foreach response
            
            //Insert into Database
            $xml = simplexml_load_string($responseXml);
			$total_images = implode(',',$img_name);
			$conn = mysqli_connect('localhost','rishi','********','ebay') or mysqli_connect_error();
			mysqli_set_charset($conn,'utf8');
			$query = mysqli_query($conn,'INSERT INTO `ebay_items` (`search_keyword`,`categoryID`,`itemID`,`title`,`description`,`startprice`,`condition`,`listingDuration`,`image`,`listingtype`) 
				VALUES ("'.$safequery.'","'.$primaryCategory.'","'.$xml->ItemID.'","'.mysqli_real_escape_string($conn,$itemTitle).'","'.mysqli_real_escape_string($conn,$itemDescription).'","'.$startPrice.'","'.$itemCondition.'","'.$listingDuration.'","'.$total_images.'","'.$listingType.'")');
			if(!$query):
				echo 'There was an Error while inserting data<br/>';
			endif;
			//Insert into Database

		} // if $errors->length > 0
	}
?>
</div>
</BODY>
</HTML>
