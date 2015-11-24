<h1>Maintenance des user</h1>
<p><strong>ATTENTION: N'utilisez ce script que si vous savez EXACTEMENT pourquoi !</strong></p>

<p>Cette page exécute une série d'opérations visant à mettre à jour la table 'bo_user' dans la base de données.<br />Le but est de faire correspondre les tables lié aux utilisateur entre drupal users avec la table bo_user du nouveau site.</p>
<p>Listes des opérations</p>
<ul>
	<li>Listes les utilisateur sous drupal (en attendant le nouveau BO-Client)</li>
	<li>Ajoute/Met à jour la liste des user de drupal vers le nouveau BO</li>
	<li>Supprime les user du nouveau BO ne figurant pas sous drupal</li>
	<li>Met à jour les données de la table bo_user_info avec celle de drupal (en attendant le nouveau BO-client)</li>
	<li>Met à jour le status B2C ou B2B avec la table de drupal (en attendant le nouveau BO-Client)</li>
</ul>

<img id="_icon_debugUser" src="<?php echo IMG_HTTP?>icon/loading.gif" /><a href="#" id="_btn_debugUser" class="debugBtn">Lancer l'opération</a>
<p><a href="#" id="_btn_debugUserReset">Reset</a></p>
<h2>Opération réalisé:</h2>
<p><strong id="_nbUserDrupal">0</strong> User Drupal enregistré<br /><strong id="_nbUser">0</strong> User enregistré</p>
<ul id="_resultDebugUser"></ul>