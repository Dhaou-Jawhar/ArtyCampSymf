<?php

namespace App\Entity;

use App\Repository\MessangerRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MessangerRepository::class)]
class Messanger
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Obligatoire!!")]
    #[Assert\Length(
        min: 3,
        max: 20,
        minMessage: "minimum {{ limit }} caractère ",
        maxMessage: "maximum {{ limit }} caractère ",
    )]
    private ?string $nomex = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Obligatoire!!")]
    #[Assert\Length(
        min: 3,
        max: 20,
        minMessage: "minimum {{ limit }} caractère ",
        maxMessage: "maximum {{ limit }} caractère ",
    )]
    private ?string $nomrec = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "pas vide ")]
    private ?string $vu = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "ecrire le message")]
    #[Assert\Length(
        min: 1,
        //max: 20,
        minMessage: "minimum {{ limit }} caractère ",
       // maxMessage: "maximum {{ limit }} caractère ",
    )]
    private ?string $msg = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomex(): ?string
    {
        return $this->nomex;
    }

    public function setNomex(string $nomex): self
    {
        $this->nomex = $nomex;

        return $this;
    }

    public function getNomrec(): ?string
    {
        return $this->nomrec;
    }

    public function setNomrec(string $nomrec): self
    {
        $this->nomrec = $nomrec;

        return $this;
    }

    public function getVu(): ?string
    {
        return $this->vu;
    }

    public function setVu(string $vu): self
    {
        $this->vu = $vu;

        return $this;
    }

    public function getMsg(): ?string
    {
        return $this->msg;
    }

    public function setMsg(string $msg): self
    {
        $this->msg = $msg;

        return $this;
    }
}
