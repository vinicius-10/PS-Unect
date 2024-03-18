document.addEventListener("DOMContentLoaded", function() {
    const links = document.querySelectorAll("a");

    links.forEach(link => {
        link.addEventListener("click", function(event) {
            event.preventDefault();
            const targetId = this.getAttribute("href").substring(1);
            const targetSection = document.getElementById(targetId);
            if (targetSection) {
                window.scrollTo({
                    top: targetSection.offsetTop,
                    behavior: "smooth"
                });
            }
        });
    });
});


const imgs = document.getElementById("corpo_carosel");
        let idx = 0;
        function carrossel() {
            idx++;
            if(idx > 5 - parseInt(imgs.clientWidth/500)){
                idx=0;
            }
            imgs.style.transform = `translateX(${-idx * (300)}px)`;
    
        }

        setInterval(carrossel, 2000);