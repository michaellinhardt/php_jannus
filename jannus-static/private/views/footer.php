<div id="_FooterMenu">
	<table>
		<tr>
			<td><a href="<?php echo ROOT_HTTP ?>"><?php $this->lang('fmenu_1') ?></a></td>
			<td><a href="<?php echo ROOT_HTTP ?>offre/resident"><?php $this->lang('fmenu_2') ?></a></td>
			<td><a href="<?php echo ROOT_HTTP ?>lesplus"><?php $this->lang('fmenu_3') ?></a></td>
			<td><a href="<?php echo ROOT_HTTP ?>presse"><?php $this->lang('fmenu_4') ?></a></td>
			<td><a href="<?php echo ROOT_HTTP ?>faq"><?php $this->lang('fmenu_5') ?></a></td>
			<td><a href="<?php echo ROOT_HTTP ?>contact"><?php $this->lang('fmenu_6') ?></a></td>
			<td><a href="http://clients.cooliz.fr/user/register">S'inscrire</a></td>
			<td><a href="<?php echo ROOT_HTTP ?>contact"><?php $this->lang('fmenu_6') ?></a></td>
			<td><a href="<?php echo PUBLIC_HTTP ?>download/pdf/cgu/cgu.pdf" target="_blank"><?php $this->lang('fmenu_7') ?></a></td>
			<td class="last"><a href="<?php echo ROOT_HTTP ?>informations/legal"><?php $this->lang('fmenu_8') ?></a></td>
		</tr>
	</table>
</div>
<div id="_FooterText">
	<p>COOLIZ © 2010 est un service de janus TELECOMTM, 1er opérateur et fournisseur d'accès Internet dédié à l'habitat collectif </p>
	<?php if (isset($this->sFooter)) echo $this->sFooter ?>
</div>