<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Rate;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class ArticlesController extends Controller
{
    public function index(){
        $articles = Article::with('author','raters','viewers')->get();
        return Inertia::render('Articles/Index', ['articles'=>$articles]);
    }

    public function showCreate(){
        return Inertia::render('Articles/Create');
    }

    public function storeArticle(Request $request){
        $request->validate([
            'title'=>'required|min:10',
            'subtitle'=>'max:200',
            'body'=>'required'
        ]);

        $article = Article::create([
            'title'=>$request->title,
            'subtitle'=>$request->subtitle ?? '',
            'body'=>$request->body,
            'author_id'=>Auth::user()->id
        ]);
        return redirect()->route('articles.index');
    }

    public function showArticle($id){
        $user = Auth::user();
        $article = Article::find($id);
        if($user && !$article->viewers->contains($user->id)){
            $article->viewers()->attach($user->id);
        }
        $article = Article::with('author','viewers')->find($id);
        $rates = Rate::where('article_id','=',$id)->get();
        
        return Inertia::render('Articles/Article',['article'=>$article, 'user'=>$user,'rates'=>$rates]);
    }

    public function deleteArticle($id){
        $article = Article::find($id);
        if($article->author_id === Auth::user()->id){
            $article->delete();
        }
        return redirect()->route('articles.index')->with('success', 'Article deleted successfully');
    }

    public function like($id)
    {
        $user = Auth::user();
        if (!$user) {
            // Optionally redirect to login or show an error
            return redirect()->route('login.show');
        }

        $article = Article::findOrFail($id);

        // Check if the user already has a rating for this article
        $existingRating = $article->raters()->where('user_id', $user->id)->first();

        if (!$existingRating) {
            // User has not rated → attach with like (rate = true)
            $article->raters()->attach($user->id, ['rate' => true]);
        } else {
            // User already rated – check the current rate value
            if ($existingRating->pivot->rate) {
                // Current rate is true → unlike (detach)
                $article->raters()->detach($user->id);
            } else {
                // Current rate is false → change to like (update pivot)
                $article->raters()->updateExistingPivot($user->id, ['rate' => true]);
            }
        }

        return redirect()->route('articles.article.show', ['id' => $id]);
    }

    public function dislike($id)
    {
        $user = Auth::user();
        if (!$user) {
            // Optionally redirect to login or show an error
            return redirect()->route('login.show');
        }

        $article = Article::findOrFail($id);

        // Check if the user already has a rating for this article
        $existingRating = $article->raters()->where('user_id', $user->id)->first();

        if (!$existingRating) {
            // User has not rated → attach with like (rate = true)
            $article->raters()->attach($user->id, ['rate' => false]);
        } else {
            // User already rated – check the current rate value
            if (!$existingRating->pivot->rate) {
                // Current rate is true → unlike (detach)
                $article->raters()->detach($user->id);
            } else {
                // Current rate is false → change to like (update pivot)
                $article->raters()->updateExistingPivot($user->id, ['rate' => false]);
            }
        }

        return redirect()->route('articles.article.show', ['id' => $id]);
    }

    public function showEdit($id){
        $article = Article::with('author')->find($id);
        return Inertia::render('Articles/Edit', ['article'=>$article]);
    }

    public function storeEdit(Request $request){
        $validated = $request->validate([
            'title'=>'required',
            'subtitle'=>'',
            'body'=>'required|string'
        ]);
        $article = Article::findOrFail($request->id);
        $article->title = $request->title;
        $article->subtitle = $request->subtitle ?? '';
        $article->body = $request->body;
        $article->save();
        return redirect()->route('articles.article.show',['id'=>$article->id]);
    }
}


