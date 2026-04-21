<?php
namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller {

    public function index() {
        $users = User::orderBy('name')->paginate(15);
        return view('users.index', compact('users'));
    }

    public function create() {
        return view('users.create');
    }

    public function store(Request $request) {
        $request->validate([
            'name'      => 'required|string|max:100',
            'apellidos' => 'required|string|max:100',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|string|min:8|confirmed',
            'rol'       => 'required|in:admin,enfermero',
        ]);
        User::create([
            'name'      => $request->name,
            'apellidos' => $request->apellidos,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'rol'       => $request->rol,
            'activo'    => true,
        ]);
        return redirect()->route('users.index')
            ->with('success','Usuario creado correctamente.');
    }

    public function edit(User $user) {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user) {
        $request->validate([
            'name'      => 'required|string|max:100',
            'apellidos' => 'required|string|max:100',
            'email'     => 'required|email|unique:users,email,'.$user->id,
            'rol'       => 'required|in:admin,enfermero',
            'password'  => 'nullable|string|min:8|confirmed',
        ]);
        $user->update([
            'name'      => $request->name,
            'apellidos' => $request->apellidos,
            'email'     => $request->email,
            'rol'       => $request->rol,
        ]);
        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }
        return redirect()->route('users.index')
            ->with('success','Usuario actualizado correctamente.');
    }

    // ✅ CORREGIDO: toggle activo/inactivo
    public function toggleActivo(User $user) {
        if ($user->id === auth()->id()) {
            return back()->with('error','No puedes desactivar tu propia cuenta.');
        }
        $nuevoEstado = !$user->activo;
        $user->update(['activo' => $nuevoEstado]);
        $msg = $nuevoEstado ? "Usuario {$user->name} activado." : "Usuario {$user->name} desactivado.";
        return back()->with('success', $msg);
    }
}
