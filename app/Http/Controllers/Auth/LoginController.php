<?php

namespace App\Http\Controllers\Auth;

use Auth;
use Socialite;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * Куда будет перенаправлен пользователь после авторизации.
     *
     * @var string
     */
    protected $redirectTo = '/search';

    /**
     * Переадресация пользователя на страницу аутентификации GitHub.
     *
     * @return Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('github')->redirect();
    }

    /**
     * Получение информации о пользователе от GitHub.
     *
     * @return Response
     */
    public function handleProviderCallback()
    {
        // получим пользователя
        $user = Socialite::driver('github')->user();

        // найдем в базе, если нет, то создадим нового
        $authUser = $this->findOrCreateUser($user);

        // авторизируе мпользователя
        Auth::login($authUser, true);

        // идем на страницу поиска
        return redirect($this->redirectTo);

        // $user->token;
    }

    /**
     * Возвращает форму входа
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth/login');
    }

    /**
     * Если пользователь зарегистрирован, то возвращаем существующего пользователя,
     * иначе создаем нового
     * @param  $user объект пользователя типа Socialite
     * @return  User
     */
    public function findOrCreateUser($user)
    {
        $authUser = User::where('email', $user->email)->first();
        if ($authUser) {
            return $authUser;
        }
        return User::create([
            'name' => $user->getName() ? $user->getName() : $user->getNickname(),
            'email' => $user->getEmail(),
            'token' => $user->token
        ]);
    }
}
