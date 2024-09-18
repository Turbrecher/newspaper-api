<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Exception;

class ArticleController extends Controller
{
    //Method that retrieves all users of db.
    function getArticles()
    {
        $articles = Article::all();


        return response()->json(
            [$articles],
            200
        );
    }

    //Method that retrieves a certain user of db.
    function getArticle(int $id)
    {

        try {
            $article = Article::find($id);

            if ($article == null) {
                return response()->json(
                    ["error" => "The article you are looking for doesn't exist"],
                    404
                );
            }


            return response()->json(
                [$article],
                200
            );
        } catch (Exception $e) {
        }
    }


    //Method that creates a new user on db.
    function createArticle(Request $request)
    {
        $validated = $request->validate([
            "title" => ["required", "max:100"],
            "subtitle" => ["required", "max:50"],
            "content" => ["required", "max:2048"],
            "user_id" => ["required", "integer"],
            "date" => ["required", "regex:/^([0-9]{2,2}-[0-9]{2,2}-[0-9]{4,4})$/"],
            "time" => ["required", "regex:/^([0-9]{2,2}:[0-9]{2,2})$/"]
        ]);


        $article = new Article();
        $article->title = $request['title'];
        $article->subtitle = $request['subtitle'];
        $article->content = $request['content'];
        $article->user_id = $request['user_id'];
        $article->date = $request['date'];
        $article->time = $request['time'];


        if ($request->photo != "") {
            $article->photo = $request['photo'];
        }

        $article->save();

        return response()->json(
            [
                "article_id" => $article->id,
                "message" => "Article succesfully created"
            ],
            200
        );
    }

    //Method that edits an existing user of db.
    function editArticle(Request $request, int $id)
    {
        $validated = $request->validate([
            "title" => ["required", "max:100"],
            "subtitle" => ["required", "max:50"],
            "content" => ["required", "max:2048"],
            "photo" => ["regex:https|^$"],
            "user_id" => ["required", "integer"],
            "date" => ["required", "regex:[0-9]{2,2}-[0-9]{2,2}[0-9]{4,4}"],
            "time" => ["required", "regex:[0-9]{2,2}:[0-9]{2,2}"]
        ]);


        $article = new Article();
        $article->title = $request['title'];
        $article->subtitle = $request['subtitle'];
        $article->content = $request['content'];
        $article->user_id = $request['user_id'];
        $article->date = $request['date'];
        $article->time = $request['time'];


        if ($request->photo != "") {
            $article->photo = $request['photo'];
        }

        $article->save();

        return response()->json(
            [
                "article_id" => $article->id,
                "message" => "Article succesfully edited"
            ],
            200
        );


        return response()->json($request->user(), 200);
    }
}
