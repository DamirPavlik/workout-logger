// Edit Workout Day Title
let editWorkoutDayButton = document.querySelectorAll(".editWorkoutDayTitle");
let editExerciseButton = document.querySelectorAll(".editExercise");
function edit(editButton, titleSelector) {
    editButton.forEach((button) => {
        button.addEventListener("click", e => {
            e.preventDefault();
            let parentEl1 = button.parentElement;
            let parentEl = parentEl1.parentElement;
            let title = parentEl.querySelector(titleSelector);
            let form = parentEl.querySelector("form");
            let input = form.querySelector("input");
            input.value = title.textContent;
            title.classList.add("d-none");
            form.classList.remove("d-none")
            console.log(title)
        })
    })
}

edit(editWorkoutDayButton, ".workoutDayTitle")
edit(editExerciseButton, ".exerciseTitle")

// Dialog
let dialogButtons = document.querySelectorAll('.showDialog');

dialogButtons.forEach(button => {
    let workoutCard = button.parentElement;
    let dialog = workoutCard.querySelector("dialog");
    let closeButton = dialog.querySelector(".closeButton");
    button.addEventListener("click", e => {
        dialog.showModal();
    })

    closeButton.addEventListener("click", e => {
        dialog.close();
    })
})

// Remove workout day confirm
function confirmSubmit(message) {
    return confirm(message);
}

// Date picker default value to current date
const currentUrl = window.location.href
const url = new URL(currentUrl);
const workoutDayCards = document.querySelectorAll(".workoutDayWrapper .workoutCard");

if (url.pathname.endsWith("/workout-day") && workoutDayCards.length !== 0) {
    document.querySelector("#date").valueAsDate = new Date()
}