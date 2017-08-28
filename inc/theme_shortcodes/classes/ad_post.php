<?php
if (! class_exists ( 'adforest_ad_post' )) {
class adforest_ad_post
{
// user object
var $user_info;

public function __construct()
{
	$this->user_info	=	get_userdata( get_current_user_id() );
}

}
}

// Ad Posting...
add_action('wp_ajax_sb_ad_posting', 'adforest_ad_posting');
if ( ! function_exists( 'adforest_ad_posting' ) ) {
function adforest_ad_posting()
{
	global $adforest_theme;
	
	if( get_current_user_id() == "" )
	{
		echo "0";
		die();
	}

	// Getting values
	$params = array();
    parse_str($_POST['sb_data'], $params);
	
	$cats = array();
	if($params['ad_cat_sub_sub_sub'] != "") { $cats[]	= $params['ad_cat_sub_sub_sub'];}
	if($params['ad_cat_sub_sub']  != "" ){ $cats[]	=  $params['ad_cat_sub_sub'];}
	if($params['ad_cat_sub'] != ""){ $params['ad_cat_sub'];}
	if($params['ad_cat'] != "") {$cats[]	=  $params['ad_cat'];}

	$ad_status	=	 'publish';
	
	if( $_POST['is_update'] != "" )
	{
		if( $adforest_theme['sb_update_approval'] == 'manual' )
		{
			$ad_status	=	'pending';
		}
		$pid	=	$_POST['is_update'];
		
		$is_imageallow = adforestCustomFieldsVals($pid, $cats);  
		$media = get_attached_media( 'image',$pid );
		if($is_imageallow == 1 && count($media) == 0)
		{
			echo "img_req";
			die();
		}
	}
	else
	{
		if( $adforest_theme['sb_ad_approval'] == 'manual' )
		{
			$ad_status	=	'pending';
		}
		$pid	=	get_user_meta ( get_current_user_id(), 'ad_in_progress', true );
		
		$is_imageallow = adforestCustomFieldsVals($pid, $cats);  
		$media = get_attached_media( 'image',$pid );
		if($is_imageallow == 1 && count($media) == 0)
		{
			echo "img_req";
			die();
		}
		
		// Now user can post new ad
		delete_user_meta(get_current_user_id(), 'ad_in_progress');
		
		$simple_ads	=	get_user_meta(get_current_user_id(), '_sb_simple_ads', true);
		if( $simple_ads > 0 && !is_super_admin( get_current_user_id() ) )
		{
			$simple_ads	=	$simple_ads - 1;
			update_user_meta( get_current_user_id(), '_sb_simple_ads', $simple_ads );
		}
		
		update_post_meta($pid, '_adforest_ad_status_', 'active' );
		update_post_meta($pid, '_adforest_is_feature', '0' );
		adforest_get_notify_on_ad_post($pid);
		
	}		
	
	

	
	
	// Bad words filteration
	$words		=	explode( ',', $adforest_theme['bad_words_filter'] );
	$replace	=	$adforest_theme['bad_words_replace'];
	$desc		=	adforest_badwords_filter( $words, $params['ad_description'], $replace );
	$title		=	adforest_badwords_filter( $words, $params['ad_title'], $replace );
	$my_post = array(
	'ID'           => $pid,
	'post_title'   => $title,
	'post_status'   => $ad_status,
	'post_content'   => $desc,
	'post_name' => $title
	);
	
	wp_update_post( $my_post );
	
	$category =	array();
	if( $params['ad_cat'] != "" )
	{
		$category[]	=	$params['ad_cat'];	
	}
	if( $params['ad_cat_sub'] != "" )
	{
		$category[]	=	$params['ad_cat_sub'];	
	}
	if( $params['ad_cat_sub_sub'] != "" )
	{
		$category[]	=	$params['ad_cat_sub_sub'];	
	}
	if( $params['ad_cat_sub_sub_sub'] != "" )
	{
		$category[]	=	$params['ad_cat_sub_sub_sub'];	
	}
	wp_set_post_terms( $pid, $category, 'ad_cats' );
	
	// setting taxonomoies selected
	$type = '';
	if( $params['buy_sell'] != "" )
	{
		$type_arr	=	explode( '|', $params['buy_sell'] );
		wp_set_post_terms( $pid, $type_arr[0], 'ad_type' );
		$type = $type_arr[1];
	}
	$conditon = '';
	if( $params['condition'] != "" )
	{
		$condition_arr	=	explode( '|', $params['condition'] );
		wp_set_post_terms( $pid, $condition_arr[0], 'ad_condition' );
		$conditon	= $condition_arr[1];
	}
	$warranty = '';
	if( $params['ad_warranty'] != "" )
	{
		$warranty_arr	=	explode( '|', $params['ad_warranty'] );
		wp_set_post_terms( $pid, $warranty_arr[0], 'ad_warranty' );
		$warranty	= $warranty_arr[1];
	}
	
	$tags	=	explode(',', $params['tags'] );
	wp_set_object_terms($pid, $tags, 'ad_tags');
	
	// Update post meta
	update_post_meta($pid, '_adforest_poster_name', $params['sb_user_name'] );
	update_post_meta($pid, '_adforest_poster_contact', $params['sb_contact_number'] );
	update_post_meta($pid, '_adforest_ad_location', $params['sb_user_address'] );
	update_post_meta($pid, '_adforest_ad_type', $type);
	update_post_meta($pid, '_adforest_ad_condition', $conditon );
	update_post_meta($pid, '_adforest_ad_warranty', $warranty );
	update_post_meta($pid, '_adforest_ad_price', $params['ad_price'] );
	update_post_meta($pid, '_adforest_ad_map_lat', $params['ad_map_lat'] );
	update_post_meta($pid, '_adforest_ad_map_long', $params['ad_map_long'] );
	update_post_meta($pid, '_adforest_ad_bidding', $params['ad_bidding'] );
	update_post_meta($pid, '_adforest_ad_price_type', $params['ad_price_type'] );
	if( isset( $params['ad_yvideo'] ) && $params['ad_yvideo'] != "" )
	{

		update_post_meta($pid, '_adforest_ad_yvideo', $params['ad_yvideo'] );
	}
	
	
	// Stroring Extra fileds in DB
	if( $params['sb_total_extra'] > 0 )
	{
		for( $i = 1; $i <= $params['sb_total_extra']; $i++ )
		{
			update_post_meta($pid, "_sb_extra_" . $params["title_$i"], $params["sb_extra_$i"] );
		}
	}
	//Add Dynamic Fields
	if( isset($params['cat_template_field']) && count( $params['cat_template_field'] ) > 0)
	{
		foreach($params['cat_template_field'] as $key => $data)
		{
			if( is_array($data) )
			{
				$dataArr = array();
				foreach($data as $k ) $dataArr[] = $k; 
				$data = stripslashes(json_encode($dataArr, true));
			}
   			update_post_meta($pid, $key, $data );
		}
	}		
	// Making Location DB
		
	// explode address
	if( $params['ad_map_lat'] == "" && $params['ad_map_long'] )
	{
		$address	=	explode(',', $params['sb_user_address'] );
		if( count( $address ) == 3 )
		{
			$city	=	trim( $address[0] );
			$state	=	trim( $address[1] );
			$country	=	trim( $address[2] );
			adforest_add_location( $country, $state, $city );
		}
		else if( count( $address ) == 2 )
		{
			$city	=	trim( $address[0] );
			$country	=	trim( $address[1] );
			$state	=	'';
			adforest_add_location( $country, $state, $city );
		}
	}

	
	echo get_the_permalink( $pid );
	
	die();	

	
}
}

