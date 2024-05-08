<?php

use app\Support\Session;

include "components/head.php";

if (!Session::isUserLoggedIn()) {
    header("Location: /workout-logger/register");
}
?>

<main>
    <form method="POST" action="/workout-logger/logout">
        <button>Logout</button>
    </form>
</main>