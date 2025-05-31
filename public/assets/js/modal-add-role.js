"use strict";
document.addEventListener("DOMContentLoaded", function (e) {
    {        
        let t = document.querySelector("#selectAll"),
            o = document.querySelectorAll('[type="checkbox"]:not(.switch-input)');
        t.addEventListener("change", (e) => {
            o.forEach((t) => {
                t.checked = e.target.checked;
            });
        });
    }
});
