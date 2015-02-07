<?php $this -> load -> view('sections/head.php'); 
?>
<body class="background-picture">
	
	<?php
	$this -> load -> view('sections/mali_menu.php');
	$this -> load -> view('sections/sastrane.php');
	?>
	<div class="large-9 columns proziran">
		<div class="row tekst">
			<div class="large-12 columns">
				<h3><?php echo $naslov;?></h3>
				ovdje ide sadrzaj naslovnice koji cemo urediti zahvaljujuci nasoj aniti jejeeeeee
				
					<a href="<?php echo base_url('login')?>">Log in</a>
			</div>
		</div>
	</div>

	<div class="large-12 columns dolje">
		&copy keche
	</div>

	<?php $this -> load -> view('sections/footer_scripts.php'); ?>
</body>
</html>

