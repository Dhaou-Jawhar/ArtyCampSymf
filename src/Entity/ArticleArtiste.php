<?php

namespace App\Entity;

//use App\Entity\Traits\Timestampable;
use App\Repository\ArticleArtisteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\HasLifecycleCallbacks] //écouter les différent évènement de cycle de vie de cette entitée
#[ORM\Table(name: "ArticleArtiste")]
#[ORM\Entity(repositoryClass: ArticleArtisteRepository::class)]
class ArticleArtiste
{
 // use Timestampable;


    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idArticle = null;

    #[Assert\NotBlank(message:'Name is required')]
    #[ORM\Column(length: 255)]
    private ?string $nomA = null;

    #[Assert\NotBlank(message:'Description is required')]
    #[ORM\Column(length: 255)]
    private ?string $descriptionA = null;



    #[ORM\Column( options: ["default" => 0])]
    private int $views ;

    #[ORM\Column(length: 255)]
    private string $imageh ;

    #[ORM\Column(options:["default"=>"CURRENT_TIMESTAMP"] )]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(options:["default"=>"CURRENT_TIMESTAMP"] )]
    private ?\DateTimeImmutable $updatedAt = null;



    public function getIdArticle(): ?int
    {
        return $this->idArticle;
    }

    public function setIdArticle(int $idArticle): self
    {
        $this->idArticle = $idArticle;

        return $this;
    }

    public function getDescriptionA(): ?string
    {
        return $this->descriptionA;
    }

    public function setDescriptionA(string $descriptionA): self
    {
        $this->descriptionA = $descriptionA;

        return $this;
    }

    public function getNomA(): ?string
    {
        return $this->nomA;
    }

    public function setNomA(string $nomA): self
    {
        $this->nomA = $nomA;

        return $this;
    }

    public function getViews(): ?int
    {
        return $this->views;
    }

    public function setViews(int $views): self
    {
        $this->views = $views;

        return $this;
    }

    public function getImageh(): ?string
    {
        return $this->imageh;
    }

    public function setImageh(string $imageh): self
    {
        $this->imageh = $imageh;

        return $this;
    }
    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    //cette méthode va nous permettre de mettre à jour nos timestamps
    //avant la création et la modification d'un article on va appeler cette méthode

    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function updateTimestamps(){
        if ($this->getCreatedAt()===null){
            $this->setCreatedAt(new \DateTimeImmutable()); //DateTimeImmutable():ajouter la date et l'heure actuelle:on ne peut pas le modifier

        }

        $this->setUpdatedAt(new \DateTimeImmutable());

    }









}
