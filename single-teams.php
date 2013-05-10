<?php get_header(); ?>
<div class="main" id="teams">
	<?php if (have_posts()) while (have_posts()) : the_post(); 
	$serie = get_field("serie");
	$kontakt = get_field("kontakt");
	$info = get_field("info");
	$logo = get_field("logo");
	$stadium = get_field("arena");
	$roster = get_field("roster");
	$coacher = get_field("coacher");
	$lagbild = get_field("lagbild");
	$aktuellltlag = get_the_title();
	?>
    	<div id="hiddenteamforjscript" style="visibility:hidden"><?php echo $aktuellltlag; ?></div>
		<div class="box full-post">
			
		<?php echo "<img class='logo' src='" . $logo["url"] . "' />";?> <h1><?php the_title(); ?> <?php edit_post_link(__('Edit', 'gray_white_black'), '', ''); ?></h1>
		
        <?php echo "<img class='lagbild' src='" . $lagbild["url"] . "' />";?>
		<div class="roster_hdr">Coachstab</div>
        <div id="coacher" class="lagtabeller">
        	<?php echo $coacher;?>
        </div>
        <div class="roster_hdr">Roster</div>
        <div id="roster" class="lagtabeller">
			<?php echo $roster;?>
        </div>	
		</div>
		<?php if ( comments_open() ) : ?>
			<div id="comments" class="box comments"><?php comments_template(); ?></div>
		<?php endif; ?>
		<p class="pages"><?php wp_link_pages(); ?></p>
	<?php endwhile; ?>
</div>
<div class="sidebar">

	<div id="tabell_div">
    
		<?php
		$lag = array();
		$links = array();
		$loop = new WP_Query( array( 'post_type' => 'teams', 'posts_per_page' => 100 ) );
		while ( $loop->have_posts() ) : $loop->the_post();
			if(get_field('serie') == $serie){
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


?>
    <div class="lagruta" id="match">
        <div class="lagruta_hdr">Senaste Matchen</div>
       <?php
		$loop = new WP_Query( array( 'post_type' => 'games', 'posts_per_page' => 100 ) );
		 	$topDate = strtotime("0001-01-01");
			$bottomDate = strtotime("3099-12-31");
			while ( $loop->have_posts() ) : $loop->the_post();
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
					$tempDate = strtotime(get_field("datum"));
					if(($hemmalag == $aktuellltlag or $bortalag == $aktuellltlag) and get_field("hemmares") != ""){
						if($tempDate > $topDate){ 
							$linken = get_permalink();
							$hemma = $hemmalag;
							$borta = $bortalag;
							$linkhemma = $hemmalink;
							$linkborta = $bortalink;
							$hemmares = get_field("hemmares");
							$bortares = get_field("bortares");
							$topDate = $tempDate;						
						};
					};
					if(($hemmalag == $aktuellltlag or $bortalag == $aktuellltlag) and get_field("hemmares") == ""){
						
						if($tempDate < $bottomDate){ 
							$linken2 = get_permalink();
							$hemma2 = $hemmalag;
							$borta2 = $bortalag;
							$linkhemma2 = $hemmalink;
							$linkborta2 = $bortalink;
							$hemmares2 = get_field("hemmares");
							$bortares2 = get_field("bortares");
							$bottomDate = $tempDate;						
						};
					};
			endwhile;
		if($linkhemma != "nope"){echo "<a href='" . $linkhemma . "'>" . $hemma . "</a> - ";}else{echo $hemma . " - ";};
		if($linkborta != "nope"){echo "<a href='" . $linkborta . "'>" . $borta . "</a>";}else{echo $borta;}	 	
		echo "<div style='float:right;position:relative;padding-right:5px;'><a href='" . $linken . "'><b>" . $hemmares . "-" . $bortares . "</b></a></div>";	 
 		?>   
        <div class="lagruta_hdr">Nästa match</div>
        <?php
		if($linkhemma2 != "nope"){echo "<a href='" . $linkhemma2 . "'>" . $hemma2 . "</a> - ";}else{echo $hemma2 . " - ";};
		if($linkborta2 != "nope"){echo "<a href='" . $linkborta2 . "'>" . $borta2 . "</a>";}else{echo $borta2;}
		echo "<div style='float:right;position:relative;padding-right:5px;'><a href='" . $linken2 ."'>" . date("d/m",$bottomDate) . "</a></div>";	 
		
 		?>   
    </div>
    <div class="lagruta" id="kontakt">
        <div class="lagruta_hdr">Kontaktuppgifter</div>
        <?php echo $kontakt ?>
    </div>
    <div class="lagruta" id="info">
        <div class="lagruta_hdr">Information</div>
        <?php echo $info ?>
    </div>
    <div class="lagruta" id="arena">
        <div class="lagruta_hdr">Arena</div>
        <?php echo $stadium ?>
    </div>
</div>

<?php get_footer(); ?>