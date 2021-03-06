<?php

namespace Portail\EtablissementBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Etablissement
 
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Etablissement
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;
    /**
     * @var text
     *
     * @ORM\Column(name="adresse", type="text")
     */
    private $adresse;
 /**
     * @var text
     *
     * @ORM\Column(name="ville", type="string",length=255)
     */
    private $ville;
    
    
    /**
     * @var text
     *
     * @ORM\Column(name="telephone", type="string",length=20)
     */
    private $telephone;

    /**
     * @var text
     *
     * @ORM\Column(name="siteweb", type="string",length=255)
     */
    private $siteweb;
    /**
     * @var string
     *
     * @ORM\Column(name="logo", type="string", length=255,nullable=true)
     */
    private $logo;
   /**
     * @var double
     *
     * @ORM\Column(name="latitude", type="float",nullable=true)
     */
     private $latitude;
     /**
     * @var double
     *
     * @ORM\Column(name="longitude", type="float",nullable=true)
     */
     private $longitude;
         /**
     * @Assert\File(maxSize="6000000")
     */
    public $file;
 
    
    /**
     *
     * @ORM\ManyToOne(targetEntity="Portail\EtablissementBundle\Entity\CategorieEtab",inversedBy="etablissements")
     */
    private $categorie;     

/**
* @ORM\OneToMany(targetEntity="Portail\FicheMedicamentBundle\Entity\FicheMedicament",
mappedBy="laboratoire")
*/
    
    public $medicaments;
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
     * Set nom
     *
     * @param string $nom
     * @return Etablissement
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    
        return $this;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set adresse
     *
     * @param string $adresse
     * @return Etablissement
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;
    
        return $this;
    }

    /**
     * Get adresse
     *
     * @return string 
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set telephone
     *
     * @param string $telephone
     * @return Etablissement
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;
    
        return $this;
    }

    /**
     * Get telephone
     *
     * @return string 
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Set siteweb
     *
     * @param string $siteweb
     * @return Etablissement
     */
    public function setSiteweb($siteweb)
    {
        $this->siteweb = $siteweb;
    
        return $this;
    }

    /**
     * Get siteweb
     *
     * @return string 
     */
    public function getSiteweb()
    {
        return $this->siteweb;
    }

    /**
     * Set latitude
     *
     * @param float $latitude
     * @return Etablissement
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    
        return $this;
    }

    /**
     * Get latitude
     *
     * @return float 
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param float $longitude
     * @return Etablissement
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    
        return $this;
    }

    /**
     * Get longitude
     *
     * @return float 
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set logo
     *
     * @param string $logo
     * @return Etablissement
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;
    
        return $this;
    }

    /**
     * Get logo
     *
     * @return string 
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * Set ville
     *
     * @param string $ville
     * @return Etablissement
     */
    public function setVille($ville)
    {
        $this->ville = $ville;
    
        return $this;
    }

    /**
     * Get ville
     *
     * @return string 
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Set categorie
     *
     * @param \Portail\EtablissementBundle\Entity\CategorieEtab $categorie
     * @return Etablissement
     */
    public function setCategorie(\Portail\EtablissementBundle\Entity\CategorieEtab $categorie = null)
    {
        $this->categorie = $categorie;
    
        return $this;
    }

    /**
     * Get categorie
     *
     * @return \Portail\EtablissementBundle\Entity\CategorieEtab 
     */
    public function getCategorie()
    {
        return $this->categorie;
    }
    
     protected function getUploadDir()
{
        return 'logo';
}
 
public function getUploadRootDir()
{
    return __DIR__.'/../../../../web/bundles/portailetablissement/images/'.$this->getUploadDir();
}
 
public function getWebPath()
{
    return null === $this->logo ? null : $this->getUploadDir().'/'.$this->logo;
}
 
public function getAbsolutePath()
{
    return null === $this->logo ? null : $this->getUploadRootDir().'/'.$this->logo;
} 
   
