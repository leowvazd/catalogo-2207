<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    public function index(){
        //$user = User::first();
        $users = User::paginate(10); //User::all();

        return view('admin.user.index', compact('users'));
    }

    public function create(){      
        return view('admin.user.new-user');
    }


    public function store(StoreUserRequest $request){
        User::create($request->validated()); // cria novo usuario passando tudo que recebeu na request

        return redirect()
            ->route('users.index')
            ->with('success', 'Usuario criado com sucesso');
    }

    public function edit(string $id){
        //$user = User::where('id', '=', $id)->first();
        //$user = User::where('id', $id)->first(); //->firstOrFail();
        
        $user = User::find($id);

        if(!$user){
            return redirect()
                ->route('users.index')
                ->with('message', 'Usuário não encontrado');
        }
        
        return view('admin.user.edit-user', compact('user'));
    }

    public function update(UpdateUserRequest $request, string $id){
        if(!$user = User::find($id)){
            return redirect()
                ->back()
                ->with('message', 'Usuário não encontrado');
        }

        $data = $request->only('name', 'email');

        if($request->password){
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);

        return redirect()
                ->route('users.index')
                ->with('success', 'Usuário editado com sucesso');
    }

    public function show(string $id){
        if(!$user = User::find($id)){
            return redirect()
                ->route('users.index')
                ->with('message', 'Usuário não encontrado');
        }

        return view('admin.user.show-user', compact('user'));
    }

    public function destroy(string $id){

        //Como Verificar usando Gate:
        //if(Gate::allows('is-admin')){ tratar quem pode}
        //if(Gate::denies('is-admin')){ tratar quem não pode}

        if(!$user = User::find($id)){
            return redirect()
                ->route('users.index')
                ->with('message', 'Usuário não encontrado');
        }

        if(Auth::user()->id == $user->id){
            return redirect()
                ->route('users.index')
                ->with('message', 'Não é possível deletar o próprio perfil');
        }

        $user->delete();

        return redirect()
                ->route('users.index')
                ->with('success', 'Usuário deletado com sucesso');
    }

}
