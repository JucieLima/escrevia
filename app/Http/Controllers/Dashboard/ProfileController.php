<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Inertia\Response
     */
    public function edit(Request $request): \Inertia\Response
    {
        return Inertia::render('Profile/Edit', [
            // Podemos passar dados do usuário logado para a página Vue
            'user' => $request->user()->only('name', 'email'),
            // Se você tiver avatar_url ou outros campos que queira exibir
            // 'avatar_url' => $request->user()->avatar_url,
        ]);
    }

    /**
     * Update the user's profile information.
     * Por enquanto, este método pode ficar vazio ou com um dd()
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        // Lógica de atualização do perfil virá aqui
        // Exemplo:
        // $request->validate([
        //     'name' => 'required|string|max:255',
        //     'email' => 'required|string|email|max:255|unique:users,email,' . $request->user()->id,
        // ]);
        // $request->user()->fill($request->validated());
        // $request->user()->save();
        // return redirect()->route('profile.edit')->with('success', 'Perfil atualizado!');
    }

    /**
     * Delete the user's account.
     * Por enquanto, este método pode ficar vazio ou com um dd()
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        // Lógica de exclusão de conta virá aqui
        // Exemplo:
        // Auth::logout();
        // $request->user()->delete();
        // return redirect()->to('/')->with('success', 'Conta excluída!');
    }
}
