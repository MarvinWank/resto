<?php


namespace App\Models;

class State
{
    private string $stateId;
    private User $user;
    private bool $data_was_mutated;

    public function __construct(string $stateID)
    {
        $this->stateId = $stateID;
        $this->data_was_mutated = false;
    }

    public function setUser(User $userID)
    {
        $this->user = $userID;
    }

    public function getUser(): string
    {
        return $this->user;
    }

    public function dataWasMutated(): bool
    {
        return $this->data_was_mutated;
    }


}
