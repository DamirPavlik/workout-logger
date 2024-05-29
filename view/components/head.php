<?php

use app\Support\Session;

$session = new Session();
$isUserLoggedIn = $session::isUserLoggedIn();

$addWorkoutUrl = '/workout-logger/workout';
$currentUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$parts = parse_url($currentUrl);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Workout Logger</title>
    <link rel="stylesheet" href="/workout-logger/public/assets/styles/main.css?v=420692">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>

<?php if ($isUserLoggedIn) : ?>
<nav>
    <header class="d-flex justify-content-between align-items-center py-4 px-5">
        <h5 class="fw-light title"><a href="/workout-logger" class="c-white">Workout<span class="fw-semibold">Logger</a></span></h5>
        <div class="d-flex align-items-center">
            <?php if (!str_ends_with($parts['path'], '/workout')) : ?>
            <a href="/workout-logger/workout" class="btn me-4">Add a workout</a>
            <?php endif; ?>
            <form method="POST" action="/workout-logger/logout">
                <button class="btn">Logout</button>
            </form>
        </div>
    </header>
</nav>
<?php endif; ?>