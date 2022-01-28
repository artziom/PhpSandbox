import {Controller} from "@hotwired/stimulus";

export default class extends Controller{
    selectColor(event) {
        console.log(event);
    }
}