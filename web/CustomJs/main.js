/**
 * Created by Emilien on 21/04/2017.
 */

$(document).ready(function()
{
    //display information to user
    $(document).tooltip();
    //will reload on last know scroll position
    $.fn.scrollPosReaload = function(){
        if (localStorage) {
            var posReader = localStorage["posStorage"];
            if (posReader) {
                $(window).scrollTop(posReader);
                localStorage.removeItem("posStorage");
            }
            $(this).click(function(e) {
                localStorage["posStorage"] = $(window).scrollTop();
            });

            return true;
        }
        return false;
    };
    $('#test_date').scrollPosReaload();

    //home "datepicker" configuration
    $('.js-datepicker').datepicker
    ({
        dateFormat : 'dd-mm-yy',
        dayNamesMin: [ "Di", "Lu", "Ma", "Me", "Je", "Ve", "Sa" ],
        monthNames: ['Janvier','Février','Mars','Avril','Mai','Juin',
            'Juillet','Août','Septembre','Octobre','Novembre','Décembre'],
        minDate : 0,
        nextText:"Après",
        prevText:"Avant",
        maxDate : '31/12/2030',
        disable: "Sunday",
        //disable every tuesday and some french bank holidays
        beforeShowDay: function(date) {
            var day   = date.getDay();
            var date_string =  jQuery.datepicker.formatDate('dd-mm-yy', date);
            var change_date  =  date_string.split('-');
            var date_to_check =  change_date[0]+'-'+change_date[1];
            var bank_holidays = ["01-05","01-11","25-12"];
            return [ bank_holidays.indexOf(date_to_check) == -1 && day != 2]
        }
    });

    $(window).load(function()
    {
        // modify home page link to "reservation-billetterie"
        var tickets_in_order = $('#tickets_ordered').val();
        var link             = $('#link_to_booking');

        if (screen.width <= 767) {
            $('#info_pricing .pricing_type:even').prepend('<p style="color: orange">Journée</p>');
            $('#info_pricing .pricing_type:odd').prepend('<p style="color: orange">1/2 Journée</p>');
        }

        if(tickets_in_order !== "")
        {
            link.text("Retour à la commande").attr('style','color: #EC971F !important;border-color: #EC971F');
        }

        //check sales level and disable submit if it reach daily limit
        var reminder = $('#reminder').val();
        var sales    = $('#tickets_stock').val();
        var btn      = $('#submit_ticket');
        var access   = $('#time').val();
        var type     = $('#mod_time_access').val();
        var discount = $('#mod_discount').val();
        //if booking is for the current day and time is at least 2pm
        //=>remove full day ticket option
        if(access == 0)
        {
            $("#ticket_time_access ").find("option").eq(0).remove();
        }
        if(sales >= 1000)
        {
            btn.prop("disabled", true);
            $('#booking_title').append('<p id="no_more_tickets">Le musée est complet, vous ne pouvez plus ajouter de tickets à votre commande !</p>');
        }
        if(type == "journée complète")
        {
            $('#ticket_time_access').val("a.m.");
        }
        if(type == "1/2 journée")
        {
            $('#ticket_time_access').val("p.m.");
        }
        if(discount == 1 )
        {
            $('#ticket_discount').prop('checked',true);
        }
        //if daily limit is reached => message + modify button text
        var sold_out = $('#sold_out').val();
        if (sold_out == 1) {
            $('.form_btns').prepend('<p id="sold_out_message">Désolé tous le musée est complet à cette date !</p>').css({'color': ' #F54041'});
            $('#test_date').text('Essayer une autre date');
        }
        //pre-fill form with data to modify
        //get hidden input values
        var dob = $('#mod_dob').val();
        var split_dob =dob.split("-");
        //check if first digit is a 0
        var regex =/^(?!00[^0])0/;
        //fill date selectors
        $('#ticket_dob_day').val(split_dob[0].replace(regex, ''));
        $('#ticket_dob_month').val(split_dob[1].replace(regex, ''));
        $('#ticket_dob_year').val(split_dob[2]);

        $('#ticket_name').val($('#mod_name').val());
        $('#ticket_surname').val($('#mod_surname').val());

    });

    $('#test_date').click(function(e) {
        if($('#tickets_ordered').val() !== "" && $('#paid').val() == "")
        {
            var confirm_message = confirm("Annuler la commande en cours et tester cette date ?");
            if(!confirm_message)
            {
                return false
            }
        }
    });

    //check form value before submit
    $('.add').click(function(){
        var validate = true;
        var name    = $('#ticket_name').val();
        var surname = $('#ticket_surname').val();
        if(name.length < 3)
        {
            $('#ticket_name').css("border-color","#F54041");
            $('.invalid_name').show();
            validate = false;
        }
        else
        {
            $('.invalid_name').hide();
            $('#ticket_name').css("border-color","#ccc");
        }
        if(surname.length < 3)
        {
            $('#ticket_surname').css("border-color","#F54041");
            $('.invalid_surname').show();
            validate = false;
        }
        else
        {
            $('.invalid_surname').hide();
            $('#ticket_surname').css("border-color","#ccc")
        }
        return validate;
    });

    $('#form_section input').focusin(function(){

        $(this).val(' ');
    });

    $('#anchor_home').click(function(){
       $('#anchor_home').hide();
    });
    //close success flash message
    $('#close').on('click', function(e) {
        $('#success').remove();

    });


});