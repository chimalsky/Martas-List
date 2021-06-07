import { Controller } from "stimulus"
import { Request } from '@lib/http/request'
import { delay } from '@helpers/timing_helpers'

const SUBMIT_DELAY = 1000

export default class extends Controller {   
    static targets = [
    ]

    initialize() {
        setTimeout(() => {
            this.submitForm()
        }, 50)
    }

    async changed(event) {
        console.log(event.target.checked)

        window.dispatchEvent(new CustomEvent('form-updated'))

        if (event.target.name == 'sort') {
            if (!event.target.checked) {
                document.querySelector('#direction').innerHTML = 'A -> Z'
            } else {
                document.querySelector('#direction').innerHTML = 'Z -> A'
            }
        }
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

        window.dispatchEvent(new CustomEvent("form-submitted", {
            detail: { 
                data: this.formData
            }
        }))

        this.submitting = true

        response.html.then((html) => { 
            document.querySelector('#results-section').innerHTML = html
            this.submitting = false

            window.dispatchEvent(new CustomEvent('results-updated'))
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