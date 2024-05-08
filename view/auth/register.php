<?php
include __DIR__ . "/../components/head.php";

$errors = $_SESSION['validationErrors'] ?? null;
$formData = $_SESSION['registrationFormData'] ?? [];

unset($_SESSION["validationErrors"]);
?>

<main>
    <form method="POST" action="/workout-logger/register/submit">
        <div>
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="<?= $formData['email'] ?? ''; ?>">
        </div>
        <?php if (isset($errors['email'])) : ?>
            <?php foreach ($errors['email'] as $error) : ?>
                <p><?= $error ?></p>
            <?php endforeach; ?>
        <?php endif; ?>
         <div>
            <label for="username">Username</label>
            <input type="text" name="username" id="username" value="<?= $formData['username'] ?? ''; ?>">
        </div>
        <?php if (isset($errors['username'])) : ?>
            <?php foreach ($errors['username'] as $error) : ?>
                <p><?= $error ?></p>
            <?php endforeach; ?>
        <?php endif; ?>
        <div>
            <label for="password">Password</label>
            <input type="password" name="password" id="password">
        </div>
        <?php if (isset($errors['password'])) : ?>
            <?php foreach ($errors['password'] as $error) : ?>
                <p><?= $error ?></p>
            <?php endforeach; ?>
        <?php endif; ?>
        <div>
            <label for="confirm_password">Confirm Password</label>
            <input type="password" name="confirm_password" id="confirm_password">
        </div>
        <?php if (isset($errors['confirm_password'])) : ?>
            <?php foreach ($errors['confirm_password'] as $error) : ?>
                <p><?= $error ?></p>
            <?php endforeach; ?>
        <?php endif; ?>
        <button type="submit">Submit</button>
    </form>
</main>
