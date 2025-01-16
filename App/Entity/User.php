<?php

namespace App\Entity;

class User extends Entity
{
    protected ?int $id = null;
    protected ?int $nb_credits = null;
    protected ?string $pseudo = "";
    protected ?string $mail = "";
    protected ?string $mot_de_passe = "";
    protected ?string $photo = "";
    protected ?int $role_id = null;

    /**
     * Get the value of id
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Set the value of id
     */
    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of nb_credits
     */
    public function getNbCredits(): ?int
    {
        return $this->nb_credits;
    }

    /**
     * Set the value of nb_credits
     */
    public function setNbCredits(?int $nb_credits): self
    {
        $this->nb_credits = $nb_credits;

        return $this;
    }

    /**
     * Get the value of pseudo
     */
    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    /**
     * Set the value of pseudo
     */
    public function setPseudo(?string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    /**
     * Get the value of mail
     */
    public function getMail(): ?string
    {
        return $this->mail;
    }

    /**
     * Set the value of mail
     */
    public function setMail(?string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Get the value of mot_de_passe
     */
    public function getMotDePasse(): ?string
    {
        return $this->mot_de_passe;
    }

    /**
     * Set the value of mot_de_passe
     */
    public function setMotDePasse(?string $mot_de_passe): self
    {
        $this->mot_de_passe = $mot_de_passe;

        return $this;
    }

    /**
     * Get the value of photo
     */
    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    /**
     * Set the value of photo
     */
    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * Get the value of role_id
     */
    public function getRoleId(): ?int
    {
        return $this->role_id;
    }

    /**
     * Set the value of role_id
     */
    public function setRoleId(?int $role_id): self
    {
        $this->role_id = $role_id;

        return $this;
    }
}
