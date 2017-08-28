<?php
add_action( 'widgets_init', function(){
     register_widget( 'adforest_search_condition' );
});
if (! class_exists ( 'adforest_search_condition' )) {
class adforest_search_condition extends WP_Widget {
	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		$widget_ops = array( 
			'classname' => 'adforest_search_conidtion',
			'description' => __('Only for search and single ad sidebar.', 'adforest'),
		);
		// Instantiate the parent object
		parent::__construct( false, __('Ad Condition', 'adforest' ), $widget_ops );
	}
	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		
		$expand	=	"";
		$cur_con	=	'';
		
		$is_show = adforest_getTemplateID('static', '_sb_default_cat_condition_show');
		if($is_show = ''  || $is_show == 1){}else{ return;}
		
		if( isset( $_GET['condition'] ) && $_GET['condition'] != "" )
		{
			$cur_con	=	$_GET['condition'];
			$expand	=	"in";
		}
		global $adforest_theme;
	?>
     <div class="panel panel-default">
          <!-- Heading -->
          <div class="panel-heading" role="tab" id="headingThree">
             <h4 class="panel-title">
                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                <i class="more-less glyphicon glyphicon-plus"></i>
                <?php echo esc_html( $instance['title'] ); ?>
                </a>
             </h4>
          </div>
          <!-- Content -->
          <form method="get" action="<?php echo get_the_permalink( $adforest_theme['sb_search_page'] ); ?>">
          <?php
				echo adforest_search_params( 'condition' );
		  ?>
          
          <div id="collapseThree" class="panel-collapse collapse <?php echo esc_attr( $expand ); ?>" role="tabpanel" aria-labelledby="headingThree">
             <div class="panel-body">
                <div class="skin-minimal">
                   <ul class="list">
                   <?php
				   		$conditions	=	adforest_get_cats('ad_condition' , 0 );
						foreach( $conditions as $con )
						{
				   ?>
                      <li>
                         <input tabindex="7" type="radio" id="minimal-radio-<?php echo esc_attr( $con->term_id); ?>" name="condition" value="<?php echo esc_attr( $con->name); ?>" <?php if( $cur_con == $con->name ) {  echo esc_attr("checked"); } ?>  >
                         <label for="minimal-radio-<?php echo esc_attr( $con->term_id); ?>" ><?php echo esc_html($con->name); ?></label>
                      </li>
                      <?php
						}
					  ?>
                   </ul>
                </div>
             </div>
          </div>
          </form>
       </div>

    <?php
	}
	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) )
		{
			$title = $instance[ 'title' ];
		}
		else 
		{
			$title = esc_html__( 'Condition', 'adforest' );
		}

		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" >
            <?php echo esc_html__( 'Title:', 'adforest' ); ?>
            </label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<?php 
	}
	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance )
	{
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		return $instance;
	}
} // Condition
}


// Ad type Widget
add_action( 'widgets_init', function(){
     register_widget( 'adforest_search_ad_type' );
});
if (! class_exists ( 'adforest_search_ad_type' )) {
class adforest_search_ad_type extends WP_Widget {
	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		$widget_ops = array( 
			'classname' => 'adforest_search_ad_type',
			'description' => __('Only for search and single ad sidebar.', 'adforest'),
		);
		// Instantiate the parent object
		parent::__construct( false, __('Ad Type', 'adforest' ), $widget_ops );
	}
	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		$cur_type	=	'';
		$expand	=	"";

		$is_show = adforest_getTemplateID('static', '_sb_default_cat_ad_type_show');
		if($is_show = ''  || $is_show == 1){}else{ return;}
		
		
		if( isset( $_GET['ad_type'] ) && $_GET['ad_type'] != "" )
		{
			$expand	=	"in";
			$cur_type	=	$_GET['ad_type'];
		}
		global $adforest_theme;
	?>
     <div class="panel panel-default">
          <!-- Heading -->
          <div class="panel-heading" role="tab" id="headingSeven">
             <h4 class="panel-title">
                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseSeven" aria-expanded="true" aria-controls="collapseSeven">
                <i class="more-less glyphicon glyphicon-plus"></i>
                <?php echo esc_html( $instance['title'] ); ?>
                </a>
             </h4>
          </div>
          <!-- Content -->
          <form method="get" action="<?php echo get_the_permalink( $adforest_theme['sb_search_page'] ); ?>" >
          <div id="collapseSeven" class="panel-collapse collapse <?php echo esc_attr( $expand ); ?>" role="tabpanel" aria-labelledby="headingSeven">
             <div class="panel-body">
                <div class="skin-minimal">
                   <ul class="list">
                   <?php
				   		$conditions	=	adforest_get_cats('ad_type' , 0 );
						foreach( $conditions as $con )
						{
				   ?>
                      <li>
                         <input tabindex="7" type="radio" id="minimal-radio-<?php echo esc_attr( $con->term_id); ?>" name="ad_type" value="<?php echo esc_attr( $con->name); ?>" <?php if( $cur_type == $con->name ) {  echo esc_attr("checked"); } ?>  >
                         <label for="minimal-radio-<?php echo esc_attr( $con->term_id); ?>" ><?php echo esc_html($con->name); ?></label>
                      </li>
                      <?php
						}
					  ?>
                    </ul>
                </div>
             </div>
          </div>
			<?php
				echo adforest_search_params( 'ad_type' );
            ?>
          </form>
       </div>

    <?php
	}
	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) )
		{
			$title = $instance[ 'title' ];
		}
		else 
		{
			$title = esc_html__( 'Ad Type', 'adforest' );
		}

		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" >
            <?php echo esc_html__( 'Title:', 'adforest' ); ?>
            </label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<?php 
	}
	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance )
	{
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		return $instance;
	}
} // Ad Type
}

