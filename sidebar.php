<div class="grid__item one-third">
<?php
$tblActive = false;
$rsltActive = false;
if ($tblActive == true){ /* Start Tabell-if */
?>
<div id="tabell_div_logo"><img src="<?php bloginfo('template_directory'); ?>/images/tbl_ss_logo.png" /></div>
	<div id="tabell_div">

		<?php
		$lag = array();
		$links = array();
		$loop = new WP_Query( array( 'post_type' => 'teams', 'posts_per_page' => 100 ) );
		while ( $loop->have_posts() ) : $loop->the_post();
			if(get_field('serie') == 'Superserien'){
				$lagnamn = get_the_title();
				array_push($lag, $lagnamn);
				if(get_field("link") == 1){
					$permalink = get_permalink();
					$links[$lagnamn] = $permalink;
				}else{
					$links[$lagnamn] = "nope";
				}
			}
		endwhile;
		$ppergame = 2;
		foreach ($lag as $laget){
			$wins = 0;
			$loss = 0;
			$tie = 0;
			$pfor = 0;
			$paga = 0;
			$games = array();

			$loop = new WP_Query( array( 'post_type' => 'games', 'posts_per_page' => 100 ) );
			while ( $loop->have_posts() ) : $loop->the_post();
				if(get_field("hemmares") != ""){
					$temp = get_field('hemmalag');
					$hemmalag = $temp[0]->ID;
					$hemmalag = get_the_title($hemmalag) ;

					$temp = get_field('bortalag');
					$bortalag = $temp[0]->ID;
					$bortalag = get_the_title($bortalag) ;

					if($hemmalag == $laget){
                        if(get_field('hemmares') < get_field('bortares')) {
                                $loss++;
                                $games[$bortalag]['p'] -= 1; // dra bort poäng från inbördes möten
                        }else if(get_field('hemmares') > get_field('bortares')){
                                $wins++;
                                $games[$bortalag]['p'] += 1; // addera poäng i inbördes möten
                        }else if(get_field('hemmares') == get_field('bortares')){
                                $tie++;
                        }
                        $pfor += get_field('hemmares');
                        $paga += get_field('bortares');
                        $games[$bortalag]['s'][] = get_field('hemmares') . "-" . get_field('bortares'); // score, för spårbarhet
                        $games[$bortalag]['diff'] += get_field('hemmares')-get_field('bortares'); // målskillnad i inbördes möten
                	};

                	if($bortalag == $laget){
                        if(get_field('bortares') < get_field('hemmares')) {
                                $loss++;
                                $games[$hemmalag]['p'] -= 1; // dra bort poäng från inbördes möten
                        }else if(get_field('bortares') > get_field('hemmares')){
                                $wins++;
                                $games[$hemmalag]['p'] += 1; // addera poäng i inbördes möten
                        }else if(get_field('bortares') == get_field('hemmares')){
                                $tie++;
                        }
                        $pfor += get_field('bortares');
                        $paga += get_field('hemmares');
                        $games[$hemmalag]['s'][] = get_field('bortares') . "-" . get_field('hemmares'); // score, för spårbarhet
                        $games[$hemmalag]['diff'] += get_field('bortares')-get_field('hemmares'); // målskillnad i inbördes möten
              		};
				}
			endwhile;

		$percent = (($wins + ($tie / 2))/($wins + $loss + $tie));
        $tabell[] = array(
                "lag" => $laget,
                "games" => $games,
                "g" => $wins + $loss + $tie,
                "w" => $wins,
                "t" => $tie,
                "l" => $loss,
                "pfor" => $pfor,
                "paga" => $paga,
                "p" => $wins * $ppergame,
                "per" => $percent
        );
};


/**
 * Lika antal matcher
 *  - poäng
 *  - seriepoäng i inbördes möten
 *  - målskillnad i inbördes möten
 *  - mest gjorda poäng
 *
 * Olika antal matcher
 *  - procent
 *  - seriepoäng i inbördes möten
 *  - målskillnad i inbördes möten
 */
function sort_array($a, $b){
        if( $a['g'] == $b['g'] ) { /* om lagen spelat likan många matcher */
                if( $a['p'] != $b['p'] ) { /* seriepoäng */
                        return ($a['p'] < $b['p']) ? 1 : -1;
                } else {
                        if( $a['games'][$b['lag']]['p'] != 0) { /* Seriepoäng i inbördes möten */
                                return ($a['games'][$b['lag']]['p'] > 0) ? -1 : 1;
                        } else {
                                if( $a['games'][$b['lag']]['diff'] != 0 ) { /* målskillnad i inbördes möten */
                                        return ($a['games'][$b['lag']]['diff'] > 0) ? -1 : 1;
                                } else { /* mest gjorda poäng */
                                        return ($a['pfor'] > $b['pfor']) ? -1 : 1;
                                }
                        }
                }

        } else { /* Om lagen inte spelat lika många matcher, whole new ball game */
                if( $a['per'] != $b['per'] ) { /* vinstprocent */
                        return ($a['per'] < $b['per']) ? 1 : -1;
                } else {
                        if( $a['games'][$b['lag']]['p'] != 0) { /* Seriepoäng i inbördes möten */
                                return ($a['games'][$b['lag']]['p'] > 0) ? -1 : 1;
                        } else {
                                if( $a['games'][$b['lag']]['diff'] != 0 ) { /* målskillnad i inbördes möten */
                                        return ($a['games'][$b['lag']]['diff'] > 0) ? -1 : 1;
                                }
                        }
                }
        }
}


function print_table( $tabell , $ar) {
        echo "<table id='tabell' border=0 cellpadding=3>";
                echo "<tr>";
                        echo "<td>Lag</td>";
                        echo "<td>G</td>";
                        echo "<td>W</td>";
                        echo "<td>L</td>";
                        echo "<td>T</td>";
                        echo "<td>+</td>";
                        echo "<td>-</td>";
                        echo "<td>P</td>";
                        echo "<td>%</td>";
                echo "</tr>";
        foreach( $tabell as $position ) {
                echo "<tr>";
						$lag = $position['lag'];
						if ($ar[$lag] != "nope"){
							echo "<td><a href='" . $ar[$lag] . "'>" . $position['lag'] . "</a></td>";
						}else{
                        	echo "<td>" . $position['lag'] . "</td>";
						}
						echo "<td>" . $position['g'] . "</td>";
                        echo "<td>" . $position['w'] . "</td>";
                        echo "<td>" . $position['l'] . "</td>";
                        echo "<td>" . $position['t'] . "</td>";
                        echo "<td>" . $position['pfor'] . "</td>";
                        echo "<td>" . $position['paga'] . "</td>";
                        echo "<td>" . $position['p'] . "</td>";
                        echo "<td>" . round($position['per']*100) . "</td>";
                echo "</tr>";
        }
        echo "</table></div>";

	}

	usort($tabell, 'sort_array');
	print_table( $tabell, $links);

}; /*Slut Tabell-if*/
if ($rsltActive == true){ /*Start Resultat-if*/
$resultat = array();
$dayofweek = date('N');
$real_week = date('W');

if($dayofweek == "1" or $dayofweek == "2"){$real_week = $real_week - 1;};
$loop = new WP_Query( array( 'post_type' => 'games', 'posts_per_page' => 300 ) );
			while ( $loop->have_posts() ) : $loop->the_post();
				$game_week = date("W",strtotime(get_field("datum")));
				if(get_field("serie") != "Superserien" and $game_week == $real_week){
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
    return strcmp($a["serie"], $b["serie"]);
}

usort($resultat, "cmp");
  ?>

<div id="resultat_div">
	<table id="resultat">
    		<?php
			$serie;
			foreach($resultat as $match){
				if($match["serie"] != $serie){
					?>
				<tr><td><?php echo $match["serie"] ?></td><td></td></tr>
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
                    <td>
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