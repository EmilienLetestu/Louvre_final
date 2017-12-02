/**
 * Created by Emilien on 04/05/2017.
 */
$(document).ready(function() {

    var spinner = $('#processing');
    spinner.hide();
    var url = window.location.href;
    var url_split = url.split('/');
    if (url_split[5] == 'payer-commande')
    {
        //remove key to commit
        var key = '';
    }
    else
    {   //remove key to commit
        var key = '';
    }

    Stripe.setPublishableKey(key);
    var $form      =   $('#payment_form');
    var card_input =   $('#card_data :input');
    var card_data  =   $('#card_data');
    $form.submit(function (e) {
        e.preventDefault();
        $form.find('button').prop('disabled',true);
            Stripe.card.createToken($form,function (status,response) {
            if (response.error) {
                $form.find('.errors').remove();
                card_data.prepend('<p class = "errors">Veuillez vérifier vos informations bancaires</p>');
                card_input.css({'border':'solid 1px #F54041'});
                $form.find('button').prop('disabled', false);
            } else {
                // token contains id, last4, and card type
                var token = response.id;
                // Insert the token into the form so it gets submitted to the server
                $('#stripe_form_stripeToken').val(token);
                $('#confirm').remove();
                // and re-submit
                $form.get(0).submit();
                $form.find('button').show();
                $form.find('button').hide();
                spinner.show();
            }
        });
    });
});
