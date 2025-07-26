<?php

namespace App\Entity;

class Preference extends Entity
{
    protected int $id;
    protected int $preference_id;
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
     * Get the value of preference_id
     */
    public function getPreferenceId(): int
    {
        return $this->preference_id;
    }

    /**
     * Set the value of preference_id
     */
    public function setPreferenceId(int $preference_id): self
    {
        $this->preference_id = $preference_id;

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
