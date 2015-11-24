$(document).ready(function(){
	iImgAccueil = 1 ; // Image de départ
	iRotationTime = 5000 ; // temps entre chaque image
	setTimeout('imgAccueil();', iRotationTime ); // Lance la rotation d'image de la page d'accueil
});

function imgAccueil()
{
	if (iImgAccueil==5) iImgAccueil = 1 ;
	else iImgAccueil++ ;
	
	$('#_ImgAccueil').attr('src', sBaseurl + 'public/img/pages/accueil/img' + iImgAccueil + '.jpg' );
	
	setTimeout('imgAccueil();', iRotationTime );
}