<?php

namespace App\Models;

use Illuminate\Contracts\Support\Arrayable;

class Recipe implements Arrayable
{
    private string $title;
    private string $diet_style;
    private string $cuisine;


    public function __construct()
    {

    }

    public function toArray(): array
    {
        // TODO: Implement toArray() method.
    }
}
