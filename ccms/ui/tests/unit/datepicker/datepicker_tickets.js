/*
 * datepicker_tickets.js
 */
(function($) {

module("datepicker: tickets", {
	teardown: function() {
		stop();
		setTimeout(start, 13);
	}
});

// http://forum.jquery.com/topic/several-breaking-changes-in-jquery-ui-1-8rc1
test('beforeShowDay-getDate', function() {
	var inp = init('#inp', {beforeShowDay: function(date) { inp.datepicker('getDate'); return [true, '']; }});
	var dp = $('#ui-datepicker-div');
	inp.val('01/01/2010').datepicker('show');
	// contains non-breaking space
	equals($('div.ui-datepicker-title').text(), 'January 2010', 'Initial month');
	$('a.ui-datepicker-next', dp).click();
	$('a.ui-datepicker-next', dp).click();
	// contains non-breaking space
	equals($('div.ui-datepicker-title').text(), 'March 2010', 'After next clicks');
	inp.datepicker('hide').datepicker('show');
	$('a.ui-datepicker-prev', dp).click();
	$('a.ui-datepicker-prev', dp).click();
	// contains non-breaking space
	equals($('div.ui-datepicker-title').text(), 'November 2009', 'After prev clicks');
	inp.datepicker('hide');
});

test('Ticket 7602: Stop datepicker from appearing with beforeShow event handler', function(){
    var inp = init('#inp',{
        beforeShow: function(){
            return false;
        }
    });
	var dp = $('#ui-datepicker-div');
    inp.datepicker('show');
    equals(dp.css('display'), 'none',"beforeShow returns false");
    inp.datepicker('destroy');
    
    inp = init('#inp',{
        beforeShow: function(){
        }
    });
    dp = $('#ui-datepicker-div');
    inp.datepicker('show');
    equal(dp.css('display'), 'block',"beforeShow returns nothing");
	inp.datepicker('hide');
    inp.datepicker('destroy');
    
    inp = init('#inp',{
        beforeShow: function(){
            return true;
        }
    });
    dp = $('#ui-datepicker-div');
    inp.datepicker('show');
    equal(dp.css('display'), 'block',"beforeShow returns true");
	inp.datepicker('hide');
    inp.datepicker('destroy');
});

test('Ticket 6827: formatDate day of year calculation is wrong during day lights savings time', function(){
    var time = $.datepicker.formatDate("oo", new Date("2010/03/30 12:00:00 CDT")); 
    equals(time, "089");
});

test('Ticket #7244: date parser does not fail when too many numbers are passed into the date function', function() {
    expect(1);
    try{
        var date = $.datepicker.parseDate('dd/mm/yy', '18/04/19881');
    }catch(e){
        ok("invalid date detected");
    }
});

})(jQuery);