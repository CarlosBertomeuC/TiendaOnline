document.addEventListener('DOMContentLoaded', function() {
    const userIcon = document.getElementById('user-icon');
    const userMenu = document.getElementById('user-menu');

    userIcon.addEventListener('click', function() {
        userMenu.style.display = userMenu.style.display === 'block' ? 'none' : 'block';
    });

    document.addEventListener('click', function(event) {
        if (!userIcon.contains(event.target) && !userMenu.contains(event.target)) {
            userMenu.style.display = 'none';
        }
    });
});