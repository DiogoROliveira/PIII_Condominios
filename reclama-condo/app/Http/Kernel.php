protected $middlewareAliases = [
'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
'can' => \Illuminate\Auth\Middleware\Authorize::class,
'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
'admin' => \App\Http\Middleware\Admin::class,
'localization' => \App\Http\Middleware\Localization::class

];