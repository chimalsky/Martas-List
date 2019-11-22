import { Controller } from "stimulus"

export default class extends Controller {   
    static targets = ['type', 'options']

    connect() {
        console.log(this.element, this.typeTarget.value)
        this.refreshUi()
    }

    changeType() {
        this.refreshUi()
    }

    addOption(ev) {
        ev.preventDefault()

        let input = document.createElement('input')
        console.log(input)

        input.setAttribute('name', 'options[]')
        input.setAttribute('class', 'form-input block')

        this.optionsTarget.appendChild(input)
    }

    refreshUi() {
        if (this.typeTarget.value == 'dropdown') {
            return this.optionsTarget.classList.remove('hidden')
        }

        this.optionsTarget.classList.add('hidden')
    }
}