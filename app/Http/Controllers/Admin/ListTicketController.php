<?php

namespace App\Http\Controllers\Admin;
use App\Models\Event;
use App\Models\Ticket;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Exports\TicketExport;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class ListTicketController extends Controller
{
    //
    public function test()

    {  
        $event = Auth::user();
        //  dd($event);
        $data['ticket'] = $event->tickets;
        $data['nom'] = "nom";
        $data['email'] = "email";
        $data['contact'] = "contact";
        $data['placing'] = "placing";
        $data['code'] = "code ticket";

        // $data['ticket'] = Ticket::orderBy('created_at', 'desc')->get();
        return view("ticket", $data);
    }
    
    public function index (Request $request)
    {

        $data['nom'] = "nom";
        $data['email'] = "email";
        $data['contact'] = "contact";
        $data['placing'] = "placing";
        $data['code'] = "code ticket";
        $event = Auth::user();
        $ticketsQuery = $event->tickets(); // Commencez par récupérer une instance de la relation de ticket pour l'événement actuel

        //filtres de recherche si des paramètres de recherche sont présents dans la requête
        if ($request->filled('placing')) {
            $ticketsQuery->where('placing', 'like', '%' . $request->input('placing') . '%');
        }

        if ($request->filled('place')) {
            $ticketsQuery->where('place', 'like', '%' . $request->input('place') . '%');
        }
        // Exécutez la requête pour récupérer les tickets
        $tickets = $ticketsQuery->paginate(10);

        // Retournez les données à la vue
        return view('ticket',$data, [
            'tickets' => $tickets,
            'name' => $request->input('placing', ''), //
            'place' => $request->input('place', ''), // 
            //
        ]);
    }

    public function exportToExcel()
    {
        $event = Auth::user();
        $tickets = $event->tickets;
    
        return Excel::download(new TicketExport($tickets), 'tickets.xlsx');
    }
    
        public function exportToPDF()
    {
        $event = Auth::user();
        $tickets = $event->tickets;

        $pdf = PDF::loadView('pdf', compact('tickets'));
        return $pdf->download($event->name.'.pdf');
    }
}
