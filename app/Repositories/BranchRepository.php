<?php

namespace App\Repositories;

use App\Branch;
use Illuminate\Support\Facades\DB;

class BranchRepository extends Repository
{
    /**
     * Create new instance of branch repository.
     *
     * @param Branch branch Branch model
     */
    public function __construct(Branch $branch)
    {
        parent::__construct($branch);
        $this->branch = $branch;
    }

    /**
     * Store the data in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return boolean
     */
    public function store($request)
    {
        return DB::transaction(function () use ($request) {
            $branch = $this->branch->create($request->all());
            $branch->costCenter()->create($branch->toArray());

            return $branch;
        });
    }
}
