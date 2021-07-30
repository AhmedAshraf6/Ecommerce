

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
        
        
	$('.live').keyup(function () {

		$($(this).data('class')).text($(this).val());

	});


    /*
    Confirmation Message On Delete Btn
    */


	});


    // Switch Between Login & SignUp

    let h1 = document.querySelector('.login-page h1');
    let span = document.querySelectorAll('.login-page h1 span');
    let login = document.querySelector('.login-page .login');
    let signup = document.querySelector('.login-page .signup');
    let hide  = document.querySelectorAll('.login-page  form');
    span.forEach(el =>{

    el.addEventListener('click',()=>{

          h1.querySelector('.selected').classList.remove('selected');    
          el.classList.add('selected');

          hide.forEach(h=>{

          h.style.display = 'none';

          });

            var n = '.'+el.dataset.class;
            document.querySelector(n).style.display='block';      
            
    });

 });

/*
// function onkeyup
let innn = document.querySelector('.login .live-user');
 function onKKK(){
    
    console.log('czx');
}

*/





    
    
    
    