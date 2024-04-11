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

    public function index()
{
    
    $event = Auth::user();
      // Compter le nombre de tickets avec un statut égal à 1 pour cet événement
    $data['ticketCountStatus'] = Ticket::where('event_id', $event->id)
    ->where('status', 1)
    ->count();

     // Compter le nombre de tickets avec un statut égal à 0 pour cet événement
     $data['ticketCountStatusI'] = Ticket::where('event_id', $event->id)
     ->where('status', 0)
     ->count();

    //compter le nombre de ticket total
    $data['ticket'] = $event->tickets->count();
    // Compter le nombre de tickets par 'placing' pour l'événement connecté
    $data['ticketCounts'] = Ticket::where('event_id', $event->id)
                            ->groupBy('placing')
                            ->select('placing', DB::raw('COUNT(*) as total'))
                            ->where('status', 1)
                            ->get();

    // Préparer les données pour les graphiques
    $data['labels'] = $data['ticketCounts']->pluck('placing')->toArray(); // Labels pour les catégories de ticket
    $data['totals'] = $data['ticketCounts']->pluck('total')->toArray(); // Total de tickets pour chaque catégorie
    
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
