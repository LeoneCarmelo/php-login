///////////////// Admin Form Edit and Delete /////////////////////
const editForm = document.querySelector('.edit')
const editBtns = document.querySelectorAll('input[value="Modifica"]')
const deleteForm = document.querySelector('.delete')
const indietroBtns = document.querySelectorAll('input[value="INDIETRO"]')
const backBtns = document.querySelectorAll('input[value="back"]')
const deleteBtns = document.querySelectorAll('input[value="Cancella"]')

deleteBtns.forEach((deleteBtn, index) => {
    deleteBtn.addEventListener('click', (e) => {
        e.preventDefault()
        const modals = document.querySelectorAll('.modal')
        modals[index].classList.add("d-flex")
    })
})

editBtns.forEach((editBtn, index) => {
    editBtn.addEventListener('click', (e) => {
        e.preventDefault()
        const modals = document.querySelectorAll('.edit-modal')
        modals[index].classList.add("d-flex")
    })
})

indietroBtns.forEach((indietroBtn, index) => {
    indietroBtn.addEventListener('click', () => {
        const modals = document.querySelectorAll('.modal')
        modals[index].classList.remove("d-flex")
    })
})

backBtns.forEach((backBtn, index) => {
    backBtn.addEventListener('click', () => {
        const modals = document.querySelectorAll('.edit-modal')
        modals[index].classList.remove("d-flex")
    })
})