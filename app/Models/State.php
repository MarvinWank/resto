<?php


namespace App\Models;

class State
{
    private string $stateId;
    private int $userID;
    private bool $data_was_mutated;

    public function __construct(string $stateID)
    {
        $this->stateId = $stateID;
        $this->data_was_mutated = false;
    }

    public function setUserID(int $userID)
    {
        $this->data_was_mutated = true;
        $this->userID = $userID;
    }

    public function getUserID(): int
    {
        return $this->userID;
    }

    public function dataWasMutated(): bool
    {
        return $this->data_was_mutated;
    }

    public function getStateId(): string
    {
        return  $this->stateId;
    }

}
