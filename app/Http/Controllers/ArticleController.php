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
        //load writer subobject
        foreach ($articles as $article) {
            $article->writer;
        }


        return response()->json(
            $articles,
            200
        );
    }

    //Method that retrieves a certain user of db.
    function getArticle(int $id)
    {

        try {
            $article = Article::find($id);

            //load subobjects
            $article->writer;
            $article->comments;
            foreach ($article->comments as $comment) {
                $comment->user;
            }

            if ($article == null) {
                return response()->json(
                    ["error" => "The article you are looking for doesn't exist"],
                    404
                );
            }


            return response()->json(

                $article,
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
            "content" => ["required", "max:2048"]
        ]);


        $article = new Article();
        $article->title = $request['title'];
        $article->subtitle = $request['subtitle'];
        $article->content = $request['content'];
        $article->user_id = $request->user()->id;
        $article->date = date("m-d-Y");
        $article->time = date("H:i");


        if ($request->photo != "") {
            $article->photo = $request['photo'];
        }

        $article->save();

        return response()->json(
            [
                "article_id" => $article->id,
                "article" => $article,
                "message" => "Article succesfully created"
            ],
            200
        );
    }

    //Method that edits an existing user of db.
    function editArticle(Request $request, int $id)
    {
        if ($request->user()->hasRole('general')) {
            return response()->json(
                ["message" => "You are not allowed to edit this article"],
                401
            );
        }


        $validated = $request->validate([
            "title" => ["required", "max:100"],
            "subtitle" => ["required", "max:50"],
            "content" => ["required", "max:2048"],
            "photo" => ["regex:https|^$"]
        ]);

        $article = Article::find($id);

        //If writer user tries to edit another person's article.
        if ($request->user()->hasRole('writer')) {
            $NOT_MY_ARTICLE = $request->user()->id != $article->user_id;
            if ($NOT_MY_ARTICLE) {
                return response()->json(
                    ["message" => "You are not allowed to edit this article"],
                    401
                );
            }
        }


        $article->title = $request['title'];
        $article->subtitle = $request['subtitle'];
        $article->content = $request['content'];


        if ($request->photo != "") {
            $article->photo = $request['photo'];
        }

        $article->save();

        return response()->json(
            [
                "article_id" => $article->id,
                "article" => $article,
                "message" => "Article succesfully edited"
            ],
            200
        );


        return response()->json($request->user(), 200);
    }
}
