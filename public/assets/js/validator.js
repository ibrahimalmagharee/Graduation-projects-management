
(function(){
  'use strict';

  $(document).ready(function(){

  	let form = $('.bootstrap-form');

  	// On form submit take action, like an AJAX call
    $(form).submit(function(e){

        if(this.checkValidity() == false) {
            $(this).addClass('was-validated');
            e.preventDefault();
            e.stopPropagation();
        }

    });

    // On every :input focusout validate if empty
    $(':input').blur(function(){
    	let fieldType = this.id;

    	switch(fieldType){
    	    // personal validation
            case 'student_id':
                validateStudent_Id($(this));
                break;

            case 'name':
                validateName($(this));
                break;

            case 'email':
                validateEmail($(this));
                break;

            case 'specialization':
                validateSpecialization($(this));
                break;

            case 'level_four':
                validateLevel_Four($(this));
                break;

            case 'level_five':
                validateLevel_Five($(this));
                break;

            case 'telephone':
                validateTelephone($(this));
                break;

            case 'phone_J':
                validatePhone_J($(this));
                break;

            case 'phone_W':
                validatePhone_W($(this));
                break;

            case 'facebook':
                validateFacebook($(this));
                break;

            case 'home_place':
                validatebHome_place($(this));
                break;

            case 'qulification':
                validateQulification($(this));
                break;

            case 'job':
                validateJob($(this));
                break;

            case 'university':
                validateUniversity($(this));
                break;

    	}
	});


	// On every :input focusin remove existing validation messages if any
    $(':input').click(function(){

    	$(this).removeClass('is-valid is-invalid');

    });
    // radio button for status
    $(function() {
        $("#submit").click(function() {
          if($('input[type=radio][name=OrderStatus]:checked').length == 0)
          {
             alert("Please select atleast one");
             return false;
          }
          else
          {
              alert("radio button selected value: ");
          }
        });
    });





    // On every :input focusin remove existing validation messages if any
    $(':input').keydown(function(){

        $(this).removeClass('is-valid is-invalid');

    });

	// Reset form and remove validation messages
    $(':reset').click(function(){
        $(':input, :checked').removeClass('is-valid is-invalid');
    	$(form).removeClass('was-validated');
    });

  });



    // validate student

    function validateStudent_Id(thisObj){
        let fieldValue = thisObj.val();
        if (fieldValue.length == 8) {
            $(thisObj).addClass('is-valid');
        }
        else {
            $(thisObj).addClass('is-invalid');

        }



    }

    function validateName(thisObj){
        let fieldValue = thisObj.val();
        let pattern=/^[a-zA-Zء-ي\s]+$/i;
        if (  pattern.test(fieldValue) && fieldValue.length >= 10) {
            $(thisObj).addClass('is-valid');
        }
        else {
            $(thisObj).addClass('is-invalid');

        }



    }

    function validateEmail(thisObj) {
        let fieldValue = thisObj.val();
        let pattern = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i;

        if(pattern.test(fieldValue)) {
            $(thisObj).addClass('is-valid');
        } else {
            $(thisObj).addClass('is-invalid');
        }
    }

    function validateSpecialization(thisObj){
        let fieldValue = thisObj.val();
        if (fieldValue != "") {
            $(thisObj).addClass('is-valid');
        }
        else {
            $(thisObj).addClass('is-invalid');

        }



    }

    function validateStudent_name_A(thisObj){
        let fieldValue = thisObj.val();
        let pattern=/^[a-zA-Zء-ي\s]+$/i;
        if (  pattern.test(fieldValue) && fieldValue.length >= 10) {
            $(thisObj).addClass('is-valid');
        }
        else {
            $(thisObj).addClass('is-invalid');

        }



    }

    function validateStudent_name_E(thisObj){
        let fieldValue = thisObj.val();
        let pattern=/^[a-zA-Zء-ي\s]+$/i;
        if (  pattern.test(fieldValue) && fieldValue.length >= 10) {
            $(thisObj).addClass('is-valid');
        }
        else {
            $(thisObj).addClass('is-invalid');

        }



    }



    function validateBirthday(thisObj){
        let fieldValue = thisObj.val();
        if (fieldValue != "") {
            $(thisObj).addClass('is-valid');
        }
        else {
            $(thisObj).addClass('is-invalid');

        }



    }

    function validateTelephone(thisObj){
        let fieldValue = thisObj.val();
        let pattern = /(08)[123456789][0-9]{6}/;

        if ( pattern.test(fieldValue) && fieldValue.length == 9){
            $(thisObj).addClass('is-valid');
        } else {
            $(thisObj).addClass('is-invalid');
        }

    }

    function validatePhone_J(thisObj){
        let fieldValue = thisObj.val();
        let pattern = /(059)[123456789][0-9]{6}/;

        if ( pattern.test(fieldValue) && fieldValue.length == 10){
            $(thisObj).addClass('is-valid');
        } else {
            $(thisObj).addClass('is-invalid');
        }

    }

    function validatePhone_W(thisObj){
        let fieldValue = thisObj.val();
        let pattern = /(056)[123456789][0-9]{6}/;

        if ( pattern.test(fieldValue) && fieldValue.length == 10){
            $(thisObj).addClass('is-valid');
        } else {
            $(thisObj).addClass('is-invalid');
        }

    }



    function validateFacebook(thisObj){
        let fieldValue = thisObj.val();
        let pattern=/^(?:http(s)?:\/\/)?[\w.-]+(?:\.[\w\.-]+)+[\w\-\._~:/?#[\]@!\$&'\(\)\*\+,;=.]+$/i;
        if (  pattern.test(fieldValue) && fieldValue.length > 1) {
            $(thisObj).addClass('is-valid');
        }
        else {
            $(thisObj).addClass('is-invalid');

        }



    }

    function validatebHome_place(thisObj){
        let fieldValue = thisObj.val();
        let pattern=/^[a-zA-Zء-ي\s]+$/i;
        if (  pattern.test(fieldValue) && fieldValue.length >= 10) {
            $(thisObj).addClass('is-valid');
        }
        else {
            $(thisObj).addClass('is-invalid');

        }



    }

    function validateQulification(thisObj){
        let fieldValue = thisObj.val();
        let pattern=/^[a-zA-Zء-ي\s]+$/i;
        if (  pattern.test(fieldValue) && fieldValue.length >= 10) {
            $(thisObj).addClass('is-valid');
        }
        else {
            $(thisObj).addClass('is-invalid');

        }



    }

    function validateJob(thisObj){
        let fieldValue = thisObj.val();

        if (   fieldValue != "") {
            $(thisObj).addClass('is-valid');
        }
        else {
            $(thisObj).addClass('is-invalid');

        }



    }

    function validateUniversity(thisObj){
        let fieldValue = thisObj.val();
        let pattern=/^[a-zA-Zء-ي\s]+$/i;
        if (  pattern.test(fieldValue) && fieldValue.length >= 10) {
            $(thisObj).addClass('is-valid');
        }
        else {
            $(thisObj).addClass('is-invalid');

        }



    }


})();
