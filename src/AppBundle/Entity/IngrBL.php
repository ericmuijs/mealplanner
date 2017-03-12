<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Entity\Boodschappenlijst;
use AppBundle\Entity\Ingredient;
use AppBundle\Entity\Afdeling;

/**
 * IngrBL
 *
 * @ORM\Table(name="ingr_bl")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\IngrBLRepository")
 */
class IngrBL
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     *
     * @ORM\ManyToOne(targetEntity="Boodschappenlijst", inversedBy="ingrbl")
     * @ORM\JoinColumn(name="bl_id", referencedColumnName="id", onDelete="SET NULL")
     *
     */    
    private $boodschappenlijst;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Ingredient", inversedBy="ingrbl")
     * @ORM\JoinColumn(name="ingr_id", referencedColumnName="id")
     *
     */    
    private $ingredient;
    
    /**
     *
     * @ORM\ManyToOne(targetEntity="Afdeling", inversedBy="ingrbl")
     * @ORM\JoinColumn(name="afd_id", referencedColumnName="id")
     *
     */    
    private $afdeling;

	/**
	 * @ORM\Column(type="integer")
	 * @Assert\Type("integer")
	 */
	private $servings;

	/**
	 * @ORM\Column(type="text")
	 */
    private $ingr_ingr;
    
    /**
     *
     * @ORM\ManyToOne(targetEntity="ReceptBLOrdered", inversedBy="ingrbl")
     * @ORM\JoinColumn(name="ro_id", referencedColumnName="id")
     *
     */    
    private $receptblordered;    

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set servings
     *
     * @param integer $servings
     *
     * @return IngrBL
     */
    public function setServings($servings)
    {
        $this->servings = $servings;

        return $this;
    }

    /**
     * Get servings
     *
     * @return integer
     */
    public function getServings()
    {
        return $this->servings;
    }

    /**
     * Set boodschappenlijst
     *
     * @param \AppBundle\Entity\Boodschappenlijst $boodschappenlijst
     *
     * @return IngrBL
     */
    public function setBoodschappenlijst(\AppBundle\Entity\Boodschappenlijst $boodschappenlijst = null)
    {
        $this->boodschappenlijst = $boodschappenlijst;

        return $this;
    }

    /**
     * Get boodschappenlijst
     *
     * @return \AppBundle\Entity\Boodschappenlijst
     */
    public function getBoodschappenlijst()
    {
        return $this->boodschappenlijst;
    }

    /**
     * Set ingredient
     *
     * @param \AppBundle\Entity\Ingredient $ingredient
     *
     * @return IngrBL
     */
    public function setIngredient(\AppBundle\Entity\Ingredient $ingredient = null)
    {
        $this->ingredient = $ingredient;

        return $this;
    }

    /**
     * Get ingredient
     *
     * @return \AppBundle\Entity\Ingredient
     */
    public function getIngredient()
    {
        return $this->ingredient;
    }

    /**
     * Set afdeling
     *
     * @param \AppBundle\Entity\Afdeling $afdeling
     *
     * @return IngrBL
     */
    public function setAfdeling(\AppBundle\Entity\Afdeling $afdeling = null)
    {
        $this->afdeling = $afdeling;

        return $this;
    }

    /**
     * Get afdeling
     *
     * @return \AppBundle\Entity\Afdeling
     */
    public function getAfdeling()
    {
        return $this->afdeling;
    }

    /**
     * Set ingrIngr
     *
     * @param string $ingrIngr
     *
     * @return IngrBL
     */
    public function setIngrIngr($ingrIngr)
    {
        $this->ingr_ingr = $ingrIngr;

        return $this;
    }

    /**
     * Get ingrIngr
     *
     * @return string
     */
    public function getIngrIngr()
    {
        return $this->ingr_ingr;
    }

    /**
     * Set receptblordered
     *
     * @param \AppBundle\Entity\ReceptBLOrdered $receptblordered
     *
     * @return IngrBL
     */
    public function setReceptblordered(\AppBundle\Entity\ReceptBLOrdered $receptblordered = null)
    {
        $this->receptblordered = $receptblordered;

        return $this;
    }

    /**
     * Get receptblordered
     *
     * @return \AppBundle\Entity\ReceptBLOrdered
     */
    public function getReceptblordered()
    {
        return $this->receptblordered;
    }
}
