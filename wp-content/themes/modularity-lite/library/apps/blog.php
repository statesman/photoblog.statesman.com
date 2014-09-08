<div class="span-<?php
		$sidebar_state = get_option('T_sidebar_state');

		if($sidebar_state == "On") {
			echo "15 colborder home";
		}
		else {
			echo "24 last";
		}
		?>">
<h3 class="sub">Latest</h3>
	<?php if (have_posts()) : ?>
	<?php $i = 0; ?>
		<?php while (have_posts()) : the_post(); $i++; ?>
			<div class="post" id="post-<?php the_ID(); ?>">
				<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
				<div class="entry">
					<?php
						include (THEMELIB . '/apps/multimedia.php');
						the_content();
                    ?>
				</div>
				<div class="clear"></div>
                <div id="ratings"><?php if(function_exists('the_ratings')) { the_ratings(); } ?></div>
				<p class="postmetadata"><?php the_time('M d, Y') ?><?php if(get_the_tags()) the_tags(' | Tags: '); ?> | <?php comments_popup_link('Leave A Comment &#187;', '1 Comment &#187;', '% Comments &#187;'); ?> | More photos from <?php the_author_posts_link(); ?><?php edit_post_link('Edit', ' | ', ''); ?> </p>
			</div>
		<div class="clear"></div>
		<?php endwhile; ?>

		<div id="page_navigation" class="navigation">
			<div class="alignleft"><?php next_posts_link('&laquo; Older Entries') ?></div>
			<div class="alignright"><?php previous_posts_link('Newer Entries &raquo;') ?></div>
		</div>

	<?php else : ?>

		<h2 class="center">Not Found</h2>
		<p class="center">Sorry, but you are looking for something that isn't here.</p>
		<?php include (TEMPLATEPATH . "/searchform.php"); ?>

	<?php endif; ?>
</div>

<?php
		$sidebar_state = get_option('T_sidebar_state');

		if($sidebar_state == "On") {
			get_sidebar() ;
		}
		else {
			echo "";
		}
		?>

</div>
