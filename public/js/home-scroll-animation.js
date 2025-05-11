gsap.registerPlugin(ScrollTrigger);

gsap.to(".mask h2", {
    scale: 300,
    scrollTrigger: {
        trigger: ".scroll-container",
        scrub: 1,
        pin: true,
        start: "top top",
        end: "+=1000",
        ease: "none"
    },
});
