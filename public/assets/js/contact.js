$(document).ready(function(){
    
    (function($) {
        "use strict";

    // Animated Notification System
    function showNotification(title, message, type = 'success', duration = 5000) {
        const container = $('#notification-container');
        const notificationId = 'notification-' + Date.now();
        
        const icon = type === 'success' ? '✓' : '✕';
        
        const notification = $(`
            <div id="${notificationId}" class="notification ${type}">
                <button class="notification-close" onclick="closeNotification('${notificationId}')">&times;</button>
                <div class="notification-icon">${icon}</div>
                <div class="notification-content">
                    <span class="notification-title">${title}</span>
                    <div class="notification-message">${message}</div>
                </div>
                <div class="notification-progress"></div>
            </div>
        `);
        
        container.append(notification);
        
        // Trigger animation
        setTimeout(() => {
            notification.addClass('show');
        }, 100);
        
        // Progress bar animation
        const progressBar = notification.find('.notification-progress');
        setTimeout(() => {
            progressBar.css({
                'width': '100%',
                'transition-duration': duration + 'ms'
            });
        }, 200);
        
        // Auto remove
        setTimeout(() => {
            closeNotification(notificationId);
        }, duration);
        
        return notificationId;
    }
    
    // Close notification function
    window.closeNotification = function(notificationId) {
        const notification = $('#' + notificationId);
        notification.removeClass('show');
        setTimeout(() => {
            notification.remove();
        }, 400);
    };

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
                // Add loading state to form
                $(form).addClass('form-loading');
                
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
                        // Remove loading state
                        $(form).removeClass('form-loading');
                        
                        if (response.success) {
                            // Show success notification
                            const successTitle = currentLanguage === 'en' ? 'Message Sent!' : '¡Mensaje Enviado!';
                            const successMessage = response.message || (currentLanguage === 'en' ? 
                                'Your message has been sent successfully! We\'ll get back to you soon.' : 
                                '¡Tu mensaje ha sido enviado exitosamente! Te responderemos pronto.');
                            
                            showNotification(successTitle, successMessage, 'success', 6000);
                            
                            $('#contactForm :input').attr('disabled', 'disabled');
                            $('#contactForm').fadeTo("slow", 1, function() {
                                $(this).find(':input').attr('disabled', 'disabled');
                                $(this).find('label').css('cursor','default');
                                
                                // Reset form after delay
                                setTimeout(function() {
                                    $('#contactForm')[0].reset();
                                    $('#contactForm :input').removeAttr('disabled');
                                    $('#contactForm').fadeTo("slow", 1);
                                }, 3000);
                            });
                        } else {
                            // Handle validation errors
                            const errorTitle = currentLanguage === 'en' ? 'Validation Error' : 'Error de Validación';
                            
                            if (response.errors) {
                                var errorMessage = '';
                                $.each(response.errors, function(field, messages) {
                                    errorMessage += messages.join('<br>') + '<br>';
                                });
                                showNotification(errorTitle, errorMessage, 'error', 8000);
                            } else {
                                const defaultError = response.message || (currentLanguage === 'en' ? 
                                    'There was an error sending your message.' : 
                                    'Hubo un error al enviar tu mensaje.');
                                showNotification(errorTitle, defaultError, 'error', 6000);
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        // Remove loading state
                        $(form).removeClass('form-loading');
                        
                        const errorTitle = currentLanguage === 'en' ? 'Connection Error' : 'Error de Conexión';
                        var errorMessage = currentLanguage === 'en' ? 
                            'There was an error sending your message. Please check your connection and try again.' : 
                            'Hubo un error al enviar tu mensaje. Por favor verifica tu conexión e intenta de nuevo.';
                        
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        
                        showNotification(errorTitle, errorMessage, 'error', 8000);
                        
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