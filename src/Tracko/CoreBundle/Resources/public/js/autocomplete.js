/**
 * Initiate autocomplete fields
 *
 * @param {Object} $scope
 */
function initAutocompleteFields($scope) {

    $("input.autocomplete", $scope).not(".select2-container").not(".select2-offscreen").each(function (id, el) {
        initAutocompleteElement(el);
    });

}

/**
 * Init Select2 autocomplete on given dom identifier
 *
 * @param el
 */
function initAutocompleteElement(el) {
    $element = $(el);

    // Save current text
    var currentText = $element.val();

    // Init select2
    $element.select2({
        minimumInputLength: 3,
        allowClear: true,
        createSearchChoice: function (term, data) {
            if (!$element.hasClass('no-create')) {
                if ($(data).filter(function () {
                    return this.text.localeCompare(term) === 0;
                }).length === 0) {
                    return {id: term, text: term};
                }
            }
        },
        ajax: {
            url: $element.attr('data-autocomplete-url'),
            dataType: 'json',
            data: function (term, page) {
                return {
                    term: term
                };
            },
            results: function (data, page) { // parse the results into the format expected by Select2.
                var results = [];
                for (var i = 0, suggestion; suggestion = data[i]; i++) {
                    results.push({id: suggestion, text: suggestion});
                }
                return {results: results};
            }
        }
    });

    // Set current text as selected value
    if (currentText != '') {
        $element.select2('data', {id: currentText, text: currentText});
    }
}


function initSelect2GoogleMaps($scope) {
    // Enable for google-autocomplete
    // Create a dom element for jQuery.data
    // It is shared between multiple fields on each page
    $('.body').append('<div id="gmaps" style="display:none;"></div>');

    jQuery('input.google-autocomplete', $scope).each(function (id, el) {
        var $element = $(el);

        // Save current text
        var currentText = $element.val();

        // Init select2
        $(el).select2({
            minimumInputLength: 3,
            allowClear: true,
            query: function (query) {
                // Create the Autocomplete service
                var service = new google.maps.places.AutocompleteService();
                // This call saves results in jQuery.data field
                service.getPlacePredictions({
                    input: query.term,
                    //componentRestrictions: {country: 'se'},
                    types: [$(el).attr('data-google-autocomplete-type')]
                }, gmapsCallback);
                var data = {results: []};
                // Load results via jQuery.data
                data.results = $('#gmaps').data('results');
                query.callback(data);
            }
        });

        // Set current text as selected value
        if (currentText != '') {
            $element.select2('data', {id: currentText, text: currentText});
        }
    });
}

/**
 * Callback function to manage results from gmaps api
 *
 * @param predictions
 * @param status
 */
function gmapsCallback(predictions, status) {

    if (status != google.maps.places.PlacesServiceStatus.OK) {
        return;
    }
    var results = [];
    for (var i = 0, prediction; prediction = predictions[i]; i++) {
        results.push({id: prediction.description, text: prediction.description});
    }
    // Save results with jQuery.data
    $('#gmaps').data('results', results);
};