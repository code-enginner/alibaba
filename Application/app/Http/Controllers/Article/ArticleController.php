<?php

namespace App\Http\Controllers\Article;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleRequest;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use function Laravel\Prompts\alert;


class ArticleController extends Controller
{

    private const MESSAGES = [
        'success' => [
            'مقاله با موفقیت ثبت شده'
        ],

        'error' => [
            'ثبت مقاله ناموفق بود',
            'هیچ مقاله ای یافت نشد'
        ],
    ];

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::check()) {
            try {
                $articles = Article::where('publish_status', 1)
                    ->where('approve_status', 1)
                    ->whereNull('deleted_at')
                    ->pagginate(5);

                Log::channel('article')->info('Load All Articles | Success', [
                    'created_at' => Carbon::now()
                ]);

                return view('dashboard', compact('articles'));

            } catch (\Exception $exception) {
                Log::channel('article')->error('oad All Articles | Error', [
                    'systemMessage' => $exception->getMessage(),
                    'created_at' => Carbon::now()
                ]);

                $error = self::MESSAGES['error'][1];
                return view('dashboard', compact('error'));
            }
        }
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
        if (Auth::check()) {
            try {
                $article = Article::create([
                    'user_id'        => Auth::user()->id,
                    'title'          => $request->title,
                    'content'        => $request->contnet,
                    'publish_status' => 0,
                    'approve_status' => 0,
                    'publish_date'   => Carbon::now(),
                    'approve_date'   => NULL,
                    'deleted_at'     => NULL,
                ]);

                Log::channel('article')->info('Article Register | Success', [
                    'userInputs' => $request->all(),
                    'article'    => $article,
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

        return redirect()->route('login');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if (Auth::check()) {
            try {
                //todo use model resource
                $article = Article::where([
                    ['publish_status', 1],
                    ['approve_status', 1],
                ])->whereNull('deleted_at')->firstOrFail();

                Log::channel('article')->info('Article Find | Success', [
                    'result'     => $article,
                    'modelId'    => $id,
                    'created_at' => Carbon::now()
                ]);

                return view('dashboard', compact('article'));

            } catch (\Exception $exception) {
                Log::channel('article')->error('Article Find | Error', [
                    'systemMessage' => $exception->getMessage(),
                    'modelId'       => $id,
                    'created_at'    => Carbon::now()
                ]);
            }
        }

        return redirect()->route('login');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (Auth::check()) {
            $article = Article::whereNull('deleted_at')->firstOrFail();
            try {
                if ($article->user()->id === $article->user_id) {

                }
                //todo use model resource
                $article = Article::where([
                    ['publish_status', 1],
                    ['approve_status', 1],
                ])->

                Log::channel('article')->info('Article Find | Success', [
                    'result'     => $article,
                    'modelId'    => $id,
                    'created_at' => Carbon::now()
                ]);

                return view('dashboard', compact('article'));

            } catch (\Exception $exception) {
                Log::channel('article')->error('Article Find | Error', [
                    'systemMessage' => $exception->getMessage(),
                    'modelId'       => $id,
                    'created_at'    => Carbon::now()
                ]);
            }
        }

        return redirect()->route('login');
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
        if (Auth::guard('admin')->check()) {

        }

    }
}
