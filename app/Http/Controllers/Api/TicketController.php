<?php

namespace App\Http\Controllers\Api;

use Log;
use App\Models\Ticket;
use App\Models\Ticketing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Support\Facades\Validator;

class TicketController extends Controller
{
    //

    public function storeTicket(Request $request)
    {
        try {

            //dd($request);
            // Afficher les données reçues dans la console
            Log::info('Données reçues : ' . json_encode($request->all()));

            // Valider les données reçues
            $request->validate([
//                'code' => 'required',
//                'tickets' => 'required|array',
//                'tickets.*.code' => 'required',
//                'tickets.*.name' => 'required',
//                'tickets.*.email' => 'nullable',
//                'tickets.*.placing',
//                'tickets.*.contact' => 'nullable',
//                'tickets.*.place',
//                'tickets.*.sexe' => 'required',
//                'tickets.*.status' => 'nullable',
//                'tickets.*.date_scanne' => 'required',
            ]);

//            if ($request->fails()) {
//                return response()->json([
//                    'status' => false,
//                    'message' => 'Erreur de Validation',
//                    'errors' => $request->errors()->all(),
//                ], 400);
//            }

            // Vérifier si le code de l'événement existe
            $event = Event::where('code', $request->code)->first();

            if (!$event) {
                return response()->json([
                    'status' => false,
                    'message' => 'Le code d\'évènement est incorrect'], 401);
            }

            // Vérifier si le code du ticket existe déjà
//            foreach ($request->tickets as $ticketData) {
//                $existingTicket = Ticket::where('code', $ticketData['code'])->first();
//                if ($existingTicket) {
//                    return response()->json([
//                        'status' => false,
//                        'message' => 'Le ticket avec le code ' . $ticketData['code'] . ' a été déjà scanné'], 401);
//                }
//            }

            // mettre à jour un événement
            $event->update($request->only([
                'name',
                'email',
                'placing',
                'contact',
                'place',
                'sexe',
                'status',
            ]));

            // Enregistrer les tickets associés
            foreach ($request->tickets as $ticketData) {
                $ticket = [
                    'name' => $ticketData['name'],
                    'email' => $ticketData['email'],
                    'code' => $ticketData['code'],
                    'placing' => $ticketData['placing'],
                    'contact' => $ticketData['contact'],
                    'place' => $ticketData['place'],
                    'sexe' => $ticketData['sexe'],
                    'status' => $ticketData['status'],
                    'date_scanne' => $ticketData['date_scanne'],
                    'ticketing_id' => $event->id
                ];
                Ticket::updateOrCreate(
                    [
                        'code' => $ticketData['code'],
                    ],
                    $ticket
                );
            }
            return response()->json([
                'status' => true,
                'message' => 'Ticket créé avec succès'], 200);

        } catch (\Exception $e) {
            // Gérer les erreurs
            return response()->json([
                'status' => false,
                'message' => 'Échec de la création de l\'événement',
                'errors' => $e->getMessage()
            ], 500);
        }
    }


    // creer un nuvelle event
    

    public function createEvent(Request $request)
    {
        try {

            Log::info('Données reçues : ' . json_encode($request->all()));
            //code...
            $input = $request->all();
            $validator = Validator::make($input, [
                'name' => 'required',
                'code' => 'required',
                'email' => 'required',
                'password' => 'required',
                'status' => 'required',

            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Erreur de Validation',
                    'errors' => $validator->errors()->all(),
                ], 400);
            }
            // Vérifier si le code de l'événement existe
            $event = Event::where('code', $request->code)->first();

            if (!$event) {
                return response()->json([
                    'status' => false,
                    'message' => 'Le code d\'évènement est incorrect'], 401);
            }
            $input['password'] = Hash::make($request->password);

            $event->update([
                "code" => $request->code,
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'status' => 1,

            ]);

            return response()->json([
                'status' => true,
                'message' => 'Evenement crée avec succès',
            ], 200);
        } catch (\Exception $th) {
            //throw $th;
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function verification(Request $request)
    {

//        Log::info('Données reçues : ' . json_encode($request->all()));

        $request->validate([
            'code' => 'required',
            'ticket' => 'required',
        ]);

        $ticket = Ticket::whereHas('ticketing', function ($query) use ($request) {
            $query->where('code', $request->code);
        })->where('code', $request->ticket)->first();
        if (!$ticket) {
            return response()->json([
                'status' => false,
                'message' => 'Le code ticket est introuvable'], 404);
        }
        if ($ticket && $ticket->status == 0) {
            $ticket->status = 1;
            $ticket->save();
            return response()->json([
                'status' => true,
                'message' => 'Ticket ' . $request->ticket . ' scanné avec succès',
                'data'=>[
                    "donneeEvent"=>$ticket->ticketing,
                    "donneeTicket" =>$ticket
                ]
            ], 200);
        }

        return response()->json([
            'status' => false,
            'message' => 'Le ticket avec le code ' . $request->ticket . ' est a été déjà scanné',
            'data'=>[
                "donneeTicket" =>$ticket->ticketing,
                "donneeTicket" =>$ticket
            ]
        ], 409);

        // Vérifier si le code de existe
//
//


    }
}