<?php

namespace App\Http\Controllers;

use App\Models\Caregiver;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CaregiverController extends Controller
{
    public function get()
    {
        try {
            $caregivers = Caregiver::with([
                'documentType'
            ])
                ->where('regist_status', 'A')
                ->get();
            return response()->json(['data' => $caregivers, 'size' => count($caregivers)], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => '' . $e,
            ], 500);
        }
    }
    public function show($id)
    {
        try {
            $caregiver = Caregiver::with([
                'documentType'
            ])
                ->find($id);
            return response()->json($caregiver, 200);
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
                'docu_type_id' => 'required|exists:document_type,id',
                'name' => 'required|string|max:255',
                'surnames' => 'required|string|max:255',
                'num_docu' => 'required|string|max:255',
            ]);
            $caregiver = Caregiver::create([
                'docu_type_id' => $request->docu_type_id,
                'name' => $request->name,
                'surnames' => $request->surnames,
                'num_docu' => $request->num_docu,
            ]);
            DB::commit(); // Confirma la transacción
            return response()->json([
                'message' => 'Cuidador registrado con éxito',
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack(); // Revierte la transacción en caso de error
            return response()->json([// Devuelve una respuesta de error
                'message' => '' . $e,
            ], 500);
        }
    }
    public function update(Request $request, $id)
    {
        DB::beginTransaction(); // Inicia la transacción
        try {
            $caregiver = Caregiver::find($id);

            // Validar los datos de entrada
            $request->validate([
                'docu_type_id' => 'required|exists:document_type,id',
                'name' => 'required|string|max:255',
                'surnames' => 'required|string|max:255',
                'num_docu' => 'required|string|max:255',
            ]);
            $caregiver->update([
                'docu_type_id' => $request->docu_type_id,
                'name' => $request->name,
                'surnames' => $request->surnames,
                'num_docu' => $request->num_docu,
            ]);
            DB::commit(); // Confirma la transacción
            return response()->json([
                'message' => 'Cuidador actualizado con éxito',
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack(); // Revierte la transacción en caso de error
            return response()->json([
                'message' => '' . $e,
            ], 500);
        }
    }
    public function delete($id)
    {
        DB::beginTransaction(); // Inicia la transacción
        try {
            $caregiver = Caregiver::find($id);
            $caregiver->update(['regist_status' => 'I']);// Cambiar el estado a inactivo ('I')
            DB::commit(); // Confirma la transacción
            return response()->json(['message' => 'Registro marcado como inactivo con éxito'], 204);
        } catch (\Exception $e) {
            DB::rollBack(); // Revierte la transacción en caso de error
            return response()->json([
                'message' => '' . $e,
            ], 500);
        }
    }
}
