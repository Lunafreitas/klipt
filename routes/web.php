<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\FotoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicGalleryController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/* ROTAS PÚBLICAS — acessíveis por qualquer visitante sem autenticação */

// Galeria principal: lista todas as fotos públicas em formato masonry
Route::get('/', [PublicGalleryController::class, 'index'])->name('public.index');

// Detalhe de uma foto pública (o controller filtra apenas públicas)
Route::get('/foto/{foto}', [PublicGalleryController::class, 'foto'])->name('public.foto');

// Álbum público — o controller usa abort_if(!$album->publico, 403)
Route::get('/album/{album}', [PublicGalleryController::class, 'album'])->name('public.album');

// Perfil público de um fotógrafo — exibe apenas seu conteúdo público
Route::get('/fotografo/{user}', [PublicGalleryController::class, 'fotografo'])->name('public.fotografo');

// Fotos de uma tag — filtra somente fotos públicas
Route::get('/tag/{tag}', [PublicGalleryController::class, 'tag'])->name('public.tag');




/* ROTAS AUTENTICADAS — requer login (middleware 'auth') */
Route::middleware('auth')->group(function () {

    /* Perfil do usuário — edição de dados e exclusão de conta */
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /* CRUD de Álbuns - A autorização é feita no controller via abort_unless(owner) */
    Route::resource('albums', AlbumController::class);

    /* CRUD de Fotos - A autorização é feita via FormRequest (UpdateFotoRequest) e abort_unless no controller
    */
    Route::resource('fotos', FotoController::class);




    /* ROTAS DE ADMINISTRADOR - AdminMiddleware que verifica user->is_admin */
    Route::middleware('admin')->group(function () { //grupo de rotas que exigem vaidação middleware

        // Gerenciamento de Tags (categorias) — criação, edição e exclusão
        Route::resource('tags', TagController::class)->except(['show']);

        // Gerenciamento de Usuários — visualização e exclusão
        Route::get('/admin/usuarios', [UserController::class, 'index'])->name('usuarios.index');
        Route::get('/admin/usuarios/{user}', [UserController::class, 'show'])->name('usuarios.show');
        Route::delete('/admin/usuarios/{user}', [UserController::class, 'destroy'])->name('usuarios.destroy');
    });
});

require __DIR__.'/auth.php';

Route::get('/download-imagem/{filename}', [FotoController::class, 'download'])->name('foto.download')
    ->where('filename', '.*'); // ISSO PERMITE BARRAS NA URL