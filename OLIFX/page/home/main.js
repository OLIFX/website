// Script that will show or hide the dropdown menu;
const userImageButton = document.querySelector(".user-area");
const dropdown = document.querySelector(".dropdown");

userImageButton.addEventListener("click", (evt) => {
    if (dropdown.style.display === "none") {
        dropdown.style.display = "flex";
    } else {
        dropdown.style.display = "none";
    }
});