// Ad Warranty
add_action( 'widgets_init', function(){
     register_widget( 'adforest_search_ad_warranty' );
});
if (! class_exists ( 'adforest_search_ad_warranty' )) {
class adforest_search_ad_warranty extends WP_Widget {
	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		$widget_ops = array( 
			'classname' => 'adforest_search_ad_warranty',
			'description' => __('Only for search and single ad sidebar.', 'adforest'),
		);
		// Instantiate the parent object
		parent::__construct( false, __('Ad Warranty', 'adforest' ), $widget_ops );
	}
	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		$cur_war	=	'';
		$expand	=	"";
		
		$is_show = adforest_getTemplateID('static', '_sb_default_cat_warranty_show');
		if($is_show = ''  || $is_show == 1){}else{ return;}
		
		
		if( isset( $_GET['warranty'] ) && $_GET['warranty'] != "" )
		{
			$expand	=	"in";
			$cur_war	=	$_GET['warranty'];
		}
		global $adforest_theme;
	?>
     <div class="panel panel-default">
          <!-- Heading -->
          <div class="panel-heading" role="tab" id="headingEight">
             <h4 class="panel-title">
                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseEight" aria-expanded="true" aria-controls="collapseEight">
                <i class="more-less glyphicon glyphicon-plus"></i>
                <?php echo esc_html( $instance['title'] ); ?>
                </a>
             </h4>
          </div>
          <!-- Content -->
          <form method="get" action="<?php echo get_the_permalink( $adforest_theme['sb_search_page'] ); ?>" >
          <div id="collapseEight" class="panel-collapse collapse <?php echo esc_attr( $expand ); ?>" role="tabpanel" aria-labelledby="headingEight">
             <div class="panel-body">
                <div class="skin-minimal">
                   <ul class="list">
                   <?php
				   		$conditions	=	adforest_get_cats('ad_warranty' , 0 );
						foreach( $conditions as $con )
						{
				   ?>
                      <li>
                         <input tabindex="7" type="radio" id="minimal-radio-<?php echo esc_attr( $con->term_id); ?>" name="warranty" value="<?php echo esc_attr( $con->name); ?>" <?php if( $cur_war == $con->name ) {  echo esc_attr("checked"); } ?>  >
                         <label for="minimal-radio-<?php echo esc_attr( $con->term_id); ?>" ><?php echo esc_html($con->name); ?></label>
                      </li>
                      <?php
						}
					  ?>
                    </ul>
                </div>
             </div>
          </div>
			<?php
				echo adforest_search_params( 'warranty' );
            ?>
          </form>
       </div>

    <?php
	}
	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) )
		{
			$title = $instance[ 'title' ];
		}
		else 
		{
			$title = esc_html__( 'Warranty', 'adforest' );
		}

		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" >
            <?php echo esc_html__( 'Title:', 'adforest' ); ?>
            </label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<?php 
	}
	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance )
	{
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		return $instance;
	}
} // Ad Warranty
}

// Simple or featured ad search
add_action( 'widgets_init', function(){
     register_widget( 'adforest_search_ad_simple_feature' );
});
if (! class_exists ( 'adforest_search_ad_simple_feature' )) {
class adforest_search_ad_simple_feature extends WP_Widget {
	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		$widget_ops = array( 
			'classname' => 'adforest_search_ad_simple_feature',
			'description' => __('Only for search and single ad sidebar.', 'adforest'),
		);
		// Instantiate the parent object
		parent::__construct( false, __('Simple or feature ad search', 'adforest' ), $widget_ops );
	}
	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		$simple	=	'';
		$featured	=	'';
		$expand	=	"";
		if( isset( $_GET['ad'] ) && $_GET['ad'] != "" )
		{
			$expand	=	"in";
			if( $_GET['ad'] == 0)
			{
				$simple	=	"checked";	
			}
			if( $_GET['ad'] == 1)
			{
				$featured	=	"checked";	
			}
		}
		global $adforest_theme;
	?>
     <div class="panel panel-default">
          <!-- Heading -->
          <div class="panel-heading" role="tab" id="headingNine">
             <h4 class="panel-title">
                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseNine" aria-expanded="true" aria-controls="collapseNine">
                <i class="more-less glyphicon glyphicon-plus"></i>
                <?php echo esc_html( $instance['title'] ); ?>
                </a>
             </h4>
          </div>
          <!-- Content -->
          <form method="get" action="<?php echo get_the_permalink( $adforest_theme['sb_search_page'] ); ?>" >
          <div id="collapseNine" class="panel-collapse collapse <?php echo esc_attr( $expand ); ?>" role="tabpanel" aria-labelledby="headingNine">
             <div class="panel-body">
                <div class="skin-minimal">
                   <ul class="list">
                      <li>
                         <input tabindex="7" type="radio" id="minimal-radio-sb_1" name="ad" value="0" <?php echo esc_attr( $simple ); ?>  >
                         <label for="minimal-radio-sb_1" >
						 <?php echo __('Simple Ads','adforest'); ?></label>
                      </li>
                      <li>
                         <input tabindex="7" type="radio" id="minimal-radio-sb_2" name="ad" value="1" <?php echo esc_attr( $featured ); ?>  >
                         <label for="minimal-radio-sb_2" >
						 <?php echo __('Featured Ads','adforest'); ?></label>
                      </li>
                    </ul>
                </div>
             </div>
          </div>
			<?php
				echo adforest_search_params( 'ad' );
            ?>
          </form>
       </div>

    <?php
	}
	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) )
		{
			$title = $instance[ 'title' ];
		}
		else 
		{
			$title = esc_html__( 'Simple or Featured', 'adforest' );
		}

		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" >
            <?php echo esc_html__( 'Title:', 'adforest' ); ?>
            </label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<?php 
	}
	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance )
	{
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		return $instance;
	}
} // Simple or featured ad search
}

