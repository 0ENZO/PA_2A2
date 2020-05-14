/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import '../css/app.scss';

// Need jQuery? Install it with "yarn add jquery", then uncomment to import it.
import $ from 'jquery';

require('bootstrap');
require('@fortawesome/fontawesome-free/js/all.js');


// confirm delete modal in franchises.html.twig
$('[data-toggle="modal"][title]').tooltip();

$('#delete_franchise').on('show.bs.modal', function(e) {
    $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
});

$(function () {
    $('[data-toggle="tooltip"]').tooltip()
})


