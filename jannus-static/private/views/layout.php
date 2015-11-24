<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//FR"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
		<title>Cooliz.fr</title>
		<link rel="shortcut icon" href="<?php echo IMG_HTTP; ?>favicon.png" type="image/x-icon" />
		<link rev="start" href="<?php echo ROOT_HTTP; ?>" title="Accueil" />
		<link rel="stylesheet" type="text/css" href="<?php echo CSS_HTTP; ?>jquery.css">
		<link rel="stylesheet" type="text/css" href="<?php echo CSS_HTTP; ?>superfish.css">
		<script type="text/javascript" src="<?php echo JS_HTTP; ?>jquery/jquery.js"></script>
		<script type="text/javascript" src="<?php echo JS_HTTP; ?>jquery/jqueryui.js"></script>
		<script type="text/javascript" src="<?php echo JS_HTTP; ?>superfish.js"></script>
		<script type="text/javascript" src="<?php echo JS_HTTP; ?>dump.js"></script>
		<?php $this->head(); ?>
		<!--  <script type="text/javascript">$(document).ready(function(){ jQuery('ul.sf-menu').superfish(); });</script> -->
	</head>
	<body>
		<div id="_HeaderContent">
			<?php include VIEWS_PATH . '/header.php' ; ?>
		</div>
		<div id="_CenterContent">
			<?php $this->incView(); ?>
		</div>
		<div id="_FooterContent">
			<?php include VIEWS_PATH . '/footer.php' ; ?>
		<br />
		</div>
	</body>
</html>

