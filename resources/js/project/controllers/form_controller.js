import { Controller } from "stimulus"
import { Request } from '@lib/http/request'
import { delay } from '@helpers/timing_helpers'
 
const SUBMIT_DELAY = 1000

export default class extends Controller {   
    static targets = [
    ]

    initialize() {
        const { params } = JSON.parse(localStorage.getItem(this.key))
    
        for (const [ key, value ] of new URLSearchParams(params)) {
            const input = this.element.elements[key]
            console.log(input, key, value, input.type)

            switch (input.type) {
                case "text":
                    input.value = value
                    break;
                case "checkbox":
                    input.checked = !!value
                    break
                case "select-one":
                    input.value = value
                    break;
                case undefined:
                    input.forEach((el) => {
                        if (el.value == value) {
                            el.setAttribute('checked', true)
                        }
                    })
                    default: 
                  break
            }
        }
        setTimeout(() => { 
            this.submitForm(false)
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
 
    async submitForm(persistState = true) {
        if (persistState) 
            this.saveState(); 

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

    saveState() {
        let params = this.formDataString
        localStorage.setItem(this.key, JSON.stringify({params}))
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

    get formDataString() {
        return new URLSearchParams(this.formData).toString()
    }

    get pathname() {
        return new URL(this.action, location).pathname
    }

    get key() {
        return `curation::${this.pathname}`
    }

    get savedState() {
        return localStorage.getItem(this.key)
    }
}