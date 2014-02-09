<?php get_header(); ?>
 
    <div id="content">

        <?php if(have_posts()) : ?><?php while(have_posts()) : the_post(); ?>
         
        <div class="post">
        <h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
 
		<div class="postmetadata">
        	<?php edit_post_link('EDIT'); ?><br/>
    		</div>
 
            <div class="entry">
            <?php the_content(); ?>

		<div class="pagenumber">  
		<?php wp_link_pages(); ?> 
		</div>

            </div>
 

		<?php comments_popup_link('No Comments &#187;', '1 Comment &#187;', '% Comments &#187;'); ?>

   			<div class="comments-template"><?php comments_template(); ?>
			<?php paginate_comments_links(); ?> 
			</div>


        </div>

<?php endwhile; ?>
 
<?php endif; ?>
</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>