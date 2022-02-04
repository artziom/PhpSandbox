import {Controller} from "@hotwired/stimulus";

export default class extends Controller{
    static targets = ['content'];
    static values = {
        url: String,
    }

    async refreshContent(event) {
        this.contentTarget.style.opacity = .5;
        const respone = await fetch(this.urlValue);
        this.contentTarget.innerHTML = await respone.text();
        this.contentTarget.style.opacity = 1;
    }
}