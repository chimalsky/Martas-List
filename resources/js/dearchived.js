
import { Application } from "stimulus"
import { definitionsFromContext } from "stimulus/webpack-helpers"
import $ from 'jquery'

import 'jquery-ui/ui/widgets/draggable'

import 'jquery-ui/themes/base/core.css'
import 'jquery-ui/themes/base/draggable.css'
import 'jquery-ui/ui/core'
import 'jquery-ui/ui/widgets/draggable'

const application = new Application.start()
const context = require.context("./controllers", true, /\.js$/)
application.load(definitionsFromContext(context))

let birds = document.querySelectorAll('.bird')

$(document).ready(function() {
    birds.forEach((el) => {
        animateToPosition(el)
    })
});

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
