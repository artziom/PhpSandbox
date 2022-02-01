import {Controller} from "@hotwired/stimulus";
import Swal from "sweetalert2";

export default class extends Controller{
    removeItem(event) {
        console.log(event.currentTarget);
    }
}