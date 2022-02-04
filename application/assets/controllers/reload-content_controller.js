import {Controller} from "@hotwired/stimulus";

export default class extends Controller{
    static targets = ['content'];
    static values = {
        url: String,
    }

    async refreshContent(event) {
        const respone = await fetch(this.urlValue);
        this.contentTarget.innerHTML = await respone.text();
    }
}