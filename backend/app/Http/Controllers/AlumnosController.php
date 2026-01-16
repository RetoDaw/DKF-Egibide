<?php

namespace App\Http\Controllers;

use App\Models\Alumnos;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AlumnosController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index() {
        return Alumnos::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        $validated = $request->validate([
            'nombre' => ['required'],
            'apellidos' => ['required'],
            'telefono' => ['required'],
            'ciudad' => ['required']
        ]);

        // Generar email y contraseña temporal
        $email = strtolower($validated['nombre']) . '.' . strtolower(explode(' ', $validated['apellidos'])[0]) . '@ikasle.egibide.org';
        $password = Hash::make('12345Abcde');

        // USUARIO
        $user = User::create([
            'email' => $email,
            'password' => $password,
            'role' => 'alumno',
        ]);

        // ALUMNO
        $alumno = Alumnos::create([
            'nombre' => $validated['nombre'],
            'apellidos' => $validated['apellidos'],
            'ciudad' => $validated['ciudad'],
            'telefono' => $validated['telefono'],
            'user_id' => $user->id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Alumno agregado correctamente'
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Alumnos $alumnos) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Alumnos $alumnos) {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Alumnos $alumnos) {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Alumnos $alumnos) {
        //
    }

    public function me()
{
    $userId = auth()->id();

    $row = Alumnos::join('users', 'alumnos.user_id', '=', 'users.id')
        ->select(
            'alumnos.nombre',
            'alumnos.apellidos',
            'alumnos.telefono',
            'alumnos.ciudad',

            'users.email',
        )
        ->where('alumnos.user_id', $userId)
        ->first();

    if (!$row) {
        return response()->json(['message' => 'Alumno no encontrado'], 404);
    }

    return response()->json($row);
}
    public function notaCuadernoLogeado(Request $request)
    {
    $userId = auth()->user()->id_usuario;

    $row = DB::table('alumnos as a')
        ->join('estancias as e', 'e.id_alumno', '=', 'a.id_alumno')
        ->join('cuadernos_practicas as c', 'c.id_estancia', '=', 'e.id_estancia')
        ->leftJoin('notas_cuaderno as n', 'n.id_cuaderno', '=', 'c.id_cuaderno')
        ->where('a.id_usuario', $userId)
        ->orderByDesc('e.fecha_fin')
        ->select([
            'n.nota',
            'e.id_estancia',
            'e.fecha_fin',
            'c.id_cuaderno',
        ])
        ->first();
        if (!$row) {
            return response()->json([
                'nota' => null,
                'message' => 'No hay cuaderno/estancia para este alumno todavía.'
            ], 200);
        }

        if ($row->fecha_fin > now()->toDateString()) {
            return response()->json([
                'nota' => null,
                'message' => 'La estancia aún no ha finalizado. La nota no está disponible.'
            ], 200);
        }

        if ($row->nota === null) {
            return response()->json([
                'nota' => null,
                'message' => 'La estancia ha finalizado, pero aún no hay nota del cuaderno.'
            ], 200);
        }

        return response()->json([
            'nota' => (float) $row->nota,
            'message' => null
        ], 200);
    }
}
