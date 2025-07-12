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

console.log('🏁 Diagnóstico completado. Revisa los mensajes anteriores.');