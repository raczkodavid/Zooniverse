let darkmode = localStorage.getItem('darkmode');
const themeToggle = document.querySelector('#theme-switch');
const navbarToggler = document.querySelector('.navbar-toggler');

// Apply dark mode on page load if enabled
if (darkmode === 'enabled') {
    document.body.classList.add('darkmode');
}

themeToggle.addEventListener('click', () => {
    darkmode !== 'enabled' ? enableDarkMode() : disableDarkMode();
});

const enableDarkMode = () => {
    document.body.classList.add('darkmode');
    localStorage.setItem('darkmode', 'enabled');
    darkmode = 'enabled';
    navbarToggler.classList.add('navbar-dark');
};

const disableDarkMode = () => {
    document.body.classList.remove('darkmode');
    localStorage.setItem('darkmode', 'disabled'); // Change `null` to `'disabled'`
    darkmode = 'disabled';
    navbarToggler.classList.remove('navbar-dark');
};
