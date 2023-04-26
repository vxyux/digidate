const container = document.querySelector(".s-container");
const linkItems = document.querySelectorAll(".link-item");
const darkMode = document.querySelector(".dark-mode");
const image = document.getElementById("profile-img");
// const logo = document.querySelector(".logo svg");

//Container Hover
container.addEventListener("mouseenter", () => {
    container.classList.add("active");
    image.style.display="block";
});

//Container Hover Leave
container.addEventListener("mouseleave", () => {
    container.classList.remove("active");
    image.style.display="none";
});

//Link-items Clicked
for (let i = 0; i < linkItems.length; i++) {
    if (!linkItems[i].classList.contains("dark-mode")) {
        linkItems[i].addEventListener("click", (e) => {
            linkItems.forEach((linkItem) => {
                linkItem.classList.remove("active");
            });
            linkItems[i].classList.add("active");
        });
    }
}

// Dark Mode Functionality
darkMode.addEventListener("click", function () {
    if (document.body.classList.contains("dark-mode")) {
        darkMode.querySelector("span").textContent = "Dark mode";
        darkMode.querySelector("ion-icon").setAttribute("name", "moon-outline");
        localStorage.setItem("mode", "dark");

        // logo.style.fill = "#363b46";
    } else {
        darkMode.querySelector("span").textContent = "light mode";
        darkMode.querySelector("ion-icon").setAttribute("name", "sunny-outline");
        localStorage.setItem("mode", "light");
        // logo.style.fill = "#eee";
    }
    document.body.classList.toggle("dark-mode");
});
