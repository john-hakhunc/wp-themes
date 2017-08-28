<?php global $adforest_theme; 
?>
<?php
	$layout = 'default';
	if( isset( $adforest_theme['footer_style'] ) )
	{
		$layout= $adforest_theme['footer_style'];
	}
get_template_part( 'template-parts/layouts/footer', $layout );

if ( in_array( 'sb_framework/index.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) )
{
	if ( is_rtl() ) {
?>

<input type="hidden" id="is_rtl" value="1" />
<?php
	}
	$is_single	=	0;
	if( is_singular( 'ad_post' ) ) {
		$is_single = 1;
	}
?>
<input type="hidden" id="is_rtl" value="0" />
<input type="hidden" id="is_single_ad" value="<?php echo esc_attr( $is_single ); ?>" />
<input type="hidden" id="profile_page" value="<?php echo get_the_permalink( $adforest_theme['sb_profile_page'] ); ?>" />
<input type="hidden" id="login_page" value="<?php echo get_the_permalink( $adforest_theme['sb_sign_in_page'] ); ?>" />
<input type="hidden" id="theme_path" value="<?php echo trailingslashit( get_template_directory_uri () ); ?>" />
<input type="hidden" id="adforest_ajax_url" value="<?php echo admin_url( 'admin-ajax.php' ); ?>" />
<input type="hidden" id="adforest_forgot_msg" value="<?php echo __( 'Password reset link sent to your email.', 'adforest' ); ?>" />
<input type="hidden" id="adforest_profile_msg" value="<?php echo __( 'Profile saved successfully.', 'adforest' ); ?>" />
<input type="hidden" id="adforest_max_upload_reach" value="<?php echo __( 'Maximum upload limit reached', 'adforest' ); ?>" />
<input type="hidden" id="not_logged_in" value="<?php echo __( 'You have been logged out.', 'adforest' ); ?>" />
<input type="hidden" id="sb_upload_limit" value="<?php echo esc_attr( $adforest_theme['sb_upload_limit'] ); ?>" />

<input type="hidden" id="facebook_key" value="<?php echo esc_attr( $adforest_theme['fb_api_key'] ); ?>" />
<input type="hidden" id="google_key" value="<?php echo esc_attr( $adforest_theme['gmail_api_key'] ); ?>" />
<input type="hidden" id="confirm_delete" value="<?php echo __( 'Are you sure to delete this?', 'adforest' ); ?>" />
<input type="hidden" id="confirm_update" value="<?php echo __( 'Are you sure to update this?', 'adforest' ); ?>" />
<input type="hidden" id="ad_updated" value="<?php echo __( 'Ad updated successfully.', 'adforest' ); ?>" />
<input type="hidden" id="redirect_uri" value="<?php echo esc_url( $adforest_theme['redirect_uri'] ); ?>" />
<input type="hidden" id="select_place_holder" value="<?php echo __( 'Select an option', 'adforest' ); ?>" />
<input type="hidden" id="is_sticky_header" value="<?php echo esc_attr( $adforest_theme['sb_sticky_header'] ); ?>" />
<input type="hidden" id="required_images" value="<?php echo __( 'Images are required.', 'adforest' ); ?>" />
<input type="hidden" id="is_sub_active" value="1" />
<?php 
$yes	=	0;
$not_time	=	'';
if( isset( $adforest_theme['msg_notification_on'] ) && isset( $adforest_theme['communication_mode'] ) && ( $adforest_theme['communication_mode'] == 'both' || $adforest_theme['communication_mode'] == 'message' ) )
{
	
		$yes	=	$adforest_theme['msg_notification_on'];
		$not_time	=	$adforest_theme['msg_notification_time'];
}
global $wpdb;
$user_id	=	get_current_user_id();
$unread_msgs = $wpdb->get_var( "SELECT COUNT(*) FROM $wpdb->commentmeta WHERE comment_id = '$user_id' AND meta_value = '0' " );
?>
<input type="hidden" id="msg_notification_on" value="<?php echo esc_attr( $yes ); ?>" />
<input type="hidden" id="msg_notification_time" value="<?php echo esc_attr( $not_time ); ?>" />
<input type="hidden" id="is_unread_msgs" value="<?php echo esc_attr( $unread_msgs ); ?>" />

<?php
	}
	else
	{
?>
<input type="hidden" id="is_sub_active" value="0" />
<?php
	}
// Password Reset Html	
if( isset( $_GET['token'] ) && $_GET['token'] != "" && !is_user_logged_in() )
{
?>
<input type="hidden" id="adforest_password_mismatch_msg"  value="<?php echo __( 'Password not matched.', 'adforest' ); ?>" />
<div id="sb_reset_password_modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
       <!-- Modal content-->
       <div class="modal-content">
          <div class="modal-header rte">
             <h2 class="modal-title"><?php echo  __( 'Set your Password','adforest' ); ?></h2>
          </div>
          		<form id="sb-reset-password-form">
				 <div class="modal-body">
					<div class="form-group">
					  <label><?php echo __( 'New Password','adforest' ); ?></label>
					  <input placeholder="<?php echo  __( 'Enter Password','adforest' ); ?>" class="form-control" type="password" data-parsley-required="true" data-parsley-error-message="<?php echo __( 'This field this required.', 'adforest' ); ?>" data-parsley-trigger="change" name="sb_new_password" id="sb_new_password">
					</div>
					<div class="form-group">
					  <label><?php echo __( 'Confirm New Password','adforest' ); ?></label>
					  <input placeholder="<?php echo  __( 'Confirm Password','adforest' ); ?>" class="form-control" type="password" data-parsley-required="true" data-parsley-error-message="<?php echo __( 'This field this required.', 'adforest' ); ?>" data-parsley-trigger="change" name="sb_confirm_new_password" id="sb_confirm_new_password">
					</div>
                 </div>
				 <div class="modal-footer">
                 <br />
					   <button class="btn btn-theme btn-sm" type="submit" id="sb_reset_password_submit"><?php echo __( 'Change Password','adforest' ); ?></button>
					   <button class="btn btn-theme btn-sm" type="button" id="sb_reset_password_msg"><?php echo __( 'Processing...','adforest' ); ?></button>
                       <input type="hidden" name="token" value="<?php echo $_GET['token']; ?>" />
					<br /><br />
				 </div>
		  </form>
          </div>
    </div>
 </div>
 <?php
}
?>
    <!-- Post Ad Sticky -->
    <?php get_template_part( 'template-parts/layouts/sell','button' ); ?>
    <!-- Back To Top -->
    <?php get_template_part( 'template-parts/layouts/scroll','up' ); ?>
    
    <?php  echo wp_kses( $adforest_theme['footer_js_and_css'], adforest_required_tags() ); ?>
    <?php wp_footer(); ?>
   </body>
</html>

