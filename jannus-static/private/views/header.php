<div id="_HeaderLogo">
	<img src="<?php echo IMG_HTTP?>layout/logo.jpg" />
</div>
<div id="_HeaderMenu">
	<ul class="sf-menu">
		<li><a href="<?php echo ROOT_HTTP ?>"><span<?php if (strtolower($_SESSION['class'])=='accueil') echo ' class="_HighLineViolet"'?>><?php $this->lang('hmenu_1') ?></span></a></li>
		<li><a href="<?php echo ROOT_HTTP ?>offre/resident"><span<?php if (strtolower($_SESSION['class'])=='offre') echo ' class="_HighLineViolet"'?>><?php $this->lang('hmenu_2') ?></span></a>
			<ul>
				<li><a href="<?php echo ROOT_HTTP ?>offre/resident"><span<?php if ( (strtolower($_SESSION['class'])=='offre') && (strtolower($_SESSION['method'])=='resident') ) echo ' class="_HighLineViolet"'?>><?php $this->lang('hmenu_2_1') ?></span></a></li>
				<li><a href="<?php echo ROOT_HTTP ?>offre/gestionnaire"><span<?php if ( (strtolower($_SESSION['class'])=='offre') && (strtolower($_SESSION['method'])=='gestionnaire') ) echo ' class="_HighLineViolet"'?>><?php $this->lang('hmenu_2_2') ?></span></a></li>
			</ul>
		</li>
		<li><a href="<?php echo ROOT_HTTP ?>lesplus"><span<?php if (strtolower($_SESSION['class'])=='lesplus') echo ' class="_HighLineViolet"'?>><?php $this->lang('hmenu_3') ?></span></a></li>
		<li><a href="<?php echo ROOT_HTTP ?>presse"><span<?php if (strtolower($_SESSION['class'])=='presse') echo ' class="_HighLineViolet"'?>><?php $this->lang('hmenu_4') ?></span></a></li>
		<li><a href="<?php echo ROOT_HTTP ?>faq"><span<?php if (strtolower($_SESSION['class'])=='faq') echo ' class="_HighLineViolet"'?>><?php $this->lang('hmenu_5') ?></span></a></li>
		<li><a href="<?php echo ROOT_HTTP ?>contact"><span<?php if (strtolower($_SESSION['class'])=='contact') echo ' class="_HighLineViolet"'?>><?php $this->lang('hmenu_6') ?></span></a></li>
	</ul>
	<a href="http://clients.cooliz.fr" id="_LinkBoClient" target="_blank">Mon compte</a>
</div>