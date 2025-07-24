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
                phone: {
                    required: false,
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
            messages: {
                name: {
                    required: "Please enter your name",
                    minlength: "Your name must consist of at least 2 characters"
                },
                subject: {
                    required: "Please enter a subject",
                    minlength: "Your subject must consist of at least 4 characters"
                },
                phone: {
                    minlength: "Your phone number must consist of at least 5 characters"
                },
                email: {
                    required: "Please enter a valid email"
                },
                message: {
                    required: "Please enter your message",
                    minlength: "Your message must consist of at least 20 characters"
                }
            },
            submitHandler: function(form) {
                // Get CSRF token
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                
                $(form).ajaxSubmit({
                    type: "POST",
                    data: $(form).serialize(),
                    url: $(form).attr('action'), // Use the form's action attribute
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#contactForm :input').attr('disabled', 'disabled');
                            $('#contactForm').fadeTo("slow", 1, function() {
                                $(this).find(':input').attr('disabled', 'disabled');
                                $(this).find('label').css('cursor','default');
                                
                                // Show success message
                                alert(response.message || (currentLanguage === 'en' ? 
                                    'Your message has been sent successfully!' : 
                                    '¡Tu mensaje ha sido enviado exitosamente!'));
                                
                                // Reset form
                                setTimeout(function() {
                                    $('#contactForm')[0].reset();
                                    $('#contactForm :input').removeAttr('disabled');
                                    $('#contactForm').fadeTo("slow", 1);
                                }, 2000);
                            });
                        } else {
                            // Handle validation errors
                            if (response.errors) {
                                var errorMessage = '';
                                $.each(response.errors, function(field, messages) {
                                    errorMessage += messages.join('\n') + '\n';
                                });
                                alert(errorMessage);
                            } else {
                                alert(response.message || (currentLanguage === 'en' ? 
                                    'There was an error sending your message.' : 
                                    'Hubo un error al enviar tu mensaje.'));
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        var errorMessage = currentLanguage === 'en' ? 
                            'There was an error sending your message. Please try again.' : 
                            'Hubo un error al enviar tu mensaje. Por favor intenta de nuevo.';
                        
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        
                        alert(errorMessage);
                        
                        $('#contactForm').fadeTo("slow", 1, function() {
                            // Re-enable form
                            $('#contactForm :input').removeAttr('disabled');
                        });
                    }
                });
            }
        })
    })
        
 })(jQuery)
})