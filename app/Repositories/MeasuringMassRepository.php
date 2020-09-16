<?php

namespace App\Repositories;

use App\MeasuringMass;
use App\Repositories\Repository;

class MeasuringMassRepository extends Repository
{
    /**
     * Measuring mass
     *
     * App\MeasuringMass
     */
    protected $measuringMass;

    /**
     * Create new instance of measuring mass repository.
     *
     * @param MeasuringMass $measuringMass Measuring mass model
     */
    public function __construct(MeasuringMass $measuringMass)
    {
        parent::__construct($measuringMass);

        $this->measuringMass = $measuringMass;
    }
}
