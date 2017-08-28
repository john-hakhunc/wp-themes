<?php global $adforest_theme; ?>
        <a href="<?php echo home_url( '/' ); ?>">
            <?php 
            if( isset( $adforest_theme['sb_site_logo']['url'] ) && $adforest_theme['sb_site_logo']['url'] != "" )
            {
            ?>
               <img src="<?php echo esc_url( $adforest_theme['sb_site_logo']['url'] ); ?>" alt="<?php echo esc_attr__('Site Logo', 'adforest' ); ?>">
            <?php
            }
            else
            {
            ?>
                <img src="<?php echo esc_url( trailingslashit( get_template_directory_uri () ) ). 'images/logo.png' ?>" alt="<?php echo esc_attr__('Site Logo', 'adforest' ); ?>" />
            <?php
            }
            ?>
        </a>


