import $ from 'jquery'
import 'jquery-ui/ui/widgets/draggable'

import 'jquery-ui/themes/base/core.css'
import 'jquery-ui/themes/base/draggable.css'
import 'jquery-ui/ui/core'
import 'jquery-ui/ui/widgets/draggable'

import { Controller } from "stimulus"

export default class extends Controller {  
    static targets = ['container']
 
    connect() {
        console.log("frame city")
        
        this.zoom = 1
        this.center = undefined
        this.explorable = true

        $(this.containerTarget).draggable()

        console.log($(this.containerTarget), this.img)
    }

    get img() {
        return this.element.querySelector('img')
    }
}