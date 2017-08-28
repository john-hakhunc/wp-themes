<?php
 /* Template Name: Ad Search */ 
/**
 * The template for displaying Pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Adforest
 */

?>
<?php get_header(); ?>
<?php global $adforest_theme;
adforest_load_search_countries();
/* Only need on this page so inluded here don't want to increase page size for optimizaion by adding extra scripts in all the web */
wp_enqueue_script( 'google-map-callback');
wp_enqueue_script( 'adforest-search');

	$meta	=	array( 
			'key'     => 'post_id',
			'value'   => '0',
			'compare' => '!=',
	);
	$condition	=	'';
	if( isset( $_GET['condition'] ) && $_GET['condition'] != "" )
	{
		$condition	=	array(
			'key'     => '_adforest_ad_condition',
			'value'   => $_GET['condition'],
			'compare' => '=',
		);	
	}
	$ad_type	=	'';
	if( isset( $_GET['ad_type'] ) && $_GET['ad_type'] != "" )
	{
		$ad_type	=	array(
			'key'     => '_adforest_ad_type',
			'value'   => $_GET['ad_type'],
			'compare' => '=',
		);	
	}
	$warranty	=	'';
	if( isset( $_GET['warranty'] ) && $_GET['warranty'] != "" )
	{
		$warranty	=	array(
			'key'     => '_adforest_ad_warranty',
			'value'   => $_GET['warranty'],
			'compare' => '=',
		);	
	}
	$feature_or_simple	=	'';
	if( isset( $_GET['ad'] ) && $_GET['ad'] != "" )
	{
		$feature_or_simple	=	array(
			'key'     => '_adforest_is_feature',
			'value'   => $_GET['ad'],
			'compare' => '=',
		);	
	}
	$price	=	'';
	if( isset( $_GET['min_price'] ) && $_GET['min_price'] != "" )
	{
		$price	=	array(
			'key'     => '_adforest_ad_price',
			'value'   => array( $_GET['min_price'], $_GET['max_price'] ),
			'type'    => 'numeric',
			'compare' => 'BETWEEN',
		);	
	}
	$location	=	'';
	if( isset( $_GET['location'] ) && $_GET['location'] != "" )
	{
		$location	=	array(
			'key'     => '_adforest_ad_location',
			'value'   => trim( $_GET['location'] ),
			'compare' => '=',
		);	
	}
	$order	=	'desc';
	if( isset( $_GET['sort'] ) && $_GET['sort'] != "" )
	{
		$order	=	$_GET['sort'];
	}
	$category	=	'';
	if( isset( $_GET['cat_id'] ) && $_GET['cat_id'] != ""  )
	{
		$category	=	array(
			array(
			'taxonomy' => 'ad_cats',
			'field'    => 'term_id',
			'terms'    => $_GET['cat_id'],
			),
		);	
	}
	
	$title	=	'';
	if( isset( $_GET['ad_title'] ) && $_GET['ad_title'] != "" )
	{
		$title	=	$_GET['ad_title'];
	}

	$custom_search = array();
	if( isset( $_GET['custom'] ) )
	{
		foreach($_GET['custom'] as $key => $val)
		{
			if( is_array($val) )
			{
				$arr = array();
				$metaKey = '_adforest_tpl_field_'.$key;
				
				foreach ($val as $v)
				{ 
				
					 $custom_search[] = array(
					  'key'     => $metaKey,
					  'value'   => $v,
					  'compare' => 'LIKE',
					 ); 
				}
			}
			else
			{
				if(trim( $val ) == "0" ) { continue; }
				
				$val =  stripslashes_deep($val);
				
				$metaKey = '_adforest_tpl_field_'.$key;
				$custom_search[] = array(
				 'key'     => $metaKey,
				 'value'   => $val,
				 'compare' => 'LIKE',
				);     
			}
   		}
	}

