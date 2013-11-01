/**
 * This file contain form stuff
 */


/**
 * Make sure to add 'http://' on every empty url field
 * @param $scope
 */
function initUrlFields($scope) {
    $("form input[type='url']", $scope).focus(function () {
        if ($(this).val() == '') {
            $(this).val('http://');
        }
    })

        .blur(function () {
            //make sure we do not submit only 'http://'
            if ($(this).val() == 'http://') {
                $(this).val('');
            }
            else if ($(this).val().length > 0 && !$(this).val().match(/https?:\/\//)) {
                $(this).val('http://' + $(this).val());
            }
        });
}


/**
 * If it exists a form with confirmNavigation class on it, then we should ask the user if he is sure before
 * leaving tha page. (And if the form has been changed)
 *
 * @param $scope
 */
function initConfirmNavigationForm($scope) {
    $("form.confirmNavigation", $scope).submit(function () {
        //dont show when the form is submitted
        window.onbeforeunload = null;
    }).change(function (event) {
            window.onbeforeunload = function (event) {
                return trans.confirmNavigation;
            };

            $(this).unbind(event);
        });

}


/**
 * This function adds an event on the a.help. The event is to toggle the help text.
 *
 * @param Object $scope is where we should look for those links. This value may be undefined
 */
function activateHelpLinks($scope) {
    $('a.help', $scope).click(function (e) {
        if ($('a.help').attr('href') != '#' || $('a.help').attr('href') != '') {
            // do not stop propagation
        } else {
            e.stopPropagation();
        }
        // Show info of exists
        $(this).siblings('div.help').toggle();
        $(this).siblings('div.help').toggleClass('hidden');
        return false;
    });
}

/**
 * Activate select2
 *
 * @param $scope
 */
function initSelect2($scope) {
    /* Do this, to copy all data-* attributes from parent div to datetime selects */
    // Should probably be done in symfony
    $('.datetime_widget', $scope).children('select').not('[style="display:none"]').each(function (id, el) {
        $element = $(el);
        $element.data($element.parent().parent().data());
    });
    /* Select all that are not topnav, autocompleted or has a direct style display:none */
    // Please note, :visible / :hidden takes parents visibility into account
    $('select', $scope).not('#selectnav').not('.autocomplete').not('[style="display:none"]').each(function (id, el) {
        // If this is a date field select, then copy all data-* values to the select
        // Init select2
        $(el).select2({
            allowClear: true
        });
    });
}