document.addEventListener('DOMContentLoaded', () => {
    const urlSearchParams = new URLSearchParams(window.location.hash);
    const accessToken     = urlSearchParams.get('access_token');


    if (accessToken) {
        window.location.href = '/check?access_token=' + accessToken;
    } else {
        window.location.href = '/login';
    }
});