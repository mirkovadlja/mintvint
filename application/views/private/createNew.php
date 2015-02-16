<?php $this -> load -> view('sections/head.php'); ?>
<body>
	<div class="row">
		<div class="large-12 columns">
			<?php $this -> load -> view('sections/cp_menu.php'); ?>
			<div class="hide-for-small">
				<h3>Kreiraj novi post:</h3>
				<div class="large-12 columns">
					<?php echo form_open_multipart('post/inputNew'); ?>
			<label for="naslov">Naslov:
		<?php 
				echo form_error('naslov'); 
			;?>
			</label>
			<input type="text" id="naslov" name="naslov" value="<?php echo(isset($post['naslov']) ? $post['naslov']: '');?>"/>
			<br/>
			<label for="sadrzaj">Sadržaj:
			<?php 
				echo form_error('sadrzaj'); 
			;?>
			</label>
			<textarea type="text" id="sadrzaj" rows="5" name="sadrzaj" value=""><?php echo(isset($post['sadrzaj']) ? $post['sadrzaj']: '');?></textarea>
			<br/>
			<?php 
			echo(isset($error) ? $error:'');
			?>
			<input type="file" name="postimg" size="20" />
			<input class="button siroki" type="submit" value="Unesi"/>
			</form>
			<a class="button odustani siroki" href="<?php echo base_url(), 'posts'?>">Odustani</a>		
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

