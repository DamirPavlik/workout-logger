// Edit Workout Day Title
let editButton = document.querySelectorAll(".editWorkoutDayTitle");
editButton.forEach((button) => {
    button.addEventListener("click", e => {
        e.preventDefault();
        let parentEl1 = button.parentElement;
        let parentEl = parentEl1.parentElement;
        let title = parentEl.querySelector(".workoutDayTitle");
        let form = parentEl.querySelector("form");
        let input = form.querySelector("input");
        input.value = title.textContent;
        title.classList.add("d-none");
        form.classList.remove("d-none")
        console.log(title)
    })
})

// Dialog
let dialogButton = document.querySelector('.showDialog');
let dialog = document.querySelector('.logDialog');
let dialogCloseButton = document.querySelector('.logDialog .closeButton');

dialogButton.addEventListener('click', e => {
    dialog.showModal();
});

dialogCloseButton.addEventListener('click', e => {
    dialog.close();
});

// Date picker default
document.querySelector("#date").valueAsDate = new Date()