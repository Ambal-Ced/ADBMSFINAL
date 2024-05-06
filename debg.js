document.getElementById('submit').addEventListener('click', function(event) {
    var productValues = document.getElementById('productvalues').value;
    if (productValues === '') {
        event.preventDefault();
        alert('Please select a product.');
    }
});
