/**
 * Set the datepicker values
 */
var defaultDateFormat = s_message["date_format_js"];
$(function() {
	var dates = $("#adr-date-left, #adr-date-right").datepicker({
		showOn: 'both', // use to enable both calendar button and textbox
        buttonImage: '/core/img/calendar.gif',
        buttonImageOnly: true,
        buttonText: s_message['show_calendar'],
        numberOfMonths: 1,           
        changeMonth: false, // must be disabled when using maxDate
        changeYear: false,
        maxDate: '+0',
        showButtonPanel: false,
        dateFormat: defaultDateFormat,
        onSelect: function(selectedDate) {
              var option = this.id == "adr-date-left" ? "minDate" : "maxDate";
              var instance = $(this).data("datepicker");
              var date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat, selectedDate, instance.settings);
              dates.not(this).datepicker("option", option, date);
        }
	});

	//$('#adr-date-left').datepicker('setDate',  - s_message['adr_track_default_days']);
	//$('#adr-date-right').datepicker('setDate', '+0');
});

/**
 * Reset to default values the datepickers
 */
function resetDateFields(){
	$('#adr-date-left').datepicker('setDate',  - s_message['adr_track_default_days']);
	$('#adr-date-right').datepicker('setDate', '+0');
}