import { Controller } from "stimulus"

export default class extends Controller {   
    static targets = ['citation', 'newAttribute']

    connect() {
        console.log(this.element, this.citationTarget.value)
        this.refreshUi()
    }

    addCitation(ev) {
        ev.preventDefault()

        this.citationTarget.classList.remove('hidden')
    }

    addNewAttribute(ev) {
        ev.preventDefault()

        this.newAttributeTarget.classList.remove('hidden')
        this.newAttributeTarget.querySelector('input').focus()
    }

    refreshUi() {
        if (this.citationTarget.value) {
            return this.citationTarget.classList.remove('hidden')
        }

        this.citationTarget.classList.add('hidden')
    }
}