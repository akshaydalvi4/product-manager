<?php
$current_user = wp_get_current_user();
$_SESSION['user_id'] = $current_user->ID;
$user = new WP_User( $_SESSION['user_id'] );
$user->roles[0];
require_once ('paging.php');
extract($_POST);
global $wpdb;
$upload_dir = wp_upload_dir(); 


if(isset($_POST['action']) && $_POST['action'] != '')
{
	$cid =implode(",",$_POST['chk']);
	print_r($cid);
	if($_POST['action'] == "Delete")
	{

	$abc=$wpdb->query("delete from wp_product where id in (".$cid.")","0");

	?>
	<script type="text/javascript">
		window.location="?page=product-manager%2Fproduct-info.php";
	</script>
   <?php 
	}	
	if($_POST['action'] == "Active")
	{
		
	 $qry =$wpdb->query("UPDATE wp_product SET status = 'Active' where id in (". $cid.")","0");
	 ?>
	<script type="text/javascript">
		window.location="?page=product-manager%2Fproduct-info.php";
	</script>
        <?php
	}
		if($_POST['action'] == "Inactive")
	{
		
		$qry =$wpdb->query("UPDATE wp_product SET status = 'Inactive' where id in (". $cid.")","0");
	
	?>
	<script type="text/javascript">
		window.location="?page=product-manager%2Fproduct-info.php";
	</script>
        <?php
	}
	}
?>

<?php
    $user_id = $_SESSION['user_id'];
	if(isset($_GET['stat']))
	{
        	$pageid = $_GET['pageid'];
		if($_GET['stat'] == "active")
		{
			$updatequery=$wpdb->get_results("UPDATE  `wp_product` SET  `status` =  'Active' WHERE  `id` =  ".$pageid);
		}
		elseif($_GET['stat'] == "inactive")
		{
			$updatequery=$wpdb->get_results("UPDATE  `wp_product` SET  `status` =  'Inactive' WHERE  `id` = ".$pageid);
		}
		?>
		<script>
		alert("Data status updated");
			window.location="?page=manage-product";
		</script>
		<?php 
    }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" href="<?php echo plugins_url()?>/product-manager/css/style.css" />
<script>
checked=false;
function checkedAll () {
	var aa= document.getElementById('frm1');
	 if (checked == false)
          {
           checked = true
          }
        else
          {
          checked = false
          }
	for (var i =0; i < aa.elements.length; i++) 
	{
	 aa.elements[i].checked = checked;
	}
      }
  
	function check_box()
	{
		if (document.getElementById('action').value == "") 
		{
		alert ( "Please select action." ); 
		return false; 
		}
		
		var chks = document.getElementsByName('chk[]');
		var hasChecked = false;
		
		for (var i = 0; i < chks.length; i++)
		{
			if (chks[i].checked)
			{
			hasChecked = true;
			break;
			}
		}
	
		if (hasChecked == false)
			{
			alert("Please select at least one record.");
			return false;
			}
		if(!confirm('Are you sure to perform this action?'))
		return false;
		}

</script>

