<?php
echo '<a href="http://www.cooliz.fr/payline/examples/demos/web.php" />Retour au site de test</a><br />
<a href="http://www.cooliz.fr/payline/track.html" target="_blank" />Voir le Tracking</a><br /><br />' ;
function logThis( $mVar )
{
	/*
	 * Date et heure
	 */
	$sDate = date( 'Y-m-d' ) ;
	$sTime = date( 'H:i:s' ) ;
	/*
	 * Chemin d'acces du fichier
	 */
	$sPath = microtime(true) .'.txt' ;
	/*
	 * Formatage du log
	 */
	$oFile = fopen( $sPath, 'a+' ) ;
	fwrite( $oFile, $mVar ) ;
	fclose( $oFile ) ;
}

function varDump($mVar)
{
    ob_start();
    var_dump($mVar);
    $sResult = ob_get_clean();
    return $sResult;
}

?>