<nav class="top-bar" data-topbar="" role="navigation" data-options="sticky_on: large">
	<ul class="title-area">
		<li class="name">
			<h1><a href="<?php echo base_url('user')?>/cpHome">Nadzorna Ploča</a></h1>
		</li>
		<li class="toggle-topbar menu-icon">
			<a href="#"><span>Menu</span></a>
		</li>
	</ul>

	<section class="top-bar-section">
		<ul class="left">
			<li class="divider hide-for-small"></li>
			<li>
				<a href="<?php echo base_url()?>posts">Postovi</a>
			</li>
			<li class="divider hide-for-small"></li>
			<li>
				<a href="<?php echo base_url('gallery')?>">Galerije</a>
			</li>
			<li class="divider hide-for-small"></li>
			<li>
				<a href="<?php echo base_url('user')?>/pageSettings">Uređivanje</a>
			</li>
		</ul>
		<ul class="right">
			<li>
				<a href="<?php echo base_url('controlPanel')?>/logout"><?php echo $session['username'];?>Odjavi se</a>
			</li>
			
		</ul>
	</section>
</nav>
