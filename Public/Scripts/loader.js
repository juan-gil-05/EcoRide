const loader = document.getElementById("loader")

function loaderPage() {
    window.addEventListener("load", () => {
        loader.classList.add("loader--hidden")

        loader.addEventListener("transitionend", () => {
            if (loader && loader.parentNode === document.body) {
                document.body.removeChild(loader)
            }
        })
    })
}

loaderPage()