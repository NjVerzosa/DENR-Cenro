$(document).ready(function () {
    $('#imageModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var image = button.data('image');

        var modal = $(this);
        modal.find('#id').val(id);
        modal.find('#modalImage').attr('src', 'Scanned/' + image);
    });
});