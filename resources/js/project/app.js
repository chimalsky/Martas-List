import { Application } from "stimulus"
import { definitionsFromContext } from "stimulus/webpack-helpers"

import turbolinks from 'turbolinks'

import Alpine from 'alpinejs'

turbolinks.start()  

document.addEventListener('turbolinks:load', () => {
    window.livewire.rescan()
})

const application = new Application.start()
const context = require.context("./controllers", true, /\.js$/)
application.load(definitionsFromContext(context))