<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;
    protected $table ='tikets';

    protected $fillable = [
        'name',
        'email',
        'ticketing_id',
        'code',
        'placing',
        'contact',
        'place',
        'sexe',
        'date_scanne',
        'status',

    ];

    public function ticketing()
    {
        return $this->belongsTo(Event::class, "ticketing_id","id");
    }

}
