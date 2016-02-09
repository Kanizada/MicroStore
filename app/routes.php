<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use MicroStore\Domain\Comment;
use MicroStore\Domain\User;
use MicroStore\Domain\Produit;
use MicroStore\Domain\Commande;
use MicroStore\DAO\UserDAO;
use MicroStore\DAO\ProduitDAO;
use MicroStore\DAO\CommandeDAO;

// Home page
$app->get('/', function () use ($app) {
	return $app['twig']->render('layout.html.twig');
})->bind('home');

// Login form
$app->get('/login', function(Request $request) use ($app) {
	return $app['twig']->render('login.html.twig', array(
		'error'         => $app['security.last_error']($request),
		'last_username' => $app['session']->get('_security.last_username'),
	));
})->bind('login');

// Register form
$app->get('/register', function(Request $request) use ($app) {
	return $app['twig']->render('register.html.twig', array(
		'error'         => $app['security.last_error']($request),
		'last_username' => $app['session']->get('_security.last_username'),
	));
})->bind('register');

// Register validation
$app->post('/register_check', function(Request $request) use ($app) {
  
	$data = $request->request->all();

	$user = new User();
	$user->setUsername($data["_username"]);
	$salt = substr(md5(time()), 0, 23);
	$user->setSalt($salt);
	$plainPassword = $data["_password"];
	$encoder = $app['security.encoder.digest'];
	$password = $encoder->encodePassword($plainPassword, $user->getSalt());
	$user->setPassword($password);
	$user->setRole("ROLE_USER");
	$user->setMail($data["_mail"]);
	$user->setTelephone($data["_tel"]);
	$user->setVille($data["_ville"]);
	$user->setAdresse($data["_adresse"]);
	$userDao = new UserDAO($app['db']);
	$userDao->save($user);

	return $app->redirect('/login');
})->bind('register_check');

$app->get('/produit', function (Request $request) use ($app) {
	 $produitDAO = new produitDAO($app['db']);
	 $mesProduits = $produitDAO->findAll();
	 if(!$app['session']->has('panier')){
		 return $app ['twig']->render('produit.html.twig', array(
			 'error'         => $app['security.last_error']($request),
			 'last_username' => $app['session']->get('_security.last_username'),
			 'ProduitsALL' => $mesProduits,));
	 } else {

		 return $app ['twig']->render('produit.html.twig', array(
			 'error'         => $app['security.last_error']($request),
			 'last_username' => $app['session']->get('_security.last_username'),
			 'ProduitsALL' => $mesProduits,
		 ));
	 }
})->bind('produit');

$app->get('/panier', function (Request $request) use ($app) {
	if(!$app['session']->has('panier')){
		return $app ['twig']->render('panier.html.twig', array(
			'error'         => $app['security.last_error']($request),
			'last_username' => $app['session']->get('_security.last_username'),
		));
	} else {
		$myTmpObject = new ProduitDAO($app['db']);
		$myTmpPanier = $app['session']->get('panier');
		$mySecondTmpPanier;
		foreach ($myTmpPanier as $key => $value) {
			$mySecondTmpPanier[$key]['objet'] = $myTmpObject->find($key);
			$mySecondTmpPanier[$key]['quantite'] = $value;
		}

		return $app ['twig']->render('panier.html.twig', array(
			'error'         => $app['security.last_error']($request),
			'last_username' => $app['session']->get('_security.last_username'),
			'ArrayPanier' 	=> $mySecondTmpPanier,
		));
	}

})->bind('panier');

$app->post('/gopanier', function(Request $request) use ($app) {
	if(!$app['session']->has('panier')){
		$app['session']->set('panier', array());
	}
	$data = $request->request->all();
	$tmpPanier = $app['session']->get('panier');
	if(isset($tmpPanier[$data["prod_id"]])) {
		$qte = $tmpPanier[$data["prod_id"]];
		$qte += intval($data["quantite"]);
		$tmpPanier[$data["prod_id"]] = $qte;
		$app['session']->set('panier', $tmpPanier);
	} else {
		$tmpPanier[$data["prod_id"]] = intval($data["quantite"]);
		$app['session']->set('panier', $tmpPanier);
	}
	return $tmpPanier[$data["prod_id"]];
})->bind('gopanier');

$app->get('/validPanierScr', function (Request $request) use ($app) {
	
	$tmpPanier = $app['session']->get('panier');
	$tableauCommande = [];
	$commandeDAO = new commandeDAO($app['db']);
	$produitDAO = new produitDAO($app['db']);
	$lastId = $commandeDAO->findLastId();
	$lastId = intval($lastId);
	$lastId += 1;

	foreach ($tmpPanier as $key => $value) {
			$tmpObject = $produitDAO->find($key);
			if($tmpObject->getStock() < $value){
				$app['session']->getFlashBag()->add(
					'error',
        			array(
            			'title'   => 'Oups, problème de stock...',
            			'message' => "Vous avez demandé $value Kg de " . $tmpObject->getNomProduit(). ", nous n'en possédons que " . $tmpObject->getStock() . " Kg."));
				return $app->redirect($app['url_generator']->generate('panier'));
			}
			$tableauCommande[$key] = new Commande();
			$tableauCommande[$key]->setComId($lastId);
			$tableauCommande[$key]->setProdId($key);
			$tableauCommande[$key]->setComQuantite($value);
			$token = $app['security']->getToken();
			$user = $token->getUser();
			$tableauCommande[$key]->setUsrId(intval($user->getId()));
			$tableauCommande[$key]->setComEtat('En attente');
		}

		foreach ($tableauCommande as $key => $value) {
			$commandeDAO->save($value);
		}
		$app['session']->remove('panier');
	return $app->redirect($app['url_generator']->generate('profil'));

})->bind('validPanierScr');

$app->post('/addPanierScr', function(Request $request) use ($app) {

	$data = $request->request->all();
	$tmpPanier = $app['session']->get('panier');
	$idQte = intval($data["quantite"]);
	$tmpPanier[$data["id"]] = $idQte;
	$app['session']->set('panier', $tmpPanier);

	return $idQte;
})->bind('addPanierScr');

$app->post('/supprPanierScr', function(Request $request) use ($app) {

	$data = $request->request->all();
	$tmpPanier = $app['session']->get('panier');
	unset($tmpPanier[$data["id"]]);
	$app['session']->set('panier', $tmpPanier);
	$verifPanier = $app['session']->get('panier');
	if( empty($verifPanier)){
		$app['session']->remove('panier');
			return "empty";
	}

	return "ok";
})->bind('supprPanierScr');

$app->get('/viderSession', function (Request $request) use ($app) {
	$app['session']->clear();
	return $app->redirect('/produit');
})->bind('viderSession');


//$app->error(function (\Exception $e, $code) use ($app) {
//
//  if ($app['debug'] && false) {
//    // in debug mode we want to get the regular error message
//    return;
//  }
//
//  switch ($code) {
//  	/*
//		Ok mais c'est quoi le code pour access denied ? 403
//  	*/
//    case 404:
//        $message = 'The requested page could not be found.';
//        break;
//    case 403:
//    	return $app->redirect($app['url_generator']->generate('home'));
//        break;
//    default:
//        $message = 'We are sorry, but something went terribly wrong.';
//  }
//
//  return new Response($message);
//});

$app->mount('/user', include 'user.php');
$app->mount('/admin', include 'admin.php');