<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ReceptRepository")
 * @ORM\Table(name="recept") 
 * @Vich\Uploadable
 */
class Recept
{
    public function __construct() {
    	$this->ingredienten = new ArrayCollection();
        $this->tags = new ArrayCollection();
        $this->receptenordered = new ArrayCollection();
        $this->receptenblordered = new ArrayCollection();
    }

	/**
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;
	
	/**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank()
     */
    private $titel;
    
    /**
     * @ORM\Column(type="text", nullable=true)
     */    
    private $beschrijving;
    
    /**
     * @ORM\Column(type="string", nullable=true)
     */      
    private $bereidingstijd;
    
    /**
     * @ORM\OneToMany(targetEntity="Ingredient", mappedBy="recept", cascade={"persist"})
     * @Assert\Valid
     */
     private $ingredienten;

    /**
     * @ORM\Column(type="text", nullable=true)
     */        
    private $bereidingswijze;
    
    /** 
     * @Vich\UploadableField(mapping="recept_foto", fileNameProperty="fotoNaam")
     * @var File
     */
    private $fotoBestand;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string
     */
    private $fotoNaam;

	/**
     * @ORM\ManyToOne(targetEntity="Gerecht", inversedBy="recepten")
     * @ORM\JoinColumn(name="gerecht_id", referencedColumnName="id")
     */    
    private $gerecht;

	/**
     * @ORM\ManyToOne(targetEntity="Keuken", inversedBy="recepten")
     * @ORM\JoinColumn(name="keuken_id", referencedColumnName="id")
     */      
    private $keuken;

	/**
     * @ORM\ManyToOne(targetEntity="Hoofdingredient", inversedBy="recepten")
     * @ORM\JoinColumn(name="hoofdingredient_id", referencedColumnName="id")
     */       
    private $hoofdingredient;
    
    /**
     * @ORM\ManyToMany(targetEntity="Tag", inversedBy="recepten")
     * @ORM\JoinTable(name="recepten_tags")
     */
    private $tags;
	
	/**
	 * @var \DateTime $toegevoegdOp
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="create")
     * @var \DateTime      
     */   
    private $toegevoegdOp;
    
	/**
	 * @var \DateTime $aangepastOp
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="update")
     * @var \DateTime     
     */    
    private $aangepastOp;
    
    /**
     * @ORM\Column(type="decimal", scale=2, nullable=true)
     */    
    private $kostprijs;
    
    /**
     * @ORM\OneToMany(targetEntity="ReceptOrdered", mappedBy="recept", cascade={"all"})
     */
	private $receptenordered;
	
	/**
     * @ORM\OneToMany(targetEntity="ReceptBLOrdered", mappedBy="recept", cascade={"all"})
     */
	private $receptenblordered;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="recepten")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

	/**
	 * @ORM\Column(type="integer")
	 * @Assert\Type("integer")
	 */
	private $personen;

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
     * Set titel
     *
     * @param string $titel
     * @return Recept
     */
    public function setTitel($titel)
    {
        $this->titel = $titel;

        return $this;
    }

    /**
     * Get titel
     *
     * @return string 
     */
    public function getTitel()
    {
        return $this->titel;
    }

    /**
     * Set beschrijving
     *
     * @param string $beschrijving
     * @return Recept
     */
    public function setBeschrijving($beschrijving)
    {
        $this->beschrijving = $beschrijving;

        return $this;
    }

    /**
     * Get beschrijving
     *
     * @return string 
     */
    public function getBeschrijving()
    {
        return $this->beschrijving;
    }

    /**
     * Set bereidingswijze
     *
     * @param string $bereidingswijze
     * @return Recept
     */
    public function setBereidingswijze($bereidingswijze)
    {
        $this->bereidingswijze = $bereidingswijze;

        return $this;
    }

    /**
     * Get bereidingswijze
     *
     * @return string 
     */
    public function getBereidingswijze()
    {
        return $this->bereidingswijze;
    }

    /**
     * Set kostprijs
     *
     * @param string $kostprijs
     * @return Recept
     */
    public function setKostprijs($kostprijs)
    {
        $this->kostprijs = $kostprijs;

        return $this;
    }

    /**
     * Get kostprijs
     *
     * @return string 
     */
    public function getKostprijs()
    {
        return $this->kostprijs;
    }

    /**
     * Set bereidingstijd
     *
     * @param \DateTime $bereidingstijd
     * @return Recept
     */
    public function setBereidingstijd($bereidingstijd)
    {
        $this->bereidingstijd = $bereidingstijd;

        return $this;
    }

    /**
     * Get bereidingstijd
     *
     * @return \DateTime 
     */
    public function getBereidingstijd()
    {
        return $this->bereidingstijd;
    }

    /**
     * Set toegevoegdOp
     *
     * @param \DateTime $toegevoegdOp
     * @return Recept
     */
    public function setToegevoegdOp($toegevoegdOp)
    {
        $this->toegevoegdOp = $toegevoegdOp;

        return $this;
    }

    /**
     * Get toegevoegdOp
     *
     * @return \DateTime 
     */
    public function getToegevoegdOp()
    {
        return $this->toegevoegdOp;
    }

    /**
     * Set aangepastOp
     *
     * @param \DateTime $aangepastOp
     * @return Recept
     */
    public function setAangepastOp($aangepastOp)
    {
        $this->aangepastOp = $aangepastOp;

        return $this;
    }

    /**
     * Get aangepastOp
     *
     * @return \DateTime 
     */
    public function getAangepastOp()
    {
        return $this->aangepastOp;
    }

	/**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
     * @return Recept
     */
    public function setFotoBestand(File $image = null)
    {
        $this->fotoBestand = $image;

        if ($image) {
            $this->aangepastOp = new \DateTimeImmutable();
        }

        return $this;
    }

    /**
     * @return File|null
     */
    public function getFotoBestand()
    {
        return $this->fotoBestand;
    }


    /**
     * Set fotoNaam
     *
     * @param string $fotoNaam
     * @return Recept
     */
    public function setFotoNaam($fotoNaam)
    {
        $this->fotoNaam = $fotoNaam;

        return $this;
    }

    /**
     * Get fotoNaam
     *
     * @return string|null 
     */
    public function getFotoNaam()
    {
        return $this->fotoNaam;
    }

    /**
     * Set gerecht
     *
     * @param \AppBundle\Entity\Gerecht $gerecht
     * @return Recept
     */
    public function setGerecht(\AppBundle\Entity\Gerecht $gerecht = null)
    {
        $this->gerecht = $gerecht;

        return $this;
    }

    /**
     * Get gerecht
     *
     * @return \AppBundle\Entity\Gerecht 
     */
    public function getGerecht()
    {
        return $this->gerecht;
    }

    /**
     * Set keuken
     *
     * @param \AppBundle\Entity\Keuken $keuken
     * @return Recept
     */
    public function setKeuken(\AppBundle\Entity\Keuken $keuken = null)
    {
        $this->keuken = $keuken;

        return $this;
    }

    /**
     * Get keuken
     *
     * @return \AppBundle\Entity\Keuken 
     */
    public function getKeuken()
    {
        return $this->keuken;
    }

