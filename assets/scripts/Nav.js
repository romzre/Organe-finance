let btnBurger = document.querySelector('#hamburger')
let Nav = document.querySelector('.Nav')

btnBurger.addEventListener('click' , (e) => {
    if(btnBurger.className === 'open'){
        Nav.style.transition = "all .5s linear"
        Nav.style.transform = "translate(220px)"
        btnBurger.style.position = "absolute"
        btnBurger.style.left = "250px"
        btnBurger.style.top = "5px"
    }
    else
    {
        Nav.style.transform = "translate(-220px)"
        btnBurger.style.position = "relative"
        btnBurger.style.left = "0px"
        btnBurger.style.top = "0px"
    }
})