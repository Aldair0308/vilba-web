// Ejemplo de cómo usar el módulo de internacionalización desde cualquier parte
// Este archivo demuestra las diferentes formas de usar el sistema i18n

// Importar las funciones del módulo
import { getI18nManager, changeLanguage, translate } from './i18n-module.js';

// Ejemplo 1: Cambiar idioma programáticamente
function switchToEnglish() {
    changeLanguage('en');
    console.log('Idioma cambiado a inglés');
}

function switchToSpanish() {
    changeLanguage('es');
    console.log('Idioma cambiado a español');
}

// Ejemplo 2: Obtener traducciones
function getTranslation(key) {
    return translate(key);
}

// Ejemplo 3: Usar el manager completo
function useFullManager() {
    const i18nManager = getI18nManager();
    
    // Obtener idioma actual
    const currentLang = i18nManager.getCurrentLanguage();
    console.log(`Idioma actual: ${currentLang}`);
    
    // Agregar nuevas traducciones
    i18nManager.addTranslations('es', {
        'new_key': 'Nuevo texto en español'
    });
    
    i18nManager.addTranslations('en', {
        'new_key': 'New text in English'
    });
    
    // Obtener la nueva traducción
    const newTranslation = i18nManager.translate('new_key');
    console.log(`Nueva traducción: ${newTranslation}`);
}

// Ejemplo 4: Escuchar cambios de idioma
window.addEventListener('languageChanged', (event) => {
    console.log(`El idioma cambió a: ${event.detail.language}`);
    
    // Aquí puedes ejecutar código personalizado cuando cambie el idioma
    // Por ejemplo, recargar contenido dinámico, actualizar formularios, etc.
});

// Ejemplo 5: Función para crear botones de idioma dinámicos
function createLanguageButtons() {
    const container = document.createElement('div');
    container.className = 'dynamic-language-buttons';
    
    // Botón para español
    const spanishBtn = document.createElement('button');
    spanishBtn.textContent = 'Español';
    spanishBtn.onclick = () => changeLanguage('es');
    
    // Botón para inglés
    const englishBtn = document.createElement('button');
    englishBtn.textContent = 'English';
    englishBtn.onclick = () => changeLanguage('en');
    
    container.appendChild(spanishBtn);
    container.appendChild(englishBtn);
    
    return container;
}

// Ejemplo 6: Función para traducir contenido dinámico
function translateDynamicContent(element) {
    const i18nManager = getI18nManager();
    
    // Buscar todos los elementos con data-translate dentro del elemento
    const elementsToTranslate = element.querySelectorAll('[data-translate]');
    
    elementsToTranslate.forEach(el => {
        const key = el.getAttribute('data-translate');
        const translation = i18nManager.translate(key);
        if (translation) {
            el.textContent = translation;
        }
    });
}

// Exportar funciones para uso en otros módulos
export {
    switchToEnglish,
    switchToSpanish,
    getTranslation,
    useFullManager,
    createLanguageButtons,
    translateDynamicContent
};

// Ejemplo de uso cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', () => {
    console.log('Ejemplo de uso del módulo i18n cargado');
    
    // Puedes descomentar estas líneas para probar:
    // setTimeout(() => switchToEnglish(), 3000); // Cambiar a inglés después de 3 segundos
    // setTimeout(() => switchToSpanish(), 6000); // Cambiar a español después de 6 segundos
});