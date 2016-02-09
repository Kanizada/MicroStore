<?php

namespace MicroStore\DAO;

use MicroStore\Domain\Commande;

class CommandeDAO extends DAO
{
    /**
     * Returns a list of all produit, sorted by role and name.
     *
     * @return array A list of all produit.
     */
    public function findAll()
    {
        $sql = "select * from t_commande order by com_id";
        $result = $this->getDb()->fetchAll($sql);

        // Convert query result to an array of domain objects
        $entities = array();
        foreach ($result as $row) {
            $id = $row['com_id'];
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
        $sql = "select * from t_commande where com_id=?";
        $result = $this->getDb()->fetchAll($sql, array($id));

        if ($result){

            // Convert query result to an array of domain objects
            $entities = array();
            foreach ($result as $row) {
                $entities[] = $this->buildDomainObject($row);
            }
            return $entities;

        } else {

            throw new \Exception("No produit matching id " . $id);
        }
    }

    /**
     * Returns a produit matching the supplied id.
     *
     * @param integer $id The produit id.
     *
     * @return \MicroCMS\Domain\Produit|throws an exception if no matching user is found
     */
    public function findByUser($id)
    {
        $sql = "select * from t_commande where fk_usr_id=?";
        $row = $this->getDb()->fetchAll($sql, array($id));

        if ($row) {

            $allCommandes = [];
            foreach ($row as $key => $value) {
                $allCommandes[] = $this->buildDomainObject($value);
            }
            return $allCommandes;
            // return $this->buildDomainObject($row);
        } else {
            return false;
        }
    }

    /**
     * Returns a produit matching the supplied id.
     *
     * @param integer $id The produit id.
     *
     * @return \MicroCMS\Domain\Produit|throws an exception if no matching user is found
     */
    public function findLastId()
    {
        $sql = "select max(com_id) from t_commande";
        $row = $this->getDb()->fetchAssoc($sql)['max(com_id)'];

        if ($row)
            return $row;
        else
            return 0;
    }

    /**
     * Saves a produit into the database.
     *
     * @param \MicroCMS\Domain\Produit $produit The produit to save
     */
    public function save(Commande $commande)
    {
        $commandeData = array(
            'com_id' => $commande->getComId(),
            'com_quantite' => $commande->getComQuantite(),
            'fk_usr_id' => $commande->getUsrId(),
            'fk_prod_id' => $commande->getProdId(),
            'com_etat' => $commande->getComEtat(),
        );

            $this->getDb()->insert('t_commande', $commandeData);
    }

    /**
     * Saves a produit into the database.
     *
     * @param \MicroCMS\Domain\Produit $produit The produit to save
     */
    public function editSave(Commande $commande)
    {
        $commandeData = array(
            'com_id' => $commande->getComId(),
            'com_quantite' => $commande->getComQuantite(),
            'fk_usr_id' => $commande->getUsrId(),
            'fk_prod_id' => $commande->getProdId(),
            'com_etat' => $commande->getComEtat(),
        );

        if ($commande->getComId()) {
            // The user has already been saved : update it
            $this->getDb()->update('t_commande', $commandeData, array('com_id' => $commande->getComId()));
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
        $this->getDb()->delete('t_commande', array('com_id' => $id));
    }

    /**
     * {@inheritDoc}
     */

    public function supportsClass($class)
    {
        return 'MicroStore\Domain\Commande' === $class;
    }

    /**
     * Creates a Produit object based on a DB row.
     *
     * @param array $row The DB row containing Produit data.
     * @return \MicroCMS\Domain\Commande
     */
    protected function buildDomainObject($row)
    {
        $commande = new Commande();
        $commande->setComId($row['com_id']);
        $commande->setComQuantite($row['com_quantite']);
        $commande->setUsrId($row['fk_usr_id']);
        $commande->setProdId($row['fk_prod_id']);
        $commande->setComEtat($row['com_etat']);
        return $commande;
    }

    /**
     * Change state of a produit from the database.
     *
     * @param integer $id The produit id.
     */
    public function stateSave(Commande $commande)
    {
        $commandeData = array(
            'com_etat' => $commande->getComEtat(),
        );
        // Update state of a command
        $count = $this->getDb()->executeUpdate('UPDATE t_commande SET com_etat = ? WHERE com_id = ?', array($commande->getComEtat(), $commande->getComId()));
        return $count;
    }
}
