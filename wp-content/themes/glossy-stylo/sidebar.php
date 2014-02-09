<div id="sidebar" role="complementary">
	<div id="sidebarhead"></div>
		<div id="sidebarinner">
		<?php if ( has_nav_menu( 'menu' ) ) : wp_nav_menu( array( 'container_id'    => 'access' ,  'theme_location' => 'menu' ) ); else : endif; ?>

			<ul>
		
				<?php 	/* Widgetized sidebar, if you have the plugin installed. */
						if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar() ) : ?>
				<li>
					<?php get_search_form(); ?>
				</li>

				<?php if ( is_404() || is_category() || is_day() || is_month() ||
							is_year() || is_search() || is_paged() ) {
				?> <li>

				<?php /* If this is a 404 page */ if (is_404()) { ?>
				<?php /* If this is a category archive */ } elseif (is_category()) { ?>
				<p>You are currently browsing the archives for the <?php single_cat_title(''); ?> category.</p>

				<?php /* If this is a daily archive */ } elseif (is_day()) { ?>
				<p>You are currently browsing the <a href="<?php echo home_url(); ?>/"><?php bloginfo('name'); ?></a> blog archives
				for the day <?php the_time(get_option('date_format')); ?>.</p>

				<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
				<p>You are currently browsing the <a href="<?php echo home_url(); ?>/"><?php bloginfo('name'); ?></a> blog archives
				for <?php the_time(get_option('date_format')); ?>.</p>

				<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
				<p>You are currently browsing the <a href="<?php echo home_url(); ?>/"><?php bloginfo('name'); ?></a> blog archives
				for the year <?php the_time(get_option('date_format')); ?>.</p>

				<?php /* If this is a search result */ } elseif (is_search()) { ?>
				<p>You have searched the <a href="<?php echo home_url(); ?>/"><?php bloginfo('name'); ?></a> blog archives
				for <strong>'<?php the_search_query(); ?>'</strong>. If you are unable to find anything in these search results, you can try one of these links.</p>

				<?php /* If this set is paginated */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
				<p>You are currently browsing the <a href="<?php echo home_url(); ?>/"><?php bloginfo('name'); ?></a> blog archives.</p>

				<?php } ?>

				</li>
			<?php }?>
			</ul>
			<ul role="navigation">
		 

				<h2>Pages</h2>
				<?php wp_nav_menu(); ?>
				<li>
					<h2>Archives</h2>
						<ul>
						<?php wp_get_archives('type=monthly'); ?>
						</ul>
				</li>
				
					<li>
					<h2>Login</h2>
						<ul>
						<?php wp_login_form(); ?> 
						</ul>
				</li>
				

				<?php wp_list_categories('show_count=1&title_li=<h2>Categories</h2>'); ?>
			</ul>
			<ul>
				<?php /* If this is the frontpage */ if ( is_home() || is_page() ) { ?>
					<?php wp_list_bookmarks(); ?>

					<li><h2>Meta</h2>
					<ul>
						<?php wp_register(); ?>
						<li><?php wp_loginout(); ?></li>
						 <?php wp_meta(); ?>
					</ul>
					</li>
				<?php } ?>

				<?php endif; ?>
			</ul>
			
		</div>
		<div id="sidebarfooter"></div>
</div>