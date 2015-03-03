<?php $this -> load -> view('sections/head.php'); ?>
<body>
	<div class="row">
		<div class="large-12 columns">
			<?php $this -> load -> view('sections/cp_menu.php'); ?>
			<div class="hide-for-small">
				<div class="large-12 columns">
					<h3>UREĐIVANJE ITEMA:</h3>
					
				<?php echo form_open_multipart('gallery/update'); ?>
			<label for="naslov">Naziv:
		<?php 
				echo form_error('naziv'); 
			;?>
			</label>
			<input type="text" id="naziv" name="naziv" value="<?php echo $item['naziv']?>"/>
			<br/>
			<label for="opis">Opis:
			<?php 
				echo form_error('opis'); 
			;?>
			</label>
			<textarea type="text" rows="5" id="opis" name="opis" value=""/><?php echo $item['opis']?></textarea>
			<br/>
			<input type="hidden" id="id" name="id" value="<?php echo $item['id']?>"/>
			<input type="hidden" id="foto" name="foto" value="<?php echo $item['foto']?>"/>
			<input type="hidden" id="foto_thumb" name="foto_thumb" value="<?php echo $item['foto_thumb']?>"/>
			<?php //echo $post['foto_thumb'], $post['foto'];?>
			<label for='current_img' >Foto:</label>
			<img name="current_img" src="<?php echo(isset($item['foto_thumb']) ? base_url('assets/img/gallery').'/'.$item['foto_thumb']:'')?>" alt=""/></br></br>
			<label for="new_img">Promjeni fotografiju:
				<?php 
			echo(isset($error) ? $error:'');
			?></label>
			<input type="file" id="new_img" name="new_img" size="20" />
			<input class="button siroki" type="submit" value="Unesi promjene"/>
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

