import { Controller } from "stimulus"

export default class extends Controller {
  delete(event) {
    var confirm = prompt("Really delete this?", "Yes do it!");
    if (confirm == null || confirm == "") {
      event.preventDefault()
    } else {
      return true;
    }
  }
}