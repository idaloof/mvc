"use strict";

export default () => {
    let noticeDiv = document.getElementById('proj-flash');

    if (noticeDiv) {
        setTimeout(() => {
            noticeDiv.remove();
        }, 3000);
    }
}