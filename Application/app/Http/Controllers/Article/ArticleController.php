<?php

namespace App\Http\Controllers\Article;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleRequest;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class ArticleController extends Controller
{

    private const MESSAGES = [
        'success' => [
            'مقاله با موفقیت ثبت شده'
        ],

        'error' => [
            'ثبت مقاله ناموفق بود'
        ],
    ];

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return redirect()->route('dashboard');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ArticleRequest $request)
    {
        try {
            $article = Article::create([
                'user_id' => Auth::user()->id,
                'title' => $request->title,
                'content' => $request->contnet,
                'publish_status' => 0,
                'approve_status' => 0,
                'publish_date' => Carbon::now(),
                'approve_date' => NULL,
                'deleted_at' => NULL,
            ]);

            Log::channel('article')->info('Article Register | Success', [
                'userInputs' => $request->all(),
                'article' => $article,
                'created-at' => Carbon::now()
            ]);

            return redirect()->back()->with('success', self::MESSAGES['success'][0]);

        } catch (\Exception $exception) {
            Log::channel('article')->error('Article Register | Error', [
                'userInputs'  => $request->all(),
                'sysMessages' => $exception->getMessage(),
                'created-at'  => Carbon::now()
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
