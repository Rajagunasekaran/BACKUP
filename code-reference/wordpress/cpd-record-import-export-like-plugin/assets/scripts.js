jQuery(document).ready(function($) {
	function pad(n) {
		return (n < 10 ? '0' : '') + n;
	}
	/**
	 * handle export csv
	 */
	$(document).on('click', '#export_cpd_btn', function() {
		var $this = $(this);
		$.ajax({
			url: ajaxurl,
			type: 'POST',
			dataType: "json",
			data: {
				action: 'admin_imp_exp_cpd_csv',
				export: 'export_cpd'
			},
			beforeSend: function() {
				$('.export_csv_section .message').html('');
				$('.export_csv_section .loader').show();
				$this.prop('disabled', true);
			},
			success: function(data) {
				if (data.csv_data != undefined && data.csv_data != '') {
					var csv = data.csv_data;
					var uri = 'data:text/csv;charset=utf-8,' + encodeURIComponent(csv);
					var download_link = document.createElement('a');
					download_link.href = uri;
					var dt = new Date();
					var datetime = dt.getFullYear() + "" +
						pad(dt.getMonth() + 1) + "" +
						pad(dt.getDate());
					if (data.file_name != "") {
						download_link.download = data.file_name;
					} else {
						download_link.download = "CPD-Records-Export-" + datetime + ".csv";
					}
					/*document.body.appendChild(download_link);
					download_link.click();
					document.body.removeChild(download_link);*/
				}
				setTimeout(function() {
					$this.prop('disabled', false);
					$('.export_csv_section .loader').hide();
					$('.export_csv_section .message').html('<div class="info sucs">CPD Records successfully exported!</div>');
				}, 500);
			}
		});
	});

	/**
	 * handle import csv
	 */
	$(document).on('submit', '#upload_cpd_form', function(ev) {
		ev.preventDefault();
		var $this = $('#upload_cpd_btn');
		var fdata = new FormData($('#upload_cpd_form')[0]);
		fdata.append('action', 'admin_imp_exp_cpd_csv');
		$.ajax({
			url: ajaxurl,
			type: 'POST',
			data: fdata,
			dataType: "json",
			contentType: false,
			processData: false,
			beforeSend: function() {
				$('.import_csv_section .message').html('');
				$('.import_csv_section .loader').show();
				$this.prop('disabled', true);
			},
			success: function(data) {
				console.log(data);
				$this.prop('disabled', false);
				$('.import_csv_section .loader').hide();
				if (data.success != '' && data.success != undefined) {
					$('#upload_cpd_file').val('');
					$('.import_csv_section .message').html('<div class="info sucs">' + data.success + '</div>');
				}
				if (data.error != '' && data.error != undefined) {
					$('.import_csv_section .message').append('<div class="info err">' + data.error + '</div>');
				}
			},
			error: function(xhr, textStatus, errorThrown) {
				$this.prop('disabled', false);
				$('.import_csv_section .loader').hide();
				$('.import_csv_section .message').html('<div class="info err">' + xhr.responseText + '</div>');
				console.log(xhr, textStatus, errorThrown);
			}
		});
	});

	$(document).on('change', '#upload_cpd_file', function(e) {
		if ($(this).val()) {
			$('#upload_cpd_btn').prop("disabled", false);
		} else {
			$('#upload_cpd_btn').prop("disabled", true);
		}
		$('.import_csv_section .message').html('');
	});

	$(document).on('click', 'a#import_cpd_csv, a#export_cpd_csv', function(e) {
		var toggle = $(this).attr('data-toggle');
		$('.section-toggle').each(function(i, elem) {
			if (!$(elem).is(toggle)) {
				$(elem).slideUp('fast').removeClass("show");
			}
		});
		if (!$(toggle).hasClass('show')) {
			$(toggle).slideDown('fast').addClass('show');
		} else {
			$(toggle).slideUp('fast').removeClass('show');
		}
	});

});