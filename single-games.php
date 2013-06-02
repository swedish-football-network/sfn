<?php get_header(); ?>

	<?php 
	if (have_posts()) : while (have_posts()) : the_post(); 
		$temp = get_field('hemmalag');
		$id = $temp[0]->ID;
		$hemmabild = get_field("logo",$id);
		$hemmaroster = get_field("roster",$id);
		$hemmalag = get_the_title($id);
		if(get_field("link", $id) == 1){
			$hemmalink = get_permalink($id);
		}else{
			$hemmalink = "nope";
		}
		
		$temp = get_field('bortalag');
		$id = $temp[0]->ID;
		$bortabild = get_field("logo",$id);
		$bortaroster = get_field("roster",$id);
		$bortalag = get_the_title($id);
		if(get_field("link", $id) == 1){
			$bortalink = get_permalink($id);
		}else{
			$bortalink = "nope";
		}
		
		$hemmares = get_field("hemmares");
		$bortares = get_field("bortares");
		$datum = get_field("datum");
		$matchtid = get_field("matchtid");
		$serie = get_field("serie");
		$tid = get_field("tid");
		$rubrik = get_the_title();
		$content = get_the_content();
		$stream = get_field("stream");
		$twitter = get_field("twitter");
		
	
	?>
	
    <div class="full-post">
        <div id="game_header">
        	<div id="hemmalag_hdr" class="hdr hemma">
            	<?php if($hemmalink != "nope"){echo "<a href='" . $hemmalink . "'>" . $hemmalag . "</a>";}else{echo $hemmalag;} ?>
            </div>
            <div id="hemmabild_hdr" class="hdr hemma" <?php if($hemmabild["url"] != ""){ ?> style='background:url(<?php echo $hemmabild["url"] ?>) no-repeat center #fff' <?php } ?>>
			<?php 
			if($hemmabild["url"] != ""){
			?>	
				<img src="<?php bloginfo("template_directory") ?>/images/overlay_game.png"/>
			<?php
            };
			?>
            	
            </div>
            <div id="hemmares_hdr" class="hdr hemma">
            	<?php echo $hemmares ?>
            </div>
            
            <div id="mitten" class="hdr">
            	<div id="serie_hdr">
                	<?php echo $serie ?>
                </div>
                <div id="tiden">
                	<?php 
					if($hemmares != "" and $matchtid == ""){
						echo "SLUT";
					}else if($hemmares == ""){
						echo date('j/n',strtotime($datum)) . " " . $tid;
					}else{
						echo $matchtid;	
					}
						
					
					
					
					
					
					?>
                </div>
            </div>
            
            <div id="bortalag_hdr" class="hdr borta">
            	<?php if($bortalink != "nope"){echo "<a href='" . $bortalink . "'>" . $bortalag . "</a>";}else{echo $bortalag;} ?>
            </div>
            <div id="bortabild_hdr" class="hdr borta" <?php if($bortabild["url"] != ""){ ?> style='background:url(<?php echo $bortabild["url"] ?>) no-repeat center #fff' <?php } ?>>
			<?php 
			if($bortabild["url"] != ""){
			?>	
				<img src="<?php bloginfo("template_directory") ?>/images/overlay_game.png"/>
			<?php
            };
			?>
            	
            </div>
            <div id="bortares_hdr" class="hdr borta">
            	<?php echo $bortares ?>
            </div>
        </div>
    </div>
    <div id="info_button" class="active_button">Info</div>
    <div id="roster_button" class="button">Roster</div>
    <div class="main" style="width:100%">
	<div class="box full-post">
	
	
	
	<div id="info_pane">
<div class="main" style="width:63%">
	
	<?php 
	if($rubrik == "" && $content == ""){
		echo "Ingen övrig info om matchen än";
	}else{
		echo "<h1>".$rubrik."</h1>";
		the_content(); 
	}
	?>
	
</div>		
<div class="sidebar">

	<div id="tabell_div">
    
		<?php
		$lag = array();
		$links = array();
		$loop = new WP_Query( array( 'post_type' => 'teams', 'posts_per_page' => -1 ) );
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
	  		
			$loop = new WP_Query( array( 'post_type' => 'games', 'posts_per_page' => -1 ) );
			while ( $loop->have_posts() ) : $loop->the_post();
			if(get_field('matchtid') == ""){
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
			};
			};
		endwhile;
		
		 if($wins + $loss + $tie == 0){$percent = 0;}else{$percent = (($wins + ($tie / 2))/($wins + $loss + $tie));}        $tabell[] = array(
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
if($twitter != "" || $stream != ""){
?>
        <div class="lagruta" id="ovrig">
        <div class="lagruta_hdr">Info</div>
        <?php
	        if($twitter != ""){echo "<a href='".$twitter."' target='_blank'>Länk till livetwitter</a><br>";};
	        if($stream != ""){echo "<a href='".$stream."' target='_blank'>Länk till livestream</a>";};
        ?>
    </div>
    <?php }; ?>
</div>	   	

	</div>
	<div id="roster_pane">
		<div id="left_game" class="game_panels">
	    
	    	<?php 
	    	if($hemmaroster != ""){echo $hemmaroster;}else{echo "Laget har ingen roster på SFN";}
	    	?>
	        &nbsp;
	    </div>
	    <div id="right_game" class="game_panels">
	    	<?php if($bortaroster != ""){echo $bortaroster;}else{echo "Laget har ingen roster på SFN";}?>
	        &nbsp;
	    </div>	
	</div>	
		
		
	</div>

			<div id="comments" class="box comments"><?php comments_template();?></div>
            
	<?php endwhile; endif; ?>
    
</div>
<?php get_footer(); ?>