// Get sub cats
add_action('wp_ajax_sb_get_sub_cat_search', 'adforest_get_sub_cats_search');
add_action( 'wp_ajax_nopriv_sb_get_sub_cat_search', 'adforest_get_sub_cats_search' );
if ( ! function_exists( 'adforest_get_sub_cats_search' ) ) {
function adforest_get_sub_cats_search()
{
	$cat_id	=	$_POST['cat_id'];
	$ad_cats	=	adforest_get_cats('ad_cats' , $cat_id );
	$res	=	'';
	if( count( $ad_cats ) > 0 )
	{
		$res	=	'<label>'.adforest_get_taxonomy_parents( $cat_id, 'ad_cats', false).'</label>';
		$res	.= '<ul class="city-select-city" >';
		foreach( $ad_cats as $ad_cat )
		{
			$id	=	'ajax_cat';
			$res .= '<li class="col-sm-3 col-xs-4"><a href="javascript:void(0);" data-cat-id="'.esc_attr( $ad_cat->term_id ). '" id="'.$id.'">'.$ad_cat->name.' (' . $ad_cat->count. ')</a></li>';	
		}
		$res	.= '</ul>';
		echo($res);
	}
	else
	{
		echo "submit";
	}
	die();
}
}


// Get sub cats
add_action('wp_ajax_sb_get_sub_cat', 'adforest_get_sub_cats');
if ( ! function_exists( 'adforest_get_sub_cats' ) ) {
function adforest_get_sub_cats()
{
	$cat_id	=	$_POST['cat_id'];
	$ad_cats	=	adforest_get_cats('ad_cats' , $cat_id );
	if( count( $ad_cats ) > 0 )
	{
		$cats_html	=	'<select class="category form-control" id="ad_cat_sub" name="ad_cat_sub">';
		$cats_html	.=	'<option label="Select Option"></option>';
		foreach( $ad_cats as $ad_cat )
		{
			$cats_html	.=	'<option value="'.$ad_cat->term_id.'">' . $ad_cat->name .  '</option>';
		}
		$cats_html	.=	'</select>';
		echo($cats_html);
		die();
	}
	else
	{
		echo "";
		die();
	}
}
}


