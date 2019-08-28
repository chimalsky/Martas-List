import { Controller } from "stimulus"

import $ from 'jquery'
import 'jquery-ui/ui/widgets/draggable'

import 'jquery-ui/themes/base/core.css'
import 'jquery-ui/themes/base/draggable.css'
import 'jquery-ui/ui/core'
import 'jquery-ui/ui/widgets/draggable'

const Draggable = class extends Controller {   
    connect() { 
        let that = this

        $(this.element).draggable({
            handle: '.draggable-handle',
            start: function(ev) {
                return that.start.call(that, ev)
            },
            drag: function(ev) {
                return that.dragging.call(that, ev)
            },
            stop: function(ev) {
                return that.stop.call(that, ev)
            }
        })
    }

    start(ev) {
        this.starts++
    }

    dragging(ev) {
        this.duration++

        this.media.play()
    }

    stop(ev) {
        let media = this.media
        setTimeout(function() {
            media.pause()
        }, 3000)
    }

    get starts() {
        return parseInt(this.data.get('starts')) || 0
    }
    
    set starts(value) {
        this.data.set('starts', value)
    }

    get duration() {
        return parseInt(this.data.get('duration')) || 0
    }

    set duration(value) {
        this.data.set('duration', value)
    }

    get media() {
        let media = this.data.get('media')
        console.log(media)
        return document.querySelector('#birdsong-' + media)
    }
    
}

export default Draggable;