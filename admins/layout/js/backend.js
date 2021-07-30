

    $(function(){

        // Add Astrisk On Required Field
        $('input').each(function(){


           if($(this).attr('required')==='required') {
               $(this).after("<span class='astrisk'>*</span>");
           }
        });


        // Category View Option

        $('.cat h3').click(function () {

            $(this).next('.full-view').fadeToggle(200);

        });
        
        
        // Options 
        
        $('.option span').click(function () {

            $(this).addClass('active').siblings('span').removeClass('active');

            if ($(this).data('view') === 'full') {

                $('.cat .full-view').fadeIn(200);

            } else {

                $('.cat .full-view').fadeOut(200);

            }

        });

    });

    /* Js Code On Input Of Password */

    let inputpassword = document.querySelector('.special-pass');

    function showPassword(){
         inputpassword.type ='text'; 
    }
    function hidePassword(){
         inputpassword.type ='password';

    }

    /*
    Confirmation Message On Delete Btn
    */

    // Dashboard
	// Dashboard 

	$('.toggle-info').click(function () {

		$(this).toggleClass('selected').parent().next('.panel-body').fadeToggle(100);

		if ($(this).hasClass('selected')) {

			$(this).html('<i class="fa fa-minus fa-lg"></i>');

		} else {

			$(this).html('<i class="fa fa-plus fa-lg"></i>');

		}

	});
    
    
    
    
    