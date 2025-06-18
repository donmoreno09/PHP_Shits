<?php

declare(strict_types = 1);

namespace App;

class Toaster
{
    protected array $slices;
    protected int $size;

    public function __construct() {
        $this->slices = [];
        $this->size = 2;
    }

    public function addSlice(string $slice): void 
    {
        if(count($this->slices) < $this->size) {
            $this->slices[] = $slice;
        } else {
            echo "Toaster is full. Cannot add more slices.\n";
        }
    }

    public function toast(): void
    {
        foreach($this->slices as $i => $slice) {
            echo ($i + 1) . ': Toasting ' . $slice . '<br>' ;
        }
    }
}