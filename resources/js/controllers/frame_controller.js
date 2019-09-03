import $ from 'jquery'
import 'jquery-ui/ui/widgets/draggable'

import 'jquery-ui/themes/base/core.css'
import 'jquery-ui/themes/base/draggable.css'
import 'jquery-ui/ui/core'
import 'jquery-ui/ui/widgets/draggable'

import { Controller } from "stimulus"

export default class extends Controller {  
    static targets = ['container', 'text']
 
    connect() {        
        this.zoom = 1
        this.center = undefined
        this.explorable = true

        let that = this

        $(this.img).draggable({
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
    }

    dragging(ev) {
    }

    stop(ev) {
        let text = this.textTarget
        setTimeout(function() {
            text.classList.remove('hidden')
        }, 300)
        setTimeout(function() {
            text.classList.add('hidden')
        }, 3000)
    }

    zoomImg(ev) {
        const $img = $(this.img)
        const newWidth = $img.prop('naturalWidth') * (this.zoom * 1.1)
        $img.css('width', newWidth)

        console.log($img, $img.prop('naturalWidth'), $img.css('width'))

        const newHeight = $img.prop('height') 

    }

    repositionImg(point) {
        const $frame = $(this.frameTarget)
        const $img = $(this.img)

        let frame = {
            x: $frame.prop('clientWidth'),
            y: $frame.prop('clientHeight')
        }

        let w = $img.prop('width'),
            h = $$img.prop('height');

        // Halve the frame clientWidth & clientHeight
        // because we use the half value as 
        // subtractor to retain center
        var x = -( (point.x * w) /*pixels*/ - frame.x / 2 ),
            y = -( (point.y * h) /*pixels*/ - frame.y / 2 );
        
        $img.css('left', x)
            .css('top', y);
    }

    get img() {
        return this.element.querySelector('img')
    }

    getProjection(point) {
        var projection = {
            x: point.x / $(this.img).prop('width'),
            y: point.y / $(this.img).prop('height')
        }
        console.log('projection:', projection)
        return projection
    }

}