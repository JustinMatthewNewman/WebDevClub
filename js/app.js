const navSlide = () => {
    const icon = document.querySelector('.icon');
    const nav = document.querySelector('.nav-links');
    const navLinks = document.querySelectorAll('.nav-links li')
    icon.addEventListener('click', () => {
        nav.classList.toggle('nav-active');
            /// Animate slide out word links
        navLinks.forEach((link, index) => {
            if (link.style.animation) {
                link.style.animation = '';
            } else {
                link.style.animation = `navLinkFade 0.5s ease forwards ${index / 7 + 0.7}s`;
            }
            
        });
        icon.classList.toggle('toggle');
    });
    

}

navSlide();