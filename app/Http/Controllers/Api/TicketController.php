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
                'code' => 'required',
                'tickets' => 'required|array',
                'tickets.*.code' => 'required',
                'tickets.*.name' => 'required',
                'tickets.*.email'=>'nullable',
                'tickets.*.placing',
                'tickets.*.contact'=>'nullable',
                'tickets.*.place',
                'tickets.*.sexe' => 'required',
                'tickets.*.status',
                'tickets.*.date_scanne'=> 'required',
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
            foreach ($request->tickets as $ticketData) {
                $existingTicket = Ticket::where('code', $ticketData['code'])->first();
                if ($existingTicket) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Le ticket avec le code ' . $ticketData['code'] . ' a été déjà scanné'], 401);
                }
            }

            // mettre à jour un événement
            $event->update($request->only([
                'code',
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
                $ticket = new Ticket([
                    'name' => $ticketData['name'],
                    'email' => $ticketData['email'],
                    'code' => $ticketData['code'],
                    'placing' => $ticketData['placing'],
                    'contact' => $ticketData['contact'],
                    'place' => $ticketData['place'],
                    'sexe' => $ticketData['sexe'],
                    'status' => $ticketData['status'],
                    'date_scanne' => $ticketData['date_scanne'],
                ]);
                $event->tickets()->save($ticket);
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
   /* public function storeEvent(Request $request)
    {

        try {
            DB::transaction(function () use ($request) {
                // Créer un nouvel événement
                Ticketing::create([
                    'email' => $request->email,
                    'nom' => $request->nom,
                    'logo' => empty($request->logo)? '' :storeFile($request->logo),
                    'background' => empty($request->background)? '' :storeFile($request->background),
                    'status' => 0,
                ]);

                if ($request->email) {
                    @Mail::send('emails.ticket', [], function ($message) use ($request) {
                        $message->from('ne-pas-repondre@tdisplay.com', 'Tinitz Display')->to($request->email)->subject('Code de votre ticket');
                    });
                }
                return response()->json(['message' => 'Ticket ajouté avec succès'], 201);
            });
        } catch (\Exception $e) {
            return response()->json(['message' => "Une erreur s'est produite ====>" . $e->getMessage()], 500);
        }


    }
    */

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
            $event = Ticket::where('code', $request->code)->first();

            if (!$event) {
                return response()->json([
                    'status' => false,
                    'message' => 'Le code d\'évènement est incorrect'], 401);
            }
            $input['password'] = Hash::make($request->password);

            $event->update([
                "code" => $request->code,
                'name'=> $request->name,
                'email'=> $request->email,
                'password'=> Hash::make($request->password),
                'status'=> 1,

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
}