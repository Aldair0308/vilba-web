// Sistema de Internacionalización para Grúas Vilba
// Detección automática de ubicación y cambio de idiomas

class I18nManager {
    constructor() {
        this.currentLang = 'es'; // Idioma por defecto
        this.translations = {
            es: {
                // Navegación
                home: 'Inicio',
                about: 'Nosotros',
                projects: 'Proyectos',
                services: 'Servicios',
                blog: 'Blog',
                blog_detail: 'Detalle del Blog',
                pages: 'Páginas',
                elements: 'Elementos',
                project_detail: 'Detalle del Proyecto',
                service_detail: 'Detalle del Servicio',
                contact: 'Contacto',
                contact_btn: 'Contáctanos',
                language: 'Idioma',
                
                // Logo alt text
                logo_alt: 'Logo de Grúas Vilba',
                
                // Otros textos comunes
                loading: 'Cargando...',
                error: 'Error',
                success: 'Éxito'
            },
            en: {
                // Navigation
                home: 'Home',
                about: 'About Us',
                projects: 'Projects',
                services: 'Services',
                blog: 'Blog',
                blog_detail: 'Blog Detail',
                pages: 'Pages',
                elements: 'Elements',
                project_detail: 'Project Detail',
                service_detail: 'Service Detail',
                contact: 'Contact',
                contact_btn: 'Contact Us',
                language: 'Language',
                
                // Logo alt text
                logo_alt: 'Vilba Cranes Logo',
                
                // Other common texts
                loading: 'Loading...',
                error: 'Error',
                success: 'Success'
            }
        };
        
        this.init();
    }
    
    async init() {
        // Detectar ubicación del usuario
        await this.detectUserLocation();
        
        // Configurar rutas de banderas
        this.flagPaths = {
            'es': '/assets/images/flags/mx.svg',
            'en': '/assets/images/flags/us.svg'
        };
        
        // Verificar si estamos en un entorno Laravel
        const baseUrl = window.location.origin;
        this.flagPaths = {
            'es': `${baseUrl}/assets/images/flags/mx.svg`,
            'en': `${baseUrl}/assets/images/flags/us.svg`
        };
        
        // Configurar el selector de idioma
        this.setupLanguageSelector();
        
        // Aplicar traducciones iniciales
        this.applyTranslations();
        
        // Configurar eventos
        this.setupEventListeners();
    }
    
    async detectUserLocation() {
        // Primero verificar si hay un idioma guardado en localStorage
        const savedLang = localStorage.getItem('vilba_language');
        if (savedLang && (savedLang === 'es' || savedLang === 'en')) {
            this.currentLang = savedLang;
            console.log(`Idioma cargado desde localStorage: ${this.currentLang}`);
            return;
        }
        
        try {
            // Si no hay idioma guardado, intentar detectar por ubicación
            const response = await fetch('https://ipapi.co/json/');
            const data = await response.json();
            
            // Si el usuario está en México, usar español; si no, inglés
            if (data.country_code === 'MX') {
                this.currentLang = 'es';
            } else {
                this.currentLang = 'en';
            }
            
            // Guardar la detección automática en localStorage
            localStorage.setItem('vilba_language', this.currentLang);
            console.log(`Idioma detectado automáticamente: ${this.currentLang}`);
            
        } catch (error) {
            console.warn('No se pudo detectar la ubicación, usando español por defecto:', error);
            this.currentLang = 'es';
            localStorage.setItem('vilba_language', this.currentLang);
        }
    }
    
    setupLanguageSelector() {
        // Actualizar la apariencia visual del selector según el idioma actual
        const languageOptions = document.querySelectorAll('.language-option');
        
        languageOptions.forEach(option => {
            const optionLang = option.getAttribute('data-lang');
            if (optionLang === this.currentLang) {
                // Marcar visualmente la opción activa
                option.style.fontWeight = 'bold';
                option.style.backgroundColor = 'rgba(255, 255, 255, 0.1)';
            } else {
                option.style.fontWeight = 'normal';
                option.style.backgroundColor = 'transparent';
            }
        });
        
        console.log(`Idioma actual configurado: ${this.currentLang}`);
    }
    
    setupEventListeners() {
        // Eventos para el selector de idioma
        const languageOptions = document.querySelectorAll('.language-option');
        languageOptions.forEach(option => {
            option.addEventListener('click', (e) => {
                e.preventDefault();
                const selectedLang = e.currentTarget.getAttribute('data-lang');
                this.changeLanguage(selectedLang);
            });
        });
    }
    
    changeLanguage(newLang) {
        if (newLang !== this.currentLang && (newLang === 'es' || newLang === 'en')) {
            this.currentLang = newLang;
            
            // Guardar en localStorage
            localStorage.setItem('vilba_language', newLang);
            
            // Actualizar el selector
            this.setupLanguageSelector();
            
            // Aplicar nuevas traducciones
            this.applyTranslations();
            
            console.log(`Idioma cambiado a: ${newLang}`);
        }
    }
    
    applyTranslations() {
        const elementsToTranslate = document.querySelectorAll('[data-translate]');
        
        elementsToTranslate.forEach(element => {
            const key = element.getAttribute('data-translate');
            const translation = this.translations[this.currentLang][key];
            
            if (translation) {
                element.textContent = translation;
            }
        });
        
        // Actualizar alt text de los logos
        const logoBig = document.getElementById('logo-big');
        const logoSmall = document.getElementById('logo-small');
        
        if (logoBig) {
            logoBig.alt = this.translations[this.currentLang].logo_alt;
        }
        
        if (logoSmall) {
            logoSmall.alt = this.translations[this.currentLang].logo_alt;
        }
        
        // Actualizar el título de la página
        const currentTitle = document.title;
        if (this.currentLang === 'en' && !currentTitle.includes('Vilba Cranes')) {
            document.title = currentTitle.replace('Grúas Vilba', 'Vilba Cranes');
        } else if (this.currentLang === 'es' && !currentTitle.includes('Grúas Vilba')) {
            document.title = currentTitle.replace('Vilba Cranes', 'Grúas Vilba');
        }
        
        console.log(`Traducciones aplicadas para idioma: ${this.currentLang}`);
    }
    
    // Método público para obtener una traducción específica
    translate(key) {
        return this.translations[this.currentLang][key] || key;
    }
    
    // Método público para obtener el idioma actual
    getCurrentLanguage() {
        return this.currentLang;
    }
    
    // Método público para agregar nuevas traducciones
    addTranslations(lang, translations) {
        if (this.translations[lang]) {
            this.translations[lang] = { ...this.translations[lang], ...translations };
        } else {
            this.translations[lang] = translations;
        }
    }
}

// Inicializar el sistema de internacionalización cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', function() {
    // Crear instancia global del manager de i18n
    window.i18nManager = new I18nManager();
    
    // Debug: verificar que los elementos existen
    console.log('Elementos del selector de idioma:');
    console.log('language-options:', document.querySelectorAll('.language-option'));
    console.log('Sistema de i18n inicializado correctamente');
});

// Exportar para uso en otros módulos si es necesario
if (typeof module !== 'undefined' && module.exports) {
    module.exports = I18nManager;
}