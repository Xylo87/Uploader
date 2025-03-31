// console.log("Hello")

const linkBtns = document.querySelectorAll(".linkBtn")

linkBtns.forEach(linkBtn => {

    // Images link copy elements
    const parent = linkBtn.closest('.imgSet')
    const image = parent.querySelector('img')
    
    // Files link copy elements
    const link = parent.querySelector('a')
    const realLink = (link.getAttribute('href')).slice(1)
    
    linkBtn.addEventListener("click", () => {

        // Reset text when other button clicked
        linkBtns.forEach(resetBtn => {
            resetBtn.textContent = "Copier le lien"
        });

        // File link copy
        if (
            realLink.endsWith("pdf") ||
            realLink.endsWith("txt") ||
            realLink.endsWith("docx") ||
            realLink.endsWith("doc") ||
            realLink.endsWith("odt") ||
            realLink.endsWith("xls") ||
            realLink.endsWith("xlsx")
        ) {
            navigator.clipboard.writeText('http://localhost/Uploader' + realLink)

            // >>> Ligne à adapter en production <<<
            // navigator.clipboard.writeText('https://image-uploader.tiz.fr' + realLink)

        // Image link copy
        } else {
            navigator.clipboard.writeText(image.src)
        }
        
        linkBtn.textContent = "Copié !"
    })
})


