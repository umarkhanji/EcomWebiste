/*price range*/

if ($.fn.slider) {
    $('#sl2').slider();
}

var RGBChange = function () {
    $('#RGB').css('background', 'rgb(' + r.getValue() + ',' + g.getValue() + ',' + b.getValue() + ')')
};

/*scroll to top*/

$(document).ready(function () {
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

//Change Price and Stock with Size
$(document).ready(function(){
   $("#selSize").change(function(){
    var idSize = $(this).val();
    if(idSize ==""){
        return false;
    }
    $.ajax({
        type:'get',
         url:'/get-product-price',
        data:{idSize:idSize},
        success:function(resp){
        var arr = resp.split('#');
        $("#getPrice").html("INR "+arr[0]);
        $('#price').val(arr[0]);
        if(arr[1]==0){
            $("#cartButton").hide();
            $("#Availability").text("Out Of Stock");
        }else{
           $("#cartButton").show();
            $("#Availability").text("In Stock");
        }
        },error:function(){
            alert("Error"); 
        }
    });
   });
});


//Replace Main Image With 
$(document).ready(function(){
        $(".changeImage").click(function(){
      var image = $(this).attr('src');
        $(".mainImage").attr('src',image);
    });
});


        // Instantiate EasyZoom instances
        var $easyzoom = $('.easyzoom').easyZoom();

        // Setup thumbnails example
        var api1 = $easyzoom.filter('.easyzoom--with-thumbnails').data('easyZoom');

        $('.thumbnails').on('click', 'a', function(e) {
            var $this = $(this);

            e.preventDefault();

            // Use EasyZoom's `swap` method
            api1.swap($this.data('standard'), $this.attr('href'));
        });

        // Setup toggles example
        var api2 = $easyzoom.filter('.easyzoom--with-toggle').data('easyZoom');

        $('.toggle').on('click', function() {
            var $this = $(this);

            if ($this.data("active") === true) {
                $this.text("Switch on").data("active", false);
                api2.teardown();
            } else {
                $this.text("Switch off").data("active", true);
                api2._init();
            }
        });

$().ready(function(){
    $("#accountForm").validate({
        rules:{
            name:{
                required:true,
                minlength:2,
                accept:"[a-zA-Z]+"
            },
            address:{
                required:true,
                minlength:6
            },
            city:{
                required:true,
                minlength:6
            },
            state:{
                required:true,
                minlength:6
            },
            country:{
                required:true,
                minlength:6
            }
        },
        messages:{
            name:{
                required:"Please Enter Your Name",
                minlength:"Your name must be 2 char long",
                accept:"Your name must be char"
            },
            address:{
                 required:"Please Enter Your address",
                minlength:"Your name must be 2 char long"
            },
            city:{
                required:"Please Enter Your city",
                minlength:"Your name must be 2 char long"
            },
            state:{
                required:"Please Enter Your state",
                minlength:"Your name must be 2 char long"
            },
            country:{
                required:"Please Enter Your country"
            }
        }
    });

    //Check Current User password
    $("#current_pwd").keyup(function(){
      var  current_pwd = $(this).val();
      // alert(current_pwd);
      $.ajax({
            headers:{
             'X-CSRF-TOKEN':$('meta[name="csrf_token"]').attr('content')
            },
            type:'post',
            url:'check-user-pwd',
            data:{current_pwd:current_pwd},
            success:function(resp){
                alert(resp);
            },
            error:function(){
                alert("Error");
            }
      });
    });

    //Copy Shipping to Billing Address
    $("#billtoship").on('click',function(){
    if(this.checked){
       $("#shipping_name").val($("#billing_name").val());
       $("#shipping_address").val($("#billing_address").val());
       $("#shipping_city").val($("#billing_city").val());
       $("#shipping_state").val($("#billing_state").val());
       $("#shipping_country").val($("#billing_country").val());
       $("#shipping_pincode").val($("#billing_pincode").val());
       $("#shipping_mobile").val($("#billing_mobile").val());
       }else{
       $("#shipping_name").val('');
       $("#shipping_address").val('');
       $("#shipping_city").val('');
       $("#shipping_state").val('');
       $("#shipping_country").val('');
       $("#shipping_pincode").val('');
       $("#shipping_mobile").val('');

    }
    });
});

function selectPaymentMethod()
{
   if($('#Paypal').is(':checked')||$('#COD').is(':checked')){
    // alert('checked');
   }else
   {
      alert('Please Select Payment Method');
      return false;
   }
    
}