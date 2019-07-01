
import { Application } from "stimulus"
import { definitionsFromContext } from "stimulus/webpack-helpers"

import trix from 'trix'

import turbolinks from 'turbolinks'

turbolinks.start()  

const application = new Application.start()
const context = require.context("./controllers", true, /\.js$/)
application.load(definitionsFromContext(context))
