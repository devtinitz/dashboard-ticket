<?php

namespace App\Http\Controllers\Admin;

use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    //
    public function index(){
        $data['libelleEvent'] = "Nombre d'évènements";
        $data['libelleTicket'] = "Nombre de Tickets";
        $data['vip'] = "Nombre de Tickets VIP";
        $data['vvip'] = "Nombre de Tickets VVIP";
        $data['public'] = "Nombre de Tickets PUBLIC";

        $event = Auth::user();
        //  dd($event);
         $data['ticket'] = $event->tickets->groupBy('placing')->count();
         // Compter le nombre de tickets par 'placing' pour l'événement connecté
        $data['ticketCounts'] = Ticket::where('event_id', $event->id) 
             ->groupBy('placing')//name = placing
             ->select('placing', DB::raw('COUNT(*) as total'))
             ->get();
        // Définir une liste de couleurs
    $colors = ['bg-primary', 'bg-secondary', 'bg-success', 'bg-danger', 'bg-warning', 'bg-info', 'bg-dark'];

    // Associer les couleurs aux données des tickets
    foreach ($data['ticketCounts'] as $index => $ticketCount) {
        // Calculer l'index de la couleur en fonction de la position dans la liste des couleurs
        $colorIndex = $index % count($colors);
        // Attribuer la couleur à la colonne
        $ticketCount->color = $colors[$colorIndex];
    }
       
        return view('dashboard', $data);
    }
}
