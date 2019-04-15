<?php

namespace App\Http\Requests\Invoice;

use App\Http\Requests\Request;
use App\Models\Invoice;

class ShowInvoiceRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */

    public function authorize() : bool
    {
        return auth()->user()->can('view', $this->invoice);
    }

}