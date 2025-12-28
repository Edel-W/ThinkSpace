//Mobile Menu

document.addEventListener('DOMContentLoaded', () => {
    const hamburgerBtn = document.querySelector('.hamburger_btn');
    const mobileMenu = document.querySelector('.mobile_menu');

    hamburgerBtn.addEventListener('click', () => 
        mobileMenu.classList.toggle('active')
);
})