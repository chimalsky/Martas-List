import { Controller } from "stimulus"

import moment from 'moment'

export default class extends Controller {   
    connect() {
        this.element.innerHTML = moment(this.date).fromNow()
    }

    get date() {
        return this.data.get('datetime')
    }
}