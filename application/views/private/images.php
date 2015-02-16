<?php $this -> load -> view('sections/head.php'); ?>
<body>
	<div class="row">
		<div class="large-12 columns">
			<?php $this -> load -> view('sections/cp_menu.php'); ?>
			<div class="hide-for-small">
				<h3 class="centar">UPRAVLJANJE FOTOGRAFIJAMA</h3>
				
				<a class="button siroki" href="<?php echo base_url('createnew'); ?>">stvori novi</a>
				<?php echo form_open_multipart('imageControl/do_upload');
				?>
 <input type="file" name="userfile" size="20" />
 <input type="submit" value="Unesi"/>
 </form>
		</div>
	</div>
	</div>

	<div class="large-12 columns dolje">
		&copy keche
	</div>

	<?php $this -> load -> view('sections/footer_scripts.php'); ?>
	
</body>
</html>

