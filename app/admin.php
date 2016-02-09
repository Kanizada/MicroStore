<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use MicroStore\Domain\Comment;
use MicroStore\Domain\Produit;
use MicroStore\Domain\User;
use MicroStore\Domain\Commande;
use MicroStore\DAO\UserDAO;
use MicroStore\DAO\ProduitDAO;
use MicroStore\DAO\CommandeDAO;

$admin = $app['controllers_factory'];

$admin->get('/backoffice', function () use ($app) {
	$produitDAO = new ProduitDAO($app['db']);
	$mesProduits = $produitDAO->findAll();
	$quantiteProduits = 0;
	foreach($mesProduits as $key => $value){
		$quantiteProduits += 1;
	}

	$userDAO = new UserDAO($app['db']);
	$mesUsers = $userDAO->findAll();
	$quantiteUsers = 0;
	foreach($mesUsers as $key => $value){
		$quantiteUsers += 1;
	}

	$quantiteCommandes = 0;
	$commandeDAO = new CommandeDAO($app['db']);
	$mesCommandes = $commandeDAO->findAll();
	$quantiteCommandes = 0;
	foreach($mesCommandes as $key => $value){
		$quantiteCommandes += 1;
	}

	return $app['twig']->render('admin/backoffice.html.twig', array(
		'tableauProduits'	=> $mesProduits,
		'quantiteProduits'	=> $quantiteProduits,
		'tableauUsers'		=> $mesUsers,
		'quantiteUsers' 	=> $quantiteUsers,
		'quantiteCommandes' => $quantiteCommandes,
	));

})->bind('backoffice');

$admin->get('/gestionUtilisateurs', function () use ($app) {
	$userDAO = new UserDAO($app['db']);
	$mesUsers = $userDAO->findAllById();
	$quantiteUsers = 0;
	foreach($mesUsers as $key => $value){
		$quantiteUsers += 1;
	}
	return $app['twig']->render('admin/gestUsers.html.twig', array(
		'tableauUsers'		=> $mesUsers,
		'quantiteUsers' 	=> $quantiteUsers,
	));
})->bind('gestUsers');

$admin->get('/gestionProduits', function () use ($app) {
	$produitDAO = new ProduitDAO($app['db']);
	$mesProduits = $produitDAO->findAll();
	$quantiteProduits = 0;
	foreach($mesProduits as $key => $value){
		$quantiteProduits += 1;
	}
	return $app['twig']->render('admin/gestProds.html.twig', array(
		'tableauProduits'	=> $mesProduits,
		'quantiteProduits'	=> $quantiteProduits,
	));
})->bind('gestProds');

$admin->get('/AjoutProduit', function () use ($app) {
	return $app['twig']->render('admin/addProd.html.twig', array(

	));
})->bind('addProd');

$admin->get('/gestionCommandes', function () use ($app) {
//	CODE A INTEGRER !
	$commandeDAO = new CommandeDAO($app['db']);
	$mesCommandes = $commandeDAO->findAll();
	$quantiteCommandes = 0;
	foreach($mesCommandes as $key => $value){
		$quantiteCommandes += 1;
	}
	return $app['twig']->render('admin/gestComm.html.twig', array(
		'tableauCommandes'	=> $mesCommandes,
		'quantiteCommandes'	=> $quantiteCommandes,
	));
})->bind('gestComm');


// Edition mot de passe admin
$app->post('/changeCommScr', function(Request $request) use ($app) {
  
	$data = $request->request->all();
	$comid = $data["idCom"];
	$commandeDAO = new CommandeDAO($app['db']);
	$produitDAO = new produitDAO($app['db']);
	$mesCommandes = $commandeDAO->find($comid);
	$state = $data["etat"];
	if($state == "Expédiée"){
		foreach ($mesCommandes as $key => $value) {
			$idProd = $value->getProdId();
			$quantiteProdCom = $value->getComQuantite();
			$prodObj = $produitDAO->find($idProd);
			$actualStock = $prodObj->getStock();
			$newStock = $actualStock - $quantiteProdCom;
			if($newStock >= 0){
				$prodObj->setStock($newStock);
				$produitDAO->save($prodObj);
			} else {
				$app['session']->getFlashBag()->add(
					'error',
        			array(
            			'title'   => 'Oups, problème de stock...',
            			'message' => "Si vous demandez $quantiteProdCom Kg de " . $prodObj->getNomProduit(). ", le stock va passer en négatif, augmentez les stocks avant. Stock actuel : " . $prodObj->getStock() . " Kg."));
				return "error";
			}
		}
	}
	foreach ($mesCommandes as $key => $value) {
		$value->setComEtat($state);
		$count = $commandeDAO->stateSave($value);
	}

	return $value->getComEtat();
})->bind('changeCommScr');


// Edition mot de passe admin
$app->post('/changePassScr', function(Request $request) use ($app) {
  
	$data = $request->request->all();

	$userDao = new UserDAO($app['db']);
	$user = $userDao->find($data["id"]);
	$plainPassword = $data["mdp"];
	$salt = substr(md5(time()), 0, 23);
	$user->setSalt($salt);
	$encoder = $app['security.encoder.digest'];
	$password = $encoder->encodePassword($plainPassword, $user->getSalt());
	$user->setPassword($password);
	$userDao->save($user);

	return $user->getPassword();
})->bind('changePassScr');

// Edition produit
$app->post('/changeProdScr', function(Request $request) use ($app) {
  
	$data = $request->request->all();

	$produitDAO = new ProduitDAO($app['db']);
	$produit = $produitDAO->find($data["id"]);
	$produit->setNomProduit($data["nom"]);
	$produit->setDescriptionProduit($data["description"]);
	$produit->setPrixKiloProduit($data["prixKilo"]);
	$produit->setImageProduit($data["image"]);
	$produit->setStock($data["quantite"]);
	$produitDAO->save($produit);

	return var_dump($produit);
})->bind('changeProdScr');

// Ajouter produit
$app->post('/addProdScr', function(Request $request) use ($app) {
  
	$data = $request->request->all();
	$file = $request->files->get('_photo');
	$keys = array_merge(range(0, 9), range('a', 'z'));
	$key = '';
	for ($i = 0; $i < 50; $i++) {
        $key .= $keys[array_rand($keys)];
    }
    $key .= $file->getClientOriginalName();
    $file->move(__DIR__.'/../web/pics/Produit', $key); 

    $produit = new Produit();
	$produit->setNomProduit($data["_nom"]);
	$produit->setDescriptionProduit($data["_desc"]);
	$produit->setPrixKiloProduit($data["_prix"]);
	$produit->setImageProduit($key);
	$produit->setStock($data["_stock"]);
	$produitDAO = new ProduitDAO($app['db']);
	$produitDAO->save($produit);

	return $app->redirect($app['url_generator']->generate('gestProds'));
})->bind('addProdScr');

// Supprimer produit
$app->post('/supprProdScr', function(Request $request) use ($app) {
  
	$data = $request->request->all();

	$produitDAO = new ProduitDAO($app['db']);
	$produitDAO->delete($data["id"]);
	
	return "ok";
})->bind('supprProdScr');



return $admin;