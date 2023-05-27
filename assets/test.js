"use strict";

// Test hej-button on card landing page.
let button = document.getElementById("thebutton");

if (button) {
    button.addEventListener("click", () => {
        console.log("HEJ");
    });
}