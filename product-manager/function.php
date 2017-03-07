<?php

//function load data front end//


function allDataLoad()
{
global $wpdb,$current_user;
?>

<form name="frm1" method="post" action=""  onchange="ajax_data_load(this.value,'00');">
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

	 $adsperpage =10;
	 $StartRow = $adsperpage * ($page-1);
	 $l =  $StartRow.','.$adsperpage;
	 /*-----------------------------------*/
		                                        if(isset($_REQUEST['cntsate']) and $_REQUEST['cntsate']>=1)
								$whrcnd= " and  childid= '".$_REQUEST['cntsate']."' ";
								else
								$whrcnd=" and  childid= '' ";
			                                        $query = "select * from wp_product where child_id='".$_REQUEST['cntsate']."' and status='Active' ";
								 $data2 = $wpdb->get_results($query,"ARRAY_A");
								if(!empty($data2))
							       {
								foreach($data2 as $load_all_datas)
                                                                {
							       ?>
							<div class=" product-details-blk">
          				         	<div class=" product-img-blk">
             <a href="<?php  echo $load_all_datas['product_url']?>"><img height="80px;" width="100px" src="<?php echo home_url();?>/wp-content/uploads/<?php echo $load_all_datas['product_image'];?>" />
						        </div>
							<div class=" product-desc-blk">
							<p class="product-name"><?php echo $load_all_datas['product_name']; ?></p></a>
							<p><?php         $sql1= "select childid,child_name from wp_child where childid=".$load_all_datas['child_id'];
									 $cntrinfo1=$wpdb->get_results($sql1,"ARRAY_A");
									 if (!empty($cntrinfo1)) 
									  {
										foreach($cntrinfo1 as $cntrinfo)
										{
										echo $cntrinfo['child_name'];
									        }
									  }?></br>
				                                  <?php  $sql1= "select parent_id,parent_name from wp_parent where parent_id=".$load_all_datas['parent_id'];
									 $cntrinfo1=$wpdb->get_results($sql1,"ARRAY_A");
									 if (!empty($cntrinfo1)) 
									   {
										foreach($cntrinfo1 as $cntrinfo)
										{
										echo $cntrinfo['parent_name'];
									        }
									   }?>
						             			<p class="product-info"><?php echo $load_all_datas['product_info']; ?></p>
									</div>       
							</div>
					<?php
						}
						}
					else
						{ ?>
			
						<?php
						}
?>
				
</form>      


<?php	die();							
}
add_action('wp_ajax_check_dataload', 'allDataLoad');
add_action('wp_ajax_nopriv_check_dataload', 'allDataLoad');

function allParentLoad()
{
global $wpdb,$current_user;
?>

				<select  class="form-control" name="child_id" id="child_id" onchange="loadalldata(this.value,'00');" >
                                <option value="">Select Brand</option>
                                <?php
								if(isset($_REQUEST['cntsate']) and $_REQUEST['cntsate']>=1)
								$whrcnd= " and  parentid= '".$_REQUEST['cntsate']."' ";
								else
								
								$whrcnd='';
								$query = "select child_name,childid from wp_child where status='Active' ".$whrcnd." ORDER BY child_name ASC ";
								 $data2 = $wpdb->get_results($query,"ARRAY_A");
								if(!empty($data2))
								{
								foreach($data2 as $load_all_datas)
                                                                {
                                ?>
            <option value="<?php echo $load_all_datas['childid']; ?>" <?php if($load_all_datas['childid']==$_REQUEST['c_id']){ ?>selected="true" <?php } ?>> <?php echo $load_all_datas['child_name']; ?></option>
                                <?php } }?>

								</select>

													
<?php	die();							
}

add_action('wp_ajax_check_parentload', 'allParentLoad');
add_action('wp_ajax_nopriv_check_parentload', 'allParentLoad');

    // Create Database //
global $jal_db_version;
$jal_db_version = '1.0';

function jal_install_child() {
	global $wpdb;
	global $jal_db_version;

	$table_name = $wpdb->prefix . 'child';
	
	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE $table_name (
  `childid` mediumint(9) AUTO_INCREMENT NOT NULL,
  `parentid` int(11) NOT NULL,
  `child_name` varchar(500) NOT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
    primary key (childid)
)  $charset_collate;";


	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );

	add_option( 'jal_db_version', $jal_db_version );
}
function jal_install_parent() {
	global $wpdb;
	global $jal_db_version;

	$table_name = $wpdb->prefix . 'parent';
	
	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE IF NOT EXISTS $table_name (
		  `parent_id`  mediumint(9) AUTO_INCREMENT NOT NULL,
		  `parent_code` varchar(100) NOT NULL,
		  `parent_name` varchar(100) NOT NULL,
		  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
			primary key (parent_id)
		) $charset_collate;";


	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );

	add_option( 'jal_db_version', $jal_db_version );
}


function jal_install_product() {
	global $wpdb;
	global $jal_db_version;

	$table_name = $wpdb->prefix . 'product';
	
	$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE IF NOT EXISTS $table_name  (
	  `id` mediumint(9) AUTO_INCREMENT NOT NULL,
	  `product_name` varchar(150) NOT NULL,
	  `product_info` varchar(500) NOT NULL,
	  `city_id` varchar(100) NOT NULL,
	  `child_id` varchar(100) NOT NULL,
	  `parent_id` varchar(100) NOT NULL,
	  `product_url` varchar(500) NOT NULL,
	  `product_image` varchar(500) NOT NULL,
	  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
		primary key (id)
	   )$charset_collate;";


	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );

	add_option( 'jal_db_version', $jal_db_version );
}
?>


