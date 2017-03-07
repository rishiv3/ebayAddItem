<?php
require_once('keys.php') ;
require_once('eBaySession.php');

$endpoint = 'http://open.api.sandbox.ebay.com/Shopping';  // URL to call
$responseEncoding = 'XML';   // Format of the response
$categoryID = $_GET['catId'];

$siteID  = 0; //0-US,77-DE

// Construct the FindItems call
$apicall = "$endpoint?callname=GetCategoryInfo"
     . "&appid=$appID"
     . "&siteid=$siteID"
     . "&CategoryID=$categoryID"
     . "&version=677"
     . "&responseencoding=$responseEncoding"
     . "&IncludeSelector=ChildCategories";

// Load the call and capture the document returned by the GetCategoryInfo API

$xml = simplexml_load_file($apicall);

$errors = $xml->Errors;
$browse = "";
$i = isset($_GET['counter']) ? $_GET['counter'] + 1 : 0;
//echo $i;

//if there are error nodes
if($errors->count() > 0)
{
    echo '<p><b>eBay returned the following error(s):</b>';
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
    //if sub-categories found
    if($xml->CategoryArray->Category->LeafCategory=='false'):

        foreach($xml->CategoryArray->Category as $cat){
            if($cat->CategoryID!=$categoryID):
                if($cat->CategoryLevel!=0):
                    $browse.='<option value="'.$cat->CategoryID.'">'.$cat->CategoryName.'</option>';
                endif;
            endif;
        }

        echo '<select size="15" class="columns" id="subcat_'.$i.'">'.$browse.'</select><span class="subcat_'.$i.'"></span>';
        echo '<script>$("#continue").attr("disabled","disabled"); </script>';
    else: // if no sub-categories found
        $categorypath = str_replace(':', ' > ', $xml->CategoryArray->Category->CategoryNamePath);
        $name =  $xml->CategoryArray->Category->CategoryName;
        $id   = $xml->CategoryArray->Category->CategoryID;
        ?>
        <input type="hidden" name="category" value="<?php echo $id; ?>-<?php echo $name; ?>" />
        <span class="nocategories"><img src="http://pics.ebaystatic.com/aw/pics/icon/iconSuccess_32x32.gif" alt=" ">
              You have selected a category. Click <b>Continue</b>.</span>';
        <script>$("#continue").removeAttr("disabled","disabled"); $(".ionise").html("<b>Category you have selected:</b><ul><li><?php echo $categorypath ?></li></ul><input type='button' id='remove' value='Remove' />")</script>
    <?php
    endif;
}

?>
<script>
$(document).ready(function(){
    <?php $i = isset($_GET['counter']) ? $_GET['counter'] + 1 : 0; ?>
    var counter = <?php echo $i; ?>;
    $('#subcat_'+counter).change(function(){
        var catId = $('#subcat_'+counter).val();

        $.get('getCategoriesInfo.php?counter='+counter+'&catId='+catId, function(response,status){
            if(status =='success'){
                //alert(response);
                $('span.subcat_'+counter).html(response);
            }
        });
    }); //select onchange
    $('#remove').click(function(){ //alert('response cleared');
        $('.div-scrollbar > span,.ionise').html('');
    })
});
</script>