<?php

namespace App\Http\Controllers\Admin;

use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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
        if ($request->filled('name')) {
            $ticketsQuery->where('name', 'like', '%' . $request->input('name') . '%');
        }

        if ($request->filled('email')) {
            $ticketsQuery->where('email', 'like', '%' . $request->input('email') . '%');
        }

        

        // Exécutez la requête pour récupérer les tickets
        $tickets = $ticketsQuery->get();

        // Retournez les données à la vue
        return view('ticket',$data, [
            'tickets' => $tickets,
            'name' => $request->input('name', ''), // Utilisez les valeurs de recherche fournies ou une chaîne vide
            'email' => $request->input('email', ''), // Utilisez les valeurs de recherche fournies ou une chaîne vide
            // Ajoutez plus de données selon vos besoins...
        ]);
    }
}
