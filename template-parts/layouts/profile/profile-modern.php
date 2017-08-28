<?php global $adforest_theme; ?>
<?php
	$author_id = get_query_var( 'author' );
	$author = get_user_by( 'ID', $author_id );
	$user_pic =	adforest_get_user_dp( $author_id, 'adforest-user-profile' );
?>
<section class="section-padding bg-gray" >
    <div class="container">
        <div class="row">
              <!-- Middle Content Area -->
              
              <div class="col-md-12 col-xs-12 col-sm-12">
                    <section class="search-result-item">
                               <a class="image-link" href="javascript:void(0);">
                               <img class="image" alt="<?php echo __('Profile Picture','adforest'); ?>" src="<?php echo esc_attr($user_pic); ?>" id="user_dp">
                               </a>
                               <div class="search-result-item-body">
                                  <div class="row">
                                     <div class="col-md-5 col-sm-12 col-xs-12">
                                        
                                        <h4 class="search-result-item-heading sb_put_user_name"><?php echo esc_html($author->display_name); ?></h4>
                                        <p class="info sb_put_user_address"><?php echo get_user_meta($author->ID, '_sb_address', true ); ?></p>
                                        <p class="description"><?php echo __('Logged in at', 'adforest') . ': '.adforest_get_last_login( $author->ID ). ' ' . __('Ago','adforest'); ?></p>
                                        <?php
                                        if( get_user_meta($author->ID, '_sb_badge_type', true ) != "" && get_user_meta($author->ID, '_sb_badge_text', true ) != "" && isset( $adforest_theme['sb_enable_user_badge'] ) && $adforest_theme['sb_enable_user_badge'] && $adforest_theme['sb_enable_user_badge'] && isset( $adforest_theme['user_public_profile'] ) && $adforest_theme['user_public_profile'] != "" && $adforest_theme['user_public_profile'] == "modern" )
										{
										?>
                                        <span class="label <?php echo get_user_meta($author->ID, '_sb_badge_type', true ); ?>">
										<?php echo get_user_meta($author->ID, '_sb_badge_text', true ); ?>
                                        </span>
                                        <?php
										}
										?>
                                        <p></p>
                                        <?php
                                        if( isset( $adforest_theme['user_public_profile'] ) && $adforest_theme['user_public_profile'] != "" && $adforest_theme['user_public_profile'] == "modern" && isset($adforest_theme['sb_enable_user_ratting']) && $adforest_theme['sb_enable_user_ratting'] )
										{
											
										?>
                                        <a href="<?php echo get_author_posts_url( $author->ID ); ?>?type=1">
                                        <div class="rating">
                                    <?php
									$got	=	get_user_meta($author->ID, "_adforest_rating_avg", true );
									if( $got == "" )
										$got = 0;
										for( $i = 1; $i<=5; $i++ )
										{
											if( $i <= round( $got ) )
												echo '<i class="fa fa-star"></i>';
											else
												echo '<i class="fa fa-star-o"></i>';	
										}
									?>
                                           <span class="rating-count">
                                           (<?php 
										   if( get_user_meta($author->ID, "_adforest_rating_count", true ) != "" )
										   		echo get_user_meta($author->ID, "_adforest_rating_count", true ); 
											else
												echo 0;
										   ?>)
                                           </span>
                                        </div>
                                        </a>
                                       <?php
										}
										?>
                                     </div>
                                     <div class="col-md-7 col-sm-12 col-xs-12">
                                      <div class="row ad-history">
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                    
                                            </div>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <div class="user-stats">
                                                    <h2><?php echo adforest_get_sold_ads( $author->ID ); ?></h2>
                                                    <small><?php echo __( 'Ad Sold', 'adforest' ); ?></small>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <div class="user-stats">
                                                    <h2><?php echo adforest_get_all_ads( $author->ID ); ?></h2>
                                                    <small><?php echo __( 'Total Listings', 'adforest' ); ?></small>
                                                </div>
                                            </div>
                                        </div>
                                     </div>
                                     
                                     
                                     
                                     
                                     
                                  </div>
                               </div>
                            </section>
                </div>
                
              <div class="col-md-12 col-lg-12 col-sx-12">
                 <!-- Row -->
                 <div class="row">
                 <?php
                    if( have_posts() > 0 && in_array( 'sb_framework/index.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) )
                    {
                 ?>
                    <!-- Sorting Filters -->
                    <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
                       <!-- Sorting Filters Breadcrumb -->
                       <div class="filter-brudcrums">
                          <span>
                          <?php echo __('Ad(s) posted by', 'adforest' ); ?>
                          <span class="showed"><?php echo " " . $author->display_name; ?></span>
                          </span>
                       </div>
                       <!-- Sorting Filters Breadcrumb End -->
                    </div>
                    <!-- Sorting Filters End-->
                    <div class="clearfix"></div>
                    <!-- Ads Archive -->
                    <div class="posts-masonry">
                       <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
                          <ul class="list-unstyled">
                         <?php
                            while( have_posts() )
                            {
                                the_post();
                                $pid	=	get_the_ID();
                                $ad	= new ads();
                                echo($ad->adforest_search_layout_list($pid));
                            }
                        ?>
                          </ul>
                       </div>
                    </div>
                    <!-- Ads Archive End -->  
                    <div class="clearfix"></div>
                    <!-- Pagination -->  
                    <div class="col-md-12 col-xs-12 col-sm-12">
                       <?php adforest_pagination(); ?>
                    </div>
                    <!-- Pagination End -->
               <?php
                    }
                    else
                    {
                        echo '<div class="col-md-8 col-sm-12 col-xs-12">
<h2>' .  __('No Ad(s) result found.','adforest') . '</h2></div><br /><br /><br /><br />';
                    }
                ?>
                 </div>
                 <!-- Row End -->
              </div>
                </div>
    </div>
</section>
