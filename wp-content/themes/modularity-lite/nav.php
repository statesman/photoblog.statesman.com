<!-- Navigation -->
  <div id="nav">
    <ul>
      <li style="padding-right:10px; border-right:1px dotted #C4C4C4"><span><a href="/about">About</a></span></li>
      <li class="drop"><span>Photojournalists</span>
        <ul>
        	<?php wp_list_pages('orderby=name&depth=-1i&exclude=473&title_li='); ?>
        </ul>
      </li>
      <li class="drop"><span>Subscribe</span>
        <ul>
          <li><a href="<?php bloginfo('rss2_url'); ?>" class="icon entries">Subscribe to content</a></li>
          <li><a href="<?php bloginfo('comments_rss2_url'); ?>" class="icon comments">Subscribe to comments</a></li>
          <li><a href="http://www.statesman.com/community/content/circulation/index.html" class="icon paper">Subscribe to the paper</a></li>
        </ul>
      </li>
      <li class="drop"><span>Contact</span>
        <ul>
          <li><a href="tel:<?php echo $phone; ?>" class="icon phone"><?php echo $phone; ?></a></li>
          <li><a href="mailto:<?php echo $email; ?>" class="icon email"><?php echo $email; ?></a></li>
        </ul>
      </li>
    </ul>
  </div>
  <div>
    <img src="/wp-content/themes/modularity-lite/images/manneye-400-white.png" width="360">    
  </div>