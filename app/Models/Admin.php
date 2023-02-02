<?php

namespace App\Models;

use App\Concerns\HasRoles;
use Illuminate\Foundation\Auth\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Admin extends User
{
    use HasFactory, Notifiable, HasRoles;

    protected $guarded = [];
}