// script
const btnDelete = document.getElementById("delete");
const divConfirmDelete = document.querySelector(".confirm-delete");
const noDelete = document.getElementById("no-delete");

btnDelete.addEventListener("click", (evt) => {
    evt.preventDefault();
    divConfirmDelete.style.display = "flex";
});

noDelete.addEventListener("click", (evt) => {
    evt.preventDefault();
    divConfirmDelete.style.display = "none";
});
