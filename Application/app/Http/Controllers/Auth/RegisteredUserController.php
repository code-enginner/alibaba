<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Illuminate\View\View;

class RegisteredUserController extends Controller
{

    private const MESSAGES = [
        'success' => [
            'ثبت نام شما انجام شد، لطفا وارد شوید'
        ],

        'error' => []
    ];
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(RegisterRequest $request): RedirectResponse
    {
        try {
            $user = User::create([
                'full_name'      => $request->full_name,
                'email'          => $request->email,
                'password'       => Hash::make($request->password),
            ]);

            event(new Registered($user));

//            Auth::login($user);

            Log::channel('auth')->info('Register User | Success', [
                'userInputs' => $request->except('_token'),
                'created_at' => Carbon::now()
            ]);

            return redirect(RouteServiceProvider::LOGIN)->with('success', self::MESSAGES['success'][0]);

        } catch (\Exception $exception) {
            Log::channel('auth')->error('Register User | Error', [
                'userInputs' => $request->except('_token'),
                'sysMessage' => $exception->getMessage(),
                'created_at' => Carbon::now()
            ]);

            return redirect(RouteServiceProvider::REGISTER);
        }
    }
}
