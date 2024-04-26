//for booking

document.getElementById('showOptions').addEventListener('click', function() {
    document.getElementById('options').classList.toggle('options-hidden');
});

document.querySelectorAll('.option').forEach(function(option) {
    option.addEventListener('click', function(event) {
        event.preventDefault();
        document.getElementById('selectedOption').value = this.textContent;
        document.getElementById('options').classList.add('options-hidden');
    });
});