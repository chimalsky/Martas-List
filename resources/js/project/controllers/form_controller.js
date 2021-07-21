import { Controller } from "stimulus"
import { Request } from '@lib/http/request'
import { delay } from '@helpers/timing_helpers'
 
const SUBMIT_DELAY = 1000

export default class extends Controller {   
    static targets = [
    ]

    initialize() {
        if (this.savedState)
            this.restoreState(); 

        setTimeout(() => { 
            this.submitForm(false)
        }, 50)
    }

    async changed(event) {
        window.dispatchEvent(new CustomEvent('form-updated'))

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
            this.submitting = false

            window.dispatchEvent(new CustomEvent('results-updating', {'detail': html}))
        })
    }

    saveState() {
        let params = this.formDataString
        localStorage.setItem(this.key, JSON.stringify({params}))
    }

    restoreState() {
        if (!localStorage.getItem(this.key))
            return;

        const { params } = JSON.parse(localStorage.getItem(this.key))
    
        for (const [ key, value ] of new URLSearchParams(params)) {
            const input = this.element.elements[key]
            console.log(input, key, value, input.type)
            
            if (NodeList.prototype.isPrototypeOf(input)) {
                input.forEach((el) => {
                    if (el.value == value) {
                        el.setAttribute('checked', true)
                    }
                })
            } else {
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
                    case "radio":
                        console.log(input, value)
                        break;
                    default:
                      break
                }
            }

            
        }
    }

    async clearState() {
        this.submitting = true 

        localStorage.removeItem(this.key)

        let checked = Array.from(this.element.querySelectorAll('input')).filter((el) => {
            return el.checked || el.value
        }).forEach((input) => {
            switch (input.type) {
                case "text":
                    input.value = ''
                    break;
                case "checkbox":
                    input.checked = false
                    break
                case "select-one":
                    input.value = ''
                    break
                case "radio":
                    input.checked = false 
                    break
                default:
                  break
            }
        })

        this.submitForm(false)
    }

    clearQuery() {
        let queryInput = this.element.querySelector('[name="query"]')
        queryInput.value = ''

        this.submitForm()
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