// Ad Price Widget
add_action( 'widgets_init', function(){
     register_widget( 'adforest_search_ad_price' );
});
if (! class_exists ( 'adforest_search_ad_price' )) {
class adforest_search_ad_price extends WP_Widget {
	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		$widget_ops = array( 
			'classname' => 'adforest_search_ad_price',
			'description' => __('Only for search and single ad sidebar.', 'adforest'),
		);
		// Instantiate the parent object
		parent::__construct( false, __('Ad Price', 'adforest' ), $widget_ops );
	}
	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		$expand	=	"";
		

		$is_show = adforest_getTemplateID('static', '_sb_default_cat_price_show');
		if($is_show = ''  || $is_show == 1){}else{ return;}
		
		
		$min_price	=	$instance['min_price'];
		if( isset( $_GET['min_price'] ) && $_GET['min_price'] != "" )
		{
			$expand	=	"in";
			$min_price	=	$_GET['min_price'];
		}
		$max_price	=	$instance['max_price'];
		if( isset( $_GET['max_price'] ) && $_GET['max_price'] != "" )
		{
			$max_price	=	$_GET['max_price'];
		}
		global $adforest_theme;
		
		$min	=	0;
		if( isset( $instance['min_price'] ) )
		{
			$min	=	$instance['min_price'];	
		}
		global $adforest_theme;
		
	?>
     <div class="panel panel-default">
          <!-- Heading -->
          <div class="panel-heading" role="tab" id="headingfour">
             <h4 class="panel-title">
                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapsefour" aria-expanded="false" aria-controls="collapsefour">
                <i class="more-less glyphicon glyphicon-plus"></i>
                <?php echo esc_html( $instance['title'] ); ?>
                </a>
             </h4>
          </div>
          <!-- Content -->
     	<form method="get" action="<?php echo get_the_permalink( $adforest_theme['sb_search_page'] ); ?>">
          <div id="collapsefour" class="panel-collapse collapse <?php echo esc_attr( $expand ); ?>" role="tabpanel" aria-labelledby="headingfour">
             <div class="panel-body">
                <span class="price-slider-value"><?php echo __( 'Price', 'adforest' ); ?>
                 (<?php echo esc_html( $adforest_theme['sb_currency'] ); ?>) 
                <span id="price-min"></span>
                 - 
                <span id="price-max"></span>
                </span>
                <div id="price-slider"></div>
                <div class="input-group margin-top-10">
                <input type="text" class="form-control" name="min_price" id="min_selected" value="<?php echo esc_attr( $min_price ); ?>" />
                <span class="input-group-addon">-</span>
                <input type="text" class="form-control" name="max_price" id="max_selected" value="<?php echo esc_attr( $max_price ); ?>" />
                </div>
                
          <input type="hidden" id="min_price" value="<?php echo esc_attr( $instance['min_price'] ); ?>" />
          <input type="hidden" id="max_price" value="<?php echo esc_attr( $instance['max_price'] ); ?>" />
          
                <input type="submit" class="btn btn-theme btn-sm margin-top-20" value="<?php echo __( 'Search', 'adforest' ); ?>" />
             </div>
          </div>
          <?php echo adforest_search_params( 'min_price', 'max_price' ); ?>
       </form>
       </div>
    <?php
	}
	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) )
		{
			$title = $instance[ 'title' ];
		}
		else 
		{
			$title = esc_html__( 'Ad Price', 'adforest' );
		}
		
		if ( isset( $instance[ 'min_price' ] ) )
		{
			$min_price = $instance[ 'min_price' ];
		}
		else 
		{
			$min_price = 1;
		}
		
		if ( isset( $instance[ 'max_price' ] ) )
		{
			$max_price = $instance[ 'max_price' ];
		}
		else 
		{
			$max_price = esc_html__( '10000000', 'adforest' );
		}

		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" >
            <?php echo esc_html__( 'Title:', 'adforest' ); ?>
            </label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'min_price' ) ); ?>" >
            <?php echo esc_html__( 'Min Price:', 'adforest' ); ?>
            </label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'min_price' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'min_price' ) ); ?>" type="text" value="<?php echo esc_attr( $min_price ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'max_price' ) ); ?>" >
            <?php echo esc_html__( 'Max Price:', 'adforest' ); ?>
            </label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'max_price' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'max_price' ) ); ?>" type="text" value="<?php echo esc_attr( $max_price ); ?>">
		</p>
		<?php 
	}
	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance )
	{
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['min_price'] = ( ! empty( $new_instance['min_price'] ) ) ? strip_tags( $new_instance['min_price'] ) : '';
		$instance['max_price'] = ( ! empty( $new_instance['max_price'] ) ) ? strip_tags( $new_instance['max_price'] ) : '';
		return $instance;
	}
} // Ad Price
}


