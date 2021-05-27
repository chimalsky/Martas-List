export class LocalForm {
    constructor(element) {
      this.element = element
    }
  
    save() {
      const time = Date.now()
      const params = new URLSearchParams(this.formData).toString()
      localStorage.setItem(this.key, JSON.stringify({ time, params }))
    }
  
    restore() {
      const { params } = JSON.parse(localStorage.getItem(this.key))
  
      for (const [ key, value ] of new URLSearchParams(params)) {
        const input = this.element.elements[key]
  
        switch (input.type) {
          case "checkbox":
            input.checked = !!value
            break
          case "select-multiple":
            input[input.options.length] = new Option(value, value, true, true)
            break
          default: {
            const trixElement = this.element.querySelector(`trix-editor[input="${input.id}"]`)
            trixElement
              ? trixElement.value = value
              : input.value = value
            break
          }
        }
      }
    }
  
    discard() {
      localStorage.removeItem(this.key)
    }
  
    get isSaved() {
      return this.key in localStorage
    }
  
    get key() {
      return `localform::${this.pathname}`
    }
  
    get pathname() {
      return new URL(this.element.action, location).pathname
    }
  
    get formData() {
      return new FormData(this.element)
    }
  }
  