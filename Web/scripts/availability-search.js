function AvailabilitySearch(options)
{
    var elements = {
        searchForm: $('#searchForm'),
        availabilityResults: $('#availability-results')
    };

    var init = function()
    {
        ConfigureAsyncForm(elements.searchForm, function(){elements.availabilityResults.empty()}, showSearchResults);
        elements.availabilityResults.on('click', '.opening', function(e){
            var opening = $(this);
            window.location = options.reservationUrlTemplate
                .replace('[rid]', encodeURIComponent(opening.data('resourceid')))
                .replace('[sd]', encodeURIComponent(opening.data('startdate')))
                .replace('[ed]', encodeURIComponent(opening.data('enddate')));
        })
    };

    var showSearchResults = function(data)
    {
        elements.availabilityResults.empty().html(data);
        elements.availabilityResults.find('.resourceName').each(function () {
            var resourceId = $(this).attr("data-resourceId");
            $(this).bindResourceDetails(resourceId, {position: 'left top'});
        });
    };

    return {init:init};
}