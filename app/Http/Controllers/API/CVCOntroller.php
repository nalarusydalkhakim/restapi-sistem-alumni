<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CVCOntroller extends Controller
{

    /**
     * Display the CV resource.
     *
     * @param  int  $user_id
     * @return \Illuminate\Http\Response
     */
    public function show($user_id)
    {
        $user = User::findOrFail($user_id);
        $response = [
            'success' => true,
            'code' => 200,
            'messege' => 'Generate CV',
            'user' => $user
        ];

        return response($response, 200);
    }
}
