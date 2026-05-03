// Language switcher and IP detection
const languageSwitcher = {
  currentLanguage: window.initialLanguage || 'es',
  translations: {
    en: {
      // Add all English translations here
      home: 'Home',
      about: 'About Us',
      projects: 'Projects',
      services: 'Services',
      language: 'Language',
      contact: 'Contact',
      contact_btn: 'Contact Us',
      welcome: 'Welcome'
    },
    es: {
      // Add all Spanish translations here
      home: 'Inicio',
      about: 'Nosotros',
      projects: 'Proyectos',
      services: 'Servicios',
      language: 'Idioma',
      contact: 'Contacto',
      contact_btn: 'Contáctanos',
      welcome: 'Bienvenido'
    }
  },

  init: function() {
    // Solo detectar país si no hay idioma definido desde Laravel
    if (!window.initialLanguage) {
      this.detectCountry();
    }
    this.createLanguageSelector();
    this.applyTranslations();
  },

  detectCountry: function() {
    // Solo detectar si no hay idioma definido desde Laravel
    if (window.initialLanguage) {
      return;
    }
    
    fetch('https://ipapi.co/json/')
      .then(response => response.json())
      .then(data => {
        if (data.country === 'MX') {
          this.currentLanguage = 'es';
          this.applyTranslations();
        }
      })
      .catch(error => console.error('Error detecting country:', error));
  },

  createLanguageSelector: function() {
    const nav = document.querySelector('.main-menu ul');
    if (nav) {
      // const li = document.createElement('li');
      li.innerHTML = `
        <a href="#" class="lang-btn ${this.currentLanguage === 'en' ? 'active' : ''}" data-lang="en">EN</a>
        <span class="separator">/</span>
        <a href="#" class="lang-btn ${this.currentLanguage === 'es' ? 'active' : ''}" data-lang="es">ES</a>
      `;
      nav.appendChild(li);
      
      li.querySelectorAll('.lang-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
          e.preventDefault();
          const selectedLang = e.target.dataset.lang;
          
          // Redirigir a la ruta correcta según el idioma
          if (selectedLang === 'en') {
            window.location.href = '/EN';
          } else {
            window.location.href = '/ES';
          }
        });
      });
    }
  },

  applyTranslations: function() {
    // Update all elements with data-translate attribute
    document.querySelectorAll('[data-translate]').forEach(el => {
      const key = el.getAttribute('data-translate');
      if (this.translations[this.currentLanguage][key]) {
        el.textContent = this.translations[this.currentLanguage][key];
      }
    });
  }
};

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
  languageSwitcher.init();
});