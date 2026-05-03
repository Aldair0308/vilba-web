// Módulo de internacionalización que puede ser importado desde cualquier parte
// Uso: import { I18nManager } from './i18n-module.js';

export class I18nManager {
    constructor() {
        // Usar idioma inicial desde Laravel si está disponible
        this.currentLang = window.initialLanguage || 'es';
        console.log('🚀 I18nManager inicializado con idioma:', this.currentLang);
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
                
                // Página de inicio - Hero Section
                welcome: 'Bienvenido',
                hero_subtitle: 'maquinaria industrial y servicios de construcción',
                our_services: 'Nuestros Servicios',
                
                // Servicios
                our_services_title: 'Nuestros Servicios',
                services_back: 'Servicios',
                engineering_techniques: 'Técnicas e implementación de ingeniería',
                read_more: 'Leer más',
                
                // Sobre nosotros
                who_we_are: 'Quiénes somos',
                about_us_back: 'Sobre nosotros',
                read_more_about_us: 'Leer más sobre nosotros',
                company_description_1: 'En Vilba, ofrecemos soluciones confiables en renta de equipo pesado para tus proyectos industriales, de construcción o logísticos.',
                company_description_2: 'Contamos con una amplia variedad de maquinaria como montacargas, grúas, plataformas y más. Nos enfocamos en brindar equipos en excelente estado, acompañados de un servicio al cliente profesional y puntual. Ya sea para uso diario o por proyecto, en Vilba te apoyamos con la maquinaria que necesitas, cuando la necesitas.',
                
                // Proyectos
                our_projects: 'Nuestros Proyectos',
                gallery: 'Galería',
                all: 'Todos',
                interiors: 'Interiores',
                recent: 'Recientes',
                drainage: 'Drenaje',
                parks: 'Parques',
                
                // Testimonios
                testimonials: 'Testimonios',
                what_clients_say: 'Lo que dicen nuestros clientes',
                
                // Equipo
                our_team: 'Nuestro Equipo',
                team_back: 'Equipo',
                meet_team: 'Conoce a nuestro equipo',
                
                // Blog
                latest_news: 'Últimas Noticias',
                news_back: 'Noticias',
                
                // Footer
                quick_links: 'Enlaces Rápidos',
                follow_us: 'Síguenos',
                newsletter: 'Boletín',
                subscribe: 'Suscribirse',
                enter_email: 'Ingresa tu email',
                copyright: 'Todos los derechos reservados',
                
                // Formularios
                name: 'Nombre',
                email: 'Email',
                phone: 'Teléfono',
                message: 'Mensaje',
                send: 'Enviar',
                required: 'Requerido',
                
                // Logo alt text
                logo_alt: 'Logo de Grúas Vilba',
                
                // Otros textos comunes
                loading: 'Cargando...',
                error: 'Error',
                success: 'Éxito',
                view_more: 'Ver más',
                learn_more: 'Aprender más',
                get_quote: 'Obtener cotización',
                call_now: 'Llamar ahora',
                years_experience: 'Años de experiencia',
                since: 'Desde'
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
                
                // Home page - Hero Section
                welcome: 'Welcome',
                hero_subtitle: 'industrial machinery and construction services',
                our_services: 'Our Services',
                
                // Services
                our_services_title: 'Our Services',
                services_back: 'Services',
                engineering_techniques: 'Engineering techniques and implementation',
                read_more: 'Read more',
                
                // About us
                who_we_are: 'Who we are',
                about_us_back: 'About us',
                read_more_about_us: 'Read more about us',
                company_description_1: 'At Vilba, we offer reliable solutions in heavy equipment rental for your industrial, construction or logistics projects.',
                company_description_2: 'We have a wide variety of machinery such as forklifts, cranes, platforms and more. We focus on providing equipment in excellent condition, accompanied by professional and punctual customer service. Whether for daily use or by project, at Vilba we support you with the machinery you need, when you need it.',
                
                // Projects
                our_projects: 'Our Projects',
                gallery: 'Gallery',
                all: 'All',
                interiors: 'Interiors',
                recent: 'Recent',
                drainage: 'Drainage',
                parks: 'Parks',
                
                // Testimonials
                testimonials: 'Testimonials',
                what_clients_say: 'What our clients say',
                
                // Team
                our_team: 'Our Team',
                team_back: 'Team',
                meet_team: 'Meet our team',
                
                // Blog
                latest_news: 'Latest News',
                news_back: 'News',
                
                // Footer
                quick_links: 'Quick Links',
                follow_us: 'Follow Us',
                newsletter: 'Newsletter',
                subscribe: 'Subscribe',
                enter_email: 'Enter your email',
                copyright: 'All rights reserved',
                
                // Forms
                name: 'Name',
                email: 'Email',
                phone: 'Phone',
                message: 'Message',
                send: 'Send',
                required: 'Required',
                
                // Logo alt text
                logo_alt: 'Vilba Cranes Logo',
                
                // Other common texts
                loading: 'Loading...',
                error: 'Error',
                success: 'Success',
                view_more: 'View more',
                learn_more: 'Learn more',
                get_quote: 'Get quote',
                call_now: 'Call now',
                years_experience: 'Years of experience',
                since: 'Since'
            }
        };
        
        this.flagPaths = {
            'es': '/assets/images/flags/mx.svg',
            'en': '/assets/images/flags/us.svg'
        };
        
        this.init();
    }
    
    async init() {
        console.log('🔧 Inicializando I18nManager...');
        
        // Prioridad de idioma:
        // 1. Idioma desde Laravel (window.initialLanguage)
        // 2. Idioma guardado en localStorage
        // 3. Idioma por defecto (es)
        
        if (window.initialLanguage && (window.initialLanguage === 'es' || window.initialLanguage === 'en')) {
            this.currentLang = window.initialLanguage;
            console.log('✅ Usando idioma desde Laravel:', this.currentLang);
        } else {
            const savedLang = localStorage.getItem('vilba_language');
            if (savedLang && (savedLang === 'es' || savedLang === 'en')) {
                this.currentLang = savedLang;
                console.log('✅ Usando idioma desde localStorage:', this.currentLang);
            } else {
                console.log('✅ Usando idioma por defecto:', this.currentLang);
            }
        }
        
        // Sincronizar localStorage con el idioma actual
        localStorage.setItem('vilba_language', this.currentLang);
        
        console.log(`📊 Idioma final configurado: ${this.currentLang}`);
        
        // Detectar ubicación del usuario como respaldo
        await this.detectUserLocation();
        
        // Configurar rutas de banderas con URL base
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
                option.style.borderRadius = '4px';
                option.style.padding = '4px 8px';
            } else {
                option.style.fontWeight = 'normal';
                option.style.backgroundColor = 'transparent';
                option.style.padding = '4px 8px';
            }
        });
        
        console.log(`Idioma actual configurado: ${this.currentLang}`);
    }
    
    setupEventListeners() {
        console.log('🔧 Configurando event listeners para i18n...');
        
        // Usar delegación de eventos para manejar clics en opciones de idioma
        // Esto funciona mejor con contenido dinámico y módulos ES6
        document.addEventListener('click', (e) => {
            console.log('👆 Click detectado en:', e.target);
            
            // Verificar si el elemento clickeado es una opción de idioma
            if (e.target.closest('.language-option')) {
                console.log('🌐 Click en opción de idioma detectado!');
                e.preventDefault();
                e.stopPropagation();
                
                const option = e.target.closest('.language-option');
                const selectedLang = option.getAttribute('data-lang');
                
                console.log(`🔄 Idioma seleccionado: ${selectedLang}`);
                console.log('📍 Elemento de opción:', option);
                
                this.changeLanguage(selectedLang);
                
                // Cerrar el menú después de seleccionar
                const submenu = option.closest('.submenu');
                if (submenu) {
                    submenu.style.display = 'none';
                    setTimeout(() => {
                        submenu.style.display = '';
                    }, 100);
                }
            }
        });
        
        // También configurar eventos directos como respaldo
        const languageOptions = document.querySelectorAll('.language-option');
        console.log(`Configurando eventos para ${languageOptions.length} opciones de idioma`);
        
        languageOptions.forEach(option => {
            // Remover listener anterior si existe
            option.removeEventListener('click', this.handleLanguageClick);
            
            // Agregar nuevo listener
            option.addEventListener('click', this.handleLanguageClick.bind(this));
        });
    }
    
    changeLanguage(newLang) {
        console.log(`🚀 changeLanguage llamado con: ${newLang}`);
        console.log(`📊 Idioma actual: ${this.currentLang}`);
        
        if (newLang !== this.currentLang && (newLang === 'es' || newLang === 'en')) {
            console.log(`✅ Cambiando idioma de ${this.currentLang} a ${newLang}`);
            
            // Guardar en localStorage inmediatamente
            localStorage.setItem('vilba_language', newLang);
            console.log(`💾 Idioma guardado en localStorage: ${newLang}`);
            
            // Redirigir a la ruta de Laravel para cambiar idioma y recargar página
            console.log(`🔄 Redirigiendo a Laravel para cambio de idioma...`);
            window.location.href = `/cambiar-idioma/${newLang}`;
            
        } else {
            console.log(`❌ No se cambió el idioma. Razón: newLang=${newLang}, currentLang=${this.currentLang}`);
        }
    }
    
    applyTranslations() {
        console.log('🔤 Aplicando traducciones...');
        const elements = document.querySelectorAll('[data-translate]');
        console.log(`📝 Encontrados ${elements.length} elementos con data-translate`);
        
        elements.forEach((element, index) => {
            const key = element.getAttribute('data-translate');
            const translation = this.translate(key);
            
            console.log(`🔍 Elemento ${index + 1}: key='${key}', traducción='${translation}'`);
            
            if (translation) {
                const oldText = element.textContent;
                element.textContent = translation;
                console.log(`✏️ Texto actualizado: '${oldText}' → '${translation}'`);
            } else {
                console.log(`⚠️ No se encontró traducción para la clave: '${key}'`);
            }
        });
        
        // Actualizar atributos alt de imágenes
        const images = document.querySelectorAll('img[data-translate-alt]');
        console.log(`🖼️ Encontradas ${images.length} imágenes con data-translate-alt`);
        images.forEach(img => {
            const key = img.getAttribute('data-translate-alt');
            const translation = this.translate(key);
            
            if (translation) {
                img.setAttribute('alt', translation);
                console.log(`🖼️ Alt actualizado: '${key}' → '${translation}'`);
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
        
        console.log('✅ Traducciones aplicadas completamente');
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
    
    // Método para manejar clics en opciones de idioma
    handleLanguageClick(e) {
        e.preventDefault();
        e.stopPropagation();
        
        const selectedLang = e.currentTarget.getAttribute('data-lang');
        console.log(`Idioma seleccionado (evento directo): ${selectedLang}`);
        
        this.changeLanguage(selectedLang);
        
        // Cerrar el menú después de seleccionar
        const submenu = e.currentTarget.closest('.submenu');
        if (submenu) {
            submenu.style.display = 'none';
            setTimeout(() => {
                submenu.style.display = '';
            }, 100);
        }
    }
    
    // Método para reinicializar los eventos (útil para contenido dinámico)
    reinitializeEvents() {
        this.setupEventListeners();
    }
}

// Crear instancia global cuando se importe el módulo
let globalI18nManager = null;

export function getI18nManager() {
    if (!globalI18nManager) {
        globalI18nManager = new I18nManager();
    }
    return globalI18nManager;
}

// Función de conveniencia para cambiar idioma desde cualquier parte
export function changeLanguage(lang) {
    const manager = getI18nManager();
    manager.changeLanguage(lang);
}

// Función de conveniencia para obtener traducciones
export function translate(key) {
    const manager = getI18nManager();
    return manager.translate(key);
}

// Auto-inicialización cuando el DOM esté listo
function initializeWhenReady() {
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => {
            console.log('DOM cargado, inicializando i18n...');
            setTimeout(() => {
                getI18nManager();
            }, 100); // Pequeño delay para asegurar que todo esté listo
        });
    } else {
        console.log('DOM ya está listo, inicializando i18n...');
        setTimeout(() => {
            getI18nManager();
        }, 100);
    }
}

// Llamar la inicialización
initializeWhenReady();