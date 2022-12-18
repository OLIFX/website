// Script that will show or hide the dropdown menu;
document.querySelector('.dropdown').click();

const userImageButton = document.querySelector(".user-area>img");
const dropdown = document.querySelector(".dropdown");

userImageButton.addEventListener("click", (evt) => {
    if (dropdown.style.display === "none") {
        dropdown.style.display = "flex";
    } else {
        dropdown.style.display = "none";
    }
});
