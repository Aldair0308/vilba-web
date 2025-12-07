# Guía para Habilitar Notificaciones en Brave Browser

## 🛡️ ¿Por qué no funcionan las notificaciones en Brave?

Brave Browser bloquea Firebase Cloud Messaging (FCM) por defecto como parte de sus características de privacidad. Esto significa que las notificaciones web que usan Firebase (como las de Vilba) no funcionarán hasta que habilites específicamente los servicios de Google.

## 🔧 Solución: Habilitar Servicios de Google para Notificaciones

### Paso 1: Acceder a la Configuración de Privacidad
1. Abre Brave Browser
2. En la barra de direcciones, escribe: `brave://settings/privacy`
3. Presiona Enter

### Paso 2: Habilitar los Servicios de Google
1. Busca la sección **"Privacy and security"**
2. Localiza la opción **"Use Google services for push messaging"**
3. **Activa** esta opción (debe quedar en ON/Activado)

### Paso 3: Reiniciar el Navegador
1. Cierra completamente Brave Browser
2. Vuelve a abrirlo
3. Regresa a la aplicación Vilba

### Paso 4: Probar las Notificaciones
1. Ve al Dashboard de Vilba
2. Haz clic en **"Activar Notificaciones"**
3. Acepta los permisos cuando el navegador te lo solicite
4. Prueba con el botón **"Notificación de Prueba"**

## 🔍 Verificación

Para verificar que todo funciona correctamente:

1. **Consola del Navegador**: Abre las herramientas de desarrollador (F12) y revisa la consola
2. **Diagnóstico Automático**: La aplicación detectará automáticamente si eres usuario de Brave y te mostrará instrucciones
3. **Notificación de Prueba**: Usa el botón de prueba en el dashboard

## 🚨 Problemas Comunes

### "Push Service not registered"
- **Causa**: Los servicios de Google no están habilitados
- **Solución**: Sigue los pasos 1-3 de arriba

### "Firebase Cloud Messaging no disponible"
- **Causa**: FCM está bloqueado por Brave
- **Solución**: Habilita "Use Google services for push messaging"

### Las notificaciones no aparecen
- **Verifica**: Que los permisos de notificación estén concedidos
- **Verifica**: Que no tengas el modo "No molestar" activado en tu sistema
- **Verifica**: Que las notificaciones del sitio no estén bloqueadas

## 🌐 Alternativas

Si prefieres no habilitar los servicios de Google en Brave:

### Navegadores Totalmente Compatibles:
- **Google Chrome** ✅ (Compatibilidad completa)
- **Mozilla Firefox** ✅ (Compatibilidad completa)
- **Microsoft Edge** ✅ (Compatibilidad completa)

### Compatibilidad Limitada:
- **Safari** ⚠️ (Solo en desktop, no en móvil)
- **Brave Mobile** ✅ (Funciona en Android)

## 📱 Brave en Dispositivos Móviles

**Buenas noticias**: Brave para Android **SÍ** soporta notificaciones Firebase sin configuración adicional.

## 🔒 Consideraciones de Privacidad

Al habilitar "Use Google services for push messaging":

- ✅ **Solo afecta**: Las notificaciones push
- ✅ **No afecta**: Otras características de privacidad de Brave
- ✅ **Puedes desactivarlo**: En cualquier momento si cambias de opinión
- ⚠️ **Implicación**: Brave usará los servidores de Google para las notificaciones push

## 🆘 Soporte Adicional

Si sigues teniendo problemas:

1. **Verifica la versión**: Asegúrate de usar una versión reciente de Brave
2. **Limpia caché**: Borra el caché y cookies del sitio
3. **Modo incógnito**: Prueba en una ventana privada
4. **Contacta soporte**: Si nada funciona, contacta al equipo de Vilba

---

**Nota**: Esta guía es específica para Brave Browser. Para otros navegadores, las notificaciones deberían funcionar sin configuración adicional.