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

// slider pour le prix lors des recherchs produits 
import noUiSlider from 'nouislider'
import 'nouislider/distribute/nouislider.css'


// confirm delete modal in franchises.html.twig
$('[data-toggle="modal"][title]').tooltip();

$('#delete_franchise').on('show.bs.modal', function(e) {
    $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
});

$(function () {
    $('[data-toggle="tooltip"]').tooltip()
})

$('.collapse').collapse()



const slider = document.getElementById('price-slider');

if (slider) {
    const min = document.getElementById('min')
    const max = document.getElementById('max')
    const minValue = Math.floor(parseInt(slider.dataset.min, 10) / 10) * 10
    const maxValue = Math.ceil(parseInt(slider.dataset.max, 10) / 10) * 10
    const range = noUiSlider.create(slider, {
        start: [min.value || minValue, max.value || maxValue],
        connect: true,
        step: 10,
        range: {
            'min': minValue,
            'max': maxValue
        }
    })
    range.on('slide', function (values, handle) {
        if (handle === 0) {
            min.value = Math.round(values[0])
        }
        if (handle === 1) {
            max.value = Math.round(values[1])
        }
        console.log(values, handle)
    })
}



