  <script src="//code.jquery.com/jquery-1.9.1.js"></script>
  <script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
  <script src="<?php echo plugins_url()?>/product-manager/js/additional-methods.js"></script>
  <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
  <script>  
   $(function() {
jQuery.validator.addMethod("integer", function(value, element) 
{
	return this.optional(element) || /^-?\d+$/.test(value);
}, "A positive or negative non-decimal number please");
jQuery.validator.addMethod('positivePrice', function (value) 
{ 
	return Number(value) > 0;
}, 'Enter a positive number.');
jQuery.validator.addMethod("letterspaceonly", function(value, element) 
{
   return this.optional(element) || /^([a-z]+([\s][a-z]+)?)+$/i.test(value);
}, "Letters and Single space only");

jQuery.validator.addMethod("alphanumeric", function(value, element) 
{
	return this.optional(element) || /^[A-Z|a-z]{4}[0][\d]{6}$/.test(value);
}, "");

 jQuery.validator.addMethod("extension", function(value, element, param)
 {
	param = typeof param === "string" ? param.replace(/,/g, '|') : "png|jpe?g|gif";
	return this.optional(element) || value.match(new RegExp(".(" + param + ")$", "i"));
}, jQuery.format("File must be jpg, gif or png. "));

$.validator.addMethod('filesize', function(value, element, param)
{
    
    return this.optional(element) || (element.files[0].size <= param) 
});

 var pre_image=jQuery("#pre_image").val(); // #pre_image is id for hidden field

	function requiredWhileAdd()
	{
	return pre_image=="";
	}
         //Specify the validation 
    $("#addProductInfo").validate({
        rules:{

             product_name:{
             required: true
	      },
           	"chk[]":{
		required: true
		},
	 product_info:{
                required: true,
		minlength:5
		},
         parent_id:{
		required: true
	         },
          child_id:{
		required: true
		
                   },

         product_url:{
		required: true,
		 url: true
		
                     },
       
         file:{
		required: true,
		extension:true,
		filesize: 1048576,
		required: requiredWhileAdd()
		//accept:"jpg|jpeg|gif|png|JPG|GIF|PNG|wbmp" 
		},
      
            agree: "required"
        },
        
        // Specify the validation error messages
        messages: {
          
            product_name:
			{
required:"Please add product name"
		},

                     
           product_info:
	{
		required:"Please add product information",
		minlength:"At least 5 character"
	},
             parent_id:
	{
	required:"Please select category",  
	}, 
	    child_id:
        {
	required:"Please select brand",  
	},   
  
             product_url:
	{
	required:"Please add product link ",  
	},  
             
             valid_date:
	{
	required:"Please Select Validity Date",  
	
	},  
             file:
	{
	required: requiredWhileAdd(), 
	required: "Please select image",
	filesize: "File must be less than 1MB",
	extension:"File must be jpg, gif or png." 

	},  
           
            agree:"Please accept our policy"
		},
		
		submitHandler: function(form) {
		    form.submit();
		}
	    });

	  });