// Ad Categories widget
add_action( 'widgets_init', function(){
     register_widget( 'adforest_search_cats' );
});
if (! class_exists ( 'adforest_search_cats' )) {
class adforest_search_cats extends WP_Widget {
	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		$widget_ops = array( 
			'classname' => 'adforest_search_cats',
			'description' => __('Only for search and single ad sidebar.', 'adforest'),
		);
		// Instantiate the parent object
		parent::__construct( false, __('Ad Categories', 'adforest' ), $widget_ops );
	}
	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		
		$new	=	'';
		$used	=	'';
		$expand	=	"";
		if( isset( $_GET['cat_id'] ) && $_GET['cat_id'] != "" )
		{
			$expand	=	"in";
		}
		global $adforest_theme;
	?>
       <div class="panel panel-default">
          <!-- Heading -->
          <div class="panel-heading" role="tab" id="headingOne">
             <!-- Title -->
             <h4 class="panel-title">
                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                <i class="more-less glyphicon glyphicon-plus"></i>
                <?php echo esc_html( $instance['title'] ); ?>
                </a>
             </h4>
             <!-- Title End -->
          </div>
          <!-- Content -->
<form method="get" id="search_cats_w" action="<?php echo get_the_permalink( $adforest_theme['sb_search_page'] ); ?>">
          <div id="collapseOne" class="panel-collapse collapse <?php echo esc_attr( $expand ); ?>" role="tabpanel" aria-labelledby="headingOne">
          
          <?php
		  $ad_cats	=	adforest_get_cats('ad_cats' , 0 );
		  if( count( $ad_cats ) > 0 )
		  {
		  ?>
             <div class="panel-body categories">
             	<?php 
				if( isset( $_GET['cat_id'] ) && $_GET['cat_id'] != "" )
				{
					echo adforest_get_taxonomy_parents( $_GET['cat_id'], 'ad_cats', false);
				}
				?>
                <ul>
                <?php
					foreach( $ad_cats as $ad_cat )
					{
						$category = get_category($ad_cat->term_id);
						$count = $category->category_count;
						$cat_meta	=	 get_option( "taxonomy_term_$ad_cat->term_id" );
						$icon	=	 $cat_meta['ad_cat_icon'];
				?>
                   <li> 
                   	<a href="javascript:void(0);" data-cat-id="<?php echo esc_attr( $ad_cat->term_id ); ?>">
                    <i class="<?php echo esc_attr( $icon ); ?>"></i>
					<?php echo esc_html( $ad_cat->name ); ?> 
                    <span>(<?php echo esc_html( $count ); ?>)</span>
                    </a>
                   </li>
                <?php
					}
				?>
                </ul>	
             </div>
          <?php
		  }
		  ?>
          </div>
    <input type="hidden" name="cat_id" id="cat_id" value="" />
    <?php echo adforest_search_params( 'cat_id' ); ?>
  </form>
       <div class="search-modal modal fade cats_model" id="cat_modal" tabindex="-1" role="dialog" aria-hidden="true">
                     <div class="modal-dialog">
                        <div class="modal-content">
                           <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&#10005;</span><span class="sr-only">Close</span></button>
                              <h3 class="modal-title text-center" id="lineModalLabel"> 
                              <i class="icon-gears"></i> 
                              <?php echo __( 'Select Any Category', 'adforest' ); ?> 
                              </h3>
                           </div>
                           <div class="modal-body">
                              <!-- content goes here -->
                              <div class="search-block">
   <div class="row">

   </div>
   <div class="row">
    <div class="col-md-12 col-xs-12 col-sm-12 popular-search" id="cats_response">
                
    </div>
   </div>

  </div>
                           </div>
                           <div class="modal-footer">
                                    <button type="submit" id="ad-search-btn" class="btn btn-lg btn-block"><?php echo __('Submit', 'adforest' ); ?></button>
                                 </div>
                        </div>
                     </div>
                  </div>
       </div>
    <?php
	}
	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) )
		{
			$title = $instance[ 'title' ];
		}
		else 
		{
			$title = esc_html__( 'Categories', 'adforest' );
		}

		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" >
            <?php echo esc_html__( 'Title:', 'adforest' ); ?>
            </label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<?php 
	}
	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance )
	{
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		return $instance;
	}
} // Categories widget
}


