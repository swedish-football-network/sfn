<?php
/*
Template Name: JSON Feed
*/

$numposts = 5;

function rss_date( $timestamp = null ) {
  $timestamp = ($timestamp==null) ? time() : $timestamp;
  echo date(DATE_RSS, $timestamp);
}

function rss_text_limit($string, $length, $replacer = '...') {
  $string = strip_tags($string);
  $string = preg_replace( "/\r|\n/", " ", $string );
  if(strlen($string) > $length)
    return (preg_match('/^(.*)\W.*$/', substr($string, 0, $length+1), $matches) ? $matches[1] : substr($string, 0, $length)) . $replacer;
  return $string;
}

$posts = query_posts('order_by=date&order=DESC&category_name=superserien&showposts='.$numposts);

$lastpost = $numposts - 1;
$first_post = true;

header("Content-Type: application/json; charset=UTF-8");
?>
{
  "title": "SFN - News for SM-final",
  "link": "http://swedishfootballnetwork.se/",
  "description": "The latest news from SFN.",
  "language": "sv-se",
  "pubDate": "<?php rss_date( strtotime($ps[$lastpost]->post_date_gmt) ); ?>",
  "managingEditor": "info@swedishfootballnetwork.se",
  "articles": [
<?php foreach ($posts as $post) :
$image =  wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'thumbnail' );
if( ! $first_post ) { echo ","; }
?>
  {
    "title": "<?php echo get_the_title($post->ID); ?>",
    "link": "<?php echo get_permalink($post->ID); ?>",
    "featuredImage": "<?php echo $image[0]; ?>",
    "description": "<?php echo rss_text_limit($post->post_content, 250);  ?>",
    "pubDate": "<?php rss_date( strtotime($post->post_date_gmt) ); ?>",
    "guid": "<?php echo get_permalink($post->ID); ?>"
  }
<?php $first_post = false; endforeach; ?>
  ]
}