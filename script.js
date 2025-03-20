// console.log("Hello")


const linkBtns = document.querySelectorAll(".linkBtn")

linkBtns.forEach(linkBtn => {
    const parent = linkBtn.closest('.imgSet')
    const image = parent.querySelector('img')
    
    linkBtn.addEventListener("click", () => {

        linkBtns.forEach(resetBtn => {
            resetBtn.textContent = "Copier le lien"
        });
        
        navigator.clipboard.writeText(image.src)
        
        linkBtn.textContent = "Copié !"
    })
})


