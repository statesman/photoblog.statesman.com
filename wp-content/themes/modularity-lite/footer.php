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
<!--<h3 class="sub">Credits</h3>-->
<p class="quiet">
        <a href="http://www.statesman.com"><img src="http://photoblog.statesman.com/images/aas_logo.gif" /></a><br />
	    Call us at 512-445-3685<br/>
        <a href="http://www.statesman.com/news/content/news/other/multimedia.html">Statesman Multimedia</a><br />
        <a href="http://www.facebook.com/pages/Collective-Vision/134129002039?ref=ts" target="_blank"><img src="http://photoblog.statesman.com/images/facebook-icon.png" /></a>
        <a href="http://www.twitter.com/statesmanphoto" target="_blank"><img src="http://photoblog.statesman.com/images/twitter-icon.png" /></a>
</p>
<br /><br />
<p class="quiet">
		<!--Powered by <a href="http://wordpress.org/">WordPress</a><br />-->
		<a href="<?php bloginfo('rss2_url'); ?>" class="feed">Subscribe to entries</a><br/>
		<a href="<?php bloginfo('comments_rss2_url'); ?>" class="feed">Subscribe to comments</a><br />
		All content &copy; <?php echo date("Y"); ?> by <?php bloginfo('name'); ?><br/>
		<!-- <?php echo get_num_queries(); ?> queries. <?php timer_stop(1); ?> seconds. -->
        Design by <a href="http://graphpaperpress.com">Graph Paper Press</a><br />
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
<!-- SiteCatalyst vH.1. -->
<script src="http://alt.coxnewsweb.com/coxnet/js/brightcove/metrics.js"></script>
<script type="text/javascript" src="http://alt.coxnewsweb.com/cnishared/omniture/sc_cxnt_h15.js"></script>
<script type="text/javascript"><!--
/* Site-Specific Vars */
var cx_regionpath = "TX|Newspaper|Daily|Metro|";
var cx_marketpath = "TX:Austin|Newspaper|Daily:Metro|";
var cx_siteName = "AAS";
var cx_rsID = "coxstatesman";
s_coxnews.siteName=cx_siteName;
s_coxnews.prop25=cx_rsID;

/* Filter Config */
s_coxnews.linkInternalFilters="javascript:,doubleclick.net,alt.coxnewsweb.com,legacy.com,uclick.com,statesman.com,austin360.com,ahorasi.com"
/* Categorization */
var cx_channel;
try { cx_channel = "PHOTOBLOG"; }
catch (e)  { cx_channel=""; }

var cx_subchannel;
try { cx_subchannel = ""; }
catch (e)  { cx_subchannel=""; }

var cx_subchannel2;
try { cx_subchannel2 = ""; }
catch (e)  { cx_subchannel2=""; }

var cx_subchannel3;
try { cx_subchannel3 = ""; }
catch (e)  { cx_subchannel3=""; }

var cx_subchannel4;
try { cx_subchannel4 = ""; }
catch (e)  { cx_subchannel4=""; }

/* Page Properties */
s_coxnews.server=window.location.host;
s_coxnews.channel=s_coxnews.siteName +" | "+cx_channel.toUpperCase(); //Section
s_coxnews.prop14=s_coxnews.channel+" | "+cx_subchannel.toLowerCase(); //Subsection
s_coxnews.prop17=s_coxnews.prop14+" | "+cx_subchannel2.toLowerCase(); //Subsection2
s_coxnews.prop13=cx_siteName+" | "+document.title; //Page Title
/* UR */
s_coxnews.prop2="<%= userId %>"; //UIDs_coxnews.prop3="<%= gender %>"; //URGs_coxnews.prop4="<%= ageGroup %>"; //URAs_coxnews.prop5="<%= zipCode %>"; //URZs_coxnews.prop6="<%= paperUsage %>"; //URNs_coxnews.prop7="<%= householdIncome %>";
s_coxnews.prop8="";
s_coxnews.prop9="";
s_coxnews.prop10="";
s_coxnews.prop13=s_coxnews.siteName+" | "+document.title;
/* Hierarchy Variables */
s_coxnews.hier3 = "cxnt:"+s_coxnews.siteName;
if(cx_channel != "")
    s_coxnews.hier3 +=":"+cx_channel.toLowerCase();
if(cx_subchannel != "")
    s_coxnews.hier3 += ":"+cx_subchannel.toLowerCase();
if(cx_subchannel2 != "")
    s_coxnews.hier3 += ":"+cx_subchannel2.toLowerCase();
if(cx_subchannel3 != "")
    s_coxnews.hier3 += ":"+cx_subchannel3.toLowerCase();
if(cx_subchannel4 != "")
    s_coxnews.hier3 += ":"+cx_subchannel4.toLowerCase();
s_coxnews.hier2=cx_regionpath;
if (cx_marketpath != ""){
s_coxnews.hier1=cx_marketpath;
}
/* E-commerce Variables */
s_coxnews.events="event1"; //Action

/************* DO NOT ALTER ANYTHING BELOW THIS LINE ! **************/
var s_code=s_coxnews.t();if(s_code)document.write(s_code)//--></script>

<script type="text/javascript"><!--
if(navigator.appVersion.indexOf('MSIE')>=0)document.write(unescape('%3C')+'\!-'+'-')
//--></script><noscript><img
src="http://coxnetmasterglobal.112.2O7.net/b/ss/coxnetmasterglobal/1/H.1--NS/0"
height="1" width="1" border="0" alt="" /></noscript><!--/DO NOT REMOVE/-->
<!-- End SiteCatalyst code version: H.1. -->

</body>
</html>
