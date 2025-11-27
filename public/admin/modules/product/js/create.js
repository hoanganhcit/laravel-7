/*
*
* Product create
*
* author: TriVH
* Modules: Admin\Product
*
*/


$(document).ready(function () {
	initialize();
	initEvent();
});


function initialize() {
	$('#lfm_thumbnail').filemanager('image', {prefix: '/Laravel-7/laravel-filemanager'});
	$('#lfm_galleries').filemanager('image', {prefix: '/Laravel-7/laravel-filemanager', allow_multiple: true});

	var editor_config = {
		path_absolute: "/",
		selector: ".content",
		plugins: [
		"advlist autolink lists link image charmap print preview hr anchor pagebreak",
		"searchreplace wordcount visualblocks visualchars code fullscreen",
		"insertdatetime media nonbreaking save table contextmenu directionality",
		"emoticons template paste textcolor colorpicker textpattern"
		],
		menubar: false,
		toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
		relative_urls: false,
		file_browser_callback: function(field_name, url, type, win) {
			var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName(
				'body')[0].clientWidth;
			var y = window.innerHeight || document.documentElement.clientHeight || document
			.getElementsByTagName('body')[0].clientHeight;

			var cmsURL = editor_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;
			if (type == 'image') {
				cmsURL = cmsURL + "&type=Images";
			} else {
				cmsURL = cmsURL + "&type=Files";
			}

			tinyMCE.activeEditor.windowManager.open({
				file: cmsURL,
				title: 'Filemanager',
				width: x * 0.8,
				height: y * 0.8,
				resizable: "yes",
				close_previous: "no"
			});
		}
	};

	tinymce.init(editor_config);
}

function initEvent() {

	$(function() {
            // $('[data-toggle="tooltip"]').tooltip();

            $('input[name="date_discount_period"]').daterangepicker({
            	timePicker: true,
            	startDate: moment().startOf('hour'),
            	endDate: moment().startOf('hour').add(32, 'hour'),
            	locale: {
            		format: 'YYYY-MM-DD hh:mm A'
            	}
            });
        });
	$("#sale_product").change(function() {
		if (this.checked) {
			$('#sale_product_form').show();
		} else {
			$('#sale_product_form').hide();
		}
	});
	$("#featured_product").change(function() {
		if (this.checked) {
			$(this).attr('value', '1');
		} else {
			$(this).attr('value', '0');
		}
	});
	$("#new_arrival").change(function() {
		if (this.checked) {
			$(this).attr('value', '1');
		} else {
			$(this).attr('value', '0');
		}
	});
	$("#on_sale").change(function() {
		if (this.checked) {
			$(this).attr('value', '1');
		} else {
			$(this).attr('value', '0');
		}
	});
	$('#discount').on('keyup', function() {
		var price = $('#price').val();
		var discount = $('#discount').val();
		var discount_price = (price * (100 - discount)) / 100;
		$('#discount_price').attr('value', discount_price);
	});
}
// Jquery Dependency

$("input[data-type='currency']").on({
    keyup: function() {
      formatCurrency($(this));
    }
});


function formatNumber(n) {
  return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
}


function formatCurrency(input) {

  var input_val = input.val();

  if (input_val === "") { return; }

  // check for decimal
  if (input_val.indexOf(".") >= 0) {
    var left_side = input_val.substring(0);
    left_side = formatNumber(left_side);

  } else {
    input_val = formatNumber(input_val);

  }

  input.val(input_val);

}


