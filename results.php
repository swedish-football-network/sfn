<?php
/*
Template Name: results
*/
?>

<?php get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); 
	$division = get_the_title();?>
    <div id="headline-single"><?php the_title(); ?> <?php edit_post_link(__('Edit', 'gray_white_black'), '', ''); ?></div>
      <div class="full-post">
    </div>
    <div class="main">
	<div class="box full-post">
		
		
		
		<?php the_content(); ?>
		<?php wp_link_pages(array('before' => '<p class="pages"><strong>'.__('Pages', 'gray_white_black').':</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
	</div>
	<?php if(has_tag()): ?>
	<div class="box tags">
		<p class="tags"><span><?php the_tags(""); ?></span></p>
	</div>
	<?php endif; ?>
		<p><?php posts_nav_link(); ?></p>

				

			
	<?php endwhile; endif; ?>
</div>

<div id="tabell_div_page">
<?php
		$lag = array();
		$links = array();
		$loop = new WP_Query( array( 'post_type' => 'teams', 'posts_per_page' => 100 ) );
		while ( $loop->have_posts() ) : $loop->the_post();
			if(get_field('serie') == $division){
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
                "per" => $percent,
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
 
usort($tabell, 'sort_array');
print_table( $tabell, $links);

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

$resultat = array();
$loop = new WP_Query( array( 'post_type' => 'games', 'posts_per_page' => 100 ) );
			while ( $loop->have_posts() ) : $loop->the_post();
				if(get_field("serie") == $division){
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
						"datum" => get_field("datum"),
						"matchlink" => get_permalink()
					);
					array_push($resultat, $temp);
				} 
		endwhile; 
function cmp($a, $b)
{
    return strcmp($a["datum"], $b["datum"]);
}

usort($resultat, "cmp");
  ?>      
	
<div id="resultat_div_page">
	<table id="resultat">
    		<?php 
			$vecka = 0;
			$veckatemp = 0;
			foreach($resultat as $match){ 
				$datum = strtotime($match["datum"]);
				$veckatemp = date('W', $datum);
				
				if($vecka != $veckatemp){
					?>
					<tr <?php if($veckatemp == date("W")){echo "style='background:#69F; color:#fff;'";}else{ echo "style='background:#fff'";} ?> ><td style="font-weight:bold; padding-top:8px;"><?php echo "Vecka " . $veckatemp ?></td><td></td></tr>
                	<?php
					$vecka = $veckatemp;
				}
				?>
			 	<tr <?php if($vecka == date("W")){echo "style='background:#69F'; color:#fff;";} ?>>
                    <td>
						<?php if($match["hemmalink"] != "nope"){echo "<a href='" . $match["hemmalink"] . "'>" . $match["hemmalag"] . "</a>"; }else{ echo $match["hemmalag"]; } ?> 
                        - 
                        <?php if($match["bortalink"] != "nope"){echo "<a href='" . $match["bortalink"] . "'>" . $match["bortalag"] . "</a>"; }else{ echo $match["bortalag"]; } ?> 
                    </td>
                    <td>
						<?php 
						if($match["hemmares"] != ""){  
							echo "<a href='" . $match["matchlink"] . "'>" .  $match["hemmares"] . " - " . $match["bortares"] . "</a>";
						}else{
							echo "<a href='" . $match["matchlink"] . "'>" .  date("d/m", strtotime($match["datum"])) . "</a>";	
						}
						?>
                    </td>
               </tr>
            <?php		
			}
			?> 
    </table>
</div>


	
  
<?php get_footer(); ?>
