/**
 Copyright 2012 Nick Korbel

 This file is part of phpScheduleIt.

 phpScheduleIt is free software: you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation, either version 3 of the License, or
 (at your option) any later version.

 phpScheduleIt is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with phpScheduleIt.  If not, see <http://www.gnu.org/licenses/>.
 */

$.fn.bindResourceDetails = function(resourceId, options)
{
    var opts = $.extend({preventClick: false}, options);

    bindResourceDetails($(this));

    function bindResourceDetails(resourceNameElement) {
		if (opts.preventClick)
        {
            resourceNameElement.click(function(e) {
                e.preventDefault();
            });
        }

		resourceNameElement.qtip({
			position: {
				my: 'top left',  // Position my top left...
				at: 'bottom left', // at the bottom right of...
				target: resourceNameElement // my target
			},
			content: {
				text: 'Loading...',
				ajax: {
					url: "ajax/resource_details.php",
					type: 'GET',
					data: { rid: resourceId },
					dataType: 'html'
				}
			},
			show: {
                ready: true,
				delay: 500
			},
			style: {
                //classes: ''
				//classes: 'ui-tooltip-shadow ui-tooltip-blue',// resourceQtip',
                //width: 700
//				tip: {
//					corner: true
//				},
//                border: {
//                         width: 7,
//                         radius: 5
//                }
			},
			hide: {
				delay: 500
				//fixed: true,
				//when: 'mouseout'
			}
		});
	}
};