// Ad title Widget
add_action( 'widgets_init', function(){
     register_widget( 'adforest_search_ad_title' );
});
if (! class_exists ( 'adforest_search_ad_title' )) {
class adforest_search_ad_title extends WP_Widget {
	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		$widget_ops = array( 
			'classname' => 'adforest_search_ad_title',
			'description' => __('Only for search and single ad sidebar.', 'adforest'),
		);
		// Instantiate the parent object
		parent::__construct( false, __('Ad Search', 'adforest' ), $widget_ops );
	}
	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		$expand	=	"";
		$title	=	'';
		if( isset( $_GET['ad_title'] ) && $_GET['ad_title'] != "" )
		{
			$expand	=	"in";
			$title	=	$_GET['ad_title'];
		}
		global $adforest_theme;
	?>
     <div class="panel panel-default">
          <!-- Heading -->
          <div class="panel-heading" role="tab" id="headingFive">
             <h4 class="panel-title">
                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFive" aria-expanded="true" aria-controls="collapseFive">
                <i class="more-less glyphicon glyphicon-plus"></i>
                <?php echo esc_html( $instance['title'] ); ?>
                </a>
             </h4>
          </div>
          <form method="get" action="<?php echo get_the_permalink( $adforest_theme['sb_search_page'] ); ?>">
          <!-- Content -->
          <div id="collapseFive" class="panel-collapse collapse <?php echo esc_attr( $expand ); ?>" role="tabpanel" aria-labelledby="headingFive">
             <div class="panel-body">
                  <div class="search-widget">
                       <input placeholder="<?php echo __('search', 'adforest' ); ?>" type="text" name="ad_title" value="<?php echo esc_attr( $title ); ?>">
                       <button type="submit"><i class="fa fa-search"></i></button>
                </div>
             </div>
          </div>
			<?php
				echo adforest_search_params( 'ad_title' );
            ?>
          </form>
       </div>

    <?php
	}
	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) )
		{
			$title = $instance[ 'title' ];
		}
		else 
		{
			$title = esc_html__( 'Ad Search', 'adforest' );
		}

		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" >
            <?php echo esc_html__( 'Title:', 'adforest' ); ?>
            </label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<?php 
	}
	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance )
	{
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		return $instance;
	}
} // Ad title
}


// Ad Locations widget
add_action( 'widgets_init', function(){
     register_widget( 'adforest_search_locations' );
});
if (! class_exists ( 'adforest_search_locations' )) {
class adforest_search_locations extends WP_Widget {
	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		$widget_ops = array( 
			'classname' => 'adforest_search_locations',
			'description' => __('Only for search and single ad sidebar.', 'adforest'),
		);
		// Instantiate the parent object
		parent::__construct( false, __('Ad Locations', 'adforest' ), $widget_ops );
	}
	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		
		$expand	=	"";
		$location	=	'';
		if( isset( $_GET['location'] ) && $_GET['location'] != "" )
		{
			$expand	=	"in";
			$location	=	$_GET['location'];
		}
		global $adforest_theme;
	?>
     <div class="panel panel-default">
          <!-- Heading -->
          <div class="panel-heading" role="tab" id="headingSix">
             <h4 class="panel-title">
                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseSix" aria-expanded="true" aria-controls="collapseSix">
                <i class="more-less glyphicon glyphicon-plus"></i>
                <?php echo esc_html( $instance['title'] ); ?>
                </a>
             </h4>
          </div>
          <!-- Content -->
          <form method="get" action="<?php echo get_the_permalink( $adforest_theme['sb_search_page'] ); ?>">
          <div id="collapseSix" class="panel-collapse collapse <?php echo esc_attr( $expand ); ?>" role="tabpanel" aria-labelledby="headingSix">
             <div class="panel-body">
                  <div class="search-widget">
                       <input placeholder="<?php echo __('search', 'adforest' ); ?>" type="text" name="location" value="<?php echo esc_attr( $location ); ?>" id="sb_user_address" />
                       <button type="submit"><i class="fa fa-search"></i></button>
                </div>
             </div>
          </div>
			<?php
				echo adforest_search_params( 'location' );
            ?>
          </form>
       <?php adforest_load_search_countries(); ?>
       </div>
    <?php
	}
	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) )
		{
			$title = $instance[ 'title' ];
		}
		else 
		{
			$title = esc_html__( 'Ad Locations', 'adforest' );
		}

		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" >
            <?php echo esc_html__( 'Title:', 'adforest' ); ?>
            </label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<?php 
	}
	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance )
	{
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		return $instance;
	}
} // Locations widget
}


