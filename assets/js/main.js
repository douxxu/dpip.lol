/*=============== SHOW MENU ===============*/
const navMenu = document.getElementById('nav-menu'),
      navToggle = document.getElementById('nav-toggle'),
      navClose = document.getElementById('nav-close')

/*===== MENU SHOW =====*/
/* Validate if constant exists */
if(navToggle){
    navToggle.addEventListener('click', () =>{
        navMenu.classList.add('show-menu')
    })
}

/*===== MENU HIDDEN =====*/
/* Validate if constant exists */
if(navClose){
    navClose.addEventListener('click', () =>{
        navMenu.classList.remove('show-menu')
    })
}

/*=============== REMOVE MENU MOBILE ===============*/
const navLink = document.querySelectorAll('.nav__link')

function linkAction(){
    const navMenu = document.getElementById('nav-menu')
    // When we click on each nav__link, we remove the show-menu class
    navMenu.classList.remove('show-menu')
}
navLink.forEach(n => n.addEventListener('click', linkAction))

/*=============== CHANGE BACKGROUND HEADER ===============*/
function scrollHeader(){
    const header = document.getElementById('header')
    // When the scroll is greater than 50 viewport height, add the scroll-header class to the header tag
    if(this.scrollY >= 50) header.classList.add('scroll-header'); else header.classList.remove('scroll-header')
}
window.addEventListener('scroll', scrollHeader)

/*=============== SHOW SCROLL UP ===============*/ 
function scrollUp(){
    const scrollUp = document.getElementById('scroll-up');
    // When the scroll is higher than 200 viewport height, add the show-scroll class to the a tag with the scroll-top class
    if(this.scrollY >= 200) scrollUp.classList.add('show-scroll'); else scrollUp.classList.remove('show-scroll')
}
window.addEventListener('scroll', scrollUp)

/*=============== SCROLL SECTIONS ACTIVE LINK ===============*/
const sections = document.querySelectorAll('section[id]')

function scrollActive(){
    const scrollY = window.pageYOffset

    sections.forEach(current =>{
        const sectionHeight = current.offsetHeight
        const sectionTop = current.offsetTop - 50;
        sectionId = current.getAttribute('id')

        if(scrollY > sectionTop && scrollY <= sectionTop + sectionHeight){
            document.querySelector('.nav__menu a[href*=' + sectionId + ']').classList.add('active-link')
        }else{
            document.querySelector('.nav__menu a[href*=' + sectionId + ']').classList.remove('active-link')
        }
    })
}
window.addEventListener('scroll', scrollActive)

/*=============== SCROLL REVEAL ANIMATION ===============*/
const sr = ScrollReveal({
    distance: '60px',
    duration: 2500,
    delay: 400,
    // reset: true
})

sr.reveal(`.home__header, .section__title`,{delay: 600})
sr.reveal(`.home__footer`,{delay: 700})
sr.reveal(`.home__img`,{delay: 900, origin: 'top'})

sr.reveal(`.sponsor__img, .products__card, .footer__logo, .footer__content, .footer__copy`,{origin: 'top', interval: 100})
sr.reveal(`.specs__data, .discount__animate`,{origin: 'left', interval: 100})
sr.reveal(`.specs__img, .discount__img`,{origin: 'right'})
sr.reveal(`.case__img`,{origin: 'top'})
sr.reveal(`.case__data`)


/*=============== SUBSCRIBE BUTTON ===============*/
document.getElementById('subscribeForm').addEventListener('submit', function(event) {
    event.preventDefault();

    const emailInput = document.querySelector('.footer__input');
    const email = emailInput.value.trim();
    if (email) {
        window.location.href = `https://dpip.lol/subscribe?email=${encodeURIComponent(email)}`;
    } else {
        alert('Veuillez entrer un email valide.');
    }
});

/*=============== HOST INFOS ===============*/
document.addEventListener("DOMContentLoaded", () => {
    const apiUrl = "https://proxy.douxx.tech?url=status.dpip.lol/api/getinfos"; //using a proxy to avoid those goofy ahhh cors errors

    const formatMemory = (bytes) => (bytes / (1024 * 1024)).toFixed(2);
    const roundToTwoDecimals = (value) => Math.round(value * 100) / 100;

    fetch(apiUrl)
        .then(response => {
            if (!response.ok) {
                console.log("Error while getting host data.");
            }
            return response.json();
        })
        .then(data => {
            const cpuUsage = roundToTwoDecimals(data.cpu_usage);
            const cpuElement = document.querySelector(".specs__data:nth-child(1) .specs__subtitle");
            cpuElement.textContent += ` (${cpuUsage}%)`;

            const { total, used } = data.memory;
            const ramElement = document.querySelector(".specs__data:nth-child(2) .specs__subtitle");
            ramElement.textContent = `${formatMemory(used)}MB / ${formatMemory(total)}MB DDR4`;
        })
        .catch(error => {
            console.error("Error while getting host data:", error);
        });
});
