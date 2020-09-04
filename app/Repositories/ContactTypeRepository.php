<?php

namespace App\Repositories;

use App\ContactType;

class ContactTypeRepository extends Repository
{
    /**
     * Create new instance of contact type repository.
     *
     * @param ContactType $contactType ContactType repository.
     */
    public function __construct(ContactType $contactType)
    {
        parent::__construct($contactType);
        $this->contactType = $contactType;
    }
}
