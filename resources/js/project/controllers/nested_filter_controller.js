import { Controller } from "stimulus"

export default class extends Controller {   
    static targets = [
        'block',
        'blockOptions',
        'pseudoBlock',
        'back'
    ]

    static values = {
        stage: Number,
        selectedBlock: String
    }

    initialize() {
        if (this.hasSelectedBlock() || this.hasSelectedBlockOption()) {
            this.selectedBlockValue = this.activeBlock
            return this.navigateToStage(2)
        }

        this.navigateToStage(1)
    }

    blockSelected(event) {
        this.selectedBlockValue = event.target.value

        this.dispatchUpdate()

        this.navigateToStage(2)
    }

    optionSelected(event) {        
        if (this.selectedBlock && this.selectedBlock.checked) {
            this.selectedBlock.click()
        }

        this.dispatchUpdate()
    }

    navigateToStage(stage) {
        this.stageValue = stage 

        if (this.stageValue === 1) {
            this.blockTargets.forEach(el => el.classList.remove('hidden'))

            this.blockOptionsTargets.forEach(el => el.classList.add('hidden'))

            this.pseudoBlockTargets.forEach(el => el.classList.remove('hidden'))

            this.backTarget.classList.add('hidden')
        }

        if (this.stageValue === 2) {
            this.blockOptionsTargets.find(
                element => element.getAttribute('data-block') == this.selectedBlockValue
            ).classList.remove('hidden')
    
            this.blockOptionsTargets.filter(
                element => element.getAttribute('data-block') != this.selectedBlockValue
            ).forEach(el => el.classList.add('hidden'))

            this.pseudoBlockTargets.forEach(el => el.classList.add('hidden'))
    
            this.blockTargets.forEach(el => el.classList.add('hidden'))

            this.backTarget.classList.remove('hidden')
        }
    }

    back(event) {
        this.navigateToStage(1)

        this.clearSelectedBlockOptions()

        this.clearSelectedBlocks()
        this.clearSelectedPseudoBlocks()

        this.dispatchUpdate()
    }

    clearSelectedBlockOptions() {
        this.blockOptionsTargets.forEach((element) => {
            element.querySelectorAll('input').forEach((el) => {
                if (el.checked) el.checked = false
            })
        })
    }

    clearSelectedBlocks() {
        this.blockTargets.forEach((element) => {
            let input = element.querySelector('input')

            input.checked = false
        }) 
    }

    clearSelectedPseudoBlocks() {
        this.pseudoBlockTargets.forEach((element) => {
            let input = element.querySelector('input')

            input.checked = false
        }) 
    }

    hasSelectedBlock() {
        return this.selectedBlock ? true : false
    }

    hasSelectedBlockOption() {
        return this.selectedBlockOptions.length
            ? true
            : false
    }

    get selectedBlock() {
        let checkedBlock = this.blockTargets.find(
            el => el.querySelector('input').checked
        )
        
        return checkedBlock 
            ? checkedBlock.querySelector('input')
            : null
    }

    get activeBlock() {
        if (this.hasSelectedBlock()) {
            return this.selectedBlock.value
        }

        if (this.hasSelectedBlockOption()) {
            return this.selectedBlockOptions[0].getAttribute('data-block')
        }

    }

    get selectedBlockOptions() {
        return Array.from(this.element.querySelectorAll('input[data-option]'))
            .filter(element => element.checked)
    }
    
    dispatchUpdate() {
        window.dispatchEvent(new CustomEvent('filter-value-updated'))
    }
}