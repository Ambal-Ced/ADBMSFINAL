document.addEventListener('DOMContentLoaded', function() {

    function hideAllFormsAndButtons() {
        // Hide all forms and buttons
        document.getElementById('emailEditForm').style.display = 'none';
        document.getElementById('passwordEditForm').style.display = 'none';
        document.getElementById('deleteAccountForm').style.display = 'none';

        // Hide all buttons
        document.getElementById('editEmailBtn').style.display = 'none';
        document.getElementById('editPasswordBtn').style.display = 'none';
        document.getElementById('deleteAccountBtn').style.display = 'none';

        // Hide all h4 and p elements
        document.querySelectorAll('h4, p').forEach(function(element) {
            element.style.display = 'none';
        });

        // Adjust the container's style
        var contElement = document.querySelector('.cont');
        contElement.style.marginTop = '-10%';
        contElement.style.fontSize = '1.4rem';
    }

    // Event listeners for each button
    document.getElementById('editEmailBtn').addEventListener('click', function() {
        hideAllFormsAndButtons();
        document.getElementById('emailEditForm').style.display = 'block';
        document.getElementById('editEmailBtn').style.display = 'none';
    });

    document.getElementById('editPasswordBtn').addEventListener('click', function() {
        hideAllFormsAndButtons();
        document.getElementById('passwordEditForm').style.display = 'block';
        document.getElementById('editPasswordBtn').style.display = 'none';
    });

    document.getElementById('deleteAccountBtn').addEventListener('click', function() {
        hideAllFormsAndButtons();
        document.getElementById('deleteAccountForm').style.display = 'none';
        document.getElementById('deleteAccountBtn').style.display = 'none';
    });

});
