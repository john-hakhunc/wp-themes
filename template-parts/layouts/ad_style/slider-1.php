<div class="flexslider single-page-slider">
   <div class="flex-viewport">
      <ul class="slides slide-main gallery">
	<?php
	$ad_id	=	get_the_ID();
    $media = get_attached_media( 'image',$ad_id );
	$title	=	get_the_title();
    if( count( $media ) > 0 )
	{
    foreach( $media as $m )
    {
		$img  = wp_get_attachment_image_src($m->ID, 'adforest-single-post');
		$full_img  = wp_get_attachment_image_src($m->ID, 'full');
    ?>
         <li class="">
         <a href="<?php echo esc_url($full_img[0]); ?>" rel="prettyPhoto[gallery1]" title="<?php echo esc_attr( $title ); ?>">
         <img alt="<?php echo esc_attr( $title ); ?>" src="<?php echo esc_attr( $img[0] ); ?>">
         </a>
         </li>
	<?php
    }
	}
    ?>
    </ul>
   </div>
</div>
<!-- Listing Slider Thumb --> 
<div class="flexslider" id="carousels">
   <div class="flex-viewport">
      <ul class="slides slide-thumbnail">
      <?php
    if( count( $media ) > 0 )
	{
    foreach( $media as $m )
    {
		$img  = wp_get_attachment_image_src($m->ID, 'adforest-ad-thumb');
    ?>
         <li><img alt="<?php echo esc_attr( $title ); ?>" draggable="false" src="<?php echo esc_attr( $img[0] ); ?>"></li>
	<?php
    }
	}
    ?>
         
      </ul>
   </div>
</div>
