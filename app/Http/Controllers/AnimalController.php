<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
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
                'photo_1' => 'nullable|image|mimes:jpg,png|max:2048',
                'photo_2' => 'nullable|image|mimes:jpg,png|max:2048',
            ], [
                'mimes' => 'El campo :attribute debe ser png o jpg',
                'image' => 'El campo :attribute debe ser una imagen'
            ]);
            $animal = Animal::create([
                'name' => $request->name,
                'category_id' => $request->category_id,
                'caregiver_id' => $request->caregiver_id,
                'regist_date' => now()->toDateString(), // Asigna la fecha actual en formato Y-m-d
            ]);
            $rutaGuardado = storage_path('app/public/animals');
            if (!File::exists($rutaGuardado)) {
                File::makeDirectory($rutaGuardado, 0755, true);
            }
            $fecha = Carbon::now()->format('Y-m-d-H-i-s-u');
            if ($request->photo_1) {
                $image = $fecha . '-IMG-' . $animal->id . '.' . $request->photo_1->extension();
                $request->photo_1->storeAs('public/animals', $image);
                $animal->photo_1 = $image;
                $animal->save();
            }
            if ($request->photo_2) {
                $image = $fecha . '-IMG-' . $animal->id . '.' . $request->photo_2->extension();
                $request->photo_2->storeAs('public/animals', $image);
                $animal->photo_2 = $image;
                $animal->save();
            }
            DB::commit(); // Confirma la transacción
            return response()->json([
                'message' => 'Animal registrado con éxito',
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack(); // Revierte la transacción en caso de error
            return response()->json([
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
                'photo_1' => 'nullable|image|mimes:jpg,png|max:2048',
                'photo_2' => 'nullable|image|mimes:jpg,png|max:2048',
            ], [
                'mimes' => 'El campo :attribute debe ser png o jpg',
                'image' => 'El campo :attribute debe ser una imagen'
            ]);
            $animal->update([
                'name' => $request->name,
                'category_id' => $request->category_id,
                'caregiver_id' => $request->caregiver_id,
                'regist_date' => now()->toDateString(), // Asigna la fecha actual en formato Y-m-d
            ]);
            $fecha = Carbon::now()->format('Y-m-d-H-i-s-u');
            if ($request->photo_1) {
                if ($animal->photo_1 && Storage::exists('public/animals/' . $animal->photo_1)) {
                    Storage::delete('public/animals/' . $animal->photo_1);
                }
                $image1 = $fecha . '-IMG-1-' . $animal->id . '.' . $request->photo_1->extension();
                $request->photo_1->storeAs('public/animals', $image1);
                $animal->photo_1 = $image1;
            }
            if ($request->photo_2) {
                if ($animal->photo_2 && Storage::exists('public/animals/' . $animal->photo_2)) {
                    Storage::delete('public/animals/' . $animal->photo_2);
                }
                $image2 = $fecha . '-IMG-2-' . $animal->id . '.' . $request->photo_2->extension();
                $request->photo_2->storeAs('public/animals', $image2);
                $animal->photo_2 = $image2;
            }
            $animal->save();// Guardar cambios en el animal
            DB::commit(); // Confirma la transacción
            return response()->json([
                'message' => 'Animal actualizado con éxito',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack(); // Revierte la transacción en caso de error
            return response()->json([
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
            return response()->json(['message' => 'Animal marcado como inactivo con éxito'], 204);// Retornar un mensaje de éxito
        } catch (\Exception $e) {
            DB::rollBack(); // Revierte la transacción en caso de error
            return response()->json([
                'error' => 'No se pudo actualizar el registro',
                'message' => '' . $e,
            ], 500);
        }
    }
}
