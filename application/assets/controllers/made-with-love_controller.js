import {Controller} from "@hotwired/stimulus";
import ReactDOM from 'react-dom';
import React from 'react';
import MadeWithLove from "../components/MadeWithLove";

export default class extends Controller{
    connect() {
        ReactDOM.render(
            <MadeWithLove/>,
            this.element
        )
    }
}