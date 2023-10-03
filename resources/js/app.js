require('./bootstrap');
document.addEventListener('DOMContentLoaded', function () {
    // Znajdź przycisk "Logout" i panel nawigacyjny
    var logoutButton = document.querySelector('#logout-button');
    var navigationPanel = document.querySelector('#navigation-panel');

    if (logoutButton && navigationPanel) {
        logoutButton.addEventListener('click', function () {
            // Tutaj dodaj kod do ukrywania lub pokazywania panelu nawigacyjnego
            if (navigationPanel.classList.contains('hidden')) {
                navigationPanel.classList.remove('hidden');
            } else {
                navigationPanel.classList.add('hidden');
            }
        });
    }
});
