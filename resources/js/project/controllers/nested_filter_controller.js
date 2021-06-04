import { Controller } from "stimulus"

export default class extends Controller {   
    static targets = [
        'block',
        'blockOptions',
        'back'
    ]

    static values = {
        stage: Number,
        selectedBlock: String
    }

    initialize() {
        this.navigateToStage(1)
    }

    blockSelected(event) {
        this.selectedBlockValue = event.target.value

        /*
        this.blockOptionsTargets.forEach((element) => {
            element.querySelectorAll('input').forEach((el) => {
                if (el.checked) el.click()
            })
        })

        this.blockTargets.forEach((element) => {
            let input = element.querySelector('input')

            console.log(element.getAttribute('data-block-name'), this.selectedBlockValue)

            if (input.checked && element.getAttribute('data-block-name') != this.selectedBlockValue) {
                console.log('foo')
                input.click()
            }
        }) 
        */

        this.navigateToStage(2)
    }

    optionSelected(event) {
        let activeBlock = this.blockTargets.find(el => {
            return el.getAttribute('data-block-name') == this.selectedBlockValue
        }).querySelector('input')
        
        if (activeBlock.checked) {
            activeBlock.click()
        }
    }

    navigateToStage(stage) {
        this.stageValue = stage 

        if (this.stageValue === 1) {
            this.blockTargets.forEach(el => el.classList.remove('hidden'))

            this.blockOptionsTargets.forEach(el => el.classList.add('hidden'))

            this.backTarget.classList.add('hidden')
        }

        if (this.stageValue === 2) {
            this.blockOptionsTargets.find(
                element => element.getAttribute('data-block') == this.selectedBlockValue
            ).classList.remove('hidden')
    
            this.blockOptionsTargets.filter(
                element => element.getAttribute('data-block') != this.selectedBlockValue
            ).forEach(el => el.classList.add('hidden'))
    
            this.blockTargets.forEach(el => el.classList.add('hidden'))

            this.backTarget.classList.remove('hidden')
        }
    }

    back(event) {
        this.navigateToStage(1)
    }
}