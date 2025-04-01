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


// Drag & Drop
const dropZone = document.getElementById('dropZone')
const dropImage = document.getElementById('dropImg')
const dropText = document.getElementById('dropText')

dropZone.addEventListener('dragover', (e) => {
    e.preventDefault()
    e.stopPropagation()

    e.dataTransfer.dropEffect = 'copy'

    dropZone.style.width = '55%'
    dropImage.style.width = '96px'
    dropText.style.fontSize = '110%'
})

dropZone.addEventListener('dragleave', (e) => {
    e.preventDefault()
    e.stopPropagation()

    dropZone.style.width = '50%'
    dropImage.style.width = '80px'
    dropText.style.fontSize = '100%'
})

dropZone.addEventListener('drop', (e) => {
    e.preventDefault()
    e.stopPropagation()

    const files = e.dataTransfer.files
    console.log(files)
})