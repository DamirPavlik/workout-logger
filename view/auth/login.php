<?php
include __DIR__ . "/../components/head.php";

$errors = $_SESSION['validationErrors'] ?? null;
$formData = $_SESSION['loginFormData'] ?? [];

var_dump($errors);
unset($_SESSION["validationErrors"]);
?>

<main>
    <form method="POST" action="/workout-logger/login/submit">
        <div>
            <label for="email">Email</label>
            <input type="email" name="email" id="email">
        </div>
        <div>
            <label for="password">Password</label>
            <input type="password" name="password" id="password">
        </div>
        <button type="submit">Submit</button>
    </form>
</main>
