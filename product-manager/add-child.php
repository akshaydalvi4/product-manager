 <script src="//code.jquery.com/jquery-1.9.1.js"></script>
 <script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
 <script src="<?php echo plugins_url()?>/product-manager/js/additional-methods.js"></script>
  <script>  
	 // Specify the validation
  $(function() {
    
     $("#addChild").validate({
        rules:{
               child_name:{
                required: true,
		minlength:1
		},
               parentid:{
		required: true
		},
                  
            agree: "required"
       },

       // Specify the validation error messages
        messages: {
          
            child_name:{
			required:"Please add brand",
			minlength:"Enter at least 1 charecters"
		},
	parentid:
		{
	required:"Please select category"  
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
global $wpdb,$current_user; // Global variables
$upload_dir = wp_upload_dir();
$current_user = wp_get_current_user();
$_SESSION['user_id'] = $current_user->ID;
extract($_POST);
$user_id = $_SESSION['user_id'];

                            if($_POST['button']=='Save')
                            {
                		$rs=$wpdb->query("insert into wp_child (child_name,parentid) values('".$_POST['child_name']."','".$_POST['parentid']."')", "0");
?>
               	<script>
			alert("New Brand Added");
			window.location="?page=add-child";
		</script>
    <?php exit; }?>
            
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<div class="bs-example">
<div id="postedit" class="clearfix">
		<h2 class="ico_mug">
		<?php if($_GET['childid']=='') {?>
                 Add Brand 
                    <?php } else { 
                        $res=$wpdb->get_row("select * from wp_child where childid=".$_GET['childid']." ","ARRAY_A");
                      ?>
		 <?php }  ?>
               </h2>
  	     <form name="addChild" id="addChild"  method="post" >
             <fieldset>
             <div class="table_wrapper">
	     <div class="table_wrapper_inner">
	     <table>
             <tr>
		<td><span>Category Name:</span></td>
		<td>
		<select name="parentid" id="parentid">
		<option value="">Select Category </option>
		<?php
		$querys= "select parent_id,parent_name from wp_parent where status='Active' order by parent_name asc";
		$contentQuery=$wpdb->get_results($querys,"ARRAY_A");
		if(!empty($contentQuery))
		{
		foreach($contentQuery as $contentdata)
		{?>
	<option <?php if($res['parentid']==$contentdata['parent_id']){ ?> selected="selected" <?php } ?> value="<?php echo $contentdata['parent_id'];?>"><?php echo $contentdata['parent_name'];?></option>
		<?php
		}
		  }
		?>
		</select>
             </td>
        </tr>
                        <tr>
				<td><span>Brand Name :</span></td>
				<td>
                                <input name="child_name" id="child_name" type="text" class="textbox" value="<?php if($res['child_name']!=''){ echo $res['child_name']; } ?>"  maxlength="255" />
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td align="left">
                     <span class="">
                        <?php if($_GET['childid']=='') {?>
                        <input type="submit" name="button" id="button" value="Save"/>
                        <?php } else { ?>
                        <input type="submit" name="button" id="button" value="Update"/>
                        <?php }  ?>
                    </span>
		        <span class="">
		        <input type="button" name="button1" id="button1" value="Cancel" onclick="javascript:window.location='<?php echo home_url();?>/wp-admin/admin.php?page=add-child'"/>
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
