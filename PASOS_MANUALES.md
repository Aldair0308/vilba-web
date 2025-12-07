# 📋 Pasos Manuales Requeridos - Resumen Ejecutivo

Este documento resume los pasos que **DEBES hacer manualmente** para completar el despliegue. Los archivos de configuración ya están creados.

---

## ✅ Archivos Creados Automáticamente

### Para Laravel (vilba-web):
- ✅ `Dockerfile` - Configuración Docker
- ✅ `.dockerignore` - Exclusiones de build
- ✅ `docker/nginx.conf` - Servidor web
- ✅ `docker/supervisord.conf` - Gestor de procesos
- ✅ `.env.koyeb` - Template de variables de entorno
- ✅ `GUIA_DESPLIEGUE.md` - Guía completa paso a paso

### Para NestJS (vilba-api):
- ✅ `NESTJS_ENV_TEMPLATE.env` - Template de variables de entorno (copiar a tu proyecto)

---

## 🔴 PASOS MANUALES OBLIGATORIOS

### 1. MongoDB Atlas (15 minutos)

1. **Crear cuenta**: https://www.mongodb.com/cloud/atlas/register
2. **Crear cluster gratuito** (M0)
3. **Crear usuario de base de datos**:
   - Username: `vilba_admin`
   - Password: (genera una segura)
4. **Permitir acceso desde cualquier IP**: `0.0.0.0/0`
5. **Copiar connection string**:
   ```
   mongodb+srv://vilba_admin:TU_PASSWORD@cluster0.xxxxx.mongodb.net/vilba?retryWrites=true&w=majority
   ```

### 2. Preparar NestJS (10 minutos)

**IMPORTANTE**: No tengo acceso a `C:\Nest\vilba-api`, debes hacer esto manualmente:

1. **Copiar archivo de entorno**:
   - Toma el archivo `NESTJS_ENV_TEMPLATE.env` que se creó en vilba-web
   - Cópialo a `C:\Nest\vilba-api\.env.example`

2. **Verificar package.json** tenga estos scripts:
   ```json
   {
     "scripts": {
       "build": "nest build",
       "start:prod": "node dist/main.js"
     }
   }
   ```

3. **Verificar src/main.ts** tenga:
   ```typescript
   const port = process.env.PORT || 3000;
   await app.listen(port, '0.0.0.0');
   ```

4. **Verificar CORS** en main.ts:
   ```typescript
   app.enableCors({
     origin: process.env.CORS_ORIGIN || '*',
     credentials: true,
   });
   ```

5. **Subir a GitHub**:
   ```bash
   cd C:\Nest\vilba-api
   git add .
   git commit -m "Add deployment configuration"
   git push origin main
   ```

### 3. Preparar Laravel (5 minutos)

1. **Generar APP_KEY**:
   ```bash
   cd C:\Users\al222\OneDrive\Documentos\GitHub\vilba-web
   php artisan key:generate --show
   ```
   Guarda el resultado.

2. **Editar `.env.koyeb`**:
   - Pega el APP_KEY generado
   - Actualiza las credenciales de MongoDB
   - Actualiza las URLs (después de desplegar)

3. **Subir a GitHub**:
   ```bash
   git add .
   git commit -m "Add Docker deployment configuration"
   git push origin main
   ```

### 4. Desplegar en Koyeb (30 minutos)

#### 4.1 Desplegar NestJS API

1. **Ir a**: https://app.koyeb.com
2. **Create Service** → GitHub → `vilba-api`
3. **Builder**: Buildpack
4. **Build command**: `npm install && npm run build`
5. **Run command**: `node dist/main.js`
6. **Variables de entorno**:
   - `PORT=8000`
   - `NODE_ENV=production`
   - `MONGODB_URI=` (tu connection string)
   - `CORS_ORIGIN=*` (actualizar después)
7. **Port**: 8000, HTTP
8. **Deploy**
9. **Guardar URL**: `https://vilba-api-xxx.koyeb.app`

#### 4.2 Desplegar Laravel

1. **Create Service** → GitHub → `vilba-web`
2. **Builder**: Docker
3. **Variables de entorno**: Copiar TODAS de `.env.koyeb`
   - Actualizar `APP_URL` con la URL que te dará Koyeb
   - Actualizar `API_URL` con la URL de NestJS del paso anterior
4. **Port**: 8000, HTTP
5. **Deploy**
6. **Guardar URL**: `https://vilba-web-xxx.koyeb.app`

#### 4.3 Actualizar CORS

1. Volver al servicio NestJS en Koyeb
2. Actualizar `CORS_ORIGIN` con la URL de Laravel
3. Redeploy

### 5. Verificar (10 minutos)

1. **Abrir API**: `https://vilba-api-xxx.koyeb.app`
2. **Abrir Laravel**: `https://vilba-web-xxx.koyeb.app`
3. **Probar funcionalidad** que use MongoDB
4. **Verificar comunicación** entre Laravel y API

---

## 📊 Checklist de Verificación

Antes de considerar completado:

- [ ] MongoDB Atlas configurado y accesible
- [ ] Connection string de MongoDB guardado
- [ ] NestJS con .env.example creado
- [ ] NestJS subido a GitHub
- [ ] Laravel con APP_KEY generado
- [ ] Laravel subido a GitHub
- [ ] NestJS desplegado en Koyeb
- [ ] Laravel desplegado en Koyeb
- [ ] CORS actualizado
- [ ] Ambas aplicaciones funcionando
- [ ] MongoDB recibiendo datos

---

## 🆘 Si Algo Falla

Consulta la sección **"7. Solución de Problemas"** en `GUIA_DESPLIEGUE.md` para errores comunes y sus soluciones.

---

## 📚 Documentación Completa

Para instrucciones detalladas paso a paso con capturas y explicaciones:

👉 **Ver: `GUIA_DESPLIEGUE.md`**

---

## ⏱️ Tiempo Estimado Total

- MongoDB Atlas: 15 min
- Preparar NestJS: 10 min
- Preparar Laravel: 5 min
- Desplegar en Koyeb: 30 min
- Verificación: 10 min

**Total: ~70 minutos** (primera vez)

---

## 💡 Notas Importantes

1. **Koyeb Free Tier**:
   - 2 servicios gratuitos
   - Suficiente para Laravel + NestJS
   - Sin tarjeta de crédito

2. **MongoDB Atlas Free Tier**:
   - 512 MB de almacenamiento
   - Suficiente para desarrollo/demo
   - Sin tarjeta de crédito

3. **Limitaciones**:
   - Los servicios pueden dormir después de inactividad
   - Primer request puede ser lento (cold start)
   - Recursos limitados (RAM, CPU)

4. **Recomendaciones**:
   - Usa la misma región para todos los servicios
   - Monitorea los logs regularmente
   - Haz backups de MongoDB periódicamente

---

**¡Éxito con el despliegue! 🚀**
