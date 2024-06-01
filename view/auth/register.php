<?php
include __DIR__ . "/../components/head.php";

$errors = $_SESSION['registerErrors'] ?? null;
$formData = $_SESSION['registrationFormData'] ?? [];

unset($_SESSION["registerErrors"]);
?>

<main class="authContainer">
    <div class="authBox">
        <div>
            <h3 class="text-center fw-bold">Register</h3>
            <form method="POST" action="/workout-logger/register/submit">
                <div>
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" value="<?= $formData['email'] ?? ''; ?>" placeholder="Email">
                </div>
                    <?php if (isset($errors['email'])) : ?>
                        <p><?= $errors['email'] ?></p>
                    <?php endif; ?>
                 <div>
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" value="<?= $formData['username'] ?? ''; ?>" placeholder="Username">
                </div>
                    <?php if (isset($errors['username'])) : ?>
                        <p><?= $errors['username'] ?></p>
                    <?php endif; ?>
                <div>
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" placeholder="Password">
                </div>
                    <?php if (isset($errors['password'])) : ?>
                        <p><?= $errors['password'] ?></p>
                    <?php endif; ?>
                <div>
                    <label for="confirm_password">Confirm Password</label>
                    <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password">
                </div>
                    <?php if (isset($errors['confirm_password'])) : ?>
                        <p><?= $errors['confirm_password'] ?></p>
                    <?php endif; ?>
                <button type="submit" class="mt-2 btn">Submit</button>
            </form>
            <p class="text-center mt-4">Already have an account? <a href="/workout-logger/login" class="link">Login.</a></p>
        </div>
    </div>
</main>

<?php include __DIR__ . "/../components/footer.php"; ?>