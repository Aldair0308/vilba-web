// Firebase Configuration
const firebaseConfig = {
  apiKey: "AIzaSyDAj_6_s0Uc6zeqjivhM2HEK4Dr8sfU5Oc", // Necesitas obtener esto de Firebase Console
  authDomain: "vilba-notificaciones.firebaseapp.com",
  projectId: "vilba-notificaciones",
  messagingSenderId: "360034090921",
  appId: "1:360034090921:web:c66e285ff5805872694eb8", // Necesitas obtener esto de Firebase Console
  vapidKey: "BCiin0ow6U8uJa2FcqshHjNsElo7wwSXGA6og15X-0xv30KOAGMcA1iMaKKYlzquh9J-IhWRIpvrKloF51Oa1lQ" // Necesitas generar esto en Firebase Console
};

// Browser detection
function detectBrowser() {
  const userAgent = navigator.userAgent;
  if (userAgent.includes('Brave')) {
    return 'brave';
  } else if (userAgent.includes('Chrome')) {
    return 'chrome';
  } else if (userAgent.includes('Firefox')) {
    return 'firefox';
  } else if (userAgent.includes('Safari')) {
    return 'safari';
  } else if (userAgent.includes('Edge')) {
    return 'edge';
  }
  return 'unknown';
}

// Check if push notifications are supported in current browser
function checkPushSupport() {
  const browser = detectBrowser();
  const hasServiceWorker = 'serviceWorker' in navigator;
  const hasNotification = 'Notification' in window;
  const hasPushManager = 'PushManager' in window;
  
  return {
    browser,
    supported: hasServiceWorker && hasNotification && hasPushManager,
    serviceWorker: hasServiceWorker,
    notification: hasNotification,
    pushManager: hasPushManager
  };
}

// Show browser-specific instructions
function showBraveInstructions() {
  const instructions = `
🔧 INSTRUCCIONES PARA BRAVE BROWSER:

Para recibir notificaciones en Brave, necesitas habilitar los servicios de Google:

1. Ve a brave://settings/privacy
2. Busca "Use Google services for push messaging"
3. Activa esta opción
4. Reinicia el navegador
5. Regresa a esta página y prueba nuevamente

Alternativamente:
- Usa Chrome, Firefox o Edge para mejor compatibilidad
- Las notificaciones funcionan en Brave para Android
  `;
  
  console.warn(instructions);
  
  // Show user-friendly alert
  if (window.showBraveAlert) {
    window.showBraveAlert();
  }
}

// Check if Firebase is loaded
if (typeof firebase === 'undefined') {
  console.error('❌ Firebase no está cargado. Verifica que los scripts de Firebase estén incluidos.');
  window.firebaseError = 'Firebase SDK no está disponible';
} else {
  try {
    // Initialize Firebase
    firebase.initializeApp(firebaseConfig);
    const messaging = firebase.messaging();
    console.log('✅ Firebase inicializado correctamente');

    // Function to request notification permission and get FCM token
    window.requestNotificationPermission = async () => {
      try {
        // Check browser compatibility first
        const pushSupport = checkPushSupport();
        console.log('🔍 Soporte del navegador:', pushSupport);
        
        // Special handling for Brave browser
        if (pushSupport.browser === 'brave') {
          console.warn('⚠️ Brave browser detectado - FCM puede estar deshabilitado');
          showBraveInstructions();
          
          // Try to proceed anyway in case user has enabled Google services
          if (!pushSupport.supported) {
            throw new Error('Brave browser: FCM deshabilitado. Sigue las instrucciones para habilitarlo.');
          }
        }
        
        if (!pushSupport.supported) {
          throw new Error(`Navegador ${pushSupport.browser} no soporta notificaciones push completamente`);
        }
        
        const permission = await Notification.requestPermission();
        if (permission === 'granted') {
          try {
            const token = await messaging.getToken({
              vapidKey: firebaseConfig.vapidKey
            });
            console.log('🌐 Token web:', token);

            // Send token to backend
            const response = await fetch('/api/register-web-token', {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Authorization': 'Bearer ' + (localStorage.getItem('auth_token') || '')
              },
              body: JSON.stringify({ 
                token, 
                platform: 'web',
                browser: pushSupport.browser
              }),
            });
            
            if (response.ok) {
              console.log('✅ Token enviado al backend exitosamente');
              return { success: true, token, browser: pushSupport.browser };
            } else {
              console.error('❌ Error enviando token al backend:', response.status);
              throw new Error('Error enviando token al servidor');
            }
          } catch (tokenError) {
            console.error('❌ Error obteniendo token FCM:', tokenError);
            
            if (pushSupport.browser === 'brave') {
              throw new Error('Brave: No se pudo obtener token FCM. Verifica que los servicios de Google estén habilitados en brave://settings/privacy');
            }
            throw tokenError;
          }
        } else {
          console.log('❌ Permisos de notificación denegados');
          throw new Error('Permisos de notificación denegados por el usuario');
        }
      } catch (error) {
        console.error('Error en requestNotificationPermission:', error);
        throw error;
      }
    };

    // Listen for foreground messages
    messaging.onMessage((payload) => {
      console.log('📨 Mensaje recibido en primer plano:', payload);
      
      // Show notification
      if (payload.notification) {
        new Notification(payload.notification.title, {
          body: payload.notification.body,
          icon: '/assets/img/favicon.ico'
        });
      }
    });

    // Auto-request permission when page loads
    document.addEventListener('DOMContentLoaded', () => {
      // Check if notifications are supported
      if ('Notification' in window && 'serviceWorker' in navigator) {
        // Register service worker
        navigator.serviceWorker.register('/firebase-messaging-sw.js')
          .then((registration) => {
            console.log('✅ Service Worker registrado:', registration);
            messaging.useServiceWorker(registration);
          })
          .catch((error) => {
            console.error('❌ Error registrando Service Worker:', error);
          });
      }
    });

  } catch (error) {
    console.error('❌ Error inicializando Firebase:', error);
    window.firebaseError = 'Error al inicializar Firebase: ' + error.message;
  }
}

// Fallback function if Firebase is not available
if (!window.requestNotificationPermission) {
  window.requestNotificationPermission = async () => {
    const errorMsg = window.firebaseError || 'Firebase no está disponible';
    console.error('❌ requestNotificationPermission no disponible:', errorMsg);
    throw new Error(errorMsg);
  };
}