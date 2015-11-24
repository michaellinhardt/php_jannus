<?php
	ini_set('default_socket_timeout', 150); // Change le temps d'attente des connexion distante
	DEFINE( 'PAYMENT_CURRENCY', 978 ); // Default payment currency (ex: 978 = EURO)
	DEFINE( 'ORDER_CURRENCY', PAYMENT_CURRENCY );

	DEFINE( 'SECURITY_MODE', 'SSL' ); // Protocol (ex: SSL = HTTPS)
	DEFINE( 'LANGUAGE_CODE', 'fr' ); // Payline pages language
	
	DEFINE( 'PAYMENT_ACTION', 101 ); // Default payment method
	DEFINE( 'PAYMENT_MODE', 'REC' ); // Default payment mode

	DEFINE('CANCEL_URL', 'http://www.cooliz.fr/public/payline/cancel.php'); // Default cancel URL
	DEFINE('NOTIFICATION_URL','http://www.cooliz.fr/public/payline/notification.php'); // Default notification URL
	DEFINE('RETURN_URL', 'http://www.cooliz.fr/public/payline/return.php'); // Default return URL
	DEFINE('CUSTOM_PAYMENT_TEMPLATE_URL', ''); // Default payment template URL

	DEFINE( 'CONTRACT_NUMBER', '5101105' ); // Contract type default (ex: 001 = CB, 003 = American Express...)
	DEFINE( 'CONTRACT_NUMBER_LIST', '5101105' ); // Contract type multiple values (separator: ;)

	DEFINE( 'CUSTOM_PAYMENT_PAGE_CODE', '' );
?>