if ( get_query_var( 'paged' ) ) {
	$paged = get_query_var( 'paged' );
} else if ( get_query_var( 'page' ) ) {
	// This will occur if on front page.
	$paged = get_query_var( 'page' );
} else {
	$paged = 1;
}
	$args	=	array(
	's' => $title,
	'post_type' => 'ad_post',
	'post_status' => 'publish',
	'posts_per_page' => get_option( 'posts_per_page' ),
	'tax_query' => array(
		$category,
	),
	'meta_query' => array(
		$condition,
		$ad_type,
		$warranty,
		$feature_or_simple,
		$price,
		$location,
		$custom_search,
	),
	'order'=> $order,
	'orderby' => 'ID',
	'paged' => $paged,
);
$results = new WP_Query( $args );
?>
      <div class="main-content-area clearfix">
         <!-- =-=-=-=-=-=-= Latest Ads =-=-=-=-=-=-= -->
         <section class="section-padding <?php echo esc_attr( $adforest_theme['search_bg'] ); ?>">
            <!-- Main Container -->
            <div class="container">
               <!-- Row -->
               <div class="row">
                  <!-- Middle Content Area -->
                  <div class="col-md-8 col-md-push-4 col-lg-8 col-sx-12 <?php echo esc_attr( $adforest_theme['search_res_bg'] ); ?>">
                     <!-- Row -->
                     <div class="row">
                        <!-- Sorting Filters -->
                        <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
                        <div class="clearfix"></div>
							<div class="listingTopFilterBar">
   								 <div class="col-md-7 col-xs-12 col-sm-6 no-padding">
                                    <ul class="filterAdType">
                                        <li class="active">
                                        <a href="javascript:void(0);"><?php echo __( 'Found Ads', 'adforest' ); ?>
                                        <small>(<?php echo esc_html( $results->found_posts ); ?>)</small>
                                        </a>
                                         </li>
                              <?php
							$param	=	$_SERVER['QUERY_STRING'];
							if( $param != "" )
							{
								?>

                                        <li class="">
                                        <a href="<?php echo get_the_permalink( $adforest_theme['sb_search_page'] ); ?>"><?php echo __('Reset Search', 'adforest' ); ?></a>
                                        </li>
                                <?php	
							}
							  ?>
                                    </ul>
                                </div>
   								 <div class="col-md-5 col-xs-12 col-sm-6 no-padding">
                               	 	<div class="header-listing">
                                    <h6><?php echo __('Sort by', 'adforest' ); ?>:</h6>
                                    <div class="custom-select-box">
                                    <?php
										$latest	=	'';
										$oldest	=	'';
										if( isset( $_GET['sort'] ) )
										{
											if( $_GET['sort'] == 'asc' )
											{
												$oldest	=	'selected';	
											}
											if( $_GET['sort'] == 'desc' )
											{
												$latest	=	'selected';	
											}
												
										}
									?>
                                    <form method="get">
                                    	<select name="sort" id="order_by" class="custom-select">
                                        	<option value="desc" <?php echo esc_attr( $latest ); ?>><?php echo __('Latest', 'adforest' ); ?></option>
                                        	<option value="asc" <?php echo esc_attr( $oldest ); ?>><?php echo __('Oldest', 'adforest' ); ?></option>
                                        </select>
                                        
                                        <?php echo adforest_search_params( 'sort' ); ?>
                                    </form>                                        
                                    </div>
                                </div>
    							</div>
							</div>
                        </div>
                        <!-- Sorting Filters End-->
                        <div class="clearfix"></div>
					<?php
                    if( isset( $adforest_theme['feature_on_search'] ) && $adforest_theme['feature_on_search'] )
                    {
						$args = 
						array( 
							'post_type' => 'ad_post',
							'posts_per_page' => $adforest_theme['max_ads_feature'],
							'meta_query' => array(
								array(
									'key'     => '_adforest_is_feature',
									'value'   => 1,
									'compare' => '=',
								),
							),
							'orderby'        => 'rand',

						);
						$ads = new ads();
						echo ( $ads->adforest_get_ads_grid_slider( $args, $adforest_theme['feature_ads_title'] ) );
                    }
                    if( isset( $adforest_theme['search_ad_720_1'] ) && $adforest_theme['search_ad_720_1'] != "" )
					{
                    ?>
                        <div class="col-md-12">
                            <div class="margin-bottom-30 margin-top-10">
                            <?php echo "" . $adforest_theme['search_ad_720_1']; ?>
                            </div>
                     	</div>
                   <?php
					}
					?>
                        <div class="clearfix"></div>
					<?php
					$layouts	=	 array( 'list_1', 'list_2', 'list_3' );
				if ( $results->have_posts() )
				{
					if (in_array($adforest_theme['search_layout'], $layouts))
					{
						require trailingslashit( get_template_directory () ) . "template-parts/layouts/ad_style/search-layout-list.php";
						echo($out);
					}
					else
					{
						require trailingslashit( get_template_directory () ) . "template-parts/layouts/ad_style/search-layout-grid.php";
						echo($out);
					}
                    
                /* Restore original Post Data */
                wp_reset_postdata();
                }
                ?>
                        <div class="clearfix"></div>
                <?php
				if(isset( $adforest_theme['search_ad_720_2'] ) &&  $adforest_theme['search_ad_720_2'] != "" )
				{
        		?>
                <div class="col-md-12">
                     <div class="margin-top-10 margin-bottom-30">
                     <?php echo "" . $adforest_theme['search_ad_720_2']; ?>
                     </div>
                 </div>
                <?php
				}
			    ?>
                        <!-- Pagination -->  
                        <div class="text-center margin-top-30 margin-bottom-20">
                           <?php adforest_pagination_search( $results ); ?>
                        </div>
                        <!-- Pagination End -->   
                     </div>
                     <!-- Row End -->
                  </div>
                  <!-- Middle Content Area  End -->
                  <!-- Left Sidebar -->
                  <?php get_sidebar( 'ads' ); ?>
                  <!-- Left Sidebar End -->
               </div>
               <!-- Row End -->
            </div>
            <!-- Main Container End -->
         </section>
      </div>
<!--footer section-->
<?php get_footer(); ?>
<!--footer section end--> 