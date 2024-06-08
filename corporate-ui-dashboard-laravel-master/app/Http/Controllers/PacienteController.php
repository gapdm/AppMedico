<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paciente;
use App\Models\Expediente;

class PacienteController extends Controller
{
    public function index(){
        $pacientes = Paciente::paginate(6);
        $expedientes = Expediente::all();

        return view('tables', compact('pacientes', 'expedientes'));
    }

    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'nombre' => 'required|string|max:255',
            'edad' => 'required|integer|min:0',
            'sexo' => 'required|string|in:M,F',
            'telefono' => 'required|string|max:15',
        ]);

        $paciente = Paciente::create([
            'nombre' => $request->nombre,
            'edad' => $request->edad,
            'sexo' => $request->sexo,
            'telefono' => $request->telefono,
        ]);

        Expediente::create([
            'id_paciente' => $paciente->id,
            'fecha_reg' => now(),
            'fecha_act' => now()
        ]);

        return redirect()->route('tables')->with('success', 'Paciente registrado exitosamente');
    }

    public function getPaciente($id)
    {
        $paciente = Paciente::findOrFail($id);
        return response()->json($paciente);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'edad' => 'required|integer|min:0',
            'sexo' => 'required|string|in:Masculino,Femenino',
            'telefono' => 'required|string|max:15',
            'expediente' => 'required|string|max:255',
        ]);

        $paciente = Paciente::where('id_paciente', $id)->firstOrFail();
        $paciente->update($request->all());

        return redirect()->route('tables')->with('success', 'Paciente actualizado exitosamente');
    }

    public function destroy($id)
    {
        $paciente = Paciente::where('id', $id)->firstOrFail();
        $expediente = Expediente::where('id_paciente', $id)->firstOrFail();
        $expediente->delete();
        $paciente->delete();

        return redirect()->route('tables')->with('success', 'Paciente eliminado exitosamente');
    }
}
