<?php

namespace App\Exports;

use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;

class TicketExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    
    protected $tickets;

    public function __construct($tickets)
    {
        $this->tickets = $tickets;
    }

    public function collection()
    {
        return $this->tickets;
    }
}
