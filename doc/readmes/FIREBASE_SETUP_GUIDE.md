# Guía de Configuración de Firebase para Notificaciones Web

## Problema Actual
El error "Failed to execute 'subscribe' on 'PushManager': The provided applicationServerKey is not valid" indica que las credenciales de Firebase no están configuradas correctamente.

## Credenciales Necesarias
Para las notificaciones web necesitas **3 credenciales específicas**:

### 1. API Key (Web)
### 2. App ID (Web)
### 3. VAPID Key (Clave Pública)

---

## Pasos para Obtener las Credenciales

### Paso 1: Acceder a Firebase Console
1. Ve a [Firebase Console](https://console.firebase.google.com/)
2. Selecciona tu proyecto: **vilba-notificaciones**

### Paso 2: Configurar App Web (si no existe)
1. En la página principal del proyecto, busca la sección "Tus apps"
2. Si no tienes una app web (ícono `</>`), haz clic en "Agregar app" → "Web"
3. Asigna un nombre (ej: "Vilba Web")
4. **NO** marques "También configurar Firebase Hosting"
5. Haz clic en "Registrar app"

### Paso 3: Obtener API Key y App ID
1. Ve a **Configuración del proyecto** (ícono de engranaje)
2. En la pestaña **"General"**
3. Baja hasta "Tus apps" y busca tu app web
4. En el código de configuración verás algo como:
```javascript
const firebaseConfig = {
  apiKey: "AIzaSyBXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX",
  authDomain: "vilba-notificaciones.firebaseapp.com",
  projectId: "vilba-notificaciones",
  storageBucket: "vilba-notificaciones.appspot.com",
  messagingSenderId: "360034090921",
  appId: "1:360034090921:web:XXXXXXXXXXXXXXXX"
};
```
5. **Copia el `apiKey` y `appId`**

### Paso 4: Generar VAPID Key
1. En **Configuración del proyecto**
2. Ve a la pestaña **"Cloud Messaging"**
3. Baja hasta "Configuración web"
4. En "Certificados push web" haz clic en **"Generar par de claves"**
5. **Copia la clave pública** que aparece

---

## Actualizar el Código

Una vez que tengas las 3 credenciales, actualiza el archivo:
`public/js/firebase.js`

```javascript
const firebaseConfig = {
  apiKey: "TU_API_KEY_REAL",           // ← Pegar aquí
  authDomain: "vilba-notificaciones.firebaseapp.com",
  projectId: "vilba-notificaciones",
  messagingSenderId: "360034090921",
  appId: "TU_APP_ID_REAL",            // ← Pegar aquí
  vapidKey: "TU_VAPID_KEY_REAL"       // ← Pegar aquí
};
```

---

## Verificación

Después de actualizar las credenciales:
1. Recarga la página web
2. Abre las herramientas de desarrollador (F12)
3. Ve a la consola
4. Haz clic en "Activar Notificaciones"
5. Deberías ver: `✅ Firebase inicializado correctamente`

---

## Notas Importantes

- Las credenciales del **service account** que proporcionaste son para el **backend** (servidor)
- Para notificaciones **web** necesitas credenciales del **cliente web**
- La **VAPID key** es específica para notificaciones push web
- Estas credenciales son **públicas** y pueden incluirse en el código del frontend

---

## Solución de Problemas

Si sigues teniendo errores:
1. Verifica que el proyecto ID sea exactamente: `vilba-notificaciones`
2. Asegúrate de que FCM esté habilitado en tu proyecto
3. Verifica que las credenciales no tengan espacios extra
4. Comprueba que la VAPID key sea la **pública**, no la privada




<script type="module">
  // Import the functions you need from the SDKs you need
  import { initializeApp } from "https://www.gstatic.com/firebasejs/11.10.0/firebase-app.js";
  // TODO: Add SDKs for Firebase products that you want to use
  // https://firebase.google.com/docs/web/setup#available-libraries

  // Your web app's Firebase configuration
  const firebaseConfig = {
    apiKey: "AIzaSyDAj_6_s0Uc6zeqjivhM2HEK4Dr8sfU5Oc",
    authDomain: "vilba-notificaciones.firebaseapp.com",
    projectId: "vilba-notificaciones",
    storageBucket: "vilba-notificaciones.firebasestorage.app",
    messagingSenderId: "360034090921",
    appId: "1:360034090921:web:c66e285ff5805872694eb8"
  };

  // Initialize Firebase
  const app = initializeApp(firebaseConfig);
</script>


##

BCiin0ow6U8uJa2FcqshHjNsElo7wwSXGA6og15X-0xv30KOAGMcA1iMaKKYlzquh9J-IhWRIpvrKloF51Oa1lQ