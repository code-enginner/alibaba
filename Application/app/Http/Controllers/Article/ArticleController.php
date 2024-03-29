<?php

namespace App\Http\Controllers\Article;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleRequest;
use App\Models\Article;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
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
            'مقاله مورد نظر، تغییر وضعیت یافت',
            'مقاله مورد نظر با موفقیت حذف شد',
            'به روز رسانی مقاله با موفقیت انجام شد',
            'مقاله با موفقیت بازیابی شد'
        ],

        'error' => [
            'ثبت مقاله ناموفق بود',
            'هیچ مقاله ای یافت نشد',
            'ویرایش این مقاله امکان پذیر نیست',
            'حذف این مقاله امکان پذیر نیست',
            'شما مجوز لازم برای این کار را ندارید!',
            'عملیات امکان پذیر نیست',
            'بازیابی ناموفق بود'
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
                    'created_at' => Carbon::now(),
                ]);

                return redirect()->back()->with('success', self::MESSAGES['success'][0]);

            } catch (\Exception $exception) {
                Log::channel('article')->error('Article Register | Error', [
                    'userInputs'  => $request->all(),
                    'sysMessages' => $exception->getMessage(),
                    'created-at'  => Carbon::now(),
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
        try {
            //todo use model resource
            $article = Article::with('user')->find($id);

            Log::channel('article')->info('Article Find | Success', [
                'result'     => $article,
                'modelId'    => $id,
                'created_at' => Carbon::now(),
            ]);

            return view('components.article.show-by-id', compact('article'));

        } catch (\Exception $exception) {
            Log::channel('article')->error('Article Find | Error', [
                'systemMessage' => $exception->getMessage(),
                'modelId'       => $id,
                'created_at'    => Carbon::now(),
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $article = Article::whereNull('deleted_at')->with('user')->find($id);

            if ($this->authorize('update', $article)) {
                Log::channel('article')->info('Article Find | Success', [
                    'result'     => $article,
                    'modelId'    => $id,
                    'created_at' => Carbon::now(),
                ]);

                return view('components.article.edit', compact('article'));
            }

        } catch (\Exception $exception) {
            Log::channel('article')->error('Article Find | Error', [
                'systemMessage' => $exception->getMessage(),
                'article'       => $article,
                'user'          => Auth::user(),
                'created_at'    => Carbon::now(),
            ]);

            return redirect()->back()->withErrors(self::MESSAGES['error'][2]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ArticleRequest $request, string $id)
    {
        $updateData = [
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'publish_status' => isset($request->publish),
        ];

        try {
            $article = Article::findOrFail($id);
            $article->update($updateData);

            Log::channel('article')->info('Article Update | Success', [
                'articleId'  => $id,
                'article'    => $article,
                'created_at' => Carbon::now(),
            ]);

            return redirect()->back()->with('success', self::MESSAGES['success'][3]);

        } catch (\Exception $exception) {
            Log::channel('article')->error('Article Update | Error', [
                'systemMessage' => $exception->getMessage(),
                'articleId'     => $id,
                'created_at'    => Carbon::now(),
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


    public function approveArticle(Request $request)
    {
        try {
            $article = Article::where('id', $request->input('article'))->whereNull('deleted_at')->firstOrfail();

            if ($this->authorize('approve', $article)) {
                $article->approve_status = !((bool)$article->approve_status);
                $article->save();

                Log::channel('article')->info('Article Approve | Success', [
                    'article'    => $article,
                    'created_at' => Carbon::now(),
                ]);

                return redirect()->back()->with('success', self::MESSAGES['success'][1]);
            }

        } catch (\Exception $exception) {
            Log::channel('article')->error('Article Approve | Error', [
                'systemMessage' => $exception->getMessage(),
                'articleId'     => $request->input('article'),
                'created_at'    => Carbon::now(),
            ]);

            return redirect()->route('admin.dashboard')->withErrors(self::MESSAGES['error'][4]);
        }
    }

    public function deleteArticle(string $id)
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
                    'created_at'    => Carbon::now(),
                ]);

                return redirect()->back()->withErrors(self::MESSAGES['error'][3]);
            }
        }

        Log::channel('article')->alert('Article Delete | Alert', [
            'articleId'     => $id,
            'systemMessage' => self::MESSAGES['error'][4],
            'user'          => Auth::user(),
            'created_at'    => Carbon::now(),
        ]);

        return redirect()->back()->withErrors(self::MESSAGES['error'][4]);
    }

    public function restoreArticle(string $id): RedirectResponse
    {
        if (Auth::guard('admin')->check()) {
            try {
                $article = Article::withTrashed($id);
                $article->restore();

                return redirect()->back()->with('success', self::MESSAGES['success'][4]);

            } catch (\Exception $exception) {
                Log::channel('article')->error('Article Restore | Success', [
                    'articleId'     => $id,
                    'systemMessage' => $exception->getMessage(),
                    'created_at'    => Carbon::now(),
                ]);

                return redirect()->back()->withErrors(self::MESSAGES['error'][6]);
            }
        }

        Log::channel('article')->alert('Article Restore | Alert', [
            'articleId'     => $id,
            'systemMessage' => self::MESSAGES['error'][4],
            'user'          => Auth::user(),
            'created_at'    => Carbon::now(),
        ]);

        return redirect()->back()->withErrors(self::MESSAGES['error'][4]);
    }
}
