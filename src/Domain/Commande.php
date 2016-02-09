<?php
/**
 * Created by PhpStorm.
 * User: gaetan
 * Date: 14/12/2015
 * Time: 16:20
 */

namespace MicroStore\Domain;

class Commande
{
    private $com_id;
    private $com_quantite;
    private $com_etat;
    private $prod_id;
    private $usr_id;
    /**
     * @return mixed
     */
    public function getProdId()
    {
        return $this->prod_id;
    }

    /**
     * @param mixed $prod_id
     */
    public function setProdId($prod_id)
    {
        $this->prod_id = $prod_id;
    }

    /**
     * @return mixed
     */
    public function getUsrId()
    {
        return $this->usr_id;
    }

    /**
     * @param mixed $usr_id
     */
    public function setUsrId($usr_id)
    {
        $this->usr_id = $usr_id;
    }


    /**
     * @return mixed
     */
    public function getComId()
    {
        return $this->com_id;
    }

    /**
     * @param mixed $com_id
     */
    public function setComId($com_id)
    {
        $this->com_id = $com_id;
    }

    /**
     * @return mixed
     */
    public function getComQuantite()
    {
        return $this->com_quantite;
    }

    /**
     * @param mixed $com_quantite
     */
    public function setComQuantite($com_quantite)
    {
        $this->com_quantite = $com_quantite;
    }

    /**
     * @return mixed
     */
    public function getComEtat()
    {
        return $this->com_etat;
    }

    /**
     * @param mixed $com_etat
     */
    public function setComEtat($com_etat)
    {
        $this->com_etat = $com_etat;
    }
}