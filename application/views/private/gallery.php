<?php $this -> load -> view('sections/head.php'); ?>
<body>
	<div class="row">
		<div class="large-12 columns">
			<?php $this -> load -> view('sections/cp_menu.php'); ?>
			<div class="hide-for-small">
				<h3 class="centar">GALERIJA</h3>
	<?php foreach($item as $a):
		echo $a->naziv;
endforeach;

		?>
		
		
				 <div class="pagination-centered"><?php echo $links; ?></div>
			</div>
		</div>
	</div>
	
	<div class="large-12 columns dolje">
		&copy keche
	</div>

	<?php $this -> load -> view('sections/footer_scripts.php'); ?>
	
</body>
</html>

