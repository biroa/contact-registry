<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Pagination\LengthAwarePaginator;

class ContactRegistryController extends Controller
{

    /**
     * Retrieves and paginates contacts with their details and addresses.
     *
     * @param Contact $contact The contact model instance.
     * @return LengthAwarePaginator The paginated contacts with their details and addresses.
     */
    public function index(Contact $contact): LengthAwarePaginator
    {
        return $contact->find(1)->with('details','addresses')->paginate(2);
    }
}
