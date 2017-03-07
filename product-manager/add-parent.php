 <script src="//code.jquery.com/jquery-1.9.1.js"></script>
 <script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
 <script src="<?php echo plugins_url()?>/product-manager/js/additional-methods.js"></script>
 <script>  
         // Specify the validation
     $(function() {
     $("#addParent").validate({
            rules:{
             parent_name:{
                required: true,
		minlength: 1
		},
             parent_code:{
		required: true,
		minlength: 2
		},
                  
            agree: "required"
        },
        
        // Specify the validation error messages
        messages: {
          
            parent_name:
			{
				required:"Please add category",
				minlength:"Enter at least 1 charecters"
		        }
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
$user_id = $_SESSION['user_id'];

                   if($_POST['button']=='Save')
                   {
		       $rs=$wpdb->query("insert into wp_parent (parent_name,parent_code) values('".$_POST['parent_name']."','".$_POST['parent_code']."')");
		?>
	    	<script>
				alert("New Category Add");
				window.location="?page=add-parent";
		</script>
		    <?php exit; }?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<div class="bs-example">
<div id="postedit" class="clearfix">
<h2 class="ico_mug">
<?php if($_GET['parent_id']=='') {?>
                        Add Category
<?php } else { 
$rs=$wpdb->get_row("select * from wp_parent where parent_id=".$_GET['parent_id']." ","ARRAY_A");
             ?>
               Update Category
           <?php }  ?>
            </h2>
         </li>
          <form name="addParent" id="addParent" method="post" ">
             <fieldset>
             <div class="table_wrapper">
             <div class="table_wrapper_inner">
	     <table>
	     		<tr>
				<td><span>Add Category :</span></td>
				<td>
                                <input name="parent_name" id="parent_name" maxlength="255" type="text" class="textbox" value="<?php if($rs['parent_name']!=''){ echo $rs['parent_name']; } ?>"  maxlength="50" />
				</td>
			</tr>
		             <tr>
				<td>&nbsp;</td>
			     <td align="left">
                <span class="">
                        <?php if($_GET['parent_id']=='') {?>
                        <input type="submit" name="button" id="button" value="Save"/>
                        <?php } else { ?>
                        <input type="submit" name="button" id="button" value="Update"/>
                        <?php }  ?>
               </span>
                <span class="">
                <input type="button" name="button1" id="button1" value="Cancel" onclick="javascript:window.location='<?php echo home_url();?>/wp-admin/admin.php?page=add-parent'"/>
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
