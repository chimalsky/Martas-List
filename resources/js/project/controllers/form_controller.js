import { Controller } from "stimulus"
import { Request } from '@lib/http/request'
import { delay } from '@helpers/timing_helpers'

const SUBMIT_DELAY = 1000

export default class extends Controller {   
    static targets = [
    ]

    connect() {
        console.log(this.element)

        console.log(this.inputTarget)
    }

    async changed(event) {
        if (this.submitting)
            await delay(SUBMIT_DELAY);

        this.submitForm()
    }

    async submitForm() {        
        const request = new Request(this.method, this.action, { responseKind: 'json', queryString: this.formData })
        const response = await request.perform()

        this.submitting = true

        response.html.then((html) => { 
            document.querySelector('#results-section').innerHTML = html
            this.submitting = false
        })
    }

    get action() {
        return this.element.action
    }

    get method() {
        return this.element.method
    }

    get formData() {
        return new FormData(this.element)
    }

    synthesizeFormMethod() {
        this.syntheticMethodInput = this.element.querySelector("input[name=_method]")

        if (!this.syntheticMethodInput) {
            this.syntheticMethodInput = document.createElement("input")
            this.syntheticMethodInput.type = "hidden"
            this.syntheticMethodInput.name = "_method"
            this.syntheticMethodInput.value = this.element.method
            this.element.append(this.syntheticMethodInput)
        }
    }
}