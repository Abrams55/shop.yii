/*price range*/

 $('#sl2').slider();

    $('.catalog').dcAccordion({
        speed: 300
    });

    function showCart(cart){
        $('#cart .modal-body').html(cart);
        $('#cart').modal();
    }

    $('#cart .modal-body').on('click', '.del-item', function() {
        var id = $(this).data('id');

        $.ajax({
            url: '/cart/dell',
            data: {id: id},
            type: 'GET',
            success: function(data) {
                showCart(data);
            },
            error: function(){
                alert('Error!');
            }
        });
    });

    function get_cart() {
        
        $.ajax({
           url: '/cart/getcart',
           type: 'GET',
           success: function(data) {
              showCart(data);
           }
        });
        
        return false;
    }

    function clearCart(){
        $.ajax({
            url: '/cart/clear',
            type: 'GET',
            success: function(res){
                if(!res) alert('Ошибка!');
                showCart(res);
            },
            error: function(){
                alert('Error!');
            }
        });
    }

    $('.add-to-cart').on('click', function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        var qty = $('#product_qty').val();
        var qty_sidebar = Number($('.sidbar_qty').html());
        qty_sidebar ++;
        $('.sidbar_qty').html(qty_sidebar);
        $.ajax({
            url: '/cart/add',
            data: {id: id, qty: qty},
            type: 'GET',
            success: function(res){
                if(!res) alert('Ошибка!');
                showCart(res);
            },
            error: function(){
                alert('Error!');
            }
        });
    });

	var RGBChange = function() {
	  $('#RGB').css('background', 'rgb('+r.getValue()+','+g.getValue()+','+b.getValue()+')')
	};	
		
/*scroll to top*/

$(document).ready(function(){
	$(function () {
		$.scrollUp({
	        scrollName: 'scrollUp', // Element ID
	        scrollDistance: 300, // Distance from top/bottom before showing element (px)
	        scrollFrom: 'top', // 'top' or 'bottom'
	        scrollSpeed: 300, // Speed back to top (ms)
	        easingType: 'linear', // Scroll to top easing (see http://easings.net/)
	        animation: 'fade', // Fade, slide, none
	        animationSpeed: 200, // Animation in speed (ms)
	        scrollTrigger: false, // Set a custom triggering element. Can be an HTML string or jQuery object
					//scrollTarget: false, // Set a custom target element for scrolling to the top
	        scrollText: '<i class="fa fa-angle-up"></i>', // Text for element, can contain HTML
	        scrollTitle: false, // Set a custom <a> title if required.
	        scrollImg: false, // Set true to use image
	        activeOverlay: false, // Set CSS color to display scrollUp active point, e.g '#00FFFF'
	        zIndex: 2147483647 // Z-Index for the overlay
		});
	});
});


function cart_quantity_up(id) {
    var id = id;
    var quantyi =  Number($('#cart_quantity_input_' + id).val());
    var quantyi = quantyi + 1;
    $('#cart_quantity_input_' + id).val(quantyi);

    $.ajax({
        url: '/cart/update',
        type: 'GET',
        data: {id: id, qty_plus: quantyi},
        success: function(data) {
            $('#cart_total_price_' + id).html('$' + data['sum']);
            $('.cart_qty').html(data['cart_qty']);
            $('#cart_total_price_all').html('$' + data['cart_sum']);
        }
    });
    return false;
}


function cart_quantity_down(id) {
    var id = id;
    var quantyi =  Number($('#cart_quantity_input_' + id).val());
    if(quantyi > 1) {
    var quantyi = quantyi - 1;
    $('#cart_quantity_input_' + id).val(quantyi);
    
    $.ajax({
        url: '/cart/update',
        type: 'GET',
        data: {id: id, qty_minus: quantyi},
        success: function(data) {
            $('#cart_total_price_' + id).html('$' + data['sum']);
            $('.cart_qty').html(data['cart_qty']);
            $('#cart_total_price_all').html('$' + data['cart_sum']);
        }
    });
    } else {
        var quantyi = 1;
    }
    return false;
}



function quantity_delete(id) {
   var qty = Number($('#cart_quantity_input_' + id).val());
   var qty_all = Number($('.cart_qty').html());
   var sum = Number($('#cart_total_price_' + id).html().slice(1));
   var sum_all = Number($('#cart_total_price_all').html().slice(1));
   var reult = sum_all - sum;
   $('.cart_qty').html(qty_all - qty);
   $('#cart_total_price_all').html('$' + reult);
   
    $.ajax({
        url: '/cart/dell',
        type: 'POST',
        data: {id: id},
        success: function() {
            $('.cart_product_' + id).hide();
        },
        error: function(){
                alert('Error!');
            }
    });
    return false;
}