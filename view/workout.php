<?php include 'components/head.php' ?>


<div class="mt-5">
    <h3 class="text-center mb-3">Add a Workout Plan</h3>
    <main class="container-small">
        <form method="POST" action="/workout-logger/workout-plan/submit">
            <div>
                <label for="title" class="d-block mb-1">Title</label>
                <input type="text" name="title" id="title" class="styledInput">
            </div>
            <div>
                <label for="description" class="d-block mb-1">Description</label>
                <textarea name="description" id="description" cols="30" rows="10" class="styledInput noResize"></textarea>
            </div>
            <button type="submit" class="btn">Submit</button>
        </form>
    </main>
</div>

<?php include 'components/footer.php' ?>
