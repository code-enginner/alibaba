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
            'مقاله با موفقیت ثبت شده',
            'مقابله مورد نظر تایید شد',
            'مقاله مورد نظر با موفقیت حذف شد',
            'یبه روز رسانی مقاله با موقیت انجام شد'
        ],

        'error' => [
            'ثبت مقاله ناموفق بود',
            'هیچ مقاله ای یافت نشد',
            'ویرایش این مقاله امکان پذیر نیست',
            'حذف این مقاله امکان پذیر نیست',
            'شما مجوز لازم برای این کار را ندارید!'
        ],
    ];

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Implemented in "ProfileController"
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
                    'title'          => $request->input('title'),
                    'publish_status' => TRUE,
                    'content'        => $request->input('content'),
                    'approve_status' => FALSE,
                    'publish_date'   => Carbon::now(),
                    'approve_date'   => NULL,
                    'deleted_at'     => NULL,
                ]);

                Log::channel('article')->info('Article Register | Success', [
                    'userInputs' => $request->all(),
                    'article'    => $article,
                    'created_at' => Carbon::now()
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
                    Log::channel('article')->info('Article Find | Success', [
                        'result'     => $article,
                        'modelId'    => $id,
                        'created_at' => Carbon::now()
                    ]);

                    return view('dashboard', compact('article'));
                }

            } catch (\Exception $exception) {
                Log::channel('article')->error('Article Find | Error', [
                    'systemMessage' => $exception->getMessage(),
                    'modelId'       => $id,
                    'created_at'    => Carbon::now()
                ]);

                return redirect()->back()->withErrors(self::MESSAGES['error'][2]);
            }
        }

        return redirect()->route('login');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //todo how should handel the fom validation
        if (Auth::check()) {
            try {
                $article = Article::findOrFail($id);
                $article->update($request->all());

                Log::channel('article')->info('Article Update | Success', [
                    'articleId'  => $id,
                    'article'    => $article,
                    'created_at' => Carbon::now()
                ]);

                return redirect()->back()->with('success', self::MESSAGES['success'][3]);

            } catch (\Exception $exception) {
                Log::channel('article')->error('Article Update | Error', [
                    'systemMessage' => $exception->getMessage(),
                    'articleId'     => $id,
                    'created_at'    => Carbon::now()
                ]);
            }
        }

        return redirect()->route('login');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (Auth::guard('admin')->check()) {
            try {
                $article = Article::findOrFail($id);
                $article->delete();

                return redirect()->back()->with('success', self::MESSAGES['success'][2]);

            } catch (\Exception $exception) {
                Log::channel('article')->error('Article Delete | Error', [
                    'articleId'     => $id,
                    'systemMessage' => $exception->getMessage(),
                    'created_at'    => Carbon::now()
                ]);

                return redirect()->back()->withErrors(self::MESSAGES['error'][3]);
            }
        }

        Log::channel('article')->alert('Article Delete | Alert', [
            'articleId'     => $id,
            'systemMessage' => self::MESSAGES['error'][4],
            'user'          => Auth::user(),
            'created_at'    => Carbon::now()
        ]);

        return redirect()->back()->withErrors(self::MESSAGES['error'][4]);
    }


    public function approveArticle(Request $request, $id)
    {
        if (Auth::guard('admin')->check()) {
            try {
                $article = Article::whereNull('deleted_at')->firstOrfail();
                $article->approved_status = $request->only('approve_status');
                $article->save();
                Log::channel('article')->info('Article Approve | Success', [
                    'article'    => $article,
                    'articleId'  => $id,
                    'created_at' => Carbon::now()
                ]);

                return redirect()->back()->with('success', self::MESSAGES['success'][]);

            } catch (\Exception $exception) {
                Log::channel('article')->error('Article Approve | Error', [
                    'systemMessage' => $exception->getMessage(),
                    'articleId'     => $id,
                    'created_at'    => Carbon::now()
                ]);
            }
        }
    }
}
