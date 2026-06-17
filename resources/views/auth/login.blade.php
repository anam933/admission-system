<x-guest-layout>
    <div class="card auth-card">
        <div class="card-body">
            <div class="text-center mb-4">
                <div class="auth-badge">
                    <i class="fas fa-user-shield"></i>
                </div>
                <h2 class="auth-heading">Welcome Back</h2>
                <p class="auth-lead">
                    Sign in to continue to {{ config('app.name', 'RBAC Management System') }}.
                </p>
            </div>

            @if (session('status'))
                <div class="auth-session mb-4" role="alert">
                    <i class="fas fa-circle-check"></i>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group mb-3">
                    <label for="email" class="auth-label">Email Address</label>
                    <div class="input-group auth-input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-envelope"></i>
                            </span>
                        </div>

                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            class="form-control @error('email') is-invalid @enderror"
                            placeholder="name@company.com"
                            required
                            autofocus
                            autocomplete="username"
                        >
                    </div>

                    @error('email')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="password" class="auth-label">Password</label>
                    <div class="input-group auth-input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-lock"></i>
                            </span>
                        </div>

                        <input
                            id="password"
                            type="password"
                            name="password"
                            class="form-control @error('password') is-invalid @enderror"
                            placeholder="Enter your password"
                            required
                            autocomplete="current-password"
                        >
                    </div>

                    @error('password')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
                    <div class="custom-control custom-checkbox">
                        <input
                            type="checkbox"
                            class="custom-control-input"
                            id="remember"
                            name="remember"
                            @checked(old('remember'))
                        >

                        <label class="custom-control-label auth-checkbox" for="remember">
                            Remember Me
                        </label>
                    </div>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="auth-link mt-2 mt-sm-0">
                            Forgot Password?
                        </a>
                    @endif
                </div>

                @if (Route::has('register'))
                    <div class="text-center mb-4">
                        <span class="text-muted">No account yet?</span>
                        <a href="{{ route('register') }}" class="auth-link ml-1">
                            Create an account
                        </a>
                    </div>
                @endif

                <button type="submit" class="btn btn-primary btn-block auth-submit">
                    <i class="fas fa-right-to-bracket mr-2"></i>
                    Sign In
                </button>
            </form>

            <div class="auth-footer">
                <i class="fas fa-lock mr-1"></i>
                Secure login for administrators, managers, and institute staff.
            </div>
        </div>
    </div>
</x-guest-layout>
