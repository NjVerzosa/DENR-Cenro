document.getElementById('importFile').addEventListener('change', function () {
    var fileInput = document.getElementById('importFile');
    var uploadMessage = document.getElementById('uploadMessage');

    if (fileInput.files.length > 0) {
        // Display a success message
        uploadMessage.innerHTML = '<p style="color: green;">File selected: ' + fileInput.files[0].name + '</p>';
    } else {
        // Display a warning message
        uploadMessage.innerHTML = '<p style="color: red;">Please select a excel file.</p>';
    }
});