// Featured Ads Widget
add_action( 'widgets_init', function(){
     register_widget( 'adforest_search_featured_ad' );
});
if (! class_exists ( 'adforest_search_featured_ad' )) {
class adforest_search_featured_ad extends WP_Widget {
	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		$widget_ops = array( 
			'classname' => 'adforest_search_featured_ad',
			'description' => __('Only for search and single ad sidebar.', 'adforest'),
		);
		// Instantiate the parent object
		parent::__construct( false, __('Ad Featured', 'adforest' ), $widget_ops );
	}
	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		$max_ads	=	$instance['max_ads'];
		global $adforest_theme;
		
	?>
    
    <div class="panel panel-default">
      <!-- Heading -->
      <div class="panel-heading" >
         <h4 class="panel-title">
            <a>
            <?php echo esc_html( $instance['title'] ); ?>
            </a>
         </h4>
      </div>
      <!-- Content -->
      <div class="panel-collapse">
         <div class="panel-body recent-ads">
            <div class="featured-slider-3">
               <!-- Featured Ads -->
               <?php
					$f_args = 
					array( 
					'post_type' => 'ad_post',
					'post_status' => 'publish',
					'posts_per_page' => $max_ads,
					'meta_query' => array(
					array(
					'key'     => '_adforest_is_feature',
					'value'   => 1,
					'compare' => '=',
					),
					),
					'orderby'        => 'rand',
					
					);
				$f_ads = new WP_Query( $f_args );
				if ( $f_ads->have_posts() ) {
					$number	= 0;
					while ( $f_ads->have_posts() )
					{
						$f_ads->the_post();
						$pid	=	get_the_ID();
						$author_id = get_post_field( 'post_author', $pid );;
						$author = get_user_by( 'ID', $author_id );
						
					   $img	=	$adforest_theme['default_related_image']['url']; 
						$media = get_attached_media( 'image', $pid );
						$total_imgs	=	count( $media );
						if( count( $media ) > 0 )
						{
							foreach( $media as $m )
							{
								$image  = wp_get_attachment_image_src( $m->ID, 'adforest-ad-related');
								$img	=	$image[0];
								break;
							}
						}      

			   ?>
                       <div class="item">
                          <div class="col-md-12 col-xs-12 col-sm-12 no-padding">
                             <!-- Ad Box -->
                             <div class="category-grid-box">
                             
                                <!-- Ad Img -->
                                <div class="category-grid-img">
                                   <img class="img-responsive" alt="<?php echo get_the_title(); ?>" src="<?php echo esc_url( $img ); ?>">
                                   <!-- Ad Status -->
                                   <!-- User Review -->
                                   <?php echo adforest_video_icon(); ?>
                                   <div class="user-preview">
                                      <a href="<?php echo get_author_posts_url( $author_id ); ?>?type=ads">
                                      <img src="<?php echo adforest_get_user_dp( $author_id ); ?>" class="avatar avatar-small" alt="<?php echo get_the_title(); ?>">
                                      </a>
                                   </div>
                                   
                                   <!-- View Details -->
                                   <a href="<?php echo get_the_permalink(); ?>" class="view-details">
                                  <?php echo __('View Details', 'adforest' ); ?>
                                   </a>
                                </div>
                                <!-- Ad Img End -->
                                <div class="short-description">
                                   <!-- Ad Category -->
                                   <div class="category-title">
                                   <?php echo adforest_display_cats( get_the_ID() ); ?>
                                   </div>
                                   <!-- Ad Title -->
                                   <h3><a href="<?php echo get_the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                   <!-- Price -->
                                   <div class="price">
                                   <?php echo(adforest_adPrice(get_the_ID())); ?> 
                                   </div>
                                </div>
                                <!-- Addition Info -->
                                <div class="ad-info">
                                   <ul>
                                      <li><i class="fa fa-map-marker"></i><?php echo get_post_meta(get_the_ID(), '_adforest_ad_location', true ); ?></li>
                                   </ul>
                                </div>
                             </div>
                             <!-- Ad Box End -->
                          </div>
                       </div>
               <?php
					}
				}
				wp_reset_postdata();
				?>
               <!-- Featured Ads -->
            </div>
         </div>
      </div>
   </div>
    <?php
	}
	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) )
		{
			$title = $instance[ 'title' ];
		}
		else 
		{
			$title = esc_html__( 'Featured Ads', 'adforest' );
		}
		if ( isset( $instance[ 'max_ads' ] ) )
		{
			$max_ads = $instance[ 'max_ads' ];
		}
		else 
		{
			$max_ads = 5;
		}
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" >
            <?php echo esc_html__( 'Title:', 'adforest' ); ?>
            </label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'max_ads' ) ); ?>" >
            <?php echo esc_html__( 'Max # of Ads:', 'adforest' ); ?>
            </label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'max_ads' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'max_ads' ) ); ?>" type="text" value="<?php echo esc_attr( $max_ads ); ?>">
		</p>
		<?php 
	}
	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance )
	{
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['max_ads'] = ( ! empty( $new_instance['max_ads'] ) ) ? strip_tags( $new_instance['max_ads'] ) : '';
		return $instance;
	}
} // Featured Ads
}


