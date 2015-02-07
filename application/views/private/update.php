<?php $this -> load -> view('sections/head.php'); ?>
<body>
	<div class="row">
		<div class="large-12 columns">
			<?php $this -> load -> view('sections/cp_menu.php'); ?>
			<div class="hide-for-small">
				<div class="large-12 columns">
					<h2>Hajde uredi svoj postić</h2>
					
				<?php echo form_open('post/update'); ?>
			<label for="naslov">Naslov:
		<?php 
				echo form_error('naslov'); 
			;?>
			</label>
			<input type="text" id="naslov" name="naslov" value="<?php echo $post['naslov']?>"/>
			<br/>
			<label for="sadrzaj">Sadrzaj:
			<?php 
				echo form_error('sadrzaj'); 
			;?>
			</label>
			<input type="text" id="sadrzaj" name="sadrzaj" value="<?php echo $post['sadrzaj']?>"/>
			<br/>
			<input type="hidden" id="id" name="id" value="<?php echo $post['id']?>"/>
			<input class="button" type="submit" value="unesi"/>
			</form>
					
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

