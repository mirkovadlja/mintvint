<?php $this -> load -> view('sections/head.php'); ?>
<body>
	<div class="row">
		<div class="large-12 columns">
			<?php $this -> load -> view('sections/cp_menu.php'); ?>
			<div class="hide-for-small">
				<h3 class="centar">UPRAVLJANJE FOTOGRAFIJAMA</h3>
				
				<a class="button siroki" href="<?php echo base_url('newitem'); ?>">stvori novi</a>
				
				<div class="large-3 columns"><div class="panel"> 
					<a href="<?php echo base_url('gallery')?>"><?php echo 'sve('.$ukupno.')';?></a></br>
					<?php
					
					foreach ($this->gallery_model->getTags() as $row => $value) :
						?>
						<a href="<?php echo base_url('gallery/viewByTag/').'/'.$value->id;?>"><?php echo $value -> tag . '(' . $value -> numb . ')</br>'; ?></a>
						
						<?php
						

					endforeach;
				?>
					
				</div></div>
				<div class="large-9 columns">
<?php
foreach($item as $a):
?>
<div class="large-3 columns gallery">
<img src="<?php echo base_url('assets/img/gallery') . '/' . $a -> foto; ?>"/>
<h5 class="centar"><?php echo $a -> naziv; ?></h5>
<a href="#" data-reveal-id="pregled_<?php echo $a -> id; ?>">(pregled)</a>
<a href="#" data-reveal-id="delete_<?php echo $a->id;?>">delete</a>
<a href="<?php echo base_url(), 'gallery/updateItem/', $a->id;?>" >update</a>		
</div>
<div id="delete_<?php echo $a->id ;?>" class="reveal-modal zatvori" data-reveal>
 
  <fieldset>
  	<?php echo form_open('gallery/deleteItem'); ?>
  		
  		<h4>Jeste li sigurni da želite obristi post pod naslovom:</h4>
  		<h3><?php echo $a->naziv;?></h3>
  		<h4>(Upozorenje: ova radnja je nepovratna!)</h4>
  		
  		<input type="hidden" name="id" value="<?php echo $a -> id;?>">
  		<input type="hidden" name="url" value="<?php echo current_url();?>">
  		<input type="hidden" name="foto" value="<?php echo $a-> foto; ?>">
  		<input type="hidden" name="foto_thumb" value="<?php echo $a-> foto_thumb; ?>">
  		<input class="button odustani siroki" type="submit" value="Obrisi"/>
  		
  		</form>

  		<a class="button custom-close-reveal-modal siroki">Odustani</a>

  </fieldset>
  
  <a class="close-reveal-modal">&#215;</a>
</div>
<div id="pregled_<?php echo $a -> id; ?>" class="reveal-modal zatvori" data-reveal>
 
  <fieldset>
  	<h3><img src="<?php echo base_url(), 'assets/img/gallery/', $a -> foto_thumb; ?>" alt=""/>
  	<?php echo $a->naziv?></h3>
  	<p><?php echo $a -> opis; ?></p>
  	<div class="large-6 columns"><a class="button siroki" href="<?php echo base_url(), 'post/updatepost/', $a -> id; ?>" >Uredi</a></div>			
  	<div class="large-6 columns"><a class="button odustani siroki" href="#" data-reveal-id="delete_<?php echo $a -> id; ?>">Obriši</a></div>
 		<a class="button custom-close-reveal-modal siroki">Odustani</a>
  		</form>

  </fieldset>
  
  <a class="close-reveal-modal">&#215;</a>
</div>
<?php
endforeach;
?></div>
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

