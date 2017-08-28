<?php global $adforest_theme; ?>
<!-- Ads Archive -->
<?php
	$out	=	'<div class="posts-masonry">';
?>
<?php
// The Loop
$layout = $adforest_theme['search_layout'];
if( isset( $type ) )
{
	$layout = $type;
}
$c = 6;
if( isset( $col ) )
{
	$c = $col;	
}
while ( $results->have_posts() )
{ 
	$results->the_post();
	$pid	=	get_the_ID();
	$ads	=	 new ads();
	$option	=	$layout;
	$function	=	"adforest_search_layout_$option";
	$out	.= $ads->$function( $pid, $c );
}
?>
<?php
	$out	.=	'</div>';
?>
<!-- Ads Archive End --> 

