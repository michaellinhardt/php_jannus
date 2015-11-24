<form id="connectForm">
	<fieldset id="_contentConnexionForm">
		<legend><?php $this->lang('connexion_titre')?></legend>
		<dl>
			<dd><?php $this->lang('connexion_login')?></dd>
			<dt><input type="text" size="30" id="sConnectLogin" /></dt>
		</dl>
		<dl>
			<dd><?php $this->lang('connexion_pass')?></dd>
			<dt><input type="password" size="30" id="sConnectPass" /></dt>
		</dl>
		<dl>
			<dt><input type="submit" id="bConnectSubmit" value="<?php $this->lang('connexion_submit')?>" /></dt>
		</dl>
		<p id="_connectMsg"></p>
	</fieldset>
</form>