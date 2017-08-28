<div class="owl-carousel owl-theme single-details gallery">
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
	<div class="item">
    <a href="<?php echo esc_url($full_img[0]); ?>" rel="prettyPhoto[gallery1]" title="<?php echo esc_attr( $title ); ?>">
		<img alt="<?php echo esc_attr( $title ); ?>" src="<?php echo esc_attr( $img[0] ); ?>">
    </a>
	</div>

<?php
}
}
?>
</div>