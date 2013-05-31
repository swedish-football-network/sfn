<?php
/*
Template Name: Custom Feed
*/

$numposts = 5;

function rss_date( $timestamp = null ) {
  $timestamp = ($timestamp==null) ? time() : $timestamp;
  echo date(DATE_RSS, $timestamp);
}

function rss_text_limit($string, $length, $replacer = '...') {
  $string = strip_tags($string);
  if(strlen($string) > $length)
    return (preg_match('/^(.*)\W.*$/', substr($string, 0, $length+1), $matches) ? $matches[1] : substr($string, 0, $length)) . $replacer;
  return $string;
}

$posts = query_posts('order_by=date&order=DESC&category_name=superserien&showposts='.$numposts);

$lastpost = $numposts - 1;

header("Content-Type: application/rss+xml; charset=UTF-8");
echo '<?xml version="1.0"?>';
?><rss version="2.0">
<channel>
  <title>SFN - News for SM-final</title>
  <link>http://swedishfootballnetwork.se/</link>
  <description>The latest news from SFN.</description>
  <language>sv-se</language>
  <pubDate><?php rss_date( strtotime($ps[$lastpost]->post_date_gmt) ); ?></pubDate>
  <lastBuildDate><?php rss_date( strtotime($ps[$lastpost]->post_date_gmt) ); ?></lastBuildDate>
  <managingEditor>info@swedishfootballnetwork.se</managingEditor>
<?php foreach ($posts as $post) {
$image =  wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'thumbnail' );
  ?>
  <item>
    <title><?php echo get_the_title$post->ID); ?></title>
    <link><?php echo get_permalink($post->ID); ?></link>
    <featuredImage><?php echo $image[0]; ?></featuredImage>
    <description><?php echo '<![CDATA['.rss_text_limit($post->post_content, 100).'<br/><br/>Läs mer hos SFN: <a href="'.get_permalink($post->ID).'">'.get_the_title($post->ID).'</a>'.']]>';  ?></description>
    <pubDate><?php rss_date( strtotime($post->post_date_gmt) ); ?></pubDate>
    <guid><?php echo get_permalink($post->ID); ?></guid>
  </item>
<?php } ?>
</channel>
</rss>