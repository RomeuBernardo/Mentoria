<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    public function adicionar(UserRequest $request)
    {
        try {
            // O request já é validado pela UserRequest
            $validated = $request->validated();
            
            // Log do payload validado
            \Log::info('Payload validado:', $validated);
        
            // Hash da senha antes de salvar
            $validated['password'] = bcrypt($validated['password']);
        
            // Se uma imagem for enviada, armazene-a e atualize o caminho da imagem
            if ($request->hasFile('caminho_img')) {
                $image = $request->file('caminho_img');
                $imagePath = $image->store('images', 'public');
                $validated['caminho_img'] = $imagePath;
            }
        
            // Criação do usuário
            $user = User::create($validated);
        
            // Retorno da resposta de sucesso usando UserResource
            return new UserResource($user);
        
        } catch (\Exception $e) {
            // Log do erro para fins de depuração
            \Log::error('Erro ao criar usuário: ' . $e->getMessage());
        
            // Retorna uma mensagem de erro genérica
            return response()->json(['message' => 'Ocorreu um erro. Por favor, tente novamente mais tarde.'], 500);
        }
    }
    


    // Exibir todos os usuários
    public function mostrar()
    {
        $users = User::all();
        if ($users->isEmpty()) return response()->json(['message' => 'Nenhum Usuário encontrado'], 404);
        return UserResource::collection($users);
    }

    // Pegar um usuário específico
    public function pegarUser($id)
    {
        $user = User::find($id);
        if (!$user) return response()->json(['message' => 'Usuário não encontrado'], 404);
        return new UserResource($user);
    }
    

    // Atualizar um usuário
    public function atualizar(Request $request, $id)
    {
        try {
            $user = User::find($id);

            if (!$user) 
                return response()->json(['message' => 'Usuário não encontrado'], 404);

            // Validação dos campos de atualização
            $validated = $request->except(['type', 'id']);
            $validated['password'] = isset($validated['password']) ? bcrypt($validated['password']) : $user->password;

            // Se uma imagem for enviada, armazene-a e atualize o caminho da imagem
            if ($request->hasFile('caminho_img')) {
                $image = $request->file('caminho_img');
                $imagePath = $image->store('images', 'public');
                $validated['caminho_img'] = $imagePath;
            }

            // Atualizar usuário com os dados validados
            $user->update($validated);

            return new UserResource($user);
       
        } catch (\Exception $e) {
            // Log do erro para fins de depuração
            \Log::error('Erro ao atualizar usuário: ' . $e->getMessage());
       
            // Retorna uma mensagem de erro genérica
            return response()->json(['message' => 'Ocorreu um erro. Por favor, tente novamente mais tarde.'], 500);
        }
    }

    // Deletar um usuário
    public function deletar($id)
    {
        $user = User::find($id);

        if (!$user) return response()->json(['message' => 'Usuário não encontrado'], 404);

        $user->delete();
        return response()->json(['message' => 'Usuário deletado com sucesso']);
    }
}
