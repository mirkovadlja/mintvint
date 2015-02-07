<?php $this -> load -> view('sections/head.php'); ?>
<body>
	<div class="row">
		<div class="large-12 columns">
			<?php $this -> load -> view('sections/cp_menu.php'); ?>
			<div class="hide-for-small">
				<h1>tvoji postovi </h1>
				<div class="large-12 columns">
					<?php echo form_open('post/inputNew'); ?>
			<label for="naslov">Naslov:
		<?php 
				echo form_error('naslov'); 
			;?>
			</label>
			<input type="text" id="naslov" name="naslov" value="<?php echo(isset($post['naslov']) ? $post['naslov']: '');?>"/>
			<br/>
			<label for="sadrzaj">Sadrzaj:
			<?php 
				echo form_error('sadrzaj'); 
			;?>
			</label>
			<input type="text" id="sadrzaj" name="sadrzaj" value="<?php echo(isset($post['sadrzaj']) ? $post['sadrzaj']: '');?>"/>
			<br/>
			<input class="button" type="submit" value="unesi"/>
			</form>
					
				</div>
			</div>
		</div>
	</div>

	<div class="large-12 columns dolje">
		&copy keche
	</div>

	<?php $this -> load -> view('sections/footer_scripts.php'); ?>
</body>
</html>

