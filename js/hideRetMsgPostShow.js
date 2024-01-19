// Function that can remove the ret-msg url param from the window.location.href
function removeRetMsg() {
    // Get the current URL
    var currentUrl = window.location.href;

    // Check if the URL already has parameters
    var urlParts = currentUrl.split('?');
    var baseUrl = urlParts[0];
    var params = urlParts[1] ? urlParts[1].split('&') : [];

    // Update or add the "ret-msg" parameter with the provided message
    for (var i = 0; i < params.length; i++) {
        var param = params[i].split('=');
        if (param[0] === 'ret-msg') {
            retMsgFound = true;
            params.splice(i, 1);
            break;
        }
    }

    // Construct the updated URL
    var updatedUrl = baseUrl + (params.length > 0 ? '?' + params.join('&') : '');

    // Reload the page with the updated URL
    window.location.href = updatedUrl;
}