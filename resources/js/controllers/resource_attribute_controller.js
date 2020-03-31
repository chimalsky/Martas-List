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
        input.setAttribute('placeholder', 'A new option awaits...')
        input.setAttribute('class', 'form-input w-full block border-gray-600 border-b mb-2')

        this.optionsTarget.appendChild(input)
    }
}