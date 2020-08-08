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
    //if sub-categories found
    if($xml->CategoryArray->Category->LeafCategory=='false'):

        foreach($xml->CategoryArray->Category as $cat){
            if($cat->CategoryID!=$categoryID):
                if($cat->CategoryLevel!=0):
                    $browse.='<option value="'.$cat->CategoryID.'">'.$cat->CategoryName.'</option>';
                endif;
            endif;
        }

        echo '<select class="form-control mb-3" id="subcat_'.$i.'">'.$browse.'</select>';
        echo '<script>$("div.subcat").append("<div class=\"form-group mb-3 subcat_'.$i.'\"></div>"); </script>';
        //echo '<script>$("#continue").attr("disabled","disabled"); </script>';
    else: // if no sub-categories found
        $categorypath = str_replace(':', ' > ', $xml->CategoryArray->Category->CategoryNamePath);
        $name =  $xml->CategoryArray->Category->CategoryName;
        $id   = $xml->CategoryArray->Category->CategoryID;
        ?>
        
        <div class="alert alert-success" role="alert">
            <h5 class="alert-heading">
                <span class="nocategories">
                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-bag-check" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M14 5H2v9a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V5zM1 4v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4H1z"/>
                        <path d="M8 1.5A2.5 2.5 0 0 0 5.5 4h-1a3.5 3.5 0 1 1 7 0h-1A2.5 2.5 0 0 0 8 1.5z"/>
                        <path fill-rule="evenodd" d="M10.854 7.646a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 10.293l2.646-2.647a.5.5 0 0 1 .708 0z"/>
                    </svg>
                    You have selected a category.</span>
            </h5>
            <hr>
            <p>Click <strong>Continue</strong> to add an item.</p>
            <div class="row-fluid ionise"></div>
        </div>

        <script>
            //$("#continue").removeAttr("disabled","disabled"); 
            $(".ionise").html("<strong>Category you have selected:</strong><ul><li><?php echo $categorypath ?></li></ul><input type='button' id='remove' class='btn btn-danger' value='Remove' /> <input type='submit' value='Continue' id='continue' class='btn btn-success'/>")
        </script>

        <input type="hidden" name="category" value="<?php echo $id; ?>-<?php echo $name; ?>" />        
    <?php endif;
}

?>
<script>
$(document).ready(function(){
    <?php $i = isset($_GET['counter']) ? $_GET['counter'] + 1 : 0; ?>
    var counter = <?php echo $i; ?>;
    $('#subcat_'+counter).change(function(){
        var catId = $('#subcat_'+counter).val();
        $.ajax({
            url:'getCategoriesInfo.php?counter='+counter+'&catId='+catId,
            method: 'GET'
        })
        .done(function(response) {
            $('div.subcat_'+counter).html(response);
        })
        .fail(function() {
            console.log("error");
        });
    }); //select onchange
    $('#remove').click(function(){ 
        $('.div-scrollbar > div.subcat').html('');
    })
});
</script>