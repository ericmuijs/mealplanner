<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Entity\User;

/**
 * Menu
 *
 * @ORM\Table(name="menu")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MenuRepository")
 */
class Menu
{
	public function __construct() {
		$this->receptenordered = new ArrayCollection();
		$this->recepten = new ArrayCollection();
	}
	
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="naam", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $naam;

    /**
     * @ORM\OneToMany(targetEntity="ReceptOrdered", mappedBy="menu", cascade={"all"})
     */
	private $receptenordered;
	
	private $recepten;
	
    public function getRecepten()
    {
        $recepten = new ArrayCollection();
        
        foreach($this->receptenordered as $r)
        {
            $recepten[] = $r->getRecept();
        }

        return $recepten;
    }	
    
    public function setRecepten($recepten)
    {
        foreach($recepten as $r)
        {
            $ro = new ReceptOrdered();

            $ro->setMenu($this);
            $ro->setRecept($r);
            
            $this->addReceptenOrdered($ro);

        }
    } 
    
    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="menus")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;   

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
     * Set naam
     *
     * @param string $naam
     * @return Menu
     */
    public function setNaam($naam)
    {
        $this->naam = $naam;

        return $this;
    }

    /**
     * Get naam
     *
     * @return string 
     */
    public function getNaam()
    {
        return $this->naam;
    }



    /**
     * Add receptenordered
     *
     * @param \AppBundle\Entity\ReceptOrdered $receptenordered
     * @return Menu
     */
    public function addReceptenordered(\AppBundle\Entity\ReceptOrdered $receptenordered)
    {
        $this->receptenordered[] = $receptenordered;

        return $this;
    }

    /**
     * Remove receptenordered
     *
     * @param \AppBundle\Entity\ReceptOrdered $receptenordered
     */
    public function removeReceptenordered(\AppBundle\Entity\ReceptOrdered $receptenordered)
    {
        $this->receptenordered->removeElement($receptenordered);
    }

    /**
     * Get receptenordered
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getReceptenordered()
    {
        return $this->receptenordered;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     * @return Menu
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
}