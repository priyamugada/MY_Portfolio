window.addEventListener('load', function () {
    let sendMessageForm = document.getElementById('mailForm');
    if (!sendMessageForm) return;

    sendMessageForm.addEventListener('submit', function (event) {
        event.preventDefault();

        let submitButton = sendMessageForm.querySelector('button[type="submit"], input[type="submit"]');
        let originalButtonText = submitButton ? submitButton.textContent : null;
        if (submitButton) {
            submitButton.disabled = true;
            submitButton.textContent = 'Sending...';
        }

        let form_data = new FormData(sendMessageForm);
        let accessKeyInput = sendMessageForm.querySelector('input[name="access_key"]');
        let endpoint = (accessKeyInput && accessKeyInput.value.trim() !== '')
            ? 'https://api.web3forms.com/submit'
            : './api/sendMail_api.php';

        if (endpoint.includes('web3forms')) {
            let recipientVal = form_data.get('recipient');
            if (recipientVal && !form_data.has('email')) {
                form_data.append('email', recipientVal);
            }
            if (!form_data.has('name')) {
                form_data.append('name', recipientVal || 'Visitor');
            }
            form_data.append('subject', 'New Message from Portfolio');
        }

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

        httpRequest.open('POST', endpoint);
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
