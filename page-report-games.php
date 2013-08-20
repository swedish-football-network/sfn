<?php /* Template Name: Report Games [SPECIAL]*/ ?>
<?php
/*-------------------------------------------------------------------------
| Specialsida för att rapportera resultat live via mobilen.
| All kod är skriven inline för att göra sidan fristående.
|
| Skapare: hampus@hampuspersson.se
| Uppdaterad: 2013-07-16
|
|------------------------------------------------------------------------*/

/* Testa så att användaren har admin-rättigheter */
if ( !current_user_can( 'manage_options' ) ) {
	die('Du har inte behörighet att visa denna sida');
}

if( $_POST['game'] ) {
	update_post_meta($_POST['game'], 'hemmares', $_POST['home']);
	update_post_meta($_POST['game'], 'bortares', $_POST['away']);
	update_post_meta($_POST['game'], 'matchtid', $_POST['time']);
	die($_POST['time']);
}
?>
<!doctype html>
<html lang="sv">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<title>Rapportera matchresultat</title>
		<style>
			*, *:before, *:after {
				box-sizing: border-box;
			}

			body {
				max-width: 960px;
				margin: 0 auto;
				padding: 15px;
			}

			.page-title {
				text-align: center;
				font-size: 1.8em;
			}

			.report-tools {
				display: none;
				max-width: 600px;
				margin: 20px auto;
				border-top: 1px solid #ccc;
				padding-top: 20px;
			}

			.input-group {
				display: block;
				float:left;
				width: 50%;
				padding: 0 6px;
			}

			.input-group:nth-child(odd) {
				padding-left: 0;
			}

			.input-group:nth-child(even) {
				padding-right: 0;
			}

			.input-group.full {
				width: 100%;
				margin-top: 10px;
				padding: 0;
			}

			.input-group input, .input-group label {
				display: block;
				width: 100%;
			}

			.input-group input {
				-webkit-appearance: none;
				-webkit-border-radius: 0;
				padding: 1em;
				border: 1px solid #ccc;
				font-size: 1.2em;
			}

			.input-group input[type=text]:active, .input-group input[type=text]:focus {
				outline: none;
				background-color: #D2F870;
			}

			input[type=submit] {
				background-color: #48DD00;
			}

			input[type=submit]:hover {
				background-color: #2DD700;
			}

			input[type=submit]:active {
				background-color: #2DD700;
				margin-top:3px;
				outline: none;
			}

			input[type=submit]:focus {
				outline: none;
			}
			/* DEMO 3 */

			.dropdown {
			    /* Size and position */
			    position: relative;
			    max-width: 400px;
			    margin: 0 auto;
			    padding: 10px;

			    /* Styles */
			    background: #fff;
			    border-radius: 7px;
			    border: 1px solid rgba(0,0,0,0.15);
			    cursor: pointer;
			    outline: none;

			    /* Font settings */
			    font-weight: bold;
			    color: #333;
			}

			.dropdown:after {
			    content: "";
			    width: 0;
			    height: 0;
			    position: absolute;
			    right: 15px;
			    top: 50%;
			    margin-top: -3px;
			    border-width: 6px 6px 0 6px;
			    border-style: solid;
			    border-color: #333 transparent;
			}

			.dropdown .dropdown__list {
			  /* Size & position */
			    position: absolute;
			    top: 90%;
			    left: 0;
			    right: 0;

			    /* Styles */
			    background: white;
			    border-radius: inherit;
			    border: 1px solid rgba(0,0,0,0.17);
			    box-shadow: 0 0 5px rgba(0,0,0,0.1);
			    font-weight: normal;
			    -webkit-transition: all 0.1s ease-in;
			    -moz-transition: all 0.1s ease-in;
			    -ms-transition: all 0.1s ease-in;
			    -o-transition: all 0.1s ease-in;
			    transition: all 0.1s ease-in;
			    list-style: none;

			    /* Hiding */
			    opacity: 0;
			    pointer-events: none;
			    padding: 0 10px;
			}

			.dropdown .dropdown__list:after {
			    content: "";
			    width: 0;
			    height: 0;
			    position: absolute;
			    bottom: 100%;
			    right: 15px;
			    border-width: 0 6px 6px 6px;
			    border-style: solid;
			    border-color: #fff transparent;
			}

			.dropdown .dropdown__list:before {
			    content: "";
			    width: 0;
			    height: 0;
			    position: absolute;
			    bottom: 100%;
			    right: 13px;
			    border-width: 0 8px 8px 8px;
			    border-style: solid;
			    border-color: rgba(0,0,0,0.1) transparent;
			}

			.dropdown .dropdown__list li a {
			    display: block;
			    padding: 10px;
			    text-decoration: none;
			    color: #333;
			    border-bottom: 1px solid #e6e8ea;
			    box-shadow: inset 0 1px 0 rgba(255,255,255,1);
			    -webkit-transition: all 0.3s ease-out;
			    -moz-transition: all 0.3s ease-out;
			    -ms-transition: all 0.3s ease-out;
			    -o-transition: all 0.3s ease-out;
			    transition: all 0.3s ease-out;
			}

			.dropdown .dropdown__list li:first-of-type a {
			    border-radius: 7px 7px 0 0;
			}

			.dropdown .dropdown__list li:last-of-type a {
			    border: none;
			    border-radius: 0 0 7px 7px;
			}

			/* Hover state */

			.dropdown .dropdown__list li:hover a {
			    background: #f3f3f3;
			}

			/* Active state */

			.dropdown.active .dropdown__list {
			    opacity: 1;
			    pointer-events: auto;
			}

			/* No CSS3 support */

			.no-opacity .dropdown .dropdown__list,
			.no-pointerevents .dropdown .dropdown__list {
			    display: none;
			    opacity: 1; /* If opacity support but no pointer-events support */
			    pointer-events: auto; /* If pointer-events support but no pointer-events support */
			}

			.no-opacity .dropdown.active .dropdown__list,
			.no-pointerevents .dropdown.active .dropdown__list {
			    display: block;
			}

			.abbr-title {
				display:none;
			}
		</style>
	</head>
	<body>
		<h1 class="page-title">Rapportera matchresultat</h1>
		<form id="report-form" action="post">
			<input type="hidden" id="game-id" value="0">
			<div id="dd" class="dropdown" tabindex="1">
				<span>Välj match:</span>
				<ul class="dropdown__list">
				<?php
				$todays_date = date('Ymd');
				$todays_date = '20130713';
				$args = array( 'post_type' => 'games', 'orderby' => 'date', 'meta_key' => 'serie', 'meta_value' => 'Superserien', 'meta_key' => 'datum', 'meta_value' => $todays_date );
				$loop = new WP_Query( $args );

				while ( $loop->have_posts() ) :
					$loop->the_post();
					$home = get_field('hemmalag');
					$away = get_field('bortalag');
					$time = get_field('matchtid');
				?>
					<li><a href="#" class="pick-game" data-game-id="<?php echo $post->ID ?>" data-home-score="<?php echo get_field('hemmares'); ?>" data-away-score="<?php echo get_field('bortares'); ?>" data-game-time="<?php echo $time; ?>"><?php echo $home[0]->post_title . ' - ' . $away[0]->post_title; ?></a></li>
				<?php endwhile; ?>
				</ul>
			</div>
			<div class="report-tools" id="report-tools">
				<div class="input-group">
					<label for="home-score">Poäng - Hemma</label>
					<input type="text" name="home-score" id="home-score">
				</div>
				<div class="input-group">
					<label for="away-score">Poäng - Borta</label>
					<input type="text" name="away-score" id="away-score">
				</div>
				<div class="input-group full">
					<label for="time-stamp">Tid (Ex. Q2 7:31. Lämna tom när matchen är slut.)</label>
					<input type="text" name="time-stamp" id="time-stamp" value="1Q 10:00">
				</div>
				<div class="input-group full">
					<input type="submit" id="send-btn" value="Registrera resultat">
				</div>
			</div>
		</form>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
		<script>
			(function() {

				function DropDown(el) {
					this.dd = el;
					this.placeholder = this.dd.children('span');
					this.opts = this.dd.find('ul.dropdown__list > li');
					this.val = '';
					this.index = -1;
					this.initEvents();
				}

				DropDown.prototype = {
					initEvents : function() {
						var obj = this;

						obj.dd.on('click', function(event){
							$(this).toggleClass('active');
							return false;
						});

						obj.opts.on('click',function(){
							var opt = $(this);
							console.log(obj);
							obj.val = opt.text();
							obj.index = opt.index();
							obj.placeholder.text(obj.val);

							$('#report-tools').fadeIn(100);
							$('#game-id').val( opt.find('.pick-game').data('game-id') );
							$('#home-score').val( opt.find('.pick-game').data('home-score') );
							$('#away-score').val( opt.find('.pick-game').data('away-score') );
							$('#time-stamp').val( opt.find('.pick-game').data('game-time') );
						});
					},
					getValue : function() {
						return this.val;
					},
					getIndex : function() {
						return this.index;
					}
				}

				var dd = new DropDown( $('#dd') );

				$(document).click(function() {
					$('.dropdown').removeClass('active');
				});

			}) (jQuery);

			$('#report-form').on('submit', function(e) {
				var game,
						home,
						away,
						time;
				game = $('#game-id').val();
				home = $('#home-score').val();
				away = $('#away-score').val();
				time = $('#time-stamp').val();
				e.preventDefault();
				$('#send-btn').val('Skickar...').css('background-color', '#FFF700');
				$.post('', { 'game': game, 'home': home, 'away': away, 'time': time } )
				.done(function() {
					$('#send-btn').val('Allt gick bra!').css('background-color', '#2DD700');
					setTimeout(function(){
						$('#send-btn').val('Registrera resultat').css('background-color', '#48DD00');
					}, 3000);
				})
				.fail(function() {
					$('#send-btn').val('Något fick fel! Försök igen...').css('background-color', '#F5001D');
					setTimeout(function(){
						$('#send-btn').val('Registrera resultat').css('background-color', '#48DD00');
					}, 3000);
				});
			});
		</script>
	</body>
</html>