<?php $this -> load -> view('sections/head.php'); 
$stranica='naslovnica.php';
?>
<body class="background-picture">
	<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/hr_HR/sdk.js#xfbml=1&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
	<?php
	$this -> load -> view('sections/mali_menu.php');
	$this -> load -> view('sections/sastrane.php');
	?>
	<div class="large-9 columns proziran">
		<div class="row">
			<div class="large-12 columns">
				<h3><?php echo $naslov;?></h3>
				ovdje ide info o namakoji cemo urediti zahvaljujuci nasoj aniti jejeeeeee
			</div>
			<div class="fb-like" data-href="https://www.facebook.com/pages/MintVint/818888814845454?fref=ts" data-layout="standard" data-action="like" data-show-faces="false" data-share="false"></div>
		</div>
	</div>

	<div class="large-12 columns dolje">
		&copy keche
	</div>

	<?php $this -> load -> view('sections/footer_scripts.php'); ?>
</body>
</html>

