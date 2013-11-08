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
		$stats = get_field("stats");
		
	
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
    <div id="info_button" class="active_button">Previews</div>
    <div id="roster_button" class="button">Roster</div>
    <div id="stats_button" class="button">Stats</div>
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
<?php
	$tbl = file_get_contents("./tbl/". strtolower(str_replace(" ","",$serie)) ."_tbl.txt");
	echo $tbl;
?>
        <div class="lagruta" id="ovrig">
        <div class="lagruta_hdr">Info</div>
        <?php
	        if($twitter != ""){echo "<a href='".$twitter."' target='_blank'>Länk till livetwitter</a><br>";}else{echo "Ingen livetwitter har registrerats.<br>";};
	        if($stream != ""){echo "<a href='".$stream."' target='_blank'>Länk till livestream</a>";}else{echo "Ingen livestream har registrerats.";};

        ?>
    </div>
</div>	   	

	</div>
	<div id="roster_pane">
		<div id="left_game" class="game_panels">
	    
	    	<?php 
	    	$con=mysqli_connect("localhost","wordpress","dukes4gold","SFN");
				mysqli_set_charset($con, "utf8");
				// Check connection
				if (mysqli_connect_errno())
				  {
				  echo "Failed to connect to MySQL: " . mysqli_connect_error();
				  }
	    	$result = mysqli_query($con,"SELECT * FROM spelare where team = '" . $save_team_home . "'");
				echo "<table class='team-roster' style='width:100%'><thead><tr class='header'><th>#</th><th>Förnamn</th><th>Efternamn</th><th>Pos</th><th>Längd</th><th>Vikt</th><tr><thead><tbody>";
				while($row = mysqli_fetch_array($result))
				  {
				  echo "<tr><td>" . $row['number'] . "</td>" . "<td>" . $row['f_name'] . "</td>" . "<td>" . $row['l_name'] . "</td>" . "<td>" . $row['pos'] . "</td>" . "<td>" . $row['length'] . "</td>" . "<td>" . $row['width'] . "</td></tr>"; 
				  };
				echo "</tbody></table>";
	    	?>
	        &nbsp;
	    </div>
	    <div id="right_game" class="game_panels">
	    	<?php
	    	$result = mysqli_query($con,"SELECT * FROM spelare where team = '" . $save_team_away . "'");
				echo "<table class='team-roster' style='width:100%'><thead><tr class='header'><th>#</th><th>Förnamn</th><th>Efternamn</th><th>Pos</th><th>Längd</th><th>Vikt</th><tr><thead><tbody>";
				while($row = mysqli_fetch_array($result))
				  {
				  echo "<tr><td>" . $row['number'] . "</td>" . "<td>" . $row['f_name'] . "</td>" . "<td>" . $row['l_name'] . "</td>" . "<td>" . $row['pos'] . "</td>" . "<td>" . $row['length'] . "</td>" . "<td>" . $row['width'] . "</td></tr>"; 
				  };
				echo "</tbody></table>";
				mysqli_close($con);
	    	?>
	       
	    </div>	
	</div>	
	<div id="stats_pane" style="width:100%">
	<?php
	    	if($stats != ""){echo $stats;}else{echo "Statistiken kommer visas här så fort den är inrapporterad.";}
	?>
	</div>	
		
		
	</div>

			<div id="comments" class="box comments"><?php $withcomments = "1"; comments_template(); ?></div>
            
	<?php endwhile; endif; ?>
    
</div>
<?php get_footer(); ?>
