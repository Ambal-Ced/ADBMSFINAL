//for booking
document.querySelectorAll('.option').forEach(function(option) {
    option.addEventListener('click', function(event) {
        event.preventDefault();
        document.getElementById('selectedOption').value = this.textContent;
        document.getElementById('options').classList.add('options-hidden');
    });
});

document.getElementById('showOptions').addEventListener('click', function() {
    // Assuming you have a way to toggle the visibility of the products
    var options = document.getElementById('options');
    options.classList.toggle('options-hidden');
});



document.querySelectorAll('.option').forEach(function(option) {
    option.addEventListener('click', function(event) {
        event.preventDefault();
        document.getElementById('selectedOption').value = this.textContent;
        document.getElementById('productvalues').value = this.textContent.match(/\d+$/)[0]; // Extract the last number as product value
        document.getElementById('options').classList.add('options-hidden');
    });
});

document.querySelectorAll('.option').forEach(function(option) {
    option.addEventListener('click', function(event) {
        event.preventDefault();
        document.getElementById('selectedOption').value = this.textContent;
        // Extract the data-value attribute and set it as the value of the hidden input field
        document.getElementById('productvalues').value = this.getAttribute('data-value');
        document.getElementById('options').classList.add('options-hidden');
    });
});
