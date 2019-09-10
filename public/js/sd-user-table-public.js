(function ($) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 */
	$(document).ready(function () {
		// Initialize Datatable jQuery Plugin with Role Filter
		$('#sd-user--table').DataTable({
			initComplete: function () {
				this.api().columns(2).every(function () {
					var column = this;
					var select = $('<select><option value="">Select Role</option></select>')
						.appendTo($('.sd-user--filters'))
						.on('change', function () {
							var val = $.fn.dataTable.util.escapeRegex(
								$(this).val()
							);

							column
								.search(val ? '^' + val + '$' : '', true, false)
								.draw();
						});

					column.data().unique().sort().each(function (d, j) {
						select.append('<option value="' + d + '">' + d + '</option>')
					});
				});
			}
		});
		// Default Username Ascending on role change
		$('.sd-user--filters select').on('change', function() {
			if(!$('.table__username').hasClass('sorting_asc')) {
				$('.table__username').click();
			}
		});

	});


})(jQuery);
