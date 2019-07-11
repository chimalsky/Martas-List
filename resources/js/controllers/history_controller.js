const localSessionKey = "history.history"

import { Controller } from "stimulus"

export default class extends Controller {
  static targets = [ "links" ]

  initialize() {
    // Listen for page changes
    this.leavingPage = this.leavingPage.bind(this)
    window.addEventListener("turbolinks:before-visit", this.leavingPage);
    window.addEventListener("beforeunload", this.leavingPage);

    // Load history from session store
    let historyValue = window.sessionStorage.getItem(localSessionKey)
    if ( historyValue ) {
      this.history = JSON.parse(historyValue)
    } else {
      this.history = []
    }

    // Used to prevent current page from being entered into the history list when going back
    this.recordVisit = true;
  }

  connect() {
    // Load in the history and display it on the page
    var links = ""
    this.history.forEach( (historyEntry, historyLocation  ) => {
       links += linkHTML(historyEntry.title, historyEntry.path, historyLocation)
    });
    this.linksTarget.innerHTML = links; 
  }

  disconnect() {
    // Unload page change listener
    window.removeEventListener("turbolinks:before-visit", this.leavingPage);
    window.removeEventListener("beforeunload", this.leavingPage);
  }


  visitPageInHistory(event) {
    // When going back to a page on our bread crumb list, remove items visited after desired page
    let historyItemIndex = event.target.getAttribute('data-history-location');
    this.history = this.history.slice(0, historyItemIndex);
    this.recordVisit = false;
  }

  leavingPage(event) {
    // Record page into history when leaving
    if (this.recordVisit) {
      let lastVisitedItem = this.history[this.history.length - 1];
      if (lastVisitedItem == null || lastVisitedItem.path != this.pagePath ) {
        this.history.push({ title: document.title, path: this.pagePath });
      }
    }
    window.sessionStorage.setItem(localSessionKey, JSON.stringify(this.history));
  }

  get pagePath() {
    return `${window.location.pathname}${window.location.search}`;
  }
}

function linkHTML(historyItemTitle, historyItemPath, historyLocation) {
  return `<li><a href="${ historyItemPath }" data-action="history#visitPageInHistory" data-history-location="${ historyLocation }"> <strong>></strong> ${ historyItemTitle }</a></li>`;
}