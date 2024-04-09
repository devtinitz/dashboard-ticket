<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class Event extends Model implements AuthenticatableContract

{
    use Authenticatable;

    use HasFactory;

    protected $table ='evenements';

    protected $fillable = [
        'name',
        'email',
        'code',
        'description',
        'password',
        'status',
        'created_by',
        'image',
        'date_debut',
        'date_fin',
    ];

    //Cette fonction permet de gererer le coupon par defaut
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        // Appel de la méthode pour générer le code coupon lors de la création de l'objet
        // Vérifier si un code de coupon est fourni
        if (!isset($this->attributes['code']) || empty($this->attributes['code'])) {
            // Si aucun code n'est fourni, générer un nouveau code de coupon
            $this->attributes['code'] = $this->genereCode();
        }
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class)->latest();
    }


    public static  function genereCode($longueur = 6): string
    {
        // Définition des caractères autorisés
        $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        // Calcul de la longueur de la chaîne de caractères autorisée
        $longueurCaracteres = strlen($caracteres);
        // Initialisation de la chaîne de caractères
        $chaine = '';
        // Boucle pour générer la chaîne de caractères aléatoire
        for ($i = 0; $i < $longueur; $i++) {
            // Sélection aléatoire d'un caractère parmi ceux autorisés
            $chaine .= $caracteres[rand(0, $longueurCaracteres - 1)];
        }
        // Retourne la chaîne générée
        return strtoupper($chaine);
    }
}
