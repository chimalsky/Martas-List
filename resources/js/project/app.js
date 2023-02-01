import { Application } from "stimulus"
import { definitionsFromContext } from "stimulus/webpack-helpers"
import $ from 'jquery'
import 'jquery-ui/ui/widgets/draggable'
import 'jquery-ui/themes/base/core.css'
import 'jquery-ui/themes/base/draggable.css'
import 'jquery-ui/ui/core'
import 'jquery-ui/ui/widgets/draggable'
import Alpine from 'alpinejs'

const application = new Application.start()
const context = require.context("./controllers", true, /\.js$/)
application.load(definitionsFromContext(context))

$(function () {
    
    window.livewire.on('media-viewer:pageChanged', function(html) {
        const transcription = document.querySelector("#js-transcription-display")
        const transcriptionX = new URLSearchParams(location.search).get('x')
        const transcriptionY = new URLSearchParams(location.search).get('y')

        console.log(transcriptionX, transcriptionY)
        if (transcriptionX && transcriptionY) {
            transcription.style.left = transcriptionX
            transcription.style.top = transcriptionY
        }
    })

    const transcription = $( "#js-transcription-display" )

    transcription.draggable({
        handle: "#transcription-icon",
        stop: function(event) {
            const currentUrl = new URL(window.location.href);
            const searchParams = new URLSearchParams(currentUrl.search);

            const parentEl = document.querySelector('#js-transcription-display')
            searchParams.set('x', parentEl.style.left);
            searchParams.set('y', parentEl.style.top);

            currentUrl.search = searchParams.toString();

            window.history.pushState({}, '', currentUrl.toString());
        }
    });
})

