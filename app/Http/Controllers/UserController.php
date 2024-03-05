<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveUserRequest;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index(): JsonResponse
    {
        $users = User::all();
        return response()->json($users, JsonResponse::HTTP_OK);
    }

    public function show(string $id): JsonResponse
    {
        $user = User::findOrFail($id);
        return response()->json($user, JsonResponse::HTTP_OK);
    }

    public function store(SaveUserRequest $request): JsonResponse
    {
        try {
            $validatedData = $request->validated();
            \Log::info('Datos validados:', $validatedData);
            $user = User::create($validatedData);
            return response()->json($user, JsonResponse::HTTP_CREATED);
        } catch (QueryException $e) {
            return response()->json(['error' => 'Error de la base de datos'], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(SaveUserRequest $request, string $id): JsonResponse
    {
        $user = User::findOrFail($id);

        try {
            $validatedData = $request->validated();
            \Log::info('Datos validados:', $validatedData);
            $user->update($validatedData);
            return response()->json($user, JsonResponse::HTTP_OK);
        } catch (QueryException $e) {
            return response()->json(['error' => 'Error de la base de datos'], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy(string $id): JsonResponse
    {
        User::destroy($id);
        return response()->json(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
