<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_tiket',
        'judul_tiket',
        'tipe_tiket',
        'assigned_to',
        'description',
        'label',
        'project_name',
        'index',
    ];
}
