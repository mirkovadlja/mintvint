<?php $this -> load -> view('sections/head.php'); ?>
<body>
	<div class="row">
		<div class="large-12 columns">
			<?php $this -> load -> view('sections/cp_menu.php'); ?>
			<div class="hide-for-small">
				<h3>Dodaj novi predmet:</h3>
				
				<div class="large-12 columns">
					<?php echo form_open_multipart('gallery/inputnew'); ?>
					<label for="naslov">Naziv: <?php
					echo form_error('naziv'); ;
						?></label>
					<input type="text" id="naziv" name="naziv" value="<?php echo(isset($post['naziv']) ? $post['naziv'] : ''); ?>"/>
					<br/>
					<label for="opis">Opis: <?php
					echo form_error('opis'); ;
						?></label>
					<textarea type="text" id="opis" rows="2" name="opis" value=""><?php echo(isset($post['opis']) ? $post['opis'] : ''); ?></textarea>
					<br/>
					<?php
					echo(isset($error) ? $error : '');
					?>
					<input type="file" name="foto"  size="20" />
					<input class="button siroki" type="submit" value="Unesi"/>
					</form>
					<a class="button odustani siroki" href="<?php echo base_url(), 'gallery'?>">Odustani</a>
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

