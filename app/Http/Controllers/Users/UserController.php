<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Persona\Personas;
use App\Models\User\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{


    public function GetUsers()
    {
        DB::beginTransaction();
    }


    
}    