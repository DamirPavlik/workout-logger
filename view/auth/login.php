<?php
include __DIR__ . "/../components/head.php";

$errors = $_SESSION['validationErrors'] ?? null;
$formData = $_SESSION['loginFormData'] ?? [];

unset($_SESSION["validationErrors"]);
?>

<main class="authContainer">
    <div class="authBox">
        <h3 class="text-center fw-bold">Login</h3>
        <div>
            <form method="POST" action="/workout-logger/login/submit">
                <div>
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" placeholder="Email">
                </div>
                    <?php if (isset($errors['email'])) : ?>
                        <p><?= $errors['email'] ?></p>
                    <?php endif; ?>
                <div>
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" placeholder="Password">
                </div>
                    <?php if (isset($errors['password'])) : ?>
                        <p><?= $errors['password'] ?></p>
                    <?php endif; ?>
                <button type="submit" class="mt-2 btn">Submit</button>
            </form>
            <p class="text-center mt-4">Don't have an account? <a href="/workout-logger/register" class="link">Register.</a></p>
        </div>
    </div>
</main>

<?php include __DIR__ . "/../components/footer.php"; ?>