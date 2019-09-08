import { Controller } from "stimulus"

export default class extends Controller {
  static targets = [
    'dateInput',
    'precision',
    'day', 'month', 'year'
  ]

  initialize() {
    this.updatePrecision()
    this.inputChanged()
  }

  updatePrecision() {    
    this.precision = this.precisionTarget.value
  }

  inputChanged(ev) {
    this.dateInputTarget.value = this.year + '-' + this.month + '-' + this.day
  }

  get precision() {
    this.data.get('precision')
  }

  set precision(value) {
    this.data.set('precision', value.toLowerCase())
  }

  get year() {
    return parseInt(this.yearTarget.querySelector('input').value)
  }

  get month() {
    return parseInt(this.monthTarget.querySelector('select').value)
  }

  get day() {
    return parseInt(this.dayTarget.querySelector('input').value)
  }
}