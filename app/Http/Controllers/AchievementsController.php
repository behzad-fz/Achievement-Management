<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;

class AchievementsController extends Controller
{
    public function index(User $user)
    {
        return response()->json(new UserResource($user));
    }
}
