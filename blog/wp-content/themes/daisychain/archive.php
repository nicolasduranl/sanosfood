<?php
/**
 * The archive template file.
 * @package DaisyChain
 * @since DaisyChain 1.0.0
*/
get_header(); ?>
<?php if ( have_posts() ) : ?>
    <div class="content-headline">
      <h1 class="entry-headline"><?php if ( is_day() ) :
						printf( __( 'Daily Archive: %s', 'daisychain' ), '<span>' . get_the_date() . '</span>' );
					elseif ( is_month() ) :
						printf( __( 'Monthly Archive: %s', 'daisychain' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'daisychain' ) ) . '</span>' );
					elseif ( is_year() ) :
						printf( __( 'Yearly Archive: %s', 'daisychain' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'daisychain' ) ) . '</span>' );
					else :
						_e( 'Archive', 'daisychain' );
					endif ;?></h1>
<?php daisychain_get_breadcrumb(); ?>
    </div>
<?php while (have_posts()) : the_post(); ?>
<?php get_template_part( 'content', 'archives' ); ?>
<?php endwhile; endif; ?> 
<?php daisychain_content_nav( 'nav-below' ); ?>  
  </div> <!-- end of content -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>