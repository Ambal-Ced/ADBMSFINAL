document.addEventListener('DOMContentLoaded', function() {
    const navLinks = document.querySelectorAll('.menu-links li a');


    navLinks.forEach(link => {
        link.addEventListener('click', function(event) {
            // Check if the href starts with a #
            if (this.getAttribute('href').startsWith('#')) {
                // Prevent the default action
                event.preventDefault();

                // Get the target section ID from the clicked link's href attribute
                const targetId = this.getAttribute('href');

                // Find the target section
                const targetSection = document.querySelector(targetId);

                // If the target section exists, scroll to it smoothly
                if (targetSection) {
                    targetSection.scrollIntoView({ behavior: 'smooth' });
                }
            }
        });
    });

    document.getElementById('dlpic').addEventListener('click', function(event) {
        event.preventDefault();
        console.log('Download button clicked');
    });

    // Check if the current URL contains a specific query parameter indicating a redirect from booking.html
    const urlParams = new URLSearchParams(window.location.search);
    const redirectFromBooking = urlParams.get('redirectFromBooking');

    if (redirectFromBooking === 'true') {
        // Redirect to index.html and scroll to the Download section
        window.location.href = 'index.html#download-section';
    }
});


function DownloadPage() {
    document.getElementById("down-section").scrollIntoView({ behavior: 'smooth' });
}




