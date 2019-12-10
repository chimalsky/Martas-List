import { Controller } from "stimulus"

export default class extends Controller {   
    static targets = ['options']

    connect() {
    }

    changeType() {
        this.refreshUi()
    }

    addOption(ev) {
        ev.preventDefault()

        let input = document.createElement('input')
        console.log(input)

        input.setAttribute('name', 'options[]')
        input.setAttribute('class', 'form-input block border-gray-600 border-b')

        this.optionsTarget.appendChild(input)
    }
}