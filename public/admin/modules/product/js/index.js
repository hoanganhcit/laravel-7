/*
*
* Product index
*
* author: TriVH
* Modules: Admin\Product
*
*/


$(document).ready(function () {
    _initialize();
    _initEvent();
});


function _initialize() {

}

function _initEvent() {
    $(document).on("click", "#btn_add_variation", function(e) {
        _getNewVariationRender();
    });

    $(document).on("click", ".btn_variation_remove", function(e) {
        var parentDivBlock = $(this).parents('.variation-child');
        parentDivBlock.remove();
    });

    $(document).on("click", ".rad_is_default", function(e) {
        var parentDivBlock = $(this).parents('.variation-child');
        $('.variation-child').find('.hdn_is_default').each(function (idx, item) {
            $(item).val(0);
        });
        parentDivBlock.find('.hdn_is_default').val(1);
    });

    $(document).on("select2:select", ".select_product_attributes", function(e) {
        var parentDivBlock = $(this).parents('.variation-child');
        var url = parentDivBlock.find('option[value="' + e.params.data.id + '"]').attr("data-url");
        var keyCurrentVariation = parentDivBlock.find('option[value="' + e.params.data.id + '"]').attr("data-key_current_variation");
        _getAttributeListRender(parentDivBlock, url, keyCurrentVariation);
    });

    $(document).on("select2:unselect", ".select_product_attributes", function(e){
        var parentDivBlock = $(this).parents('.variation-child');
        parentDivBlock.find('.wrapper_attribute_' + e.params.data.id).remove();
    });

    $(document).on("click", ".attribute_remove", function(e) {
        var parentDivBlock = $(this).parents('.variation-child');
        var parentDivAttribute = $(this).data('parent_div');
        var attributeId = $(this).data('attribute_id');
        parentDivBlock.find('.' + parentDivAttribute).remove();

        var newArray = [];
        var attributeList = parentDivBlock.find('.select_product_attributes').select2('data');
        var newData = attributeList.filter(function (value) {
            return value.id != attributeId;
        });

        newData.forEach(function(data) {
            newArray.push(+data.id);
        });
        parentDivBlock.find('.select_product_attributes').val(newArray).trigger('change');
    });

    $(".variant-product").on("click", function() {
        if ($(this).is(":checked")) {
            $(".with-variant").removeClass("d-none");
        } else {
            $(".with-variant").addClass("d-none");
        }
    });
}

function _getAttributeListRender (parentDivBlock, url, keyCurrentVariation) {
    $.ajax({
        type: "POST",
        url: url,
        data: {
            keyCurrentVariation: keyCurrentVariation
        },
        dataType: "html",
        success: function(response) {
            parentDivBlock.find('.customer_choice_options').append(response);
            parentDivBlock.find('.select2').select2();
        },
        error: function(data) {},
    });
}

function _getNewVariationRender () {
    $keyCurrentVariation = $('#key_current_variation').val();
    $.ajax({
        type: "GET",
        url: "/admin/products/render-new-variation",
        data: {
            keyCurrentVariation: $keyCurrentVariation
        },
        dataType: "html",
        success: function(response) {
            $('#div_variation_child').append(response);
            $('#div_variation_child .select2').select2();
            $('#key_current_variation').val(parseInt($keyCurrentVariation) + 1);
        },
        error: function(data) {},
    });
}
