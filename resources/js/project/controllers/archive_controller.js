import { Controller } from "stimulus"

export default class extends Controller {   
    static targets = [
        'form',
        'formFacade',
        'resultsContainer'
    ]

    relayAction(event) {
        let target = event.target
        target.setAttribute('disabled', 1)

        let formInput = this.formTarget.querySelector('[name="'+target.name+'"][value="'+target.value+'"]')
        
        formInput.click()
    }

    loading() {
        this.loadingSplashElement.classList.remove('hidden')
    }

    loadingComplete() {
        this.loadingSplashElement.classList.add('hidden')
    }

    get loadingSplashElement() {
        return this.resultsContainerTarget.querySelector('.loading-splash')
    }
}