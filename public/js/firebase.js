// Firebase Configuration
const firebaseConfig = {
  apiKey: "AIzaSyDAj_6_s0Uc6zeqjivhM2HEK4Dr8sfU5Oc", // Necesitas obtener esto de Firebase Console
  authDomain: "vilba-notificaciones.firebaseapp.com",
  projectId: "vilba-notificaciones",
  messagingSenderId: "360034090921",
  appId: "1:360034090921:web:c66e285ff5805872694eb8", // Necesitas obtener esto de Firebase Console
  vapidKey: "BCiin0ow6U8uJa2FcqshHjNsElo7wwSXGA6og15X-0xv30KOAGMcA1iMaKKYlzquh9J-IhWRIpvrKloF51Oa1lQ" // Necesitas generar esto en Firebase Console
};

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
        const permission = await Notification.requestPermission();
        if (permission === 'granted') {
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
            body: JSON.stringify({ token, platform: 'web' }),
          });
          
          if (response.ok) {
            console.log('✅ Token enviado al backend exitosamente');
          } else {
            console.error('❌ Error enviando token al backend:', response.status);
          }
        } else {
          console.log('❌ Permisos de notificación denegados');
        }
      } catch (error) {
        console.error('Error obteniendo token FCM:', error);
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
          icon: '/assets/img/logo/icon.png'
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