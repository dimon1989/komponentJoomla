
jQuery(document).ready(function ($) {

    var valid = false;

    $('#title').on('blur', function() {
        var input = $(this);
        var name_length = input.val().length;
        if(name_length >= 2 && name_length <= 30){
            input.removeClass("invalid").addClass("valid");
            valid = true;
        }
        else{
            input.removeClass("valid").addClass("invalid")
            valid = false;
        }
    });

    $('#author').on('blur', function() {
        var input = $(this);
        var name_length = input.val().length;
        if(name_length >= 2 && name_length <= 30){
            input.removeClass("invalid").addClass("valid");
            valid = true;
        }
        else{
            input.removeClass("valid").addClass("invalid")
            valid = false;
        }
    });

    $('#publisher').on('blur', function() {
        var input = $(this);
        var name_length = input.val().length;
        if(name_length >= 2 && name_length <= 20){
            input.removeClass("invalid").addClass("valid");
            valid = true;
        }
        else{
            input.removeClass("valid").addClass("invalid")
            valid = false;
        }
    });

    $('#category').on('blur', function() {
        var input = $(this);
        var name_length = input.val().length;
        if(name_length >= 2 && name_length <= 15){
            input.removeClass("invalid").addClass("valid");
            valid = true;
        }
        else{
            input.removeClass("valid").addClass("invalid")
            valid = false;
        }
    });

    $('#year').on('blur', function() {
        var input = $(this);
        var name_length = input.val().length;
        if(name_length == 4){
            input.removeClass("invalid").addClass("valid");
            valid = true;
        }
        else{
            input.removeClass("valid").addClass("invalid")
            valid = false;
        }
    });



    //Po próbie wysłania formularza
    $('#submit').click(function(event){


        if(valid == true){

        }
        else {
            event.preventDefault();
            alert("Uzupełnij wszystkie pola!");
        }
    });
});
