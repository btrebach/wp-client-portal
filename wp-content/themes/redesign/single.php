<?php get_header(); ?>
 
    <div id="content">

        <?php if(have_posts()) : ?><?php while(have_posts()) : the_post(); ?>
         
        <div class="post">

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

            <div class="entry">   
            <?php the_post_thumbnail(); ?>
            <?php the_content(); ?>

		<div class="pagenumber"><?php wp_link_pages(); ?></div>

	<!--<div class="rss"> 
    	<a href="<?php bloginfo('rss2_url'); ?>">News RSS</a>, 
	<a href="<?php bloginfo('comments_rss2_url'); ?>">Comments RSS</a>
	</div>-->


    </div><!--ends entry-->

<?php endwhile; ?>
     
<div class="comments-template"><?php comments_template(); ?>
<?php paginate_comments_links(); ?> 
</div>




	</div><!--ends post-->

<?php endif; ?>

  		<div class="navigation"><?php previous_post_link(' &laquo; %link ') ?>
		&nbsp; - &nbsp; <?php next_post_link(' %link &raquo; ') ?></div>

</div><!--ends content-->



<?php get_sidebar(); ?>
<?php get_footer(); ?>