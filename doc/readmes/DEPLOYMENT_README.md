# 🚀 Configuración de Despliegue - Vilba

Este directorio contiene toda la configuración necesaria para desplegar el proyecto Vilba (Laravel + NestJS + MongoDB) en Koyeb de forma gratuita.

## 📁 Archivos Creados

### Documentación
- **`PASOS_MANUALES.md`** ⭐ - **EMPIEZA AQUÍ**: Resumen ejecutivo de los pasos manuales requeridos
- **`GUIA_DESPLIEGUE.md`** - Guía completa paso a paso con todos los detalles
- **`DEPLOYMENT_README.md`** - Este archivo

### Configuración Laravel
- **`Dockerfile`** - Configuración Docker principal (nginx + php-fpm)
- **`Dockerfile.simple`** - Alternativa simplificada (solo PHP built-in server)
- **`.dockerignore`** - Archivos excluidos del build de Docker
- **`.env.koyeb`** - Template de variables de entorno para producción
- **`docker/nginx.conf`** - Configuración del servidor Nginx
- **`docker/supervisord.conf`** - Configuración de Supervisor (gestor de procesos)

### Configuración NestJS
- **`NESTJS_ENV_TEMPLATE.env`** - Template de variables de entorno (copiar a proyecto NestJS)

## 🎯 Inicio Rápido

### Opción 1: Resumen Ejecutivo (Recomendado)
```bash
# Lee este archivo primero
cat PASOS_MANUALES.md
```

### Opción 2: Guía Completa
```bash
# Para instrucciones detalladas paso a paso
cat GUIA_DESPLIEGUE.md
```

## 📋 Checklist Rápido

- [ ] 1. Crear cluster MongoDB Atlas (15 min)
- [ ] 2. Configurar NestJS con variables de entorno (10 min)
- [ ] 3. Generar APP_KEY de Laravel (2 min)
- [ ] 4. Subir ambos proyectos a GitHub (5 min)
- [ ] 5. Desplegar NestJS en Koyeb (15 min)
- [ ] 6. Desplegar Laravel en Koyeb (15 min)
- [ ] 7. Actualizar CORS y verificar (10 min)

**Tiempo total estimado: ~70 minutos**

## 🔧 Tecnologías

- **Frontend/Backend**: Laravel 12.x (PHP 8.2)
- **API**: NestJS 10.x (Node.js 18+)
- **Base de Datos**: MongoDB 7.x (Atlas)
- **Hosting**: Koyeb (Free Tier)
- **Containerización**: Docker

## 💰 Costos

**TOTAL: $0.00 USD** ✅

- MongoDB Atlas: Free Tier (512 MB)
- Koyeb: Free Tier (2 servicios)
- GitHub: Free
- Sin tarjeta de crédito requerida

## 🆘 Soporte

Si encuentras problemas:

1. Consulta la sección "Solución de Problemas" en `GUIA_DESPLIEGUE.md`
2. Revisa los logs en Koyeb (muy detallados)
3. Verifica las variables de entorno

## 📊 Estructura del Despliegue

```
┌─────────────────┐
│   MongoDB       │
│   Atlas         │
│   (Database)    │
└────────┬────────┘
         │
         ├──────────────┐
         │              │
┌────────▼────────┐ ┌──▼──────────────┐
│   NestJS API    │ │  Laravel Web    │
│   (Koyeb)       │◄┤  (Koyeb)        │
│   Port: 8000    │ │  Port: 8000     │
└─────────────────┘ └─────────────────┘
```

## 🔐 Seguridad

- ✅ HTTPS automático en Koyeb
- ✅ Variables de entorno seguras
- ✅ MongoDB con autenticación
- ✅ CORS configurado correctamente
- ⚠️ Recuerda cambiar contraseñas por defecto
- ⚠️ No commitear archivos `.env` reales

## 📝 Notas Importantes

### Dockerfile
- **`Dockerfile`**: Versión completa con nginx + php-fpm (recomendado para producción)
- **`Dockerfile.simple`**: Versión simplificada con PHP built-in server (más fácil, menos robusto)

Si el Dockerfile principal falla, puedes renombrar:
```bash
mv Dockerfile Dockerfile.backup
mv Dockerfile.simple Dockerfile
```

### Variables de Entorno
- Nunca commitear archivos `.env` con datos reales
- Usar `.env.koyeb` como template
- Configurar variables directamente en Koyeb

### Limitaciones Free Tier
- **Koyeb**: Los servicios pueden dormir tras inactividad
- **MongoDB Atlas**: 512 MB de almacenamiento
- **Cold starts**: Primer request puede ser lento

## 🎉 Próximos Pasos Después del Despliegue

1. **Dominio Personalizado**: Configura un dominio propio en Koyeb
2. **Monitoreo**: Configura alertas en MongoDB Atlas
3. **Backups**: Exporta datos importantes regularmente
4. **Optimización**: Implementa caché y optimiza queries
5. **CI/CD**: Configura auto-deploy desde GitHub

## 📚 Recursos Adicionales

- [Documentación de Koyeb](https://www.koyeb.com/docs)
- [Documentación de MongoDB Atlas](https://www.mongodb.com/docs/atlas/)
- [Laravel Deployment](https://laravel.com/docs/deployment)
- [NestJS Deployment](https://docs.nestjs.com/deployment)

---

**Creado**: Diciembre 2025  
**Proyecto**: Vilba Web + API  
**Versión**: 1.0.0

¡Buena suerte con el despliegue! 🚀
