const menu= document.querySelector("#barral");
const hamburguer= document.querySelector("#hamburguer");

const slider = document.getElementById("mySlider");
const sliderValue = document.getElementById("sliderValue");

hamburguer.addEventListener('click',()=>{
    if(menu.style.display=='none') {
        menu.style.display= 'flex';
    }else{
        menu.style.display='none'
    }
})

// sliderValue.innerHTML = slider.value;

// slider.addEventListener("input", () => {
//     sliderValue.innerHTML = slider.value;
// });