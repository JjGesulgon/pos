<?php

namespace App\Repositories;

use App\Corporation;

class CorporationRepository extends Repository
{
    /**
     * Create new instance of corporation repository.
     *
     * @param Corporation corporation Corporation model
     */
    public function __construct(Corporation $corporation)
    {
        parent::__construct($corporation);
        $this->corporation = $corporation;
    }
}
