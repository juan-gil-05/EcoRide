<?php

namespace App\Entity;

class PreferencePersonnelle extends Entity
{
    protected int $id;
    protected string $preference;
    protected int $user_id;


    /**
     * Get the value of id
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set the value of id
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of preference
     */
    public function getPreference(): string
    {
        return $this->preference;
    }

    /**
     * Set the value of preference
     */
    public function setPreference(string $preference): self
    {
        $this->preference = $preference;

        return $this;
    }

    /**
     * Get the value of user_id
     */
    public function getUserId(): int
    {
        return $this->user_id;
    }

    /**
     * Set the value of user_id
     */
    public function setUserId(int $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }
}