/**
 * 
 * @ORM\PrePersist()
 * @ORM\PreUpdate()
 */
public function upload()
{
  // the file property can be empty if the field is not required
    if (null === $this->file) {
        return;
    }

    // we use the original file name here but you should
    // sanitize it at least to avoid any security issues

    // move takes the target directory and then the target filename to move to
    $this->file->move($this->getUploadRootDir(), $this->file->getClientOriginalName());

    // set the path property to the filename where you'ved saved the file
    $this->logo = $this->file->getClientOriginalName();

    // clean up the file property as you won't need it anymore
    $this->file = null;
    $this->redimensionner_image($this->getUploadRootDir().'/'.$this->getLogo(), 1024, 768);
              
}
 
public function redimensionner_image($fichier, $longueur,$largeur) {

    //VARIABLE D'ERREUR
    global $error;

    //TAILLE DE L'IMAGE ACTUELLE
    $taille = getimagesize($fichier);
	
	//SI LE FICHIER EXISTE
    if ($taille) {
    
        //SI JPG
        if ($taille['mime']=='image/jpeg' ) {
            //OUVERTURE DE L'IMAGE ORIGINALE
            $img_big = imagecreatefromjpeg($fichier); 
            $img_new = imagecreate($longueur, $largeur);
            
            //CREATION DE LA MINIATURE
            $img_petite = imagecreatetruecolor($longueur, $largeur) or $img_petite = imagecreate($longueur, $largeur);

			//COPIE DE L'IMAGE REDIMENSIONNEE
            imagecopyresized($img_petite,$img_big,0,0,0,0,$longueur,$largeur,$taille[0],$taille[1]);
            imagejpeg($img_petite,$fichier);

        }
        
        //SI PNG
        else if ($taille['mime']=='image/png' ) {
            //OUVERTURE DE L'IMAGE ORIGINALE
            $img_big = imagecreatefrompng($fichier); // On ouvre l'image d'origine
            $img_new = imagecreate($longueur, $largeur);
            
            //CREATION DE LA MINIATURE
            $img_petite = imagecreatetruecolor($longueur, $largeur) OR $img_petite = imagecreate($longueur, $largeur);

            //COPIE DE L'IMAGE REDIMENSIONNEE
            imagecopyresized($img_petite,$img_big,0,0,0,0,$longueur,$largeur,$taille[0],$taille[1]);
            imagepng($img_petite,$fichier);
 
        }
        // GIF
        else if ($taille['mime']=='image/gif' ) {
            //OUVERTURE DE L'IMAGE ORIGINALE
            $img_big = imagecreatefromgif($fichier); 
            $img_new = imagecreate($longueur, $largeur);
			
            //CREATION DE LA MINIATURE
            $img_petite = imagecreatetruecolor($longueur, $largeur) or $img_petite = imagecreate($longueur, $largeur);

            //COPIE DE L'IMAGE REDIMENSIONNEE
            imagecopyresized($img_petite,$img_big,0,0,0,0,$longueur,$largeur,$taille[0],$taille[1]);
            imagegif($img_petite,$fichier);

        }
		
    }
    }
    
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->medicaments = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add medicaments
     *
     * @param \Portail\FicheMedicamentBundle\Entity\FicheMedicament $medicaments
     * @return Etablissement
     */
    public function addMedicament(\Portail\FicheMedicamentBundle\Entity\FicheMedicament $medicaments)
    {
        $this->medicaments[] = $medicaments;
    
        return $this;
    }

    /**
     * Remove medicaments
     *
     * @param \Portail\FicheMedicamentBundle\Entity\FicheMedicament $medicaments
     */
    public function removeMedicament(\Portail\FicheMedicamentBundle\Entity\FicheMedicament $medicaments)
    {
        $this->medicaments->removeElement($medicaments);
    }

    /**
     * Get medicaments
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMedicaments()
    {
        return $this->medicaments;
    }
    public function __toString()
    {
      return $this->getNom();
    }
}