<?php

declare(strict_types = 1);

namespace App\PaymentGateway\Paddle;
use App\Enums\Status;

class Transaction 
{
    

    public function __construct()
    {
        $this->setStatus(Status::PENDING);
    }

    public function setStatus($status): self
    {
        if( !isset(Status::ALL_STATUSES[$status]) ) {
            throw new \InvalidArgumentException("Invalid status: $status");
        }

        $this->$status = $status;

        return $this;
    }
}