</head>
<h2>Manage Product</h2>
<?php if(isset($_SESSION["succMsg"]) && $_SESSION["succMsg"] != "") { ?>
	       <div align="center">
			<strong class="system_title"><?php echo $_SESSION["succMsg"];  unset($_SESSION["succMsg"]);?></strong>
             </div>
	  <?php } ?>
      <a class="right" id="visit" href="?page=add-product">Add New Product</a>
      <div class="table-responsive">
      <form name="frm1" method="post" action="" id="frm1">
      <table class="table table-bordered" width="50%" >
			<thead>
			<tr>
			<th style="text-align:center;"><input type="checkbox" name="chk" onclick='checkedAll();' /></th>				
				<th>Product Image</th>
				<th>Product Name</th>
				<th>Product Description</th>
				<th>Product Link</th>
				<th>Brand</th>
				<th>Category</th>
				<th>Status</th>
				<th>Action</th>
			
			</tr>
			</thead>
			<tbody>
            <?php
		/*------------Pagination Part-1------------*/
	if(isset($_GET['pagess']) && $_GET['pagess']!="")
		{	 
		 $page=$_GET['pagess'];
	 	}
	else
		{
		 $page="";
		}	
	 if(!isset($_GET['pagess']))

		$page =1;

	 else

		$page = $page;

	 $adsperpage =3;

	 $StartRow = $adsperpage * ($page-1);

	 $l =  $StartRow.','.$adsperpage;

	 /*-----------------------------------*/
		$userdata1=("select * from wp_product order by id desc limit ".$l);
		
                  $userdata=$wpdb->get_results($userdata1,"ARRAY_A");

		if (!empty($userdata)) 
		{
		foreach($userdata as $contentdata)
			{
	                ?>
			<tr >
			<td valign="top" class="table_check"><input type="checkbox" class="noborder" name="chk[]" value="<?php echo $contentdata['id']; ?>" /></td>
			<td class="table_date" align="center">
			<img src="<?php echo $upload_dir['baseurl'].'/'.$contentdata['product_image']; ?>" class="img-rounded" height="80px" width="100px">
	                         </td>
                                    <td class="table_title" align="center">
                                    <?php echo $contentdata['product_name']; ?>
                                     </td>
				<td class="table_title" align="center">
                                    <?php echo $contentdata['product_info']; ?>
                               </td>
			<td class="table_title" align="center">
                                    <?php echo $contentdata['product_url']; ?>
                         </td>
				 <td class="table_date" align="center">
				<?php 
                        					 $sql1= "select childid,child_name from wp_child where childid=".$contentdata['child_id'];
									$cntrinfo1=$wpdb->get_results($sql1,"ARRAY_A");
									if (!empty($cntrinfo1)) 
									{
										foreach($cntrinfo1 as $cntrinfo)
										{
										echo $cntrinfo['child_name'];
									        }
									}
									?>
                                </td>	 
			<td class="table_date" align="center">
				<?php 
                                                                        $sql1= "select parent_id,parent_name from wp_parent where parent_id=".$contentdata['parent_id'];
									$cntrinfo1=$wpdb->get_results($sql1,"ARRAY_A");
									if (!empty($cntrinfo1)) 
									{
										foreach($cntrinfo1 as $cntrinfo)
										{
										echo $cntrinfo['parent_name'];
									        }
									}
									?>
                                </td>
                                 <td class="table_date">
				<?php echo $contentdata['status']; ?>
                </td>	
                      		<td align="center" ><a href="?page=add-product&id=<?php echo $contentdata['id']; ?>" title="Edit">Edit</a></td>
				
                              </td>
			</tr>
			<?php
			}
			}
			
			else
			{ ?>
			<tr> <td>No Data Found</td></tr>
			<?php
			}
	?>  

			</tbody>
		</table> 
		<tr>
    	<td colspan="4">
        
        <select name="action" id="action" class="selectbox">
			<option value="">Select Action</option>
            <option value="Delete">Delete</option>
            <option value="Active">Active</option>
            <option value="Inactive">Inactive</option>
        </select>
         	 <input type="submit" name="go" value="Go" class="go_button" onclick="return check_box();" />
        </td>
    </tr> 

</form>      				
			<div class="pagination">
				<ul>
			<div class="pagination">
       <?php 
	   	/*----------Pagination Part-2--------------*/
		 $contentdata =$wpdb->get_var("select COUNT(*) from wp_product order by id desc ");
		 $nums = $contentdata;
		 $show = 1;		
		 $total_pages = ceil($nums / $adsperpage);
		$showing   = !isset($_GET["pagess"]) ? 1 : $page;
		$firstlink = "?page=product-manager%2Fproduct-info.php";
		$seperator = '&pagess=';
        	$baselink  = $firstlink; 
		$pgnation = pagination($total_pages, $show, $showing, $firstlink, $baselink, $seperator, $nums);
         	 /*-----------------------------------*/
	  if($total_pages > 1) 
	   echo $pgnation; 
            if($nums==0){
                echo "No records available."; 
            }
	   ?>                                                                                                                        
        </div>
			</ul>
			</div>
            <div class="table_menu">
	    </div>
		</div>

</html>
