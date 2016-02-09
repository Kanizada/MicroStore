<?php

namespace MicroStore\Domain;

use Symfony\Component\Security\Core\Produit\ProduitInterface;

class Produit{

    private $idProduit ;
    private $nomProduit;
    private $descriptionProduit;
    private $imageProduit;
    private $stock;

    /**
     * @return mixed
     */
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * @param mixed $stock
     */
    public function setStock($stock)
    {
        $this->stock = $stock;
    }
    /**
     * @return mixed
     */
    public function getIdProduit()
    {
        return $this->idProduit;
    }

    /**
     * @param mixed $idProduit
     */
    public function setIdProduit($idProduit)
    {
        $this->idProduit = $idProduit;
    }

    /**
     * @return mixed
     */
    public function getNomProduit()
    {
        return $this->nomProduit;
    }

    /**
     * @param mixed $nomProduit
     */
    public function setNomProduit($nomProduit)
    {
        $this->nomProduit = $nomProduit;
    }

    /**
     * @return mixed
     */
    public function getImageProduit()
    {
        return $this->imageProduit;
    }

    /**
     * @param mixed $imageProduit
     */
    public function setImageProduit($imageProduit)
    {
        $this->imageProduit = $imageProduit;
    }

    /**
     * @return mixed
     */
    public function getDescriptionProduit()
    {
        return $this->descriptionProduit;
    }

    /**
     * @param mixed $descriptionProduit
     */
    public function setDescriptionProduit($descriptionProduit)
    {
        $this->descriptionProduit = $descriptionProduit;
    }

    /**
     * @return mixed
     */
    public function getPrixKiloProduit()
    {
        return $this->prixKiloProduit;
    }

    /**
     * @param mixed $prixKiloProduit
     */
    public function setPrixKiloProduit($prixKiloProduit)
    {
        $this->prixKiloProduit = $prixKiloProduit;
    }
    private $prixKiloProduit;
  }