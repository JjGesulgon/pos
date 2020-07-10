<?php

namespace App\Repositories;

use App\Contact;

class ContactRepository extends Repository
{
    /**
     * Create new instance of contact repository.
     *
     * @param Contact contact Contact model
     */
    public function __construct(Contact $contact)
    {
        parent::__construct($contact);
        $this->contact = $contact;
    }
}
