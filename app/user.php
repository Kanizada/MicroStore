<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use MicroStore\Domain\User;
use MicroStore\Domain\Produit;
use MicroStore\Domain\Commande;
use MicroStore\DAO\UserDAO;
use MicroStore\DAO\ProduitDAO;
use MicroStore\DAO\CommandeDAO;
$user = $app['controllers_factory'];

// Profil page
$user->get('/profil', function(Request $request) use ($app) {
	return $app['twig']->render('user/profil.html.twig', array(
		
	));
})->bind('profil');


// Change password page
$user->get('/changePassU', function(Request $request) use ($app) {
	return $app['twig']->render('user/changePassU.html.twig', array(
		
	));
})->bind('changePassU');

// Script edition mot de passe utilisateur
$user->post('/changePassScrU', function(Request $request) use ($app) {
  
	$data = $request->request->all();

	$userDao = new UserDAO($app['db']);
	$userTmp = $userDao->find($data["_id"]);
	$plainPassword = $data["_password"];
	$salt = substr(md5(time()), 0, 23);
	$userTmp->setSalt($salt);
	$encoder = $app['security.encoder.digest'];
	$password = $encoder->encodePassword($plainPassword, $userTmp->getSalt());
	$userTmp->setPassword($password);
	$userDao->save($userTmp);

	return $app->redirect('profil');
})->bind('changePassScrU');



// Change mail page
$user->get('/changeMailU', function(Request $request) use ($app) {
	return $app['twig']->render('user/changeMailU.html.twig', array(
		
	));
})->bind('changeMailU');

// Script edition mail utilisateur
$user->post('/changeMailScrU', function(Request $request) use ($app) {
  
	$data = $request->request->all();

	$userDao = new UserDAO($app['db']);
	$userTmp = $userDao->find($data["_id"]);
	$mail = $data["_mail"];
	$userTmp->setMail($mail);
	$userDao->save($userTmp);

	return $app->redirect('profil');
})->bind('changeMailScrU');



// Change tel page
$user->get('/changeTelU', function(Request $request) use ($app) {
	return $app['twig']->render('user/changeTelU.html.twig', array(
		
	));
})->bind('changeTelU');

// Script edition mail utilisateur
$user->post('/changeTelScrU', function(Request $request) use ($app) {
  
	$data = $request->request->all();

	$userDao = new UserDAO($app['db']);
	$userTmp = $userDao->find($data["_id"]);
	$telephone = $data["_tel"];
	$userTmp->setTelephone($telephone);
	$userDao->save($userTmp);

	return $app->redirect('profil');
})->bind('changeTelScrU');



// Change tel page
$user->get('/changeAdrU', function(Request $request) use ($app) {
	return $app['twig']->render('user/changeAdrU.html.twig', array(
		
	));
})->bind('changeAdrU');

// Script edition mail utilisateur
$user->post('/changeAdrScrU', function(Request $request) use ($app) {
  
	$data = $request->request->all();

	$userDao = new UserDAO($app['db']);
	$userTmp = $userDao->find($data["_id"]);
	$ville = $data["_ville"];
	$adresse = $data["_adr"];
	$userTmp->setVille($ville);
	$userTmp->setAdresse($adresse);
	$userDao->save($userTmp);

	return $app->redirect('profil');
})->bind('changeAdrScrU');

// Change password page
$user->get('/affichCommU', function(Request $request) use ($app) {

	$CommandeDAO = new CommandeDAO($app['db']);
	$token = $app['security']->getToken();
	$user = $token->getUser();
	$Commandes = $CommandeDAO->findByUser($user->getId());
	if($Commandes == false){
		return $app ['twig']->render('user/infoCommU.html.twig', array(
			 'error'         => $app['security.last_error']($request),
			 'last_username' => $app['session']->get('_security.last_username'),
			 ));
	}

	//$Commandes = intval($Commandes);

	return $app ['twig']->render('user/infoCommU.html.twig', array(
			 'error'         => $app['security.last_error']($request),
			 'last_username' => $app['session']->get('_security.last_username'),
			 'CommandeALL' => $Commandes,));
})->bind('affichCommU');


return $user;