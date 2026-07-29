window.addEventListener('load', function () {
    let sendMessageForm = document.getElementById('mailForm');
    sendMessageForm.addEventListener('submit', function (event) {
        // BUG FIX: this was missing. Without it, the browser performs its
        // default form submission (a GET/page reload) immediately after the
        // XHR below is fired, which aborts the in-flight request before it
        // ever completes — so the message was never actually sent, no
        // response was ever shown, and the page just refreshed.
        event.preventDefault();

        let submitButton = sendMessageForm.querySelector('button[type="submit"], input[type="submit"]');
        let originalButtonText = submitButton ? submitButton.textContent : null;
        if (submitButton) {
            submitButton.disabled = true;
            submitButton.textContent = 'Sending...';
        }

        let form_data = new FormData(sendMessageForm);
        let httpRequest = new XMLHttpRequest();

        httpRequest.addEventListener('load', function (loadEvent) {
            handleResponse(loadEvent);
            if (submitButton) {
                submitButton.disabled = false;
                submitButton.textContent = originalButtonText;
            }
        });
        httpRequest.addEventListener('error', function () {
            error1();
            if (submitButton) {
                submitButton.disabled = false;
                submitButton.textContent = originalButtonText;
            }
        });

        httpRequest.open('POST', './api/sendMail_api.php');
        httpRequest.send(form_data);
    });
});

let handleResponse = function (event) {
    let response;
    try {
        response = JSON.parse(event.target.responseText);
    } catch (e) {
        console.error('Could not parse server response:', event.target.responseText);
        alert('Something went wrong. Please try again later.');
        return;
    }
    console.log(response);
    if (response.success === true) {
        alert('Message sent successfully');
        document.getElementById('mailForm').reset();
    } else {
        alert(response.message);
    }
};

let error1 = function () {
    alert('Something went wrong!');
};
