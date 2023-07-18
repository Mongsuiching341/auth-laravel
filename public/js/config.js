function showLoader() {
    document.getElementById('loader').classList.remove('hidden')
}
function hideLoader() {
    document.getElementById('loader').classList.add('hidden')
}


function success(msg) {
    Toastify({
        gravity: "top", // `top` or `bottom`
        position: "right",
        text: msg,
        close: true,
        duration: 1500,
        className: "mb-5",
        style: {
            background: "#6366f1",
        }
    }).showToast();
}

function errorToast(msg) {
    Toastify({
        gravity: "top", // `top` or `bottom`
        position: "right", // `left`, `center` or `right`
        text: msg,
        close: true,
        duration: 1500,
        className: "mb-5",
        style: {
            background: "crimson",
        }
    }).showToast();
}