import { Controller } from "stimulus"

export default class extends Controller {   
    static targets = [
        'form',
        'formFacade'    
    ]

    static classes = [
        'loading'
    ]

    relayAction(event) {
        let target = event.target
        target.setAttribute('disabled', 1)

        let formInput = this.formTarget.querySelector('[name="'+target.name+'"][value="'+target.value+'"]')
        
        formInput.click()
    }
}