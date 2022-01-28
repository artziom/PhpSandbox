import {Controller} from "@hotwired/stimulus";

export default class extends Controller{
    static targets = ['colorSquare'];
    selectColor(event) {
        this.colorSquareTargets.forEach((element) => {
           element.classList.remove('selected');
        });
        event.currentTarget.classList.add('selected');
    }
}