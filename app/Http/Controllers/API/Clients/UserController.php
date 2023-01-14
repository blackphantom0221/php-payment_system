<?php
namespace App\Http\Controllers\API\Clients;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Get information about current user.
     */
    public function getUser(Request $request) {
        $user = $request->user();

        return response()->json([
            'user' => $user
        ], 200);
    }
}