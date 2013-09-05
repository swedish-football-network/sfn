<?php
define( 'BLOCK_LOAD', true );
require_once( $_SERVER['DOCUMENT_ROOT'] . '/wp-config.php' );
require_once( $_SERVER['DOCUMENT_ROOT'] . '/wp-includes/wp-db.php' );
$wpdb = new wpdb( 'root', 'kalle123', 'wordpress', 'localhost');
?>
<div id="tabell_div_logo"><img src="<?php bloginfo('template_directory'); ?>/images/tbl_ss_logo.png" /></div>	
	<div id="tabell_div">
    
		<?php
		$lag = array();
		$links = array();
		$loop = new WP_Query( array( 'post_type' => 'teams', 'posts_per_page' => -1, 'meta_key' => 'serie', 'meta_value' => 'Superserien', 'orderby' => 'title', 'order' => 'DESC' ) );
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
	  		
			$loop = new WP_Query( array( 'post_type' => 'games', 'posts_per_page' => -1, 'meta_key' => 'serie', 'meta_value' => 'Superserien' ) );
			while ( $loop->have_posts() ) : $loop->the_post();
				if(get_field('matchtid') == "" and strpos(get_the_title(), 'inal') == false){
				if(get_field("hemmares") != ""){
					$temp = get_field('hemmalag');
					$hemmalag = $temp[0]->ID;
					$hemmalag = get_the_title($hemmalag);
					
					$temp = get_field('bortalag');
					$bortalag = $temp[0]->ID;
					$bortalag = get_the_title($bortalag);
					
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
				};
				};
			endwhile;
		
		 if($wins + $loss + $tie == 0){$percent = 0;}else{$percent = (($wins + ($tie / 2))/($wins + $loss + $tie));}
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
 *  - Total Målskillnad
 *
 * Olika antal matcher
 *  - procent
 *  - seriepoäng i inbördes möten
 *  - målskillnad i inbördes möten
 *  - Total målskillnad
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
                                } else { /* Total målskillnad */
                                        return (($a['pfor'] - $a['paga']) > ($b['pfor'] - $b['paga'])) ? -1 : 1;
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
                                } else { /* Total målskillnad */
                                        return (($a['pfor'] - $a['paga']) > ($b['pfor'] - $b['paga'])) ? -1 : 1;
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
	?>
