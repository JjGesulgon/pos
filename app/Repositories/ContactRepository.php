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

    /**
     * Create pagination with filters for the resources.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string                    $orderBy
     * @param  integer                   $length
     * @param  boolean                   $removePage
     * @return array object
     */
    public function paginateWithFilters(
        $request = null,
        $length = 15,
        $orderBy = 'desc',
        $removePage = true
    ) {
        if ($orderBy == null) {
            $orderBy = 'desc';
        }

        return $this->model->filter($request)
                            ->with('contactType')
                            ->orderBy('created_at', $orderBy)
                            ->paginate($length)
                            ->withPath(
                                $this->model->createPaginationUrl($request, $removePage)
                            );
    }
}
