let logo = document.querySelector('.nav_menu_logo')
let catalog = document.querySelector('.nav_menu_catalog')
let navMenu = document.querySelector('.nav_menu')
window.addEventListener("scroll", () => {
    const topOffset = navMenu.getBoundingClientRect().top;
    if (topOffset == -1) {
        logo.classList.remove("none");
        catalog.style.margin = '0 187.5px 0 0'
    } else {
        logo.classList.add("none");
        catalog.style.margin = '0 272.5px 0 0'
    }
})

let slides = document.querySelectorAll('.slide_stocks')
let left = document.querySelector('.main_slider_stocks_button_left')
let right = document.querySelector('.main_slider_stocks_button_right')
let counter = 0;
let count = slides.length
console.log(count)
right.addEventListener('click', function () {
    counter+=100
    if(counter==count*100){
        counter = 0
        slides.forEach(slide => {
            slide.style.transform = "translateX(-"+counter+"%)"
        })
    }
    else{
        slides.forEach(slide => {
            slide.style.transform = "translateX(-"+counter+"%)"
        })
    }
    
})
left.addEventListener('click', function () {
    counter-=100
    if(counter<0){
        counter = (count-1)*100
        slides.forEach(slide => {
            slide.style.transform = "translateX(-"+counter+"%)"
        })
    }
    else{
        slides.forEach(slide => {
            slide.style.transform = "translateX(-"+counter+"%)"
        })
    }       
})