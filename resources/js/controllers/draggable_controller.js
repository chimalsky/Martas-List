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

        animateToPosition(this.element)

        this.media.pause()
        this.media.play()

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
        this.element.classList.add('exploring')
    }

    dragging(ev) {
        this.duration++

        this.media.play()
    }

    stop(ev) {
        let media = this.media
        this.element.classList.remove('exploring')

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
        return document.querySelector('#birdsong-' + media)
    }
    
}

function makeNewPosition() {
    var h = $(window).height();
    var w = $(window).width();
    
    var nh = Math.floor(Math.random() * h);
    var nw = Math.floor(Math.random() * w);
    
    return [nh,nw];    
}

function animateToPosition(el) {
    if (el.classList.contains('exploring')) {
        return setTimeout(function() {
            animateToPosition(el)
        }, 5000) 
    }

    let newq = makeNewPosition();
    let duration = Math.random() * (20000 - 1000) + 1000

    $(el).animate({ top: newq[0], left: newq[1] }, duration, function(){
        animateToPosition(el)
    });
}

export default Draggable;