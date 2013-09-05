<div class="sidebar">
<?php 
$tblActive = true;
$rsltActive = true;
if ($tblActive == true){ /* Start Tabell-if */
$tbl = file_get_contents("./tbl.txt");
echo $tbl;
?>

<?php
}; /*Slut Tabell-if*/
if ($rsltActive == true){ /*Start Resultat-if*/
$resultat = array();
$dayofweek = date('N');
$real_week = date('W');

if($dayofweek == "1" or $dayofweek == "2"){$real_week = $real_week - 1;};
$loop = new WP_Query( array( 'post_type' => 'games', 'posts_per_page' => -1 ) );
			while ( $loop->have_posts() ) : $loop->the_post();
				$game_week = date("W",strtotime(get_field("datum")));
				if((get_field("serie") != "Superserien" and $game_week == $real_week) or get_field("serie") == "Womens World Cup"){
					$temp = get_field('hemmalag');
					$id = $temp[0]->ID;
					$hemmalag = get_the_title($id);
					if(get_field("link", $id) == 1){
						$hemmalink = get_permalink($id);
					}else{
						$hemmalink = "nope";
					}
					
					$temp = get_field('bortalag');
					$id = $temp[0]->ID;
					$bortalag = get_the_title($id);
					if(get_field("link", $id) == 1){
						$bortalink = get_permalink($id);
					}else{
						$bortalink = "nope";
					}
					
					$temp = array(
						"hemmalink" => $hemmalink,
						"bortalink" => $bortalink,
						"hemmalag" => $hemmalag,
						"bortalag" => $bortalag,
						"hemmares" => get_field("hemmares"),
						"bortares" => get_field("bortares"),
						"serie" => get_field("serie"),
						"matchlink" => get_permalink(),
						"datum" => get_field("datum"),
						"tid" => get_field("tid")
					);
					array_push($resultat, $temp);
				} 
		endwhile; 
function cmp($a, $b)
{
    if(strcmp($a["serie"], $b["serie"])==0){
	    $ettan = strtotime($a['datum']) + strtotime($a['tid']);
		$tvaan = strtotime($b['datum']) + strtotime($b['tid']);
	
		return $ettan - $tvaan;
    };
    return strcmp($a["serie"], $b["serie"]);
    
};


usort($resultat, "cmp");

if(count($resultat) > 0){	
  ?>      
<div id="resultat_div">
	<table id="resultat">
    		<?php 
			$serie;
			foreach($resultat as $match){ 
				if($match["serie"] != $serie){
					?>
				<tr><td><?php echo "<span style='font-weight:bold'>".$match["serie"]."</span>" ?></td><td></td></tr>
                <?php
					$serie = $match["serie"];
				}
				?>
			 	<tr>
                    <td>
						<?php if($match["hemmalink"] != "nope"){echo "<a href='" . $match["hemmalink"] . "'>" . $match["hemmalag"] . "</a>"; }else{ echo $match["hemmalag"]; } ?> 
                        - 
                        <?php if($match["bortalink"] != "nope"){echo "<a href='" . $match["bortalink"] . "'>" . $match["bortalag"] . "</a>"; }else{ echo $match["bortalag"]; } ?> 
                    </td>
                    <td style="width:55px;">
              		<?php 
					if($match["hemmares"] != ""){
						echo "<a href='" . $match["matchlink"] . "'>" . $match["hemmares"] . " - " . $match["bortares"] . "</a>";
					}else{
						echo "<a href='" . $match["matchlink"] . "'>" . date("D", strtotime($match["datum"])) . " " . $match["tid"] . "</a>";
					}
					?>
                    </td>
               </tr>
            	<?php 		
			}
			?> 
    </table>
    

</div>

		<?php
		}
} /*Slut Resultat-if*/
		if (!dynamic_sidebar('sidebar-widget-area') ) : ?>
		<div class="widget">
			<h3><?php _e( 'Pages', 'gray_white_black' ); ?></h3>
			<ul>
		        <?php wp_list_pages('title_li='); ?>
			</ul>
		</div>
			<div class="widget">
			<h3><?php _e( 'Categories', 'gray_white_black' ); ?></h3>
			<ul>
		        <?php wp_list_categories('title_li='); ?>
			</ul>
		</div>
		<div class="widget">
			<h3><?php _e( 'Archives', 'gray_white_black' ); ?></h3>
			<ul>
				<?php wp_get_archives('type=monthly'); ?>
			</ul>
		</div>
		<?php /* If this is the frontpage */ if ( is_home() || is_page() ) { ?>
		<div class="widget">
			<h3><?php _e( 'Meta', 'gray_white_black' ); ?></h3>
			<ul>
				<?php wp_register(); ?>
				<li><?php wp_loginout(); ?></li>
				<?php wp_meta(); ?>
			</ul>
		</div>
		<?php } ?>
		<?php endif; ?>
</div>