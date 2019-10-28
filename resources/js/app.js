
import { Application } from "stimulus"
import { definitionsFromContext } from "stimulus/webpack-helpers"

import trix from 'trix'

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
    console.log('boots')
    flatpickr('input[type=date]', {inline: true, altInput: true, altFormat: 'F j, Y'})

}