// Recent Ads Widget
add_action( 'widgets_init', function(){
     register_widget( 'adforest_search_recent_ad' );
});
if (! class_exists ( 'adforest_search_recent_ad' )) {
class adforest_search_recent_ad extends WP_Widget {
	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		$widget_ops = array( 
			'classname' => 'adforest_search_recent_ad',
			'description' => __('Only for search and single ad sidebar.', 'adforest'),
		);
		// Instantiate the parent object
		parent::__construct( false, __('Ads Recent', 'adforest' ), $widget_ops );
	}
	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		$max_ads	=	$instance['max_ads'];
		global $adforest_theme;
		
	?>
    
<div class="panel panel-default">
  <!-- Heading -->
  <div class="panel-heading" >
     <h4 class="panel-title">
        <a>
        <?php echo esc_html( $instance['title'] ); ?>
        </a>
     </h4>
  </div>
  <!-- Content -->
  <div class="panel-collapse">
     <div class="panel-body recent-ads">
	   <?php
            $f_args = 
            array( 
            'post_type' => 'ad_post',
            'posts_per_page' => $max_ads,
            'post_status' => 'publish',
            'orderby'        => 'ID',
            'order' => 'DESC',
            );
        $f_ads = new WP_Query( $f_args );
        if ( $f_ads->have_posts() ) {
            $number	= 0;
            while ( $f_ads->have_posts() )
            {
                $f_ads->the_post();
                $pid	=	get_the_ID();
                $author_id = get_post_field( 'post_author', $pid );;
                $author = get_user_by( 'ID', $author_id );
                
               $img	=	$adforest_theme['default_related_image']['url']; 
                $media = get_attached_media( 'image', $pid );
                $total_imgs	=	count( $media );
                if( count( $media ) > 0 )
                {
                    foreach( $media as $m )
                    {
                        $image  = wp_get_attachment_image_src( $m->ID, 'adforest-ad-related');
                        $img	=	$image[0];
                        break;
                    }
                }      

       ?>
        <div class="recent-ads-list">
           <div class="recent-ads-container">
              <div class="recent-ads-list-image">
                 <a href="<?php the_permalink(); ?>" class="recent-ads-list-image-inner">
                 <img alt="<?php echo get_the_title(); ?>" src="<?php echo esc_url( $img ); ?>">
                 </a><!-- /.recent-ads-list-image-inner -->
              </div>
              <!-- /.recent-ads-list-image -->
              <div class="recent-ads-list-content">
                 <h3 class="recent-ads-list-title">
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                 </h3>
                 <ul class="recent-ads-list-location">
                    <li><a href="javascript:void(0);"><?php echo get_post_meta(get_the_ID(), '_adforest_ad_location', true ); ?></a></li>
                 </ul>
                 <div class="recent-ads-list-price">
                    <?php echo(adforest_adPrice(get_the_ID())); ?> 
                 </div>
                 <!-- /.recent-ads-list-price -->
              </div>
              <!-- /.recent-ads-list-content -->
           </div>
           <!-- /.recent-ads-container -->
        </div>
	   <?php
            }
        }
        wp_reset_postdata();
        ?>
 </div>
</div>
</div>               
    <?php
	}
	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) )
		{
			$title = $instance[ 'title' ];
		}
		else 
		{
			$title = esc_html__( 'Recent Ads', 'adforest' );
		}
		if ( isset( $instance[ 'max_ads' ] ) )
		{
			$max_ads = $instance[ 'max_ads' ];
		}
		else 
		{
			$max_ads = 5;
		}
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" >
            <?php echo esc_html__( 'Title:', 'adforest' ); ?>
            </label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'max_ads' ) ); ?>" >
            <?php echo esc_html__( 'Max # of Ads:', 'adforest' ); ?>
            </label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'max_ads' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'max_ads' ) ); ?>" type="text" value="<?php echo esc_attr( $max_ads ); ?>">
		</p>
		<?php 
	}
	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance )
	{
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['max_ads'] = ( ! empty( $new_instance['max_ads'] ) ) ? strip_tags( $new_instance['max_ads'] ) : '';
		return $instance;
	}
} // Recent Ads
}

// Advertisement  Widget
add_action( 'widgets_init', function(){
     register_widget( 'adforest_search_advertisement' );
});
if (! class_exists ( 'adforest_search_advertisement' )) {
class adforest_search_advertisement extends WP_Widget {
	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		$widget_ops = array( 
			'classname' => 'adforest_search_advertisement',
			'description' => __('Only for search and single ad sidebar.', 'adforest'),
		);
		// Instantiate the parent object
		parent::__construct( false, __('Adforest Advertisement', 'adforest' ), $widget_ops );
	}
	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		$ad_code	=	$instance['ad_code'];
		global $adforest_theme;
		
	?>
    
<div class="panel panel-default">
  <!-- Heading -->
  <div class="panel-heading" >
     <h4 class="panel-title">
        <a>
        <?php echo esc_html( $instance['title'] ); ?>
        </a>
     </h4>
  </div>
  <!-- Content -->
  <div class="panel-collapse">
     <div class="panel-body recent-ads">
     	<?php echo "" . $ad_code; ?>
 	 </div>
</div>
</div>               
    <?php
	}
	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) )
		{
			$title = $instance[ 'title' ];
		}
		else 
		{
			$title = esc_html__( 'Advertisement', 'adforest' );
		}
		$ad_code = '';
		if ( isset( $instance[ 'ad_code' ] ) )
		{
			$ad_code = $instance[ 'ad_code' ];
		}
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" >
            <?php echo esc_html__( '300 X 250 Ad', 'adforest' ); ?>
            </label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'ad_code' ) ); ?>" >
            <?php echo esc_html__( 'Code:', 'adforest' ); ?>
            </label> 
			<textarea class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'ad_code' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'ad_code' ) ); ?>" type="text"><?php echo esc_attr( $ad_code ); ?></textarea>
		</p>
		<?php 
	}
	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance )
	{
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['ad_code'] = ( ! empty( $new_instance['ad_code'] ) ) ? $new_instance['ad_code'] : '';
		return $instance;
	}
} // Advertisement
}






