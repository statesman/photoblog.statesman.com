<div class="clear"></div>
</div>
</div>
<div id="footer-wrap">
<div id="footer">
<div class="span-3 append-1 small">
<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Bottom-Left') ) : ?>
<?php endif; ?>
</div>
<div class="column span-3 append-1 small">
<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Bottom-Middle') ) : ?>
<?php endif; ?>
</div>
<div class="column span-10 append-1 small">
<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Bottom-Right') ) : ?>
<?php endif; ?>
</div>
<div class="column span-5 small last">
<p class="quiet">
        <a href="http://www.statesman.com"><img src="http://photoblog.statesman.com/images/aas_logo.gif" /></a><br />
	    Call us at 512-445-3685<br/>
        <a href="http://www.statesman.com/news/content/news/other/multimedia.html">Statesman Multimedia</a><br />
        <a href="http://www.facebook.com/pages/Collective-Vision/134129002039?ref=ts" target="_blank"><img src="http://photoblog.statesman.com/images/facebook-icon.png" /></a>
        <a href="http://www.twitter.com/statesmanphoto" target="_blank"><img src="http://photoblog.statesman.com/images/twitter-icon.png" /></a>
</p>
<br /><br />
<p class="quiet">
		<a href="<?php bloginfo('rss2_url'); ?>" class="feed">Subscribe to entries</a><br/>
		<a href="<?php bloginfo('comments_rss2_url'); ?>" class="feed">Subscribe to comments</a><br />
		All content &copy; <?php echo date("Y"); ?> Austin American-Statesman<br/>
</p>
</div>
<div class="clear"></div>
</div>
</div>
<?php wp_footer(); ?>
<?php
	$tmp_tracking_code = get_option('T_tracking_code');
	if($tmp_tracking_code != ''){
		echo stripslashes($tmp_tracking_code);
	}
?>
</body>
</html>