</script>
<?php 
global $wpdb,$current_user; // Global variable
$upload_dir = wp_upload_dir();
$current_user = wp_get_current_user();
$_SESSION['user_id'] = $current_user->ID;
extract($_POST);
$upload_dir = wp_upload_dir();
$user_id = $_SESSION['user_id'];
	
	if($_POST['button']=='Save')
        {
	if ($_FILES["file"]["name"]!='')
          {
                $filename = $_FILES["file"]["name"];
		$ext = pathinfo($filename, PATHINFO_EXTENSION);
			  $tempiflenm = $_FILES["file"]["tmp_name"];
			  $image_name = date('Ymdhis').$_FILES["file"]["name"];
		          $temp_dir = $_FILES["file"]["tmp_name"];
			  $upload_dir_path = $upload_dir['basedir'].'/'.$image_name;
			  move_uploaded_file($temp_dir,$upload_dir_path);
                          $image_name = $image_name;
			  //image name for inserting database
                          if($image_name!='')
                           {
			   $image_name = $image_name;
                          }else{
                            $image_name =  $_POST['file_exist'];
                           }
				$profile_comment = mysql_real_escape_string($_POST['profile_comment']);
		                $datavalue = array();
		                $datavalue['profile_comment'] = $profile_comment;
		                $datavalue['image'] = $image_name;
	    
$rs1=$wpdb->query("insert into wp_product (product_name,product_info,child_id,parent_id,product_url,product_image) values('".$_POST['product_name']."','".$_POST['product_info']."','".$_POST['child_id']."','".$_POST['parent_id']."','".$_POST['product_url']."','".$datavalue['image']."')");
$cid =implode(",",$_POST['chk']);
$a=explode(",",$cid);
$aaa=count($a);
$ec= $wpdb->insert_id;
?>
	<script>
	         	alert("New product added");
			window.location="?page=add-product";
	</script>
<?php } 
}
?>
             <?php if($_POST['button']=='Update')
              {
                if ($_FILES["file"]["name"]!='')
                {   
		    $filename = $_FILES["file"]["name"];
	            $ext = pathinfo($filename, PATHINFO_EXTENSION);
	            $tempiflenm = $_FILES["file"]["tmp_name"];   
                    $image_name = date('Ymdhis').$_FILES["file"]["name"];
		    $temp_dir  = $_FILES["file"]["tmp_name"];
		    $upload_dir_path = $upload_dir['basedir'].'/'.$image_name;
		    move_uploaded_file($temp_dir,$upload_dir_path);
                    if($_POST['file_exist']!='')
                       {
                            @unlink($upload_dir[basedir]."/".$_POST['file_exist']);
                        }
                        $image_name = $image_name;
                }
		 else
			{
			$image_name=$_POST['pre_image'];
			}

		    //image name for inserting database
                        if($image_name!='')
                        {
			$image_name = $image_name;
                        }else{
                           $image_name =  $_POST['file_exist'];
                        }
			$profile_comment = mysql_real_escape_string($_POST['profile_comment']);
                        $datavalue = array();
                        $datavalue1['image'] = $image_name;
		        $rsup=("update wp_product set product_name= '".$_POST['product_name']."',product_info='".$_POST['product_info']."',child_id='".$_POST['child_id']."',parent_id='".$_POST['parent_id']."',
                                product_url='".$_POST['product_url']."',product_image='".$datavalue1['image']."' where id=".$_GET['id']." ");
			$rsup1=$wpdb->query($rsup,"ARRAY_A");
			$cid =implode(",",$_POST['chk']);
			$a=explode(",",$cid);
			$aaa=count($a);
			?>
			<script>
				alert("Product information updated");
				window.location="?page=add-product";
			</script>

		    <?php }?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" href="<?php echo plugins_url()?>/education-info/css/style.css" />
 <style>
a {
    color:#fff;
}
.dropdown dd, .dropdown dt {
    margin:0px;
    padding:0px;
}
.dropdown ul {
    margin: -1px 0 0 0;
}
.dropdown dd {
    position:relative;
}
.dropdown a, 
.dropdown a:visited {
    color:black;
    text-decoration:none;
    outline:none;
    font-size: 12px;
}
.dropdown dt a {
    background-color:white;
    display:block;
    padding: 8px 20px 5px 10px;
    min-height: 25px;
    line-height: 24px;
    overflow: hidden;
    border:0;
    width:272px;
}
.dropdown dt a span, .multiSel span {
    cursor:pointer;
    display:inline-block;
    padding: 0 3px 2px 0;
}
.dropdown dd ul {
    background-color:white;
    border:0;
    color:black;
    display:none;
    left:0px;
    padding: 2px 5px 2px 5px;
    position:absolute;
    top:2px;
    width:280px;
    list-style:none;
    height: 100px;
    overflow: auto;
}
.dropdown span.value {
    display:none;
}
.dropdown dd ul li a {
    padding:5px;
    display:block;
}
#wpfooter {display:none; }
</style>
<script language="javascript">
function loadallparent(cntsate,stsval) {
	var action_run ='check_parentload'; 
		jQuery.ajax({
				url: ajaxurl,    
				type: "POST",
				cache: false,
				data: {action:action_run,c_id:stsval,cntsate:cntsate},
				success: function (html) {
                     jQuery('#ajax_parent_load').html(html);
					 if(cntsate>=1 && stsval=='00')
					 loadallcity('00','00');
                }
             });
	
	}
	
</script>
</head>
	<div class="bs-example">
        <div id="postedit" class="clearfix">
	    <h2 class="ico_mug">
		<?php if($_GET['id']=='') {?>
                        Add Product 
                    <?php } else { 
                        $res=$wpdb->get_row("select * from wp_product where id=".$_GET['id']."","ARRAY_A"); ?> 
                          Update Product                       
                    <?php }  ?>
             </h2>
	</div>
               <form name="addProductInfo" id="addProductInfo"  method="post"  enctype="multipart/form-data" >
                <fieldset>
                         <div class="table_wrapper">
                  		<div class="table_wrapper_inner">
		<table >
                      <tr>
			<td><span>Select Category:</span></td>
                         <td>
                              <select  class="span6" name="parent_id" id="parent_id" onchange="loadallparent(this.value,'00');">
                              <option value="">Select Category</option>
                                 <?php
                                                $sql1= "select parent_id,parent_name from wp_parent where status='Active'";
	             				$cntrdata =$wpdb->get_results($sql1,"ARRAY_A");
	       					if (!empty($cntrdata)) 
						{
		                			foreach($cntrdata as $country_datas)
						{ ?>
<option value="<?php echo $country_datas['parent_id']; ?>" <?php if($country_datas['parent_id']==$res['parent_id']){ ?>selected="true" <?php } ?>> <?php echo $country_datas['parent_name']; ?></option>
				<?php } 
				} ?>
                                </select>
                           </td>
                      </tr>
                              <tr>
	         		<td><span>Select Brand:</span></td>
                                      <td>
								<?php
								if($res['child_id']>=1)
								$stid=$res['child_id'];
								else
								$stid=00;
								if($res['parent_id']>=1)
								$cntid=$res['parent_id'];
								else
								$cntid=00;
								?>
								     <script language="javascript">
									jQuery( document ).ready(function() {
									loadallparent('<?php echo $cntid;?>','<?php echo $stid;?>');
									});
								     </script>
									<div id="ajax_parent_load">
									</div>
                                    </td>
          		     </tr>
                 		 <tr>
				     <td><span>Image:</span></td>
                                    <td>
                                    <?php if($_REQUEST['id']!='') 
                                     {?>
                                       <img height="200px" width="200px"src="<?php echo home_url();?>/wp-content/uploads/<?php echo $res['product_image'];?>" />
		                   <?php 
                                     } ?>
					<input class="span6" type="file" name="file" id="file" tabindex="17"/>
					<input type="hidden" name="pre_image" id="pre_image" value="<?php echo $res['product_image'];?>"/>   
					
                                   </td>
			      </tr>
                    <tr>
                       <td><span>Product Name:</span></td>
                      <td><input type text=""  name="product_name" maxlength="255" id="product_name" type="text" class="textbox" value="<?php if($res['product_name']!=''){ echo $res['product_name']; }  ?>"></td>
                    </tr>
		    <tr>
		     <td><span>Product Link:</span></td>
	<td><input type text=""  name="product_url" maxlength="255" id="product_url" type="text" class="textbox" value="<?php if($res['product_url']!=''){ echo $res['product_url']; }  ?>"></td></textarea></td>
                    </tr>
		<tr>
                <td><span>Product Information: </span></td>
                <td><textarea rows="8" cols="60" name="product_info" maxlength="2000" id="product_info" type="text" class="textbox" ><?php if($res['product_info']!=''){ echo $res['product_info']; }  ?></textarea></td>
                </tr>
                <tr>
                   <tr>
			<td>&nbsp;</td>
			<td align="left">
                          <span class="">
                             <?php if($_GET['id']=='') {?>
                            <input type="submit" name="button" id="button" value="Save"/>
                            <?php } else { ?>
                           <input type="submit" name="button" id="button" value="Update"/>
                          <?php }  ?>
                        </span>
                <span class="">
                 <input type="button" name="button1" id="button1" value="Cancel" onclick="javascript:window.location='<?php echo home_url();?>/wp-admin/admin.php?page=add-product'"/>
                </span>
           	</td>
	     </tr>
	  </table>
      </div>
   </div>
 </fieldset>
</form>
	</div>
	</div>
       </html>