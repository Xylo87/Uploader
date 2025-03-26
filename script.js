// console.log("Hello")


const linkBtns = document.querySelectorAll(".linkBtn")

linkBtns.forEach(linkBtn => {
    const parent = linkBtn.closest('.imgSet')
    
    const image = parent.querySelector('img')
    
    const link = parent.querySelector('a')
    const realLink = (link.getAttribute('href')).slice(1)
    
    linkBtn.addEventListener("click", () => {

        linkBtns.forEach(resetBtn => {
            resetBtn.textContent = "Copier le lien"
        });

        if (
            realLink.endsWith("pdf") ||
            realLink.endsWith("txt") ||
            realLink.endsWith("docx") ||
            realLink.endsWith("doc") ||
            realLink.endsWith("odt")
        ) {
            navigator.clipboard.writeText('http://localhost/Uploader' + realLink)

            // >>> Ligne à adapter en production <<<
            // navigator.clipboard.writeText('https://image-uploader.tiz.fr' + realLink)

        } else {
            navigator.clipboard.writeText(image.src)
        }
        
        linkBtn.textContent = "Copié !"
    })
})


