import { Application } from "stimulus"
import { definitionsFromContext } from "stimulus/webpack-helpers"

import Alpine from 'alpinejs'

const application = new Application.start()
const context = require.context("./controllers", true, /\.js$/)
application.load(definitionsFromContext(context))