if ( ! function_exists( 'adforest_check_author' ) ) {
function adforest_check_author( $ad_id )
{
	if( get_post_field( 'post_author', $ad_id ) != get_current_user_id() )
	{
		return false;
	}
	else
	{
		return true;	
	}
}
}


add_action('wp_ajax_post_ad', 'adforest_post_ad_process');
if ( ! function_exists( 'adforest_post_ad_process' ) ) {
function adforest_post_ad_process()
{
	
	if( $_POST['is_update'] != "")
	{
		die();
	}
	
	
	$title	=	$_POST['title'];

	if( get_current_user_id() == "" )
		die();
		
	if( !isset( $title ) )
		die();
	
	$ad_id	=	get_user_meta ( get_current_user_id(), 'ad_in_progress', true );	
	if( $ad_id != "" )
	{
		$my_post = array(
			'ID'           => get_user_meta ( get_current_user_id(), 'ad_in_progress', true ),
			'post_title'   => $title,
		);
		wp_update_post( $my_post );	
		die();	
	}


		
	// Gather post data.
$my_post = array(
    'post_title'    => $title,
    'post_status'   => 'pending',
    'post_author'   => get_current_user_id(),
    'post_type' => 'ad_post'
);
 
// Insert the post into the database.
$id	=  wp_insert_post( $my_post );
if( $id )
{
	update_user_meta( get_current_user_id(), 'ad_in_progress', $id );	
}

die();
}
}


add_action('wp_ajax_delete_ad_image', 'adforest_delete_ad_image');
if ( ! function_exists( 'adforest_delete_ad_image' ) ) {
function adforest_delete_ad_image()
{
	if( get_current_user_id() == "" )
		die();
	
	
	if( $_POST['is_update'] != "" )
	{
		$ad_id	=	$_POST['is_update'];
	}
	else
	{
		$ad_id	=	get_user_meta ( get_current_user_id(), 'ad_in_progress', true );
	}
	 
	 if( !is_super_admin( get_current_user_id() ) && get_post_field( 'post_author', $ad_id ) != get_current_user_id() )
	 	die();
	
	
	$attachmentid	=	$_POST['img'];	
	wp_delete_attachment( $attachmentid, true );
	echo "1";
	die();
}
}


