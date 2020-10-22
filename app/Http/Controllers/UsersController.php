<?php

namespace App\Http\Controllers;

use App\Models\User;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use PDOException;

class UsersController extends Controller
{
    public function store(Request $request)
    {
        $this->validateUser($request);
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone_number' => $request->phone_number
            ]);
        }catch (PDOException $exception) {
            return response()->json([
                'status' => false,
                'data' => null,
                'message' => "Já existe um usuário cadastrado com o email: $request->email"
            ]);
        }

        $jwt = JWT::encode($user, env('JWT_TOKEN'));
        return response()->json([
            'status' => true,
            'data' => collect($user->jsonSerialize())->merge([
                'access_token' => $jwt
            ]),
            'message' => 'Usuário cadastrado com sucesso!'
        ], 201);
    }

    public function edit(Request $request, int $userId)
    {
        $user = User::find($userId);

        if (empty($user))
            return response()->json([
                'status' => false,
                'message' => 'Não existe usuário com o id ' . "$userId",
                'data' => [
                    'userId' => $userId
                ]
            ]);

        foreach ($request->all() as $key => $value) {

            if ($key === 'password')
                $value = Hash::make($value);

            $user->$key = $value;
        }
        try {
            $user->save();
        }catch (\Exception $exception) {
            return response()->json([
                'status' => false,
                'message' => 'Algum campo está incorreto',
                'data' => null
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Usuário atualizado com sucesso!',
            'data' => $user
        ]);
    }

    public function validateUser(Request $request): void
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'phone_number' => 'required'
        ], [
            'required' => 'O campo ":attribute" é obrigatório',
            'email' => 'O campo ":attribute" deve ser um e-mail'
        ]);
    }

    public function delete(int $userId)
    {
        try {
            $user = User::find($userId);
            if(is_null($user))
                return response()->json([
                    'status' => false,
                    'message' => 'Não existe nenhum usuário com esse id',
                    'data' => [
                        'user_id' => $userId
                    ]
                ]);

            $user->delete();
        } catch (\Throwable $err) {
            return response()->json([
                'status' => false,
                'message' => 'Erro ao excluir usuário',
                'data' => ['userId' => $userId]
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Usuário deletado com sucesso!',
            'data' => null
        ]);
    }

    public function index(Request $request)
    {
        return response()->json([
            'status' => true,
            'message' => 'Usuarios buscados com sucesso!',
            'data' => DB::table('users')->paginate(env('PER_PAGE_ITEMS'),[
                'id', 'name', 'email','phone_number', 'created_at','updated_at'
            ]),
        ]);
    }
}
