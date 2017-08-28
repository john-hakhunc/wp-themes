<?php global $adforest_theme; ?>
<?php
	$layout = $adforest_theme['search_layout'];
	if( isset( $type ) )
	{
		$layout = $type;
	}
	$out	=	'';
	if( $layout == 'list_1' )
	{
		$out	.=	'<div class="col-md-12 col-xs-12 col-sm-12">
   <div id="products" class=" mid-container list-group">
      <div class="row">';
	}
	else if( $layout == 'list_2' )
	{
		$out	.=	'<div class="posts-masonry">
		   <div class="col-md-12 col-xs-12 col-sm-12">';
	}
	else if( $layout == 'list_3' )
	{
		$out	.=	'<div class="col-md-12 col-sm-12 col-xs-12">
   					<ul>';
	}
        // The Loop
        while ( $results->have_posts() )
        {
            $results->the_post();
            $pid	=	get_the_ID();
            $ads	=	 new ads();
            $option	=	$layout;
            $function	=	"adforest_search_layout_$option";
            $out	.= $ads->$function( $pid );
        }
	if( $layout == 'list_1' )
	{
		$out	.=	'</div></div></div>';
	}
	else if( $layout == 'list_2' )
	{
	   $out	.=	'</div></div>';
	}
	else if( $layout == 'list_3' )
	{
		$out	.=	'</ul></div>';
	}
?>
