<?php get_header(); ?>
 
    <div id="content">

<!--Archive label-->

<?php $post = $posts[0]; ?>

      <?php if (is_category()) { ?>
	<h2 class="entry">
	<?php single_cat_title(); ?></h2>


      <?php } elseif( is_tag()) { ?>
	<h2 class="entry">
	<?php single_tag_title(); ?></h2>


      <?php } elseif (is_day()) { ?>
	<h2 class="entry">
	<?php the_time( get_option('date_format') ); ?></h2>


      <?php } elseif (is_month()) { ?>
	<h2 class="entry">
	<?php the_time('F, Y'); ?></h2>


      <?php } elseif (is_year()) { ?>
	<h2 class="entry">
	<?php the_time('Y'); ?></h2>


      <?php } elseif (is_author()) { ?>
	<h2 class="entry">
	<?php the_time('Y'); ?></h2>


      <?php } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>

	<h2 class="entry"><?php _e('News archives:'); ?></h2>

    <?php } ?>


<!--post-->


        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

	<div class="post" id="post-<?php the_ID(); ?>">


		<div id="postmetadata"> 
		<?php the_category(', '); ?>
		<?php the_tags(', '); ?>
		</div>

        <a href="<?php the_permalink(); ?>">
	<h1><?php the_title(); ?></h1>
	</a>

		<div id="postmetadata"> 
		<?php the_author_posts_link(); ?>, <a href="<?php the_permalink(', '); ?>"><?php the_time( get_option('date_format') ); ?></a>
		<?php edit_post_link(' - EDIT '); ?>
		</div>

		<div id="postmetadata2"> 
		<?php comments_popup_link('Comment &raquo; ', '1 comment &raquo;', '% comments &raquo;'); ?>
		</div>
      
		<!--<?php the_excerpt(); ?>-->
        	<?php the_content(); ?>

		<div class="pagenumber"><?php wp_link_pages(); ?></div>

  		</div>

	<?php endwhile; endif; ?>

    	<div class="navigation"><?php posts_nav_link(); ?></div>
 
	</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>