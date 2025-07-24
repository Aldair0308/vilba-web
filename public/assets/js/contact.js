$(document).ready(function(){
    
    (function($) {
        "use strict";

    
    jQuery.validator.addMethod('answercheck', function (value, element) {
        return this.optional(element) || /^\bcat\b$/.test(value)
    }, "type the correct answer -_-");

    // Get language from session or default to Spanish
    var currentLanguage = $('html').attr('lang') || 'es';
    
    // Check if there's a language indicator in the page
    if ($('body').find('[data-language]').length > 0) {
        currentLanguage = $('body').find('[data-language]').attr('data-language');
    }
    
    // Try to detect language from page content
    if ($('.contact-title').text().includes('Get in Touch')) {
        currentLanguage = 'en';
    } else if ($('.contact-title').text().includes('Ponte en Contacto')) {
        currentLanguage = 'es';
    }

    // Define validation messages in both languages
    var validationMessages = {
        en: {
            name: {
                required: "Come on, you have a name, don't you?",
                minlength: "Your name must consist of at least 2 characters"
            },
            subject: {
                required: "Come on, you have a subject, don't you?",
                minlength: "Your subject must consist of at least 4 characters"
            },
            number: {
                required: "Come on, you have a number, don't you?",
                minlength: "Your number must consist of at least 5 characters"
            },
            email: {
                required: "No email, no message",
                email: "Please enter a valid email address"
            },
            message: {
                required: "Um...yea, you have to write something to send this form.",
                minlength: "That's all? Really? Please write a longer message."
            }
        },
        es: {
            name: {
                required: "Vamos, tienes un nombre, ¿no es así?",
                minlength: "Tu nombre debe tener al menos 2 caracteres"
            },
            subject: {
                required: "Vamos, tienes un asunto, ¿no es así?",
                minlength: "Tu asunto debe tener al menos 4 caracteres"
            },
            number: {
                required: "Vamos, tienes un número, ¿no es así?",
                minlength: "Tu número debe tener al menos 5 caracteres"
            },
            email: {
                required: "Sin correo, sin mensaje",
                email: "Por favor ingresa una dirección de correo válida"
            },
            message: {
                required: "Um...sí, tienes que escribir algo para enviar este formulario.",
                minlength: "¿Eso es todo? ¿En serio? Por favor escribe un mensaje más largo."
            }
        }
    };

    // validate contactForm form
    $(function() {
        $('#contactForm').validate({
            rules: {
                name: {
                    required: true,
                    minlength: 2
                },
                subject: {
                    required: true,
                    minlength: 4
                },
                number: {
                    required: true,
                    minlength: 5
                },
                email: {
                    required: true,
                    email: true
                },
                message: {
                    required: true,
                    minlength: 20
                }
            },
            messages: validationMessages[currentLanguage],
            submitHandler: function(form) {
                $(form).ajaxSubmit({
                    type:"POST",
                    data: $(form).serialize(),
                    url:"contact_process.php",
                    success: function() {
                        $('#contactForm :input').attr('disabled', 'disabled');
                        $('#contactForm').fadeTo( "slow", 1, function() {
                            $(this).find(':input').attr('disabled', 'disabled');
                            $(this).find('label').css('cursor','default');
                            $('#success').fadeIn()
                            $('.modal').modal('hide');
		                	$('#success').modal('show');
                        })
                    },
                    error: function() {
                        $('#contactForm').fadeTo( "slow", 1, function() {
                            $('#error').fadeIn()
                            $('.modal').modal('hide');
		                	$('#error').modal('show');
                        })
                    }
                })
            }
        })
    })
        
 })(jQuery)
})