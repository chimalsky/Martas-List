import { Controller } from "stimulus"
import { Request } from '@lib/http/request'
import { delay } from '@helpers/timing_helpers'

const SUBMIT_DELAY = 1000

export default class extends Controller {   
    static targets = [
    ]

    async changed(event) {
        if (this.submitting)
            await delay(SUBMIT_DELAY);

        this.submitForm()
    }

    sync(event) {
        console.log(event, event.detail.data)
    }

    async submitForm() {        
        const request = new Request(this.method, this.action, { responseKind: 'json', queryString: this.formData })
        const response = await request.perform()

        const event = new CustomEvent("form-submitted", {
            detail: { 
                data: this.formData
            }
        })

        window.dispatchEvent(event)

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
}