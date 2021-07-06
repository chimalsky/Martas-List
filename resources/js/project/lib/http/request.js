import { Response } from "./response"
import { getCookie } from "../cookie"

window.breakAllFetchRequestsForTests = false

export class Request {
  constructor(method, url, options = {}) {
    this.method = method
    this.url = window.breakAllFetchRequestsForTests ? "about:blank" : url
    this.options = options
  }

  async perform() {
    let url = this.options.queryString 
      ? this.url + '?' + this.queryString
      : this.url;

    if (this.queryString) {
      console.log(location, this.queryString)
      history.replaceState(null, null, location.pathname + "?"+this.queryString);
    }

    const response = new Response(await fetch(url, this.fetchOptions))
    if (response.unauthenticated && response.authenticationURL) {
      return Promise.reject(window.location.href = response.authenticationURL)
    } else {
      return response
    }
  }

  get fetchOptions() {
    return {
      method:      this.method,
      headers:     this.headers,
      body:        this.body,
      queryString: this.queryString,
      signal:      this.signal,
      credentials: "same-origin",
      redirect:    "follow"
    }
  }

  get headers() {
    return compact({
      "X-Requested-With": "XMLHttpRequest",
      "X-CSRF-Token":     this.csrfToken,
      "Content-Type":     this.contentType,
      "Accept":           this.accept
    })
  }

  get csrfToken() {
    const csrfParam = document.head.querySelector("meta[name=csrf-token]")?.content
    return csrfParam ? getCookie(csrfParam) : undefined
  }

  get contentType() {
    if (this.options.contentType) {
      return this.options.contentType
    } else if (this.body == null || this.body instanceof FormData) {
      return undefined
    } else if (this.body instanceof File) {
      return this.body.type
    } else {
      return "application/octet-stream"
    }
  }

  get accept() {
    switch (this.responseKind) {
      case "html":
        return "text/html, application/xhtml+xml"
      case "json":
        return "application/json"
      default:
        return "*/*"
    }
  }

  get body() {
    return this.options.body
  }

  get queryString() {
    return new URLSearchParams(this.options.queryString).toString();
  }

  get responseKind() {
    return this.options.responseKind || "html"
  }

  get signal() {
    return this.options.signal
  }
}

function compact(object) {
  const result = {}
  for (const key in object) {
    const value = object[key]
    if (value !== undefined) {
      result[key] = value
    }
  }
  return result
}