//     /**
//      * Set ingredienten
//      *
//      * @param string $ingredienten
//      * @return Recept
//      */
//     public function setIngredienten($ingredienten)
//     {
//         $this->ingredienten = $ingredienten;
// 
//         return $this;
//     }
// 
//     /**
//      * Get ingredienten
//      *
//      * @return string 
//      */
//     public function getIngredienten()
//     {
//         return $this->ingredienten;
//     }

    /**
     * Set hoofdingredient
     *
     * @param \AppBundle\Entity\Hoofdingredient $hoofdingredient
     * @return Recept
     */
    public function setHoofdingredient(\AppBundle\Entity\Hoofdingredient $hoofdingredient = null)
    {
        $this->hoofdingredient = $hoofdingredient;

        return $this;
    }

    /**
     * Get hoofdingredient
     *
     * @return \AppBundle\Entity\Hoofdingredient 
     */
    public function getHoofdingredient()
    {
        return $this->hoofdingredient;
    }

    /**
     * Add tags
     *
     * @param \AppBundle\Entity\Tag $tags
     * @return Recept
     */
    public function addTag(\AppBundle\Entity\Tag $tags)
    {
        $this->tags[] = $tags;

        return $this;
    }

    /**
     * Remove tags
     *
     * @param \AppBundle\Entity\Tag $tags
     */
    public function removeTag(\AppBundle\Entity\Tag $tags)
    {
        $this->tags->removeElement($tags);
    }

    /**
     * Get tags
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Add ingredienten
     *
     * @param \AppBundle\Entity\Ingredient $ingredienten
     * @return Recept
     */
    public function addIngredienten(\AppBundle\Entity\Ingredient $ingredienten)
    {
        $ingredienten->setRecept($this);
        $this->ingredienten[] = $ingredienten;

        return $this;
    }


    /**
     * Remove ingredienten
     *
     * @param \AppBundle\Entity\Ingredient $ingredienten
     */
    public function removeIngredienten(\AppBundle\Entity\Ingredient $ingredienten)
    {
        $this->ingredienten->removeElement($ingredienten);
    }

    /**
     * Get ingredienten
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIngredienten()
    {
        return $this->ingredienten;
    }



    /**
     * Add receptenordered
     *
     * @param \AppBundle\Entity\ReceptOrdered $receptenordered
     * @return Recept
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
     * Add receptenblordered
     *
     * @param \AppBundle\Entity\ReceptBLOrdered $receptenblordered
     * @return Recept
     */
    public function addReceptenblordered(\AppBundle\Entity\ReceptBLOrdered $receptenblordered)
    {
        $this->receptenblordered[] = $receptenblordered;

        return $this;
    }

    /**
     * Remove receptenblordered
     *
     * @param \AppBundle\Entity\ReceptBLOrdered $receptenblordered
     */
    public function removeReceptenblordered(\AppBundle\Entity\ReceptBLOrdered $receptenblordered)
    {
        $this->receptenblordered->removeElement($receptenblordered);
    }

    /**
     * Get receptenblordered
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getReceptenblordered()
    {
        return $this->receptenblordered;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     * @return Recept
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

    /**
     * Set personen
     *
     * @param integer $personen
     *
     * @return Recept
     */
    public function setPersonen($personen)
    {
        $this->personen = $personen;

        return $this;
    }

    /**
     * Get personen
     *
     * @return integer
     */
    public function getPersonen()
    {
        return $this->personen;
    }  

}
