<?php

declare(strict_types = 1);

namespace App;

class ToasterPro extends Toaster 
{
    public function __construct() 
    {
        parent::__construct();

        $this->size = 4;
    }

    public function toastBagel()
    {
        foreach($this->slices as $i => $slice) {
            echo ($i + 1) . ': Toasting ' . $slice . ' with bagels option. ';
        }
    }
}