add_action('wp_ajax_upload_ad_images', 'adforest_upload_ad_images');
if ( ! function_exists( 'adforest_upload_ad_images' ) ) {
function adforest_upload_ad_images(){
	
	global $adforest_theme;
	
	adforest_authenticate_check();
	
	require_once ABSPATH . 'wp-admin/includes/image.php';
	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/media.php';
	
	$size_arr	=	explode( '-', $adforest_theme['sb_upload_size'] );
	$display_size	=	$size_arr[1];
	$actual_size	=	$size_arr[0];
	
	// Allow certain file formats
	$imageFileType	=	strtolower(end( explode('.', $_FILES['my_file_upload']['name'] ) ));
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
	&& $imageFileType != "gif" )
	{
		echo '0|' . __( "Sorry, only JPG, JPEG, PNG & GIF files are allowed.", 'adforest' );
		die();
	}
	 
	 // Check file size
	if ($_FILES['my_file_upload']['size'] > $actual_size) 
	{
		echo '0|' . __( "Max allowd image size is", 'adforest' ) . " " . $display_size;
		die();
	}
	
	
	// Let WordPress handle the upload.
	// Remember, 'my_image_upload' is the name of our file input in our form above.
	if( $_GET['is_update'] != "" )
	{
		$ad_id	=	$_GET['is_update'];
	}
	else
	{
		$ad_id	=	get_user_meta ( get_current_user_id(), 'ad_in_progress', true );
	}
	
	// Check max image limit
	$media = get_attached_media( 'image',$ad_id );
	if( count( $media ) >= $adforest_theme['sb_upload_limit'] )
	{
		echo '0|' . __( "You can not upload more than ", 'adforest' ) . " " . $adforest_theme['sb_upload_limit'];
		die();
	}
	
	echo($attachment_id = media_handle_upload( 'my_file_upload', $ad_id ));
	die();
    

}
}


add_action('wp_ajax_get_uploaded_ad_images', 'adforest_get_uploaded_ad_images');
if ( ! function_exists( 'adforest_get_uploaded_ad_images' ) ) {
function adforest_get_uploaded_ad_images()
{
	if( $_POST['is_update'] != "" )
	{
		$ad_id	=	$_POST['is_update'];
	}
	else
	{
		$ad_id	=	get_user_meta ( get_current_user_id(), 'ad_in_progress', true );
	}


	$media = get_attached_media( 'image',$ad_id );
	$result	=	array();
	foreach( $media as $m )
	{
		$obj	=	array();
		$obj['name'] = $m->guid;
		$obj['size'] = filesize( get_attached_file( $m->ID ) );
		$obj['id'] = $m->ID;
		$result[] = $obj;	
	}
	header('Content-type: text/json');
	header('Content-type: application/json');
	echo json_encode($result);
	die();
}
}


if ( ! function_exists( 'adforest_delete_post_taxonomies' ) ) {
function adforest_delete_post_taxonomies( $object_id, $taxonomy )
{
	global $wpdb;
	$rows = $wpdb->get_results( "SELECT term_taxonomy_id FROM $wpdb->term_relationships WHERE object_id = '$object_id'" );
	if( count( $rows ) > 0 )
	{
		foreach( $rows as $row )
		{
			$rs = $wpdb->get_row( "SELECT taxonomy FROM $wpdb->term_taxonomy WHERE term_taxonomy_id = '".$row->term_taxonomy_id."'" );
			if( $rs->taxonomy == $taxonomy )
			{
				echo "DELETE FROM $wpdb->term_relationships WHERE object_id = '$object_id' AND term_taxonomy_id = '".$row->term_taxonomy_id."'";
				
				$wpdb->delete( $wpdb->term_relationships, array( 'object_id' => $object_id, 'term_taxonomy_id' => $row->term_taxonomy_id ) );	
			}	
			
		}
	}
}
}


