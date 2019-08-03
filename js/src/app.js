import ScrollReveal from 'scrollreveal';

// SLideUp - Realisations 
var slideUp = {
    distance: '150%',
    origin: 'bottom',
    opacity: null
};

ScrollReveal().reveal('.realisation', slideUp);

// Left Right - A propos

var left = {
    distance: '150%',
    origin: 'left',
    opacity: null,
    delay: 375
};

ScrollReveal().reveal('#about_image', left);

var right = {
    distance: '150%',
    origin: 'right',
    opacity: null,
    delay: 375
};

ScrollReveal().reveal('#about_text', right);