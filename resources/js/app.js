
import { Application } from "stimulus"
import { definitionsFromContext } from "stimulus/webpack-helpers"

import trix from 'trix'

import $ from 'jquery'

import turbolinks from 'turbolinks'

import flatpickr from "flatpickr"
import 'flatpickr/dist/flatpickr.min.css'

import '@github/time-elements'
import { Sortable } from '@shopify/draggable'

import Alpine from 'alpinejs'

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
    flatpickr('input[type=date]', {inline: true, altInput: true, altFormat: 'F j, Y'})
    flatpickr('input[type=time]', {enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",})

        
    window.livewire.on('deleteMeta', function(html, metaId) {
        eventLog.innerHTML = html
        eventLog.classList.remove('hidden')
        let deleted = document.querySelector('[data-meta-id="' + metaId + '"]')

        deleted.remove()
        
        setTimeout(() => {
            eventLog.classList.add('hidden')
        }, 3500)
    })

    // Sortable 
    const sortable = new Sortable(document.querySelectorAll('.sortable'), {
        draggable: 'article'
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


