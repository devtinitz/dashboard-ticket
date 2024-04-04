<?php

namespace App\Http\Controllers;

use Log;
use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class TicketController extends Controller
{
    //


    public function storeEvent(Request $request)
    {
        try {
            // Afficher les données reçues dans la console
            Log::info('Données reçues : ' . json_encode($request->all()));

            // Valider les données reçues
            $request->validate([
                'code' => 'required',
                'tickets' => 'required|array',
                'tickets.*.code' => 'required',
                'tickets.*.name' => 'required',
                'tickets.*.email',
                'tickets.*.placing',
                'tickets.*.contact',
                'tickets.*.place',
                'tickets.*.sexe' => 'required',
                'tickets.*.status' => 'required',
            ]);

            // Vérifier si le code de l'événement existe
            $event = Event::where('code', $request->code)->first();

            if (!$event) {
                return response()->json([
                    'status' => false,
                    'message' => 'Le code d\'événement est incorrect'
                ], 500);
            }

            // Vérifier si le code du ticket existe déjà
            foreach ($request->tickets as $ticketData) {
                $existingTicket = Ticket::where('code', $ticketData['code'])->first();
                if ($existingTicket) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Le ticket avec le code ' . $ticketData['code'] . ' existe déjà'
                    ], 500);
                }
            }

            // Créer ou mettre à jour un événement
            $evenement = Event::updateOrCreate(
                [
                    'code' => $request->code
                ],
                $request->only([
                    'code',
                    'name',
                    'email',
                ])
            );

            // Enregistrer les tickets associés
            foreach ($request->tickets as $ticketData) {
                $ticket = new Ticket([
                    'name' => $ticketData['name'],
                    'email' => $ticketData['email'],
                    'code' => $ticketData['code'],
                ]);
                $evenement->tickets()->save($ticket);
            }

            return response()->json([
                'status' => true,
                'message' => 'Ticket créé avec succès'
            ], 201);
        } catch (\Exception $e) {
            // Gérer les erreurs
            return response()->json([
                'status' => false,
                'message' => 'Échec de la création de l\'événement',
                'errors' => $e->getMessage()
            ], 500);
        }
    }



    public function createEvent(Request $request)
    {
        try {

            Log::info('Données reçues : ' . json_encode($request->all()));
            //code...
            $input = $request->all();
            $validator = Validator::make($input, [
                'name' => 'required',
                'code' => 'required',
                'email' => 'required|email|unique:events,email',
                'password' => 'required',

            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Erreur de Validation',
                    'errors' => $validator->errors()->all(),
                ], 422);
            }

            $input['password'] = Hash::make($request->password);
            $event = Event::updateOrCreate([
                "code" => $request->code,
            ], $input);

            return response()->json([
                'status' => true,
                'message' => 'Evenement creer avec succès',
            ], 205);
        } catch (\Exception $th) {
            //throw $th;
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 501);
        }
    }
}
