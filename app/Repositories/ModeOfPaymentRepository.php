<?php

namespace App\Repositories;

use App\ModeOfPayment;

class ModeOfPaymentRepository extends Repository
{
    /**
     * Mode of payment
     *
     * App\ModeOfPayment
     */
    protected $modeOfPayment;

    /**
     * Create new instance of mode of payment repository.
     *
     * @param ModeOfPayment $modeOfPayment Mode of payment model
     */
    public function __construct(ModeOfPayment $modeOfPayment)
    {
        parent::__construct($modeOfPayment);

        $this->modeOfPayment = $modeOfPayment;
    }
}
