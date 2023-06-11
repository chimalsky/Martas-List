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
    processParentElement()
    
    window.livewire.on('media-viewer:pageChanged', function(html) {
        const transcription = document.querySelector("#js-transcription-display")
        const transcriptionX = new URLSearchParams(location.search).get('x')
        const transcriptionY = new URLSearchParams(location.search).get('y')

        if (transcriptionX && transcriptionY) {
            transcription.style.left = transcriptionX
            transcription.style.top = transcriptionY
        }
        transcription.classList.remove('invisible')

        const children = transcription.getElementsByTagName('div')
        const hasOrientation = Array.from(children).some(div => div.hasAttribute('data-transcription-orientation'))
        const orientation = hasOrientation 
            ? document.querySelector("div[data-transcription-orientation]").getAttribute('data-transcription-orientation')
            : 'portrait';
        transcription.setAttribute('data-transcription-orientation', orientation);

        processParentElement()
    })

    const transcription = $( "#js-transcription-display" )

    transcription.draggable({
        handle: "#transcription-icon",
        stop: function(event) {
            const currentUrl = new URL(window.location.href)
            const searchParams = new URLSearchParams(currentUrl.search)

            const parentEl = document.querySelector('#js-transcription-display')
            searchParams.set('x', parentEl.style.left)
            searchParams.set('y', parentEl.style.top)

            currentUrl.search = searchParams.toString()

            window.history.pushState({}, '', currentUrl.toString())
        }
    })
})

function processParentElement() {
    accountForTightColumns()
    accountForWideContent()
    matchManuscriptImageHeight()
    processEditorialEncodings()
}

function accountForTightColumns() {
    const columnsTight = document.querySelector("[data-columns-tight]")
    if (columnsTight) {
        document.querySelector("#js-transcription-display").setAttribute('data-columns-tight')
    }
}

function accountForWideContent() {
    const container = document.querySelector("#js-transcription-display")
    const containerRect = container.getBoundingClientRect()
    const containerWidth = containerRect.width
    const contentWidth = container.scrollWidth

    if (contentWidth > containerWidth) {
        container.style.width = `${contentWidth + 20}px`
    } else {
        console.log('Content does not extend beyond the specified position.')
    }
}

function matchManuscriptImageHeight() {
    const portrait = document.querySelector('[data-transcription-orientation=portrait]')
    if (portrait) {
        const manuscript = document.querySelector('#js-manuscript')
        const manuscriptHeight = manuscript.getBoundingClientRect().height
        container.style.height = `${manuscriptHeight - 60}px`
        document.querySelector('#js-transcription-display-content').style.width = `${manuscriptHeight - 60}px`
    }
}

function processEditorialEncodings() {
    const transcription = document.querySelector("#js-transcription-display")
    const elementsWithEncoding = Array.from(transcription.querySelectorAll('[data-editorial]'))
    elementsWithEncoding.forEach(e => {
        const value = e.getAttribute('data-editorial')

        switch (value) {
            case 'rotated-90-degrees-l':
                const panelEl = e.closest('[data-panel]')
                panelEl.style.lineHeight = '13.5px'
                panelEl.style.transform = 'translateX(0px) translateY(-50px) rotate(-140deg)'
                transcription.style.width = '250px'
                transcription.style.clipPath = 'polygon(100% 0, 100% 100%, 100% 100%, 0 100%, 0 0)'
                break
        }
    })
}
