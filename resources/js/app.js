
import { Application } from "stimulus"
import { definitionsFromContext } from "stimulus/webpack-helpers"

import trix from 'trix'

import $ from 'jquery'

import turbolinks from 'turbolinks'

import flatpickr from "flatpickr"
import 'flatpickr/dist/flatpickr.min.css'

import '@github/time-elements'

turbolinks.start()  

const application = new Application.start()
const context = require.context("./controllers", true, /\.js$/)
application.load(definitionsFromContext(context))

document.addEventListener('turbolinks:load', bootstrap)

function bootstrap() {
    flatpickr('input[type=date]', {inline: true, altInput: true, altFormat: 'F j, Y'})
    flatpickr('input[type=time]', {enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",})

        
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

                input.value = value
                
                console.log(i, input)


            });

            $('input[name=name]')[0].value = dom.find('h1[itemprop=name]')[0].textContent.trim()

            let citation = dom.find('#player > p')[5]

            $('input.attribute').last()[0].value = citation.textContent

        })

    }


}

