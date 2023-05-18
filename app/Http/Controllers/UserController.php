<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\{
    Request, JsonResponse
};

class UserController extends Controller
{
    public function __construct()
    {
	    $this->middleware(['auth:api']);
    }

    /**
     * Display a listing of the resource.
     * 
     * @return JsonResponse
     */
    public function index() : JsonResponse
    {
        $this->authorize('viewAny', User::class);

        return response()->json(User::all(), 200);
    }

    /**
     * Display the specified resource.
     * 
     * @return JsonResponse
     */
    public function show(string $id) : JsonResponse
    {
        $user = User::find($id);

        $this->authorize('view', $user);
        
        return response()->json($user, 200);
    }

    /**
     * Update the specified resource in storage.
     * 
     * @param Request $request
     * @param string $id
     * 
     * @return JsonResponse
     */
    public function update(Request $request, string $id) : JsonResponse
    {
        $user = User::find($id);

        $this->authorize('update', $user);

        $user->update($request->all());

        return response()->json($user, 200);
    }

    /**
     * Remove the specified resource from storage.
     * 
     * @param string $id
     * 
     * @return ResponseJson
     */
    public function destroy(string $id) : JsonResponse
    {
	    $user = User::find($id);

        $this->authorize('forceDelete', $user);

        $user->delete();

        return response()->json([
	        'message' => 'User successfully deleted'
	    ], 200);
    }
}
