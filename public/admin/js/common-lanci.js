/*
*
* Common lanci JS
*
* author: TriVH
* Modules: Admin
*
*/


$(document).ready(function () {
	__initialize();
	__initEvent();
});


function __initialize() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
}

function __initEvent() {

}
