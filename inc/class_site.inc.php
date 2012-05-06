<?php
class Site
{
	private $titeltext;
	
	public function head()
	{
		print(
'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		');
		if ($this->titeltext != "") {
		print '<title>' . $this->titeltext . '</title>';
		}
		print('
		<!-- CSS -->
		<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="js/jquery.fancybox-1.3.4/fancybox/jquery.fancybox_1.3.4.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="js/nivo-slider/themes/default/default.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="js/nivo-slider/nivo-slider.css" type="text/css" media="screen" />
		<!-- JAVASCRIPT-->
		<script type="text/javascript" src="js/form_effects.js"></script>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
		<script type="text/javascript" src="js/jquery.fancybox-1.3.4/fancybox/jquery.fancybox_1.3.4.pack.js"></script>
		<script type="text/javascript" src="js/jquery.fancybox-1.3.4/fancybox/jquery.easing_1.3.pack.js"></script>
		<script type="text/javascript" src="js/nivo-slider/jquery.nivo.slider.pack.js"></script>
		<script type="text/javascript">
			$(window).load(function() {
        		$("#slider").nivoSlider({
        			effect:"fade",
        			animSpeed:600,
        			pauseTime:3000,
        			controlNav:true,
        			directionNav:true,
        			captionOpacity: 0.7,
        		});
    		});
			$(document).ready(function() {
				$("a.fancybox").fancybox({
					cyclic:true,
				});
				$(".navTab").hover(function() {
				$(this).stop().animate({
					height: "50px",
					top: "-10px"
					}, 200);
				},
				function () {
					$(this).stop().animate({
						height: "40px",
						top: "0px"
					}, 200);
				});
			});
		</script>
	</head>
	<body>
	<div id="wrapper">
	');
	}
	
	public function setTitel($page, $categorie = false)
	{
		if($categorie == false){
			$this->titeltext = 'Digital Library | ' . $page;
		}
		else $this->titeltext = 'Digital Library | ' . $page . ': ' . $categorie;
	}
	
	public function content($daten)
	{
		foreach ($daten as $value) {
			print $value;
		}
	}
	
	public function foot()
	{	  
		print('<!-- FOOTER -->
			<div id="footer">
				<div id="footer_content">
					<div class="left">
						<h2>Kontakt</h2>
						<ul>
							<li><a href="#">Kontaktformular</a></li>
							<li><a href="#">Anfahrt</a></li>
							<li><a href="#">Häufig gestellte Fragen (FAQ)</a></li>
						</ul>
					</div>
					<div class="middle">
						<h2>Rechtliches</h2>
						<ul>
							<li><a href="#">Allgemeine Geschäftsbedingungen (AGB)</a></li>
							<li><a href="#">Impressum</a></li>
							<li><a href="#">Haftungsausschluss</a></li>
						</ul>
					</div>
					<div class="right">
						<h2>Links</h2>
						<ul>
							<li><a href="http://leipzig.sae.edu/de/home/">SAE Institue Leipzig</a></li>
							<li><a href="http://www.coding-contest.de/">Coding Contest</a></li>
							<li><a href="http://www.php.net/">PHP.NET</a></li>
						</ul>
					</div>
					<div class="clear"></div>
				</div>
				<div id="footer_bottom">
				<a href="' . BASE_URL . '"><img src="images/footer_logo.png" alt="Logo" /></a>
				</div>
			</div>
		</div>
	</body>
</html>
');
	}
}
?>