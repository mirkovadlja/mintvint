<?php $this -> load -> view('sections/head.php'); ?>
<body>
	<div class="row">
		<div class="large-12 columns login">
			
			<?php echo form_open('verifylogin'); ?>
			<label for="username">Korisničko ime:
			<?php 
				echo form_error('username', '<div class="loginer">', '</div>'); 
			;?>
			</label>
			<input type="text" id="username" name="username" value="<?php echo(isset($username) ? $username: '');?>"/>
			<br/>
			<label for="password">Lozinka:
			<?php 
				echo form_error('password', '<div class="loginer">', '</div>'); 
			;?>	
			</label>
			<input type="password" id="passowrd" name="password"/>
			<br/>
			<input type="submit" value="Login"/>
			</form>
			<a href="<?php echo base_url();?>">vrati se na naslovnu</a>
		</div>
	</div>

	<div class="large-12 columns dolje">
		&copy keche
	</div>

	<?php $this -> load -> view('sections/footer_scripts.php'); ?>
</body>
</html>