if ( ! function_exists( 'adforest_get_ad_cats' ) ) {
function adforest_get_ad_cats( $id , $by = 'name' )
{
	$post_categories = wp_get_object_terms( $id,  array('ad_cats'), array('orderby' => 'term_group') );
	$cats = array();
	foreach($post_categories as $c)
	{
		$cat = get_category( $c );
		$cats[] = array( 'name' => $cat->name, 'id' => $cat->term_id );
	}
	return $cats;
}
}


// Get all messages of particular ad
add_action('wp_ajax_sb_get_messages', 'adforest_get_messages');
if ( ! function_exists( 'adforest_get_messages' ) ) {
function adforest_get_messages()
{
	adforest_authenticate_check();
	
	$ad_id	=	$_POST['ad_id'];
	$user_id	=	$_POST['user_id'];
	$authors	=	array( $user_id, get_current_user_id() );
	
	// Mark as read conversation
	update_comment_meta( get_current_user_id(), $ad_id."_".$user_id, 1 );

	
	$parent	=	$user_id;
	if( $_POST['inbox'] == 'yes' )
	{
		$parent	=	get_current_user_id();
	}
	$args = array(
		'author__in' => $authors,
		'post_id' => $ad_id,
		'parent' => $parent,
		'orderby' => 'comment_date',
		'order' => 'ASC',
	);
	$comments	=	get_comments( $args );
	$messages	=	'';
	$i = 1;
	$total	=	count( $comments );
	if( count( $comments ) > 0 )
	{
		foreach( $comments as $comment )
		{
			$user_pic	=	'';
			$class	=	'friend-message';
			if( $comment->user_id == get_current_user_id() )
			{
				$class = 'my-message';	
			}
			$user_pic =	adforest_get_user_dp( $comment->user_id );
			$id		=	'';
			if( $i ==  $total )
			{
				$id	=	'id="last_li"';
			}
			$i++;
			$messages .= '<li class="'.$class.' clearfix" '.$id.'>
							 <figure class="profile-picture">
								<img src="'.$user_pic.'" class="img-circle" alt="'.__('Profile Pic','adforest').'">
							 </figure>
							 <div class="message">
								'.$comment->comment_content .'
								<div class="time"><i class="fa fa-clock-o"></i> '.adforest_timeago($comment->comment_date ).'</div>
							 </div>
						  </li>';	
		}
	}
	echo($messages);
	die();
}
}


if ( ! function_exists( 'adforest_authenticate_check' ) ) {
function adforest_authenticate_check()
{
	if( get_current_user_id() == "" )
	{
		echo '0|' . __( "You are not logged in.", 'adforest' );
		die();
	}
}
}

if ( ! function_exists( 'adforestCustomFieldsVals' ) ) {
function adforestCustomFieldsVals($post_id = '', $terms = array())
{
 if($post_id == "") return;
    /*$terms = wp_get_post_terms($post_id, 'ad_cats');*/
	 $is_show = '';
	 if(count($terms) > 0 )
	 {
	
	   foreach ($terms as $term) 
	   {
		   $term_id = $term; 
		   $t = adforest_dynamic_templateID($term_id);
		   if($t) break;
	   }  
	  $templateID = adforest_dynamic_templateID($term_id);
	  $result = get_term_meta( $templateID , '_sb_dynamic_form_fields' , true); 
	
	   $is_show = '';
	   $html = '';
	
	   if(isset($result) && $result != "")
	   {
	   $is_show = sb_custom_form_data($result, '_sb_default_cat_image_required'); 
	   }
	  }
	 return ($is_show == 1) ? 1 : 0;
}
}