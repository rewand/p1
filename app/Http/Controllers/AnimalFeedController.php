<?php

namespace App\Http\Controllers;

use App\Models\AnimalsFeed;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AnimalFeedController extends Controller
{
    // // Listar todos los alimentos consumidos por un animal específico
    // public function index($animalId)
    // {
    //     try {
    //         // Obtener los alimentos consumidos por el animal especificado
    //         $feeds = AnimalsFeed::where('animal_id', $animalId)
    //             ->with(['feed:id,name']) // Solo selecciona los campos necesarios de la relación 'feed'
    //             ->get(['id', 'animal_id', 'feed_id']); // Solo selecciona los campos necesarios de la tabla 'animals_feeds'

    //         return response()->json($feeds, Response::HTTP_OK);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'error' => 'Error al listar los alimentos',
    //             'message' => $e->getMessage()
    //         ], Response::HTTP_INTERNAL_SERVER_ERROR);
    //     }
    // }

    // Registrar un nuevo alimento consumido por un animal
    public function store(Request $request)
    {
        DB::beginTransaction(); // Inicia la transacción
        try {
            $request->validate([
                'animal_id' => 'required|exists:animals,id',
                'feed_id' => 'required|exists:feeds,id',
            ]);
            $animalFeed = AnimalsFeed::create([
                'animal_id' => $request['animal_id'],
                'feed_id' => $request['feed_id']
            ]);
            DB::commit(); // Confirma la transacción
            return response()->json([
                'message' => 'Alimento registrado con éxito',
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack(); // Revierte la transacción en caso de error
            return response()->json([
                'message' => '' . $e,
            ], 500);
        }
    }

    // // Mostrar un registro específico de alimento consumido
    // public function show($id)
    // {
    //     try {
    //         $animalFeed = AnimalsFeed::findOrFail($id);

    //         // Excluir campos 'created_at' y 'updated_at' de la respuesta
    //         return response()->json($animalFeed->only([
    //             'id',
    //             'animal_id',
    //             'feed_id'
    //         ]), Response::HTTP_OK);
    //     } catch (ModelNotFoundException $e) {
    //         return response()->json(['message' => 'Registro de alimento no encontrado'], Response::HTTP_NOT_FOUND);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'error' => 'Error al obtener el registro de alimento',
    //             'message' => $e->getMessage()
    //         ], Response::HTTP_INTERNAL_SERVER_ERROR);
    //     }
    // }

    // Actualizar un registro de alimento consumido
    // public function update(Request $request, $id)
    // {
    //     DB::beginTransaction(); // Inicia la transacción

    //     try {
    //         $animalFeed = AnimalsFeed::findOrFail($id);

    //         // Validar los datos de entrada
    //         $validatedData = $request->validate([
    //             'animal_id' => 'required|exists:animals,id',
    //             'feed_id' => 'required|exists:feeds,id',
    //         ]);

    //         // Actualizar los datos del registro de alimento
    //         $animalFeed->update($validatedData);

    //         DB::commit(); // Confirma la transacción

    //         // Retornar un mensaje de éxito junto con los campos específicos
    //         return response()->json([
    //             'message' => 'Registro de alimento actualizado con éxito',
    //             'data' => $animalFeed->only([
    //                 'id',
    //                 'animal_id',
    //                 'feed_id'
    //             ])
    //         ], Response::HTTP_OK);
    //     } catch (ModelNotFoundException $e) {
    //         DB::rollBack(); // Revierte la transacción en caso de error

    //         return response()->json(['message' => 'Registro de alimento no encontrado'], Response::HTTP_NOT_FOUND);
    //     } catch (\Exception $e) {
    //         DB::rollBack(); // Revierte la transacción en caso de error

    //         return response()->json([
    //             'error' => 'No se pudo actualizar el registro de alimento',
    //             'message' => $e->getMessage()
    //         ], Response::HTTP_INTERNAL_SERVER_ERROR);
    //     }
    // }

    // Eliminar un registro de alimento consumido
    // public function destroy($id)
    // {
    //     DB::beginTransaction(); // Inicia la transacción

    //     try {
    //         $animalFeed = AnimalsFeed::findOrFail($id);

    //         $animalFeed->delete(); // Elimina el registro de alimento

    //         DB::commit(); // Confirma la transacción

    //         return response()->json(['message' => 'Registro de alimento eliminado con éxito'], Response::HTTP_NO_CONTENT);
    //     } catch (ModelNotFoundException $e) {
    //         DB::rollBack(); // Revierte la transacción en caso de error

    //         return response()->json(['message' => 'Registro de alimento no encontrado'], Response::HTTP_NOT_FOUND);
    //     } catch (\Exception $e) {
    //         DB::rollBack(); // Revierte la transacción en caso de error

    //         return response()->json([
    //             'error' => 'No se pudo eliminar el registro de alimento',
    //             'message' => $e->getMessage()
    //         ], Response::HTTP_INTERNAL_SERVER_ERROR);
    //     }
    // }
}
