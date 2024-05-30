const modals = document.querySelectorAll(`[data-modal]`)
for (const modal of modals) {
    const closeActions = modal.querySelectorAll(`[data-close]`)
    for (const closeAction of closeActions) {
        closeAction.addEventListener("click", () => {
            modal.classList.remove("modal--active")
        })
    }
}

const modalTriggers = document.querySelectorAll(`[data-modal-trigger]`)
for (const trigger of modalTriggers) {
    trigger.addEventListener("click", () => {
        const modalName = trigger.dataset.modalTrigger
        const modal = document.querySelector(`[data-modal="${modalName}"]`)
        if (modal) {
            modal.dispatchEvent(new CustomEvent(`modal:${modalName}:open`, {
                bubbles: true,
                detail: {
                    from: trigger
                }
            }))
            modal.classList.toggle("modal--active")
        }
    })
}

const handleFormImageInput = (input) => {
    const preview = input.parentElement.parentElement.querySelector("[data-form-image-preview]")
    const defaultSrc = preview.dataset.formImagePreview

    if (preview) {
        const imagePreview = preview.children[0]

        if (defaultSrc) {
            imagePreview.src = defaultSrc
            preview.classList.remove("hidden")
        }

        input.addEventListener("change", event => {
            const files = event.target.files

            if (files.length > 0) {
                imagePreview.src = URL.createObjectURL(files[0])
                preview.classList.remove("hidden")
            } else {
                if (imagePreview.src && imagePreview.src !== defaultSrc) {
                    URL.revokeObjectURL(imagePreview.src)

                }
                if (defaultSrc) {
                    imagePreview.src = defaultSrc
                } else {
                    preview.classList.add("hidden")
                }
            }
        })
    }
}

const formImages = document.querySelectorAll(`[data-form-image]`)
for (const input of formImages) {
    handleFormImageInput(input)
}

window.addEventListener("modal:edit-item:open", async (event) => {
    const formWrapper = document.querySelector(`#edit-item-form-wrapper`);
    const loader = document.querySelector(`#edit-item-loader`)

    loader.classList.remove("hidden")
    formWrapper.innerHTML = ""

    const res = await fetch(`/index.php/barang/edit/${event.detail.from.dataset.barangId}`, {
        headers: {
            'X-Requested-With': 'Fetch',
        }
    })

    const body = await res.text()

    formWrapper.innerHTML = body
    loader.classList.add("hidden")


    handleFormImageInput(formWrapper.querySelector(`[data-form-image]`))

    const form = formWrapper.querySelector("form")
    form.addEventListener("submit", () => {
        for (const button of document.querySelectorAll(`[data-submit-button]`)) {
            button.disabled = true;
        }
    })
})

window.addEventListener("modal:delete-item:open", event => {
    document.querySelector(`#delete-item-form`).action = `/index.php/barang/destroy/${event.detail.from.dataset.barangId}`
})

const inputNumberNotAllowedList = [".", ",", "-", "+"]
document.querySelectorAll(`input[type="number"]`).forEach(input => {
    input.addEventListener("keydown", event => {
        if (inputNumberNotAllowedList.includes(event.key)) {
            event.preventDefault()
        }
    })
});


for (const form of document.querySelectorAll(`form`)) {
    form.addEventListener("submit", () => {
        for (const button of document.querySelectorAll(`[data-submit-button]`)) {
            button.disabled = true;
        }
    })
}

const notifications = document.querySelectorAll(`[data-notif]`)
for (const notif of notifications) {
    const closeTriggers = notif.querySelectorAll(`[data-close]`)
    for (const trigger of closeTriggers) {
        trigger.addEventListener("click", () => {
            notif.remove()
        })
    }
}