/*-------------------------------------------------------------------------------------*/
/* Custom Search */
add_action( 'widgets_init', function(){
     register_widget( 'adforest_search_custom_fields' );
});
if (! class_exists ( 'adforest_search_custom_fields' )) {
class adforest_search_custom_fields extends WP_Widget {
	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		$widget_ops = array( 
			'classname' => 'adforest_search_custom_fields',
			'description' => __('Only for search and single ad sidebar.', 'adforest'),
		);
		// Instantiate the parent object
		parent::__construct( false, __('Custom Fields Search', 'adforest' ), $widget_ops );
	}
	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
public function widget( $args, $instance ) {
	$ad_code	= '';
	if( isset( $instance['ad_code'] ) )
	{
		$ad_code	=	$instance['ad_code'];
	}
	global $adforest_theme;

?>
<?php 
$term_id = '';
$customHTML = '';	
if(isset($_GET['cat_id']) && $_GET['cat_id'] != "" && is_numeric($_GET['cat_id']))
{

$term_id = $_GET['cat_id'];
$result = adforest_dynamic_templateID($term_id);
$templateID = get_term_meta( $result , '_sb_dynamic_form_fields' , true);	
	
if(isset($templateID) && $templateID != "")
{
	$formData = sb_dynamic_form_data($templateID);	
	$customHTML .= '';
	foreach($formData as $r)
	{

			
if( isset($r['types']) && trim($r['types']) != "") {
			
$in_search = (isset($r['in_search']) && $r['in_search'] == "yes") ? 1 : 0;
if($r['titles'] != "" && $r['slugs'] != "" && $in_search == 1){			
	
$customHTML .= '<div class="panel panel-default">
  <div class="panel-heading" >
     <h4 class="panel-title"><a>'.esc_html( $instance['title'] ).' '.esc_html($r['titles']).'</a></h4>
  </div>
  <div class="panel-collapse">
     <div class="panel-body recent-ads">
	 	<div class="skin-minimal">
			<form method="get" action="'.get_the_permalink( $adforest_theme['sb_search_page'] ).'" class="custom-search-form">';			
			$fieldName = "custom[".esc_attr($r['slugs'])."]";
			
					
			$fieldValue = (isset($_GET["custom"]) && isset($_GET['custom'][esc_attr($r['slugs'])])) ? $_GET['custom'][esc_attr($r['slugs'])] : '';
			if(isset($r['types'] ) && $r['types'] == 1)
			{
				$customHTML .= '<div class="search-widget"><input placeholder="'.esc_attr($r['titles']).'" name="'.$fieldName.'" value="'.$fieldValue.'" type="text"><button type="submit"><i class="fa fa-search"></i></button></div>';
			}
			if(isset($r['types'] ) && $r['types'] == 2)
			{
				$options = '';
				if(isset($r['values'] ) && $r['values'] != 1)
				{
					$varArrs = @explode("|", $r['values']);
					$options .= '<option value="0">'.esc_html__("Select Option", "adforest").'</option>';
					foreach($varArrs as $varArr)
					{
						$selected = ($fieldValue == $varArr) ? 'selected="selected"' : '';
						$options .= '<option value="'.esc_attr($varArr).'" '.$selected.'>'.esc_html($varArr).'</option>';
					}
				}
				$customHTML .= '<select name="'.$fieldName.'" class="custom-search-select" >'.$options.'</select>';				
			}
			
				if(isset($r['types'] ) && $r['types'] == 3)
				   {
					$options = '';
					if(isset($r['values'] ) && $r['values'] != 1)
					{
					 $varArrs = @explode("|", $r['values']);
						 
					 $loop = 1;
					 foreach($varArrs as $val)
					 {
					
					  $checked = '';
					  if( isset( $fieldValue ) && $fieldValue != "")
					  {
					   //$checked = in_array($val, $fieldValue) ? 'checked="checked"' : '';
					   $checked = ($val == $fieldValue) ? 'checked="checked"' : '';
					  }
					  //$checked = ( $val == $fieldValue) ? 'checked="checked"' : '';     
					  //$options .= '<li><input type="checkbox" id="minimal-checkbox-'.$loop.'"  value="'.esc_html($val).'" '.$checked.' name="'.$fieldName.'['.$val.']"><label for="minimal-checkbox-'.$loop.'">'.esc_html($val).'</label></li>';
					  $options .= '<li><input type="radio" id="minimal-checkbox-'.$loop.'"  value="'.esc_html($val).'" '.$checked.' name="'.$fieldName.'"><label for="minimal-checkbox-'.$loop.'">'.esc_html($val).'</label></li>';
					  $loop++;     
					 
					 
					 }
					}
					//$customHTML .= '<select name="'.$fieldName.'" class="custom-search-select" >'.$options.'</select>';    
					$customHTML .= '<div class="skin-minimal"><ul class="list">'.$options.'</ul></div>';
				   }				
				$customHTML  .=	 adforest_search_params( $fieldName );
				$customHTML .= '</form></div></div></div></div> ';
		
		}
}
	}
}				
	
}		
		 echo "". $customHTML;		 
?>
     	
 	               
    <?php
	}
	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {

		$title =  ( isset( $instance[ 'title' ] ) ) ? $instance[ 'title' ] : esc_html__( 'Search By:', 'adforest' );
		
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" >
            <?php echo esc_html__( 'Title:', 'adforest' ); ?> <small><?php echo esc_html__( 'You can leave it empty as well', 'adforest' ); ?></small>
            </label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
			<p><?php echo esc_html__( 'You can show/hide the specific type from categories custom fields where you created it.', 'adforest' ); ?> </p>
		</p>
		
		<?php 
	}
	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance )
	{
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		return $instance;
	}
} /*Custom Search*/
}




if ( !function_exists ( 'adforest_getTemplateID' ) ) {
function adforest_getTemplateID($type = 'dynamic', $is_show = '')
{

	if(isset($_GET['cat_id']) && $_GET['cat_id'] != "" && is_numeric($_GET['cat_id']))
	{
		
		$term_id = $_GET['cat_id'];
		$result = adforest_dynamic_templateID($term_id);
		$templateID = get_term_meta( $result , '_sb_dynamic_form_fields' , true);	
	
		if(isset($templateID) && $templateID != "")
		{
			
			if($type != 'dynamic')
			{
				$formData = sb_custom_form_data($templateID, $is_show);	
			}
			else
			{
				$formData = sb_dynamic_form_data($templateID);					
			}			
			return $formData;
		}
		else
		{
			return 1;
		}
	}
	else
	{
		return 1;	
	}
}
}