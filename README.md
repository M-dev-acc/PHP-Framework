# PHP MVC Framework

> [!WARNING]
> This project is a personal learning exercise built to revisit and strengthen PHP fundamentals. It is **not intended for production use**.

A lightweight MVC framework built from scratch in PHP 8.1+, without any third-party dependencies. Built to understand how core framework internals work — routing, dependency injection, middleware pipelines, templating, and validation.

---

## Tech Stack

- **PHP 8.1+** — constructor property promotion, `new` in initializers, `never` return type, named arguments
- **Composer** — PSR-4 autoloading, helper files autoloaded via `autoload.files`
- **Apache** — front controller via `.htaccess` mod_rewrite
- **No external dependencies** — `composer.json` `require` block is intentionally empty

---

## Project Structure

```
├── public/
│   ├── index.php               # Entry point
│   ├── .htaccess               # Front controller rewrite rules
│   └── assets/
│       └── main.css
└── src/
    ├── App/                    # Application layer
    │   ├── Config/
    │   │   ├── Path.php        # Centralised path constants
    │   │   ├── Routes.php      # Route definitions
    │   │   └── Middleware.php  # Middleware registration
    │   ├── Controllers/
    │   │   ├── HomeController.php
    │   │   └── AuthController.php
    │   ├── Middlewares/
    │   │   ├── TemplateDataMiddleware.php
    │   │   └── ValidationExceptionMiddleware.php
    │   ├── Services/
    │   │   └── ValidatorService.php
    │   ├── views/
    │   │   ├── index.phtml
    │   │   ├── register.phtml
    │   │   └── partials/
    │   ├── bootstrap.php
    │   └── container-definitions.php
    └── Framework/              # Framework layer
        ├── App.php
        ├── Router.php
        ├── Container.php
        ├── TemplateEngine.php
        ├── Validator.php
        ├── Contracts/
        │   ├── MiddlewareInterface.php
        │   └── RulesInterface.php
        ├── Exceptions/
        │   ├── ContainerExceptions.php
        │   └── ValidationException.php
        ├── Rules/
        │   └── RequiredRule.php
        └── helpers/
            ├── debugging.php   # dd()
            ├── http.php        # redirect()
            └── template_engine.php  # e()
```

---

## Key Technical Implementations

### Dependency Injection Container
Built from scratch using PHP Reflection API. Automatically resolves constructor dependencies by inspecting type hints, with singleton caching so each class is instantiated only once per request.

```php
// Container resolves AuthController and its dependencies automatically
$controller = $container->resolve(AuthController::class);
```

- `Container::resolve()` — autowires dependencies via `ReflectionClass`
- `Container::get()` — returns cached instance or builds from factory definition
- Factory definitions registered in `container-definitions.php` as closures

### Router
Regex-based router supporting GET and POST methods. Normalises paths to a consistent `/path/` format before matching.

```php
$app->get('/', [HomeController::class, 'home']);
$app->post('/register', [AuthController::class, 'register']);
```

- Path normalisation via `normalizePath()` handles trailing/leading slash inconsistencies
- Returns `http_response_code(404)` when no route matches
- Passes the DI container into dispatch for controller resolution

### Middleware Pipeline
Middlewares are registered globally and executed as a nested closure chain — wrap first, call once. `array_reverse()` preserves registration order during execution.

```
Request → ValidationExceptionMiddleware → TemplateDataMiddleware → Controller
```

- Middlewares implement `MiddlewareInterface` with a `process(callable $next)` contract
- `TemplateDataMiddleware` — injects shared template globals before render
- `ValidationExceptionMiddleware` — catches `ValidationException` and redirects

### Template Engine
PHP native templating using output buffering. Supports per-render data and global variables shared across all views via `addGlobal()`.

- `render()` uses `ob_start()` / `ob_get_contents()` / `ob_end_clean()`
- `extract()` with `EXTR_SKIP` prevents global data from overwriting local data
- `e()` helper wraps `htmlspecialchars()` for XSS-safe output in views

### Validation
Rule-based validator with a pluggable rule system. Rules implement `RulesInterface` and are registered by alias.

```php
$this->validator->add('required', new RequiredRule());
$this->validator->validate($formData, ['email' => ['required']]);
```

- Collects all field errors before throwing `ValidationException` (fail-all, not fail-fast)
- `ValidationException` extends `RuntimeException` with HTTP 422 status code
- `ValidatorService` encapsulates form-specific rule configuration

### Architectural Separation
The codebase is split into two distinct namespaces: `Framework\` (reusable framework internals) and `App\` (application-specific code). Framework classes have no knowledge of application classes.

---

## Current Status

| Feature | Status |
|---|---|
| Front controller routing | ✅ Implemented |
| GET / POST method support | ✅ Implemented |
| DI container with autowiring | ✅ Implemented |
| Singleton instance caching | ✅ Implemented |
| Middleware pipeline | ✅ Implemented |
| PHP native template engine | ✅ Implemented |
| Global template variables | ✅ Implemented |
| Rule-based form validation | ✅ Implemented |
| 404 handling | ✅ Implemented |
| XSS output escaping | ✅ Implemented |
| Database layer | ❌ Not yet implemented |
| Session management | ❌ Not yet implemented |
| Authentication | ❌ Not yet implemented |
| Error page views | ❌ Not yet implemented |

---

## Setup

**Requirements:** PHP 8.1+, Composer, Apache with `mod_rewrite`

```bash
git clone <repo-url>
cd basic-framework
composer install
```

Point your web server document root to the `public/` directory. On Laragon or XAMPP this works out of the box with the included `.htaccess`.
