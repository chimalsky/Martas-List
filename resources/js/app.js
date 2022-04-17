
import { Application } from "stimulus"
import { definitionsFromContext } from "stimulus/webpack-helpers"

import trix from 'trix'

import $ from 'jquery'

import '@github/time-elements'

import 'livewire-sortable'

import Alpine from 'alpinejs'

import Sortable from 'sortablejs';

//turbolinks.start()  

const application = new Application.start()
const context = require.context("./controllers", true, /\.js$/)
application.load(definitionsFromContext(context))

/*
document.addEventListener('turbolinks:load', () => {
    window.livewire.rescan()
    bootstrap()
})*/

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
    let nestedSortables = [].slice.call(document.querySelectorAll('.sortable'))

    for (var i = 0; i < nestedSortables.length; i++) {
        new Sortable(nestedSortables[i], {
            group: 'nested',
            animation: 150,
            fallbackOnBody: true,
            swapThreshold: 0.65,
            onSort: function(event) {
                let destination = event.to,
                    input = event.item.querySelector('input.option'); 

                if (destination.classList.contains('block-options')) {
                    let blockId = destination.getAttribute('data-block-id')
                    input.setAttribute('name', `options[${blockId}][]`)
                } else {
                    if (input.value != 'BLOCK-EMPTY-VALUE')
                        input.setAttribute('name', 'options[]');
                }
            }
        });
    }

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


