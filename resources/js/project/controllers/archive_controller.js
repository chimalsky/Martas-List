import { Controller } from "stimulus"

export default class extends Controller {   
    static targets = [
        'form',
        'formFacade',
        'resultsContainer',
        'hide'
    ]

    relayAction(event) {
        let target = event.target
        target.setAttribute('disabled', 1)

        let formInput = this.formTarget.querySelector('[name="'+target.name+'"][value="'+target.value+'"]')
        
        formInput.click()
    }

    clearForm(event) {
        window.dispatchEvent(new CustomEvent('curation-cleared'))
    }

    loading() {
        console.log('loading')
        this.loadingSplashElement.classList.remove('hidden')
    }

    loadingComplete() {
        console.log('complete')
        this.hideTargets.forEach(el => el.classList.add('hidden'))
        
        this.loadingSplashElement.classList.add('hidden')
    }

    get loadingSplashElement() {
        return this.resultsContainerTarget.querySelector('.loading-splash')
    }
}