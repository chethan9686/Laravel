$(function() {
    "use strict";
    $('.dropify').dropify();

    var drEvent = $('#dropify-event').dropify();
    drEvent.on('dropify.beforeClear', function(event, element) {
        return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
    });

    drEvent.on('dropify.afterClear', function(event, element) {
        alert('File deleted');
    });

    var drEvent1 = $('#dropify-event1').dropify();
    drEvent1.on('dropify.beforeClear', function(event, element) {
        return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
    });

    drEvent1.on('dropify.afterClear', function(event, element) {
        alert('File deleted');
    });
  
    var drEvent2 = $('#dropify-event2').dropify();
    drEvent1.on('dropify.beforeClear', function(event, element) {
        return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
    });

    drEvent2.on('dropify.afterClear', function(event, element) {
        alert('File deleted');
    });

    var drEvent3 = $('#dropify-event3').dropify();
    drEvent3.on('dropify.beforeClear', function(event, element) {
        return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
    });

    drEvent3.on('dropify.afterClear', function(event, element) {
        alert('File deleted');
    });

    var drEvent4 = $('#dropify-event4').dropify();
    drEvent4.on('dropify.beforeClear', function(event, element) {
        return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
    });

    drEvent4.on('dropify.afterClear', function(event, element) {
        alert('File deleted');
    });


    $('.dropify-fr').dropify({
        messages: {
            default: 'Glissez-déposez un fichier ici ou cliquez',
            replace: 'Glissez-déposez un fichier ou cliquez pour remplacer',
            remove: 'Supprimer',
            error: 'Désolé, le fichier trop volumineux'
        }
    });
});