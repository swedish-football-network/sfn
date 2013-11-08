<?php get_header(); ?>
<div class="main" id="teams">
	<?php if (have_posts()) while (have_posts()) : the_post(); 
	$serie = get_field("serie");
	$kontakt = get_field("kontakt");
	$info = get_field("info");
	$logo = get_field("logo");
	$stadium = get_field("arena");
	$coacher = get_field("coacher");
	$lagbild = get_field("lagbild");
	$aktuellltlag = get_the_title();
	?>
    	<div id="hiddenteamforjscript" style="visibility:hidden"><?php echo $aktuellltlag; ?></div>
		<div class="box full-post">
			
		<?php echo "<img class='logo' src='" . $logo["url"] . "' />";?> <h1><?php the_title(); ?> <?php edit_post_link(__('Edit', 'gray_white_black'), '', ''); ?></h1>
		
        <?php 
        if($lagbild["url"] != ""){
        	echo "<img class='lagbild' src='" . $lagbild["url"] . "' />";
        };
        ?>
		<div class="roster_hdr">Coachstab</div>
        <div id="coacher" class="lagtabeller">
        	<?php echo $coacher;?>
        </div>
        <div class="roster_hdr">Roster</div>
        <div id="roster" class="lagtabeller">
			<?php
				
				$con=mysqli_connect("localhost","wordpress","dukes4gold","SFN");
				mysqli_set_charset($con, "utf8");
				// Check connection
				if (mysqli_connect_errno())
				  {
				  echo "Failed to connect to MySQL: " . mysqli_connect_error();
				  }
				$result = mysqli_query($con,"SELECT * FROM spelare where team = '" . get_the_title() . "'");
				echo "<table class='team-roster'><thead><tr class='header'><th>#</th><th>Förnamn</th><th>Efternamn</th><th>Pos</th><th>Längd</th><th>Vikt</th><th>Ålder</th><th>Erfar.</th><th>Moderklubb</th><tr><thead><tbody>";
				while($row = mysqli_fetch_array($result))
				  {
				  echo "<tr><td>" . $row['number'] . "</td>" . "<td>" . $row['f_name'] . "</td>" . "<td>" . $row['l_name'] . "</td>" . "<td>" . $row['pos'] . "</td>" . "<td>" . $row['length'] . "</td>" . "<td>" . $row['width'] . "</td>";
				  
				  	if($row['born'] != 0 && $row['born'] != null){
				   		echo "<td>" . (date("Y")-$row['born']) . "</td>";
				   	}else{
					   	echo "<td></td>";
				   	}
				   	if($row['play_since'] != 0 && $row['play_since'] != null){
				   		echo "<td>" . (date("Y")-$row['play_since']) . "</td>"; 
				   	}else{
					   	echo "<td></td>";
				   	}
				   	echo "<td style='font-size:10px'>" . $row['start_play']  . "</td></tr>"; 
				  };
				echo "</tbody></table>";
				mysqli_close($con);
				?>
			
			
			
			
        </div>	
		</div>
		<?php if ( comments_open() ) : ?>
			<div id="comments" class="box comments"><?php comments_template(); ?></div>
		<?php endif; ?>
		<p class="pages"><?php wp_link_pages(); ?></p>
	<?php endwhile; ?>
</div>
<div class="sidebar">

<?php
	$tbl = file_get_contents("./tbl/". strtolower(str_replace(" ","",$serie)) ."_tbl.txt");
	echo $tbl;


?>
    <div class="lagruta" id="match">
        <div class="lagruta_hdr">Senaste Matchen</div>
       <?php
		$loop = new WP_Query( array( 'post_type' => 'games', 'posts_per_page' => -1 ) );
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