let logo = document.querySelector('.nav_menu_logo')
let catalog = document.querySelector('.nav_menu_catalog')
let navMenu = document.querySelector('.nav_menu')
window.addEventListener("scroll", () => {
    const topOffset = navMenu.getBoundingClientRect().top;
    if (topOffset == 0) {
        logo.classList.remove("none");
        catalog.style.margin = '0 187.5px 0 0'
    } else {
        logo.classList.add("none");
        catalog.style.margin = '0 272.5px 0 0'
    }
})