<?php
/*
Plugin Name: Dropdown Short Code 
Description: To show the product front end and sort by droupdown and search box   
Version: 1.0
Author: Akshay Dalvi
*/
?>

<?php

admin_url('admin-ajax.php'); 
function adding_custom_button($atts) {
	extract(shortcode_atts(array('link' => 'abc'), $atts));
?>
	<script type="text/javascript">
    	var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
	</script>

	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" type="text/css" rel="stylesheet">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script src="//code.jquery.com/jquery-1.9.1.js"></script>
	<script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
    <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
   
    <link href="../wp-content/plugins/Dropudown-Frontpage/Plugin-style.css" type="text/css" rel="stylesheet" />
<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <script>
        // When the browser is ready...
        $(function() {
                jQuery.validator.addMethod("integer", function(value, element) {
                    return this.optional(element) || /^-?\d+$/.test(value);
                }, "A positive or negative non-decimal number please");
                jQuery.validator.addMethod('positivePrice', function(value) {
                    return Number(value) > 0;
                }, 'Enter a positive number.');
                jQuery.validator.addMethod("letterspaceonly", function(value, element) {
                    return this.optional(element) || /^([a-z]+([\s][a-z]+)?)+$/i.test(value);
                }, "Letters and Single space only");

                jQuery.validator.addMethod("alphanumeric", function(value, element) {
                    return this.optional(element) || /^[A-Z|a-z]{4}[0][\d]{6}$/.test(value);
                }, "");

                jQuery.validator.addMethod("extension", function(value, element, param) {
                    param = typeof param === "string" ? param.replace(/,/g, '|') : "png|jpe?g|gif";
                    return this.optional(element) || value.match(new RegExp(".(" + param + ")$", "i"));
                }, jQuery.format("File must be jpg, gif or png. "));

                $.validator.addMethod('filesize', function(value, element, param) {
                    // param = size (en bytes) 
                    // element = element to validate (<input>)
                    // value = value of the element (file name)
                    return this.optional(element) || (element.files[0].size <= param)
                });
                var pre_image = jQuery("#pre_image").val(); // #pre_image is id for hidden field
            }
        }
        </script>
        <script language="javascript">
        function loadallparent(cntsate, stsval) {
            var action_run = 'check_parentload';
            jQuery.ajax({
                url: ajaxurl,
                type: "POST",
                cache: false,
                //data: {action:action_run,cityid:stsval,cntsate:cntsate},
                data: {
                    action: action_run,
                    cntsate: cntsate
                },
                success: function(html) {
                    //jQuery('.abc').html('');
                    //$('.abc').hide();
                    jQuery('#ajax_child_load').html(html);
                    if (cntsate >= 1 && stsval == '00')
                        loadalldata('00', '00');
                }
            });
        }

        function loadalldata(cntsate, cval) {
            var action_run = 'check_dataload';
            jQuery.ajax({
                url: ajaxurl,
                type: "POST",
                cache: false,
                data: {
                    action: action_run,
                    cntsate: cntsate
                },
                success: function(html) {
                    //jQuery('.abc').html('');
                    $('.abc').hide();
                    jQuery('#ajax_cid_load').html(html);
                }
            });

        }
        </script>
        <?php
$current_user = wp_get_current_user();
$_SESSION['user_id'] = $current_user->ID;
$user = new WP_User( $_SESSION['user_id'] );
 $user->roles[0];
require_once ('paging.php');
extract($_POST);
$upload_dir = wp_upload_dir(); 
global $wpdb,$current_user;
?>
            <div id="postedit" class="clearfix">
                <h2 class="ico_mug">
		<?php if($_GET['id']=='') {?>
                    <?php } else { 
                        $res=$wpdb->get_row("select * from wp_product where id=".$_GET['id']."","ARRAY_A");
                  ?> 
                  <?php }  ?>
               </h2>
            </div>
            <form name="addproductinfo" id="addproductinfo" method="post" enctype="multipart/form-data">
                <h4 class="title">Filter by Category</h4>
                <div class="form-data">
                    <div class="col-md-4 form-data-parent form-col">
                        <select class="form-control" name="parent_id" id="parent_id" onchange="loadallparent(this.value,'00');">
                            <option value="">Select Category</option>
                            <?php
				       $sql1= "select parent_id,parent_name from wp_parent where status='Active'";
				       $cntrdata =$wpdb->get_results($sql1,"ARRAY_A");
					  if (!empty($cntrdata)) 
					   {
					    foreach($cntrdata as $country_datas)
					     {?>
                                <option value="<?php echo $country_datas['parent_id']; ?>" <?php if($country_datas[ 'parent_id']==$res[ 'parent_id']){ ?>selected="true"
                                    <?php } ?>>
                                    <?php echo $country_datas['parent_name']; ?>
                                </option>
                                <?php } 
				    } ?>
                        </select>
                    </div>
                    <div class="col-md-4 form-data-child form-col">
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
                            jQuery(document).ready(function() {
                                loadallparent('<?php echo $cntid;?>', '<?php echo $stid;?>');
                                //alert('loadallparent'); 
                            });
                            </script>
                            <div id="ajax_child_load"></div>
                    </div>
            </form>
            <form method="GET" class="col-md-4 form-col">
                <input type="text" class="form-control" name="srchval" placeholder="Product Name">
            </form>
            <div id="resultsContainer">
                <?php 
/*------------Pagination Part-1------------*/
	if(isset($_GET['pages']) && $_GET['pages']!="")
		{	 
		 $page=$_GET['pages'];
	 	}
	else
		{
		 $page="";
		}	
	 if(!isset($_GET['pages']))

		$page =1;

	 else

		$page = $page;

	 $adsperpage =8;

	 $StartRow = $adsperpage * ($page-1);

	 $l =  $StartRow.','.$adsperpage;

	 /*-----------------------------------*/

?>
                <div class="pagination">
                    <ul>
                        <div class="pagination">
                            <?php 
	   	/*----------Pagination Part-2--------------*/
		 $load_all_datas =$wpdb->get_var("select COUNT(*) from wp_product order by id desc ");
		 $nums = $load_all_datas;
		 $show = 1;		
		 $total_pages = ceil($nums / $adsperpage);
		$showing   = !isset($_GET["pages"]) ? 1 : $page;
		$firstlink = "?page=list-product";
		$seperator = '&pages=';
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
            <?php


					if(isset($_REQUEST['srchval']) && $_REQUEST['srchval']!='')
					{
					$query222 = "select * from wp_product where product_name LIKE '%".$_REQUEST['srchval']."%' and status='Active'";
					}
					else
					{
					$query222 = ("select * from wp_product order by id desc limit ".$l);
					}
					$data2 = $wpdb->get_results($query222,"ARRAY_A");
					if(!empty($data2))
					{
					foreach($data2 as $load_all_datas)
                                        {?>
                <div class="row abc">
                    <div class="col-md-4 product-img-blk">
                        <a href="<?php  echo $load_all_datas['product_url']?>"><img height="200px" width="200px" src="<?php echo home_url();?>/wp-content/uploads/<?php echo $load_all_datas['product_image'];?>" />
				           	   </div>
					          
                                <div class="col-md-8 product-desc-blk">
							<p class="product-name"><?php echo $load_all_datas['product_name']; ?></p></a>
                        <p>
                            <?php         $sql1= "select childid,child_name from wp_child where childid=".$load_all_datas['child_id'];
									 $cntrinfo1=$wpdb->get_results($sql1,"ARRAY_A");
									 if (!empty($cntrinfo1)) 
									  {
										foreach($cntrinfo1 as $cntrinfo)
										{
										echo $cntrinfo['child_name'];
									        }
									  }?>
                            </br>
                            <?php  $sql1= "select parent_id,parent_name from wp_parent where parent_id=".$load_all_datas['parent_id'];
									 $cntrinfo1=$wpdb->get_results($sql1,"ARRAY_A");
									 if (!empty($cntrinfo1)) 
									   {
										foreach($cntrinfo1 as $cntrinfo)
										{
										echo $cntrinfo['parent_name'];
									        }
									   }?>
                            <p class="product-info">
                                <?php echo $load_all_datas['product_info']; ?>
                            </p>
                    </div>
                </div>
                <?php
						}
						}
			
						else
						{  ?>
                    <?php }  ?>
                    <div class="row product-details-blk">
                        <div id="ajax_cid_load"></div>
                        <?php// Load Data Droupdo?>
                    </div>
                    </div>
                    <div class="pagination">
                        <ul>
                            <div class="pagination">
                                <?php 
	   	/*----------Pagination Part-2--------------*/
		 $load_all_datas =$wpdb->get_var("select COUNT(*) from wp_product order by id desc ");
		 $nums = $load_all_datas;
		 $show = 2;		
		 $total_pages = ceil($nums / $adsperpage);
		$showing   = !isset($_GET["pages"]) ? 1 : $page;
		$firstlink = "?page=list-product";
		$seperator = '&pages=';
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
                    <?php
}
 add_shortcode('Akshay-dropdown', 'adding_custom_button');
?>
