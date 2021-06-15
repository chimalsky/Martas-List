import { Controller } from "stimulus"

import { request } from '@helpers/request'
import { delay } from '@helpers/timing_helpers'

export default class extends Controller {   
    static targets = [ "nextPageLink" ]
    static values = { manualLoad: Boolean, rootMargin: String }

    initialize() {
        this.observeNextPageLink()
    }

    async observeNextPageLink() {
        await nextIntersection(document.querySelector('#next-link'))
        
        this.element.setAttribute("aria-busy", "true")

        const html = await this.loadNextPageHTML()

        this.element.setAttribute("aria-busy", "false")

        this.nextPageLink.outerHTML = html

        await delay(800)
        this.observeNextPageLink()

        console.log(html)
    }

    async loadNextPageHTML() {
        const html = await request.get(this.nextPageLink.href)
        const doc = new DOMParser().parseFromString(html, "text/html")
        const element = doc.querySelector(`#results-list`)
        return element ? element.innerHTML.trim() : ""
    }

    // Private

    async loadNextPageHTML() {
        const html = await request.get(this.nextPageLink)
        const doc = new DOMParser().parseFromString(html, "text/html")
        const element = doc.querySelector(`[data-controller~="${this.identifier}"]`)
        return element ? element.innerHTML.trim() : ""
    }

    get nextPageLink() {
        const links = this.nextPageLinkTargets
        if (links.length > 1) console.warn("Multiple next page links", links)
        return links[links.length - 1]
    }

    get intersectionOptions() {
        const options = {
        root: this.scrollableOffsetParent,
        rootMargin: this.rootMarginValue
        }
        for (const [ key, value ] of Object.entries(options)) {
        if (value) continue

        delete options[key]
        }

        return options
    }

    get scrollableOffsetParent() {
        const root = this.element.offsetParent
        return root && root.scrollHeight > root.clientHeight ? root : null
    }
}


function nextIntersection(element, options = {}) {
    return new Promise(resolve => {
      new IntersectionObserver(([ entry ], observer) => {
        if (!entry.isIntersecting) return;
            
        console.log('seen')

        observer.disconnect()

        resolve()
      }, options).observe(element)
    })
  }