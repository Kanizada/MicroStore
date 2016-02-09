<?php

namespace MicroStore\DAO;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use MicroStore\Domain\Produit;

class ProduitDAO extends DAO
{
    /**
     * Returns a list of all produit, sorted by role and name.
     *
     * @return array A list of all produit.
     */
    public function findAll()
    {
        $sql = "select * from t_produit order by prod_id";
        $result = $this->getDb()->fetchAll($sql);

        // Convert query result to an array of domain objects
        $entities = array();
        foreach ($result as $row) {
            $id = $row['prod_id'];
            $entities[$id] = $this->buildDomainObject($row);
        }
        return $entities;
    }

    /**
     * Returns a produit matching the supplied id.
     *
     * @param integer $id The produit id.
     *
     * @return \MicroCMS\Domain\Produit|throws an exception if no matching user is found
     */
    public function find($id)
    {
        $sql = "select * from t_produit where prod_id=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("No produit matching id " . $id);
    }

    /**
     * Saves a produit into the database.
     *
     * @param \MicroCMS\Domain\Produit $produit The produit to save
     */
    public function save(Produit $produit)
    {
        $produitData = array(
            'prod_name' => $produit->getNomProduit(),
            'prod_lib' => $produit->getDescriptionProduit(),
            'prod_prixK' => $produit->getPrixKiloProduit(),
            'prod_image' => $produit->getImageProduit(),
            'prod_stock' => $produit->getStock(),
        );

        if ($produit->getIdProduit()) {
            // The user has already been saved : update it
            $this->getDb()->update('t_produit', $produitData, array('prod_id' => $produit->getIdProduit()));
        } else {
            // The user has never been saved : insert it
            $this->getDb()->insert('t_produit', $produitData);
            // Get the id of the newly created user and set it on the entity.
            $id = $this->getDb()->lastInsertId();
            $produit->setIdProduit($id);
        }
    }

    /**
     * Removes an produit from the database.
     *
     * @param integer $id The produit id.
     */
    public function delete($id)
    {
        // Delete the user
        $this->getDb()->delete('t_produit', array('prod_id' => $id));
    }

    /**
     * {@inheritDoc}
     */
    public function loadProduitByProdname($prodname)
    {
        $sql = "select * from t_produit ";
        $row = $this->getDb()->fetchAssoc($sql, array($prodname));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new ProdnameNotFoundException(sprintf('Produit "%s" not found.', $prodname));
    }

    /**
     * {@inheritDoc}
     */
    public function supportsClass($class)
    {
        return 'MicroStore\Domain\Produit' === $class;
    }

    /**
     * Creates a Produit object based on a DB row.
     *
     * @param array $row The DB row containing Produit data.
     * @return \MicroCMS\Domain\Produit
     */
    protected function buildDomainObject($row)
    {
        $produit = new Produit();
        $produit->setIdProduit($row['prod_id']);
        $produit->setNomProduit($row['prod_name']);
        $produit->setDescriptionProduit($row['prod_lib']);
        $produit->setPrixKiloProduit($row['prod_prixK']);
        $produit->setImageProduit($row['prod_image']);
        $produit->setStock($row['prod_stock']);
        return $produit;
    }
}
