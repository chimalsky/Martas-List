
import { Application } from "stimulus"
import { definitionsFromContext } from "stimulus/webpack-helpers"

import trix from 'trix'

import $ from 'jquery'

import turbolinks from 'turbolinks'

import '@github/time-elements'
import { Sortable } from '@shopify/draggable'
import { Droppable } from '@shopify/draggable'

import 'livewire-sortable'

import Alpine from 'alpinejs'

import 'slick-carousel'

turbolinks.start()  

const application = new Application.start()
const context = require.context("./controllers", true, /\.js$/)
application.load(definitionsFromContext(context))

document.addEventListener('turbolinks:load', () => {
    window.livewire.rescan()
    bootstrap()
})

const eventLog = document.querySelector('.event-log')

function bootstrap() {

    window.livewire.on('deleteMeta', function(html) {
        eventLog.innerHTML = html
        eventLog.classList.remove('hidden')
        document.querySelector('body').click()
        
        setTimeout(() => {
            eventLog.classList.add('hidden')
        }, 3500)
    })

    // Sortable 
    const sortable = new Sortable(document.querySelectorAll('.sortable'), {
        draggable: '.draggable'
    });
    /*const sortableHeader = new Sortable(document.querySelectorAll('.sortable'), {
        draggable: 'header.sortable'
    });*/

    sortable.on('sortable:stop', (e) => {
        let container = e.data.newContainer
        let target = e.dragEvent.data.source

        let inputId = target.querySelector('input').getAttribute('id')

        let input = document.getElementById(inputId)

        if (container.tagName.toLowerCase() == "header" && target.tagName.toLowerCase() == 'article') {
            let blockName = container.getAttribute('id')
            input.setAttribute('name', `options[${blockName}][]`)
            //let input = e.newContainer.querySelector(sourceInput)
            //let blockName = e.newContainer.getAttribute('data-block-name')

           // input.setAttribute('name', `options[${blockName}]`)
            //.setAttribute('foobar', 'options[Pen]')
        } else {
            if (target.tagName.toLowerCase() == 'article') {
                input.setAttribute('name', 'options[]')
            }
        }
    });

    $('.slick-carousel').slick({
        centerMode: true,
        dots: true,
        arrows: true,
        variableWidth: true,
        slidesToShow: 3,
        slidesToScroll: 1,
        //autoplay: true,
        autoplaySpeed: 2000,
        prevArrow: '<button type="button" class="previous"><</button>',
        nextArrow: '<button type="button" class="next">></button>'
    });

    function splitText() {
        let source = document.querySelector('#js-transcription-source');
        let display = document.querySelector('#js-transcription-display');

        let transcriptionNode = source.innerHTML;

        let splitText = transcriptionNode.split("{/pb}");

        splitText.forEach(function(page, i) {
            let div = document.createElement('div');
            div.innerHTML = page;
            div.setAttribute('page-index', i)
            div.classList.remove('hidden')

            console.log(div)

            display.appendChild(div);
        });
        
        source.classList.add('hidden');
    }

    function showPageByIndex(index) {
        if (!document.querySelector(`#js-transcription-display div[page-index="${index}"]`)) {
            splitText();
        }

        let selectedText = document.querySelector(`#js-transcription-display div[page-index="${index}"]`)

        document.querySelectorAll('#js-transcription-display div').forEach(function(div) {
            div.classList.add('hidden');
        });

        selectedText.classList.remove('hidden');
    }

    Livewire.on('media-viewer:pageChanged', pageIndex => {
        //showPageByIndex(pageIndex);
    });
        
    window.xenoPower = function() {
        window.$ = $

        let linkEl = document.querySelector("[data-target=link]")
        
        if (!linkEl.value) {
            return alert('That Xeno link is invalid')
        }

        $.get('/xeno-power?url=' + linkEl.value, function(html) {
            let dom = $(html)

            let tr = dom.find('table.key-value tr')

            let excludeIndex = [9,10,11,12,13];

            let dictionary = tr.each(function(i, el) {
                if (excludeIndex.includes(i)) {
                    return
                }

                if (i > 13) {
                    i = i-5
                }

                let key = $(el).find('td:nth-child(1)')[0].textContent.trim(),
                    value = $(el).find('td:nth-child(2)')[0].textContent.trim();
                
                let input = $("input.attribute")[i]

                console.log(input, key, value)

                input.value = value
            });

            let sonogram = 'https://xeno-canto.org/' + dom.find('a[download]')[2].getAttribute('href')

            console.log(sonogram)

            $('label.sonogram input')[0].value = sonogram 
            $('img.sonogram').attr('src', sonogram)

            $('input[name=name]')[0].value = dom.find('h1[itemprop=name]')[0].textContent.trim()

        })

    }


}


