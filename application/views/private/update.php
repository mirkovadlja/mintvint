<?php $this -> load -> view('sections/head.php'); ?>
<body>
	<div class="row">
		<div class="large-12 columns">
			<?php $this -> load -> view('sections/cp_menu.php'); ?>
			<div class="hide-for-small">
				<div class="large-12 columns">
					<h3>UREĐIVANJE POSTA:</h3>
					
				<?php echo form_open_multipart('post/update'); ?>
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
			<textarea type="text" rows="5" id="sadrzaj" name="sadrzaj" value=""/><?php echo $post['sadrzaj']?></textarea>
			<br/>
			<input type="hidden" id="id" name="id" value="<?php echo $post['id']?>"/>
			<input type="hidden" id="foto" name="foto" value="<?php echo $post['foto']?>"/>
			<input type="hidden" id="foto_thumb" name="foto_thumb" value="<?php echo $post['foto_thumb']?>"/>
			<?php //echo $post['foto_thumb'], $post['foto'];?>
			<label for='current_img' >Foto:</label>
			<img name="current_img" src="<?php echo(isset($post['foto_thumb']) ? base_url('assets/img/posts').'/'.$post['foto_thumb']:'')?>" alt=""/></br></br>
			<label for="new_img">Promjeni fotografiju:
				<?php 
			echo(isset($error) ? $error:'');
			?></label>
			<input type="file" id="new_img" name="new_img" size="20" />
			<input class="button siroki" type="submit" value="Unesi promjene"/>
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

