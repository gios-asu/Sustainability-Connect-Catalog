<?php

namespace SCCatalog\Http\Controllers\Frontend\Auth;

use Illuminate\Foundation\Auth\RegistersUsers;
use SCCatalog\Events\Frontend\Auth\UserRegistered;
use SCCatalog\Helpers\Frontend\Auth\Socialite;
use SCCatalog\Http\Controllers\Controller;
use SCCatalog\Http\Requests\Frontend\Auth\RegisterRequest;
use SCCatalog\Repositories\Auth\Frontend\UserRepository;

/**
 * Class RegisterController.
 */
class RegisterController extends Controller
{
    use RegistersUsers;

    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * RegisterController constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Where to redirect users after login.
     *
     * @return string
     */
    public function redirectPath()
    {
        return route(home_route());
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        abort_unless(config('access.registration'), 404);

        return view('frontend.auth.register')
            ->withSocialiteLinks((new Socialite)->getSocialLinks());
    }

    /**
     * @param RegisterRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Throwable
     */
    public function register(RegisterRequest $request)
    {
        $user = $this->userRepository->create($request->only('first_name', 'last_name', 'email', 'password'));

        // If the user must confirm their email or their account requires approval,
        // create the account but don't log them in.
        if (config('access.users.confirm_email') || config('access.users.requires_approval')) {
            event(new UserRegistered($user));

            return redirect($this->redirectPath())->withFlashSuccess(
                config('access.users.requires_approval') ?
                    __('exceptions.frontend.auth.confirmation.created_pending') : __('exceptions.frontend.auth.confirmation.created_confirm')
            );
        }
        auth()->login($user);

        event(new UserRegistered($user));

        return redirect($this->redirectPath());
    }
}
