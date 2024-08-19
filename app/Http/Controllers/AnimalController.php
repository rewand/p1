<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AnimalController extends Controller
{
    public function get()
    {
        try {
            $animals = Animal::with([
                'category',
                'caregiver',
                'feeds'
            ])
                ->where('regist_status', 'A')
                ->get();
            return response()->json(['data' => $animals, 'size' => count($animals)], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => '' . $e,
            ], 500);
        }
    }
    public function show($id)
    {
        try {
            $animal = Animal::with([
                'category',
                'caregiver',
                'feeds'
            ])
                ->find($id);
            return response()->json($animal, 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al obtener el animal',
                'message' => '' . $e,
            ], 500);
        }
    }
    public function store(Request $request)
    {
        DB::beginTransaction(); // Inicia la transacción
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'category_id' => 'required|exists:categories,id',
                'caregiver_id' => 'required|exists:caregivers,id',
                'photo_1' => 'nullable|string|max:255',
                'photo_2' => 'nullable|string|max:255',
            ]);
            // Crear un nuevo registro de Animal
            $animal = Animal::create([
                'name' => $request->name,
                'category_id' => $request->category_id,
                'caregiver_id' => $request->caregiver_id,
                'regist_date' => now()->toDateString(), // solo para crear nada mas
            ]);
            DB::commit(); // Confirma la transacción
            return response()->json([
                'message' => 'Animal registrado con éxito',
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack(); // Revierte la transacción en caso de error
            return response()->json([
                'error' => 'No se pudo registrar el animal',
                'message' => '' . $e,
            ], 500);
        }
    }
    public function update(Request $request, $id)
    {
        DB::beginTransaction(); // Inicia la transacción
        try {
            $animal = Animal::find($id);
            $request->validate([
                'name' => 'required|string|max:255',
                'category_id' => 'required|exists:categories,id',
                'caregiver_id' => 'required|exists:caregivers,id',
                'photo_1' => 'nullable|string|max:255',
                'photo_2' => 'nullable|string|max:255',
            ]);
            $animal->update([
                'name' => $request->name,
                'category_id' => $request->category_id,
                'caregiver_id' => $request->caregiver_id,
            ]);
            DB::commit(); // Confirma la transacción
            return response()->json([
                'message' => 'Animal actualizado con éxito',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack(); // Revierte la transacción en caso de error
            return response()->json([
                'error' => 'No se pudo actualizar el animal',
                'message' => '' . $e,
            ], 500);
        }
    }
    public function delete($id) ///cambiar a delete
    {
        DB::beginTransaction(); // Inicia la transacción
        try {
            $animal = Animal::find($id);
            $animal->update(['regist_status' => 'I']);// Cambiar el estado a inactivo ('I')
            DB::commit(); // Confirma la transacción
            return response()->json(['message' => 'Animal marcado como inactivo con éxito'], 200);// Retornar un mensaje de éxito
        } catch (\Exception $e) {
            DB::rollBack(); // Revierte la transacción en caso de error
            return response()->json([
                'error' => 'No se pudo actualizar el registro',
                'message' => '' . $e,
            ], 500);
        }
    }
}
