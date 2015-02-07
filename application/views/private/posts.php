<?php $this -> load -> view('sections/head.php'); ?>
<body>
	<div class="row">
		<div class="large-12 columns">
			<?php $this -> load -> view('sections/cp_menu.php'); ?>
			<div class="hide-for-small">
				<h1>tvoji postovi </h1>
				<a href="<?php echo base_url('createnew'); ?>">stvori novi</a>
				<table>
					<thead>
						<tr>
							
							<th width="200">Naslov</th>
							<th>Sadržaj</th>
							<th width="150">Datum</th>
							<th width="150">Opcije</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($post as $a):?>
						<tr>
							
							<td><b><?php echo character_limiter($a -> naslov,40); ?></b></td>
							<td><?php echo character_limiter($a -> sadrzaj, 100); ?> <a href="#" data-reveal-id="pregled_<?php echo $a->id;?>">(pregled)</a></td>
							<td><?php echo $a -> datum; ?></td>
							<td><a href="#" data-reveal-id="delete_<?php echo $a->id;?>">delete</a>
								<a href="<?php echo base_url(), 'post/updatepost/', $a->id;?>" >update</a>								
							</td>
						</tr>
						
						
						
<div id="delete_<?php echo $a->id ;?>" class="reveal-modal" data-reveal>
 
  <fieldset>
  	<?php echo form_open('post/deletePost'); ?>
  		<h4><?php echo $a -> id;?></h4>
  		jeste li sigurni da zelite obristi post:</br>
  		<?php echo $a->naslov;
  		?>
  		
  		<input type="hidden" name="id" value="<?php echo $a -> id;?>">
  		<input type="hidden" name="url" value="<?php echo current_url();?>">
  		<input type="submit" value="obrisi"/>
  		</form>

  </fieldset>
  
  <a class="close-reveal-modal">&#215;</a>
</div>
<div id="pregled_<?php echo $a->id ;?>" class="reveal-modal" data-reveal>
 
  <fieldset>
  	<h2><?php echo $a->naslov?></h2>
  	<p><?php echo $a->sadrzaj;?></p>
  		
 <a href="#" data-reveal-id="delete_<?php echo $a->id;?>" >delete</a>
  		</form>

  </fieldset>
  
  <a class="close-reveal-modal">&#215;</a>
</div>
						<?php endforeach; ?>
					</tbody>
				</table>
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

