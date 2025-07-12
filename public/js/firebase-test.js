// Script de prueba para verificar credenciales de Firebase
// Usar temporalmente para diagnosticar problemas

console.log('🔍 Iniciando diagnóstico de Firebase...');

// Verificar si Firebase está cargado
if (typeof firebase === 'undefined') {
    console.error('❌ Firebase SDK no está cargado');
    alert('Error: Firebase SDK no está cargado. Verifica que los scripts estén incluidos.');
} else {
    console.log('✅ Firebase SDK cargado correctamente');
    
    // Verificar configuración
    try {
        const app = firebase.apps[0];
        if (app) {
            const config = app.options;
            console.log('📋 Configuración actual:', {
                apiKey: config.apiKey ? config.apiKey.substring(0, 10) + '...' : 'NO CONFIGURADO',
                projectId: config.projectId || 'NO CONFIGURADO',
                appId: config.appId ? config.appId.substring(0, 20) + '...' : 'NO CONFIGURADO',
                messagingSenderId: config.messagingSenderId || 'NO CONFIGURADO'
            });
            
            // Verificar si las credenciales son placeholders
            if (config.apiKey && config.apiKey.includes('XXX')) {
                console.warn('⚠️ API Key parece ser un placeholder');
                alert('Advertencia: API Key no está configurado correctamente. Revisa FIREBASE_SETUP_GUIDE.md');
            }
            
            if (config.appId && config.appId.includes('XXX')) {
                console.warn('⚠️ App ID parece ser un placeholder');
                alert('Advertencia: App ID no está configurado correctamente. Revisa FIREBASE_SETUP_GUIDE.md');
            }
            
        } else {
            console.error('❌ Firebase no está inicializado');
        }
        
        // Verificar messaging
        if (firebase.messaging) {
            console.log('✅ Firebase Messaging disponible');
            
            // Verificar VAPID key
            const firebaseConfig = window.firebaseConfig || {};
            if (firebaseConfig.vapidKey && firebaseConfig.vapidKey.includes('XXX')) {
                console.warn('⚠️ VAPID Key parece ser un placeholder');
                alert('Advertencia: VAPID Key no está configurado correctamente. Revisa FIREBASE_SETUP_GUIDE.md');
            }
            
        } else {
            console.error('❌ Firebase Messaging no disponible');
        }
        
    } catch (error) {
        console.error('❌ Error verificando configuración:', error);
        alert('Error verificando configuración: ' + error.message);
    }
}

// Detectar navegador
function detectBrowser() {
    const userAgent = navigator.userAgent;
    if (userAgent.includes('Brave')) {
        return { name: 'Brave', compatible: 'Parcial - FCM deshabilitado por defecto' };
    } else if (userAgent.includes('Chrome')) {
        return { name: 'Chrome', compatible: 'Completa' };
    } else if (userAgent.includes('Firefox')) {
        return { name: 'Firefox', compatible: 'Completa' };
    } else if (userAgent.includes('Safari')) {
        return { name: 'Safari', compatible: 'Limitada - Solo desktop' };
    } else if (userAgent.includes('Edge')) {
        return { name: 'Edge', compatible: 'Completa' };
    }
    return { name: 'Desconocido', compatible: 'Desconocida' };
}

const browser = detectBrowser();
console.log('🌐 Navegador detectado:', browser.name);
console.log('🔧 Compatibilidad FCM:', browser.compatible);

// Verificar soporte del navegador
if ('Notification' in window) {
    console.log('✅ Notificaciones soportadas por el navegador');
    console.log('📊 Estado actual de permisos:', Notification.permission);
} else {
    console.error('❌ Notificaciones no soportadas por el navegador');
}

if ('serviceWorker' in navigator) {
    console.log('✅ Service Workers soportados');
} else {
    console.error('❌ Service Workers no soportados');
}

if ('PushManager' in window) {
    console.log('✅ Push Manager disponible');
} else {
    console.error('❌ Push Manager no disponible');
}

// Mostrar instrucciones específicas para Brave
if (browser.name === 'Brave') {
    console.warn('⚠️ BRAVE BROWSER DETECTADO');
    console.warn('🔧 Para habilitar notificaciones en Brave:');
    console.warn('1. Ve a brave://settings/privacy');
    console.warn('2. Busca "Use Google services for push messaging"');
    console.warn('3. Activa esta opción');
    console.warn('4. Reinicia el navegador');
    console.warn('5. Regresa a esta página');
    console.warn('');
    console.warn('💡 Alternativas:');
    console.warn('- Usa Chrome, Firefox o Edge para mejor compatibilidad');
    console.warn('- Las notificaciones funcionan en Brave para Android');
    
    // Mostrar alerta visual si está disponible
    if (typeof window.showBraveAlert === 'function') {
        setTimeout(() => {
            window.showBraveAlert();
        }, 1000);
    }
}

// Resumen de compatibilidad
console.log('📋 RESUMEN DE COMPATIBILIDAD:');
console.log('- Navegador:', browser.name);
console.log('- Compatibilidad FCM:', browser.compatible);
console.log('- Notificaciones:', 'Notification' in window ? '✅' : '❌');
console.log('- Service Workers:', 'serviceWorker' in navigator ? '✅' : '❌');
console.log('- Push Manager:', 'PushManager' in window ? '✅' : '❌');
console.log('- Permisos actuales:', 'Notification' in window ? Notification.permission : 'N/A');

console.log('🏁 Diagnóstico completado. Revisa los mensajes anteriores.');

// Mostrar recomendaciones
if (browser.name === 'Brave' && Notification.permission !== 'granted') {
    console.log('💡 RECOMENDACIÓN: Considera usar Chrome o Firefox para una experiencia óptima con notificaciones.');
}