<?php
global $adforest_theme; 
$pid	=	get_the_ID();
?>
<div class="descs-box">
           <?php 
		   		if( get_post_meta($pid, '_adforest_ad_status_', true ) == 'sold' )
				{
		   ?>
           		<div class="ad-closed">
                      <img class="img-responsive" src="<?php echo trailingslashit( get_template_directory_uri () ); ?>images/sold-out.png" alt="<?php __('sold out', 'adforest' ); ?>">
                 </div>
           <?php
				}
			?>
           <?php 
		   		if( get_post_meta($pid, '_adforest_ad_status_', true ) == 'expired' )
				{
		   ?>
           		<div class="ad-expired">
                      <img class="img-responsive" src="<?php echo trailingslashit( get_template_directory_uri () ); ?>images/expired.png" alt="<?php __('sold out', 'adforest' ); ?>">
                 </div>
           <?php
				}
			?>

                   <div class="short-features">
                      <!-- Heading Area -->
                      <div class="heading-panel">
                         <h3 class="main-title text-left">
                            <?php echo __('Description','adforest'); ?>
                         </h3>
                      </div>
					<?php 
                    if( get_post_meta($pid, '_adforest_ad_price', true ) == "" && get_post_meta($pid, '_adforest_ad_price_type', true ) == "no_price" ) 
                    {
                        
                    }
                    else
                    {
                        
                    ?>
                      <div class="col-sm-4 col-md-4 col-xs-12 no-padding">
                         <span><strong><?php echo __('Price','adforest'); ?></strong> :</span>
                        <?php echo adforest_adPrice($pid); ?> 
                         
                      </div>
				  <?php
					}
					?>
                      <?php if( get_post_meta($pid, '_adforest_ad_type', true ) != "" ) { ?>
                      <div class="col-sm-4 col-md-4 col-xs-12 no-padding">
                         <span><strong><?php echo __('Type','adforest'); ?></strong> :</span> <?php echo get_post_meta($pid, '_adforest_ad_type', true ); ?>
                      </div>
                      <?php } ?>
                      <div class="col-sm-4 col-md-4 col-xs-12 no-padding">
                         <span><strong><?php echo __('Date','adforest'); ?></strong> :</span> <?php echo get_the_date(); ?>
                      </div>
                      <?php 
					  if( get_post_meta($pid, '_adforest_ad_condition', true ) != "" && isset( $adforest_theme['allow_tax_condition'] ) && $adforest_theme['allow_tax_condition'] )
					  {
					 ?>
                      <div class="col-sm-4 col-md-4 col-xs-12 no-padding">
                         <span><strong><?php echo __('Condition','adforest'); ?></strong> :</span> <?php echo get_post_meta($pid, '_adforest_ad_condition', true ); ?>
                      </div>
                      <?php
					  }
					  if( get_post_meta($pid, '_adforest_ad_warranty', true ) != "" && isset( $adforest_theme['allow_tax_warranty'] ) && $adforest_theme['allow_tax_warranty'] )
					  {
					  ?>
                      <div class="col-sm-4 col-md-4 col-xs-12 no-padding">
                         <span><strong><?php echo __('Warranty','adforest'); ?></strong> :</span> <?php echo get_post_meta($pid, '_adforest_ad_warranty', true ); ?>
                      </div>
                      <?php
					  }
					  	global $wpdb;
						$rows = $wpdb->get_results( "SELECT * FROM $wpdb->postmeta WHERE post_id = '$pid' AND meta_key LIKE '_sb_extra_%'" );
						foreach( $rows as $row )
						{
							$caption	=	explode( '_', $row->meta_key );
							if( $row->meta_value == "" )
							{
								continue;
							}
					 ?>
                      <div class="col-sm-4 col-md-4 col-xs-12 no-padding">
                         <span><strong><?php echo esc_html( ucfirst( $caption[3] ) ); ?></strong> :</span>
						 <?php echo esc_html( $row->meta_value ); ?>
                      </div>
                     <?php		
						}
					  ?>
                     
                      <?php 
					   		if(function_exists('adforestCustomFieldsHTML'))
							{
								echo adforestCustomFieldsHTML($pid);
							}
					   ?>                     
                     
                      <?php if( get_post_meta($pid, '_adforest_ad_location', true ) != "" ) { ?>
                      <div class="col-sm-12 col-md-12 col-xs-12 no-padding">
                         <span><strong><?php echo __( "Location", 'adforest' ); ?></strong> :</span>
						 <?php echo get_post_meta($pid, '_adforest_ad_location', true ); ?>
                      </div>
                      <?php } ?>
                      
                   </div>
                   <div class="desc-points">
                      <?php the_content(); ?>
                   </div>
                   <?php if( get_post_meta($pid, '_adforest_ad_yvideo', true ) != "" ) {
					   
						preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', get_post_meta($pid, '_adforest_ad_yvideo', true ), $match);
		
						if( isset( $match[1] ) && $match[1] != "" )
						{
					    
							$video_id = $match[1];
					
				   ?>
                   <div class="heading-panel">
                         <h3 class="main-title text-left">
                            <?php echo __('Ad Video','adforest'); ?>
                         </h3>
                      </div>
                   <div>
                   		<?php 
							$iframe = 'iframe';
							echo '<'.$iframe.' width="560" height="450" src="https://www.youtube.com/embed/'. esc_attr( $video_id ) . '" frameborder="0" allowfullscreen></'.$iframe.'>'; 
					   ?>
                   </div>
                   <?php
					}
				   }
				   ?>
                   <hr />
                   <div class="tags-share clearfix">
                     <div class="tags pull-left">
                        <?php 
                            $posttags = get_the_terms( get_the_ID(), 'ad_tags');
                            $count=0;
                            $tags	=	'';
                            
                          if ($posttags)
                          {
                          ?>
                          <i class="fa fa-tags"></i>
                          	<ul>
                            
							<?php
								foreach($posttags as $tag)
								{
							?>
                            		<li>
                                    <a href="<?php echo esc_url( get_tag_link($tag->term_id) ); ?>" title="<?php echo esc_attr( $tag->name ); ?>">
                                    #<?php echo esc_attr( $tag->name ); ?>
                                    </a>
                                    </li>
							<?php
								}
							?>
                          	</ul>
                       <?php
						  }
						?>
                        
                        
                        
                     </div>
                  </div>
                   <div class="clearfix"></div>
                </div>
		<?php
       	if( isset( $adforest_theme['sb_enable_comments_offer'] ) && $adforest_theme['sb_enable_comments_offer'] && get_post_meta($pid, '_adforest_ad_status_', true ) != 'sold' && get_post_meta($pid, '_adforest_ad_status_', true ) != 'expired' && get_post_meta($pid, '_adforest_ad_price', true ) != "0" )
		{
			if( isset( $adforest_theme['sb_enable_comments_offer_user'] ) && $adforest_theme['sb_enable_comments_offer_user'] && get_post_meta($pid, '_adforest_ad_bidding', true ) == 1 )
			{
				echo adforest_html_bidding_system( $pid );
			}
			else if( isset( $adforest_theme['sb_enable_comments_offer_user'] ) && $adforest_theme['sb_enable_comments_offer_user'] && get_post_meta($pid, '_adforest_ad_bidding', true ) == 0 )
			{
				
			}
			else
			{
				echo adforest_html_bidding_system( $pid );
			}

        ?>
            
	   <?php
	   }
	   ?>
     

