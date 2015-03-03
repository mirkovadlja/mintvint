<?php $this -> load -> view('sections/head.php'); ?>
<body>
	<div class="row">
		<div class="large-12 columns">
			<?php $this -> load -> view('sections/cp_menu.php'); ?>
			<div class="hide-for-small">
				<h3>Označite vaš predmet:</h3>

				<div class="large-12 columns">
					<?php echo form_open('gallery/tagit'); ?>
					<div class="panel" id="tagovi">
								
								</div>
					
					<div id="inputi"></div>

					<input type="text" id="oznaka" placeholder="tag" value="" />
					<input type="hidden" name="id" value="<?php echo $lastId;?>">
					<input class="button" id="dodaj" value="Dodaj oznaku"/>
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
	<script src="<?php echo base_url('assets/js'); ?>/tags.js"></script>
</body>
</html>

