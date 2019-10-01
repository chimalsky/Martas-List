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
        this.exploring 

        let that = this

        $(this.img).draggable({
            start: function(ev) {
                return that.start.call(that, ev)
            },
            drag: function(ev) {
                return that.dragging.call(that, ev)
            },
            stop: function(ev) {
                //return that.stop.call(that, ev)
            }
        })

                
        $(this.img).off('mousewheel').on('mousewheel', function(ev) {   
            const direction = ev.originalEvent.deltaY < 0 ? 'down' : 'up'
            const zoom = that.zoom

            console.log(direction, zoom, that)

            if (direction == 'up') {
                that.zoomImg(zoom + .02)
            }

            if (direction == 'down') {  
                that.zoomImg(zoom - .01)
            }
            ev.preventDefault()
        }) 

        this.containImg()
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

    zoomImg(zoom) {
        const $img = $(this.img)
        this.zoom = zoom
        const newWidth = $img.prop('naturalWidth') * (this.zoom)
        $img.css('width', newWidth)

        console.log($img, $img.prop('naturalWidth'), $img.css('width'))

        const newHeight = $img.prop('height') 

    }

    refresh = function() {
        this.zoom = this.getZoom()
        //this.center = this.getCenter()
    }


    getZoom = function() {
        const $img = $(this.img)
        var zoom = $img.prop('width') / $img.prop('naturalWidth')

        return zoom
    }

    containImg() {
        if (!this.img) { return }
        
        const $img = $(this.img)
        $img.attr('width', '100%')
            .attr('left', 0)
            .attr('top', 0);
    
        this.refresh()
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