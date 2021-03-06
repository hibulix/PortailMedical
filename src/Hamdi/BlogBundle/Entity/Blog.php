<?php

namespace Hamdi\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Blog
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Hamdi\BlogBundle\Entity\BlogRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Blog
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
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     */
    private $title;

    /**
     * @var User $auteur
     *
     * @ORM\ManyToOne(targetEntity="Portail\FrontBundle\Entity\User")
     */
    private $auteur;

    /**
     * @var string
     *
     * @ORM\Column(name="blog", type="text", nullable=false)
     */
    private $blog;
    /**
     * @var string
     *
     * @ORM\Column(name="extrait", type="text", nullable=true)
     */
    private $extrait;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="nbvue", type="integer", nullable=false)
     */
    private $nbvue;

    /**
     * @var string
     *
     * @ORM\Column(name="path", type="string", length=255, nullable=false)
     */
    private $path;

        /**
     * @Assert\File(maxSize="6000000")
     */
    public $file;
    
    
    
    
    protected function getUploadDir($repertoire)
{
        return $repertoire;
}
 
public function getUploadRootDir($repertoire)
{
    return __DIR__.'/../../../../web/bundles/hamdiblog/images/'.$this->getUploadDir($repertoire);
}
 
public function getWebPath($repertoire)
{
    return null === $this->path ? null : $this->getUploadDir($repertoire).'/'.$this->path;
}
 
public function getAbsolutePath($repertoire)
{
    return null === $this->path ? null : $this->getUploadRootDir($repertoire).'/'.$this->path;
} 
   

public function upload($repertoire)
{
  // the file property can be empty if the field is not required
    if (null === $this->file) {
        return;
    }

    // we use the original file name here but you should
    // sanitize it at least to avoid any security issues

    // move takes the target directory and then the target filename to move to
    $this->file->move($this->getUploadRootDir($repertoire), $this->file->getClientOriginalName());

    // set the path property to the filename where you'ved saved the file
    $this->path = $this->file->getClientOriginalName();

    // clean up the file property as you won't need it anymore
    $this->file = null;
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
     * @var string
     *
     * @ORM\Column(name="tags", type="text", nullable=false)
     */
    private $tags;

    /**
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="blog")
     */
    protected $comments;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated", type="datetime")
     */
    private $updated;

 /**
* @ORM\ManyToOne(targetEntity="Portail\BlogUserBundle\Entity\SousCategorie",
inversedBy="blogs")
*/
       private $souscategorie;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->comments = new \Doctrine\Common\Collections\ArrayCollection();
        $this->nbvue = 0;
        
    }
    
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
     * Set title
     *
     * @param string $title
     * @return Blog
     */
    public function setTitle($title)
    {
        $this->title = $title;
    
        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    

    /**
     * Set blog
     *
     * @param string $blog
     * @return Blog
     */
    public function setBlog($blog)
    {
        $this->blog = $blog;
    
        return $this;
    }

    /**
     * Get blog
     *
     * @return string 
     */
    public function getBlog($length = null)
    {
        if (false === is_null($length) && $length > 0)
          return substr($this->blog, 0, $length);
        else
          return $this->blog;
    }

    

    /**
     * Set tags
     *
     * @param string $tags
     * @return Blog
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
    
        return $this;
    }

    /**
     * Get tags
     *
     * @return string 
     */
    public function getTags()
    {
        return $this->tags;
    }

    
    /**
     * Get comments
     *
     * @return string 
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Blog
     */
    public function setCreated($created)
    {
        $this->created = $created;
    
        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return Blog
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    
        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime 
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Add comments
     *
     * @param \Hamdi\BlogBundle\Entity\Comment $comments
     * @return Blog
     */
    public function addComment(\Hamdi\BlogBundle\Entity\Comment $comments)
    {
        $this->comments[] = $comments;
    
        return $this;
    }

    /**
     * Remove comments
     *
     * @param \Hamdi\BlogBundle\Entity\Comment $comments
     */
    public function removeComment(\Hamdi\BlogBundle\Entity\Comment $comments)
    {
        $this->comments->removeElement($comments);
    }
    
    public function __toString()
    {
      return $this->getAuteur();
    }

    /**
     * Set auteur
     *
     * @param \Portail\FrontBundle\Entity\User $auteur
     * @return Blog
     */
    public function setAuteur(\Portail\FrontBundle\Entity\User $auteur = null)
    {
        $this->auteur = $auteur;
    
        return $this;
    }

    /**
     * Get auteur
     *
     * @return \Portail\FrontBundle\Entity\User 
     */
    public function getAuteur()
    {
        return $this->auteur;
    }
    /**
     * @ORM\PrePersist
     */
    public function prePersist()
    {
        $this->created = $this->updated = new \DateTime('now');
        
        
    }
    
    /**
     * @ORM\PreUpdate
     */
    public function preUpdate()
    {
        $this->updated = new \DateTime('now');
    }

    /**
     * Set path
     *
     * @param string $path
     * @return Blog
     */
    public function setPath($path)
    {
        $this->path = $path;
    
        return $this;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath()
    {
        return $this->path;
    }

    
    

    /**
     * Set extrait
     *
     * @param string $extrait
     * @return Blog
     */
    public function setExtrait($extrait)
    {
        $this->extrait = $extrait;
    
        return $this;
    }

    /**
     * Get extrait
     *
     * @return string 
     */
    public function getExtrait()
    {
        return $this->extrait;
    }

    /**
     * Set nbvue
     *
     * @param integer $nbvue
     * @return Blog
     */
    public function setNbvue($nbvue)
    {
        $this->nbvue = $nbvue;
    
        return $this;
    }

    /**
     * Get nbvue
     *
     * @return integer 
     */
    public function getNbvue()
    {
        return $this->nbvue;
    }

    /**
     * Set souscategorie
     *
     * @param \Portail\BlogUserBundle\SousCategorie $souscategorie
     * @return Blog
     */
    public function setSouscategorie(\Portail\BlogUserBundle\SousCategorie $souscategorie = null)
    {
        $this->souscategorie = $souscategorie;
    
        return $this;
    }

    /**
     * Get souscategorie
     *
     * @return \Portail\BlogUserBundle\SousCategorie 
     */
    public function getSouscategorie()
    {
        return $this->souscategorie;
    }
}