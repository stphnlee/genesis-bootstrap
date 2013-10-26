<?php

 
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
remove_action('genesis_loop', 'genesis_do_loop');//remove genesis loop
add_action('genesis_loop', 'single_special_loop');//add the special loop
 
function single_special_loop() {
 
	if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

		<h3><?php the_title(); ?></h3>
		<div class="row single-project">
		<div class="col-sm-6">
			<?php the_field( 'description' ); ?>
			<div class="offset6"><a href="<?php /*echo the_field( 'project_url' ); */ ?>http://www.avidnetizen.com/contact"><button class="btn"><!--View-->Contact Avid Netizen Today <?php /*echo the_field( 'title' );*/ ?> &rarr;</button></a></div>
		</div>
		<div class="col-sm-6"><img src="<?php the_field( 'screenshot' ); ?>" /></div>
	


	<?php endwhile; else: ?>
	
		<p>There are no posts</p>
	
	<?php endif; 
}

    genesis();