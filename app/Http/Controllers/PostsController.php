<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostImage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostsController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => true,
            'message' => 'Postagens buscadas com sucesso!',
            'data' => Post::paginate(env('PER_PAGE_ITEMS'))
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'content' => 'required|min:50',
            'images' => 'required'
        ], [
            'required' => 'O campo ":attribute" é obrigatório',
            'email' => 'O campo ":attribute" deve ser um e-mail',
            'min' => 'O campo ":attribute" deve ter pelo menos :min carácteres',
        ]);

        $user = $this->getRequestUser();
        $post = new Post(array_merge($request->only('title', 'content'), ['user_id' => $user->id]));
        $post->save();
        foreach($request->file('images') as $img) {

            $original_filename = $request->file('images')->getClientOriginalName();
            $original_filename_arr = explode('.', $original_filename);
            $file_ext = end($original_filename_arr);
            $destination_path = './upload/user/';
            $image = 'U-' . time() . '.' . $file_ext;
            $request->file('images')->move($destination_path, $image);
            $imagePath = 'upload/usuario/' . $image;
            $post->images()->create(['address' => $imagePath]);
        };

        return response()->json([
            'status' => true,
            'message' => 'Postagem cadastrada com sucesso!',
            'data' => $post
        ]);
    }

    public function find(int $id)
    {
        $post = Post::find($id);
        if (!$post) return response()->status(204);

        return response()->json([
            'status'  => true,
            'message' => 'Postagem buscada com sucesso!',
            'data' => $post
        ]);
    }
}
