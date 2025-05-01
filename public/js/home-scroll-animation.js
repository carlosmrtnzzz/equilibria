document.addEventListener('DOMContentLoaded', function() {
    gsap.set(".mask h2", {
        scale: 300
    });

    gsap.to(".mask h2", {
        scale: 1,
        scrollTrigger: {
            trigger: ".scroll-container",
            scrub: 1,
            pin: true,
            start: "top top",
            end: "+=1000",
            ease: "none"
        },
    });
});