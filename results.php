<?php
/*
Template Name: results
*/
?>

<?php get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); 
	$division = get_the_title();?>
    <div style="margin-bottom:20px;" id="headline-single"><?php the_title(); ?> <?php edit_post_link(__('Edit', 'gray_white_black'), '', ''); ?></div>
      <div class="full-post">
    </div>
    <div class="main">

	<?php if(has_tag()): ?>
	<div class="box tags">
		<p class="tags"><span><?php the_tags(""); ?></span></p>
	</div>
	<?php endif; ?>
		<p><?php posts_nav_link(); ?></p>

				

			
	<?php endwhile; endif; ?>
</div>
<?php
if(get_the_title() != "Division 1 slutspel"){

	//$tbl = file_get_contents("./tbl/".strtolower(str_replace(" ","",get_the_title()))."_tbl.txt");
	$tbl = file_get_contents("http://www.swedishfootballnetwork.se/tbl/".strtolower(str_replace(" ","",get_the_title()))."_tbl.txt");
	echo $tbl;
        
}


$resultat = array();
$loop = new WP_Query( array( 'post_type' => 'games', 'posts_per_page' => -1 ) );
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
						"matchlink" => get_permalink(),
						"tid" => get_field("tid"),
						"serie" => get_field("serie")
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
					<tr <?php if($veckatemp == date("W")){echo "style='background:#EEE; color:#000;border-left: 1px solid #999; border-right:1px solid #999; border-top:1px solid #999'";}else if($veckatemp - 1 == date("W")){echo "style='border-top: 1px solid #999'";}else{echo "style='background:#fff'";}; ?> ><td style="font-weight:bold; padding-top:5px;">
					<?php 
					if($veckatemp == 37 && ($match["serie"] == "Superserien" || $match["serie"] == "Division 1 Dam")){echo "Final";}else if($veckatemp == 36 && ($match["serie"] == "Superserien")){echo "Semifinal";}else{echo "Vecka " . $veckatemp;}
					 ?>
					
					</td><td></td></tr>
                	<?php
					$vecka = $veckatemp;
				}
				?>
			 	<tr <?php if($vecka == date("W")){echo "style='background:#EEE; color:#000; border-left: 1px solid #999; border-right:1px solid #999; font-size:16px; padding:5px'";} ?>>
                    <td <?php if($vecka == date("W")){echo "style='color:#000;'";} ?>>
						<?php if($match["hemmalink"] != "nope"){echo "<a href='" . $match["hemmalink"] . "'>" . $match["hemmalag"] . "</a>"; }else{ echo $match["hemmalag"]; } ?> 
                        - 
                        <?php if($match["bortalink"] != "nope"){echo "<a href='" . $match["bortalink"] . "'>" . $match["bortalag"] . "</a>"; }else{ echo $match["bortalag"]; } ?> 
                    </td>
                    <td <?php if($vecka == date("W")){echo "style='color:#000; font-size:14px; text-align:right'";} ?> style="text-align:right">
						<?php 
						if($match["hemmares"] != ""){  
							echo "<a href='" . $match["matchlink"] . "'>" .  $match["hemmares"] . " - " . $match["bortares"] . "</a>";
						}else{
							echo "<a href='" . $match["matchlink"] . "'>" .  date("j/n", strtotime($match["datum"])) . " " . $match["tid"] . "</a>";	
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
