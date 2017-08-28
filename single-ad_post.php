<?php get_header(); ?>
<?php global $adforest_theme; ?>
<?php 
/* Only need on this page so inluded here don't want to increase page size for optimizaion by adding extra scripts in all the web*/
wp_enqueue_script( 'adforest-search');
if ( have_posts() )
{ 
    while ( have_posts() )
    { the_post();
		$aid	=	get_the_ID();
		// Make expired to featured ad
		if( get_post_meta($aid, '_adforest_is_feature', true ) == '1' && $adforest_theme['featured_expiry'] != '-1' )
		{
			if(isset( $adforest_theme['featured_expiry'] ) &&  $adforest_theme['featured_expiry'] != '-1' )
			{
				$now = time(); // or your date as well
				$featured_date	= strtotime(get_post_meta( $aid, '_adforest_is_feature_date', true ));
	
				$featured_days	= adforest_days_diff( $now, $featured_date );
				$expiry_days	=	$adforest_theme['featured_expiry'];
				if( $featured_days > $expiry_days )
				{
					update_post_meta( $aid, '_adforest_is_feature', 0 );
				}
			}
		}
		
		adforest_setPostViews( $aid );
	
		get_template_part( 'template-parts/layouts/ad_style/style', $adforest_theme['ad_layout_style'] );
	}
}
else
{
    get_template_part( 'template-parts/content', 'none' );
}
get_footer(); ?>