<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @OA\Get(
     *     path="/users",
     *     description="Home page",
     *     @OA\Response(response="default", description="listing users"),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *          @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/User")
     *         ),
     *     ),
     * )
     */
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index(Request $request) 
    {
        dd('here');
    }

    //
}
