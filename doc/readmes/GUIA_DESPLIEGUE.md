# 🚀 Guía Completa de Despliegue - Vilba Web + API

Esta guía te llevará paso a paso para desplegar completamente el proyecto Vilba (Laravel + NestJS + MongoDB) de forma **100% GRATUITA** usando Koyeb y MongoDB Atlas.

---

## 📋 Tabla de Contenidos

1. [Requisitos Previos](#requisitos-previos)
2. [Configuración de MongoDB Atlas](#1-configuración-de-mongodb-atlas)
3. [Preparación del Proyecto NestJS](#2-preparación-del-proyecto-nestjs)
4. [Despliegue de NestJS en Koyeb](#3-despliegue-de-nestjs-en-koyeb)
5. [Preparación del Proyecto Laravel](#4-preparación-del-proyecto-laravel)
6. [Despliegue de Laravel en Koyeb](#5-despliegue-de-laravel-en-koyeb)
7. [Verificación Final](#6-verificación-final)
8. [Solución de Problemas](#7-solución-de-problemas)

---

## Requisitos Previos

Antes de comenzar, asegúrate de tener:

- ✅ Cuenta de GitHub (gratuita)
- ✅ Cuenta de Koyeb (gratuita, sin tarjeta de crédito)
- ✅ Cuenta de MongoDB Atlas (gratuita, sin tarjeta de crédito)
- ✅ Los dos repositorios listos:
  - **Laravel**: `C:\Users\al222\OneDrive\Documentos\GitHub\vilba-web`
  - **NestJS**: `C:\Nest\vilba-api`

---

## 1. Configuración de MongoDB Atlas

### 1.1 Crear Cuenta y Cluster

1. **Ir a MongoDB Atlas**
   - Visita: https://www.mongodb.com/cloud/atlas/register
   - Crea una cuenta con tu email (NO requiere tarjeta de crédito)

2. **Crear un Cluster Gratuito**
   - Click en **"Build a Database"**
   - Selecciona **"FREE"** (M0 Sandbox)
   - Elige una región cercana (recomendado: **US East (N. Virginia)** o **US West (Oregon)**)
   - Click en **"Create"**

### 1.2 Configurar Seguridad

1. **Crear Usuario de Base de Datos**
   - En la sección "Security" → "Database Access"
   - Click en **"Add New Database User"**
   - Método de autenticación: **Password**
   - Username: `vilba_admin`
   - Password: **Genera una contraseña segura** (guárdala en un lugar seguro)
   - Database User Privileges: **Read and write to any database**
   - Click en **"Add User"**

2. **Configurar Acceso de Red**
   - En "Security" → "Network Access"
   - Click en **"Add IP Address"**
   - Selecciona **"Allow Access from Anywhere"**
   - IP Address: `0.0.0.0/0`
   - Click en **"Confirm"**

### 1.3 Obtener Connection String

1. En el Dashboard, click en **"Connect"** en tu cluster
2. Selecciona **"Connect your application"**
3. Driver: **Node.js**
4. Copia el connection string, se verá así:
   ```
   mongodb+srv://vilba_admin:<password>@cluster0.xxxxx.mongodb.net/?retryWrites=true&w=majority
   ```
5. **IMPORTANTE**: Reemplaza `<password>` con la contraseña que creaste
6. Agrega el nombre de la base de datos al final:
   ```
   mongodb+srv://vilba_admin:TU_PASSWORD@cluster0.xxxxx.mongodb.net/vilba?retryWrites=true&w=majority
   ```

**Guarda este connection string**, lo necesitarás para ambos proyectos.

---

## 2. Preparación del Proyecto NestJS

### 2.1 Verificar Archivos del Proyecto

En el directorio `C:\Nest\vilba-api`, asegúrate de tener:

- ✅ `package.json`
- ✅ `tsconfig.json`
- ✅ `src/main.ts`
- ✅ Carpeta `src/` con todos los módulos

### 2.2 Crear Archivo .env.example

Crea un archivo `.env.example` en la raíz del proyecto NestJS con el siguiente contenido:

```env
# Server Configuration
PORT=3000
NODE_ENV=production

# MongoDB Configuration
MONGODB_URI=mongodb+srv://vilba_admin:YOUR_PASSWORD@cluster0.xxxxx.mongodb.net/vilba?retryWrites=true&w=majority

# JWT Configuration (si aplica)
JWT_SECRET=your-super-secret-jwt-key-change-this-in-production

# CORS Configuration
CORS_ORIGIN=https://your-laravel-app.koyeb.app

# Other configurations as needed
```

### 2.3 Verificar package.json

Asegúrate de que tu `package.json` tenga los scripts correctos:

```json
{
  "scripts": {
    "build": "nest build",
    "start": "nest start",
    "start:prod": "node dist/main.js"
  }
}
```

### 2.4 Verificar Configuración de MongoDB en NestJS

En tu archivo `src/app.module.ts`, asegúrate de tener:

```typescript
import { Module } from '@nestjs/common';
import { MongooseModule } from '@nestjs/mongoose';

@Module({
  imports: [
    MongooseModule.forRoot(process.env.MONGODB_URI),
    // ... otros módulos
  ],
})
export class AppModule {}
```

### 2.5 Verificar Puerto en main.ts

En `src/main.ts`:

```typescript
async function bootstrap() {
  const app = await NestFactory.create(AppModule);
  
  // Habilitar CORS
  app.enableCors({
    origin: process.env.CORS_ORIGIN || '*',
    credentials: true,
  });
  
  const port = process.env.PORT || 3000;
  await app.listen(port, '0.0.0.0');
  console.log(`Application is running on: ${await app.getUrl()}`);
}
bootstrap();
```

### 2.6 Subir a GitHub

1. **Inicializar repositorio** (si no lo has hecho):
   ```bash
   cd C:\Nest\vilba-api
   git init
   git add .
   git commit -m "Initial commit for deployment"
   ```

2. **Crear repositorio en GitHub**:
   - Ve a https://github.com/new
   - Nombre: `vilba-api`
   - Visibilidad: Pública o Privada (Koyeb soporta ambas)
   - NO inicialices con README

3. **Conectar y subir**:
   ```bash
   git remote add origin https://github.com/TU_USUARIO/vilba-api.git
   git branch -M main
   git push -u origin main
   ```

---

## 3. Despliegue de NestJS en Koyeb

### 3.1 Crear Cuenta en Koyeb

1. Ve a https://app.koyeb.com/auth/signup
2. Regístrate con GitHub (recomendado) o email
3. **NO requiere tarjeta de crédito**

### 3.2 Conectar GitHub a Koyeb

1. En el dashboard de Koyeb, ve a **Settings** → **GitHub**
2. Click en **"Connect GitHub Account"**
3. Autoriza a Koyeb para acceder a tus repositorios

### 3.3 Crear Servicio para NestJS

1. **Click en "Create Service"**

2. **Seleccionar Fuente**:
   - Source: **GitHub**
   - Repository: Selecciona `vilba-api`
   - Branch: `main`

3. **Configurar Builder**:
   - Builder: **Buildpack**
   - Build command:
     ```bash
     npm install && npm run build
     ```
   - Run command:
     ```bash
     node dist/main.js
     ```

4. **Configurar Variables de Entorno**:
   Click en **"Add Environment Variable"** y agrega:
   
   | Variable | Valor |
   |----------|-------|
   | `PORT` | `8000` |
   | `NODE_ENV` | `production` |
   | `MONGODB_URI` | `mongodb+srv://vilba_admin:TU_PASSWORD@cluster0.xxxxx.mongodb.net/vilba?retryWrites=true&w=majority` |
   | `CORS_ORIGIN` | `*` (cambiar después por la URL de Laravel) |

5. **Configurar Exposición de Puerto**:
   - Ports: `8000`
   - Protocol: **HTTP**
   - Path: `/` (o tu health check endpoint)

6. **Configurar Instancia**:
   - Instance type: **Free** (Eco)
   - Regions: Selecciona la más cercana

7. **Nombre del Servicio**:
   - Service name: `vilba-api`

8. **Click en "Deploy"**

### 3.4 Esperar Despliegue

- El despliegue tomará 3-5 minutos
- Puedes ver los logs en tiempo real
- Cuando veas "Healthy", el servicio está listo

### 3.5 Obtener URL de la API

Una vez desplegado, Koyeb te dará una URL como:
```
https://vilba-api-tu-usuario.koyeb.app
```

**Guarda esta URL**, la necesitarás para configurar Laravel.

---

## 4. Preparación del Proyecto Laravel

### 4.1 Archivos Creados Automáticamente

Ya se han creado los siguientes archivos en tu proyecto Laravel:

- ✅ `Dockerfile` - Configuración de Docker para Laravel
- ✅ `.dockerignore` - Archivos a excluir del build
- ✅ `docker/nginx.conf` - Configuración de Nginx
- ✅ `docker/supervisord.conf` - Configuración de Supervisor
- ✅ `.env.koyeb` - Template de variables de entorno para producción

### 4.2 Configurar Variables de Entorno

1. **Edita el archivo `.env.koyeb`** que se creó en tu proyecto

2. **Actualiza los siguientes valores**:

```env
APP_NAME="Vilba Web"
APP_ENV=production
APP_KEY=base64:GENERA_UNA_KEY_AQUI
APP_DEBUG=false
APP_URL=https://vilba-web-tu-usuario.koyeb.app

# MongoDB Configuration
DB_CONNECTION=mongodb
DB_HOST=cluster0.xxxxx.mongodb.net
DB_PORT=27017
DB_DATABASE=vilba
DB_USERNAME=vilba_admin
DB_PASSWORD=TU_PASSWORD_DE_MONGODB

# NestJS API URL
API_URL=https://vilba-api-tu-usuario.koyeb.app
```

3. **Generar APP_KEY**:
   ```bash
   cd C:\Users\al222\OneDrive\Documentos\GitHub\vilba-web
   php artisan key:generate --show
   ```
   Copia el resultado y pégalo en `APP_KEY`

### 4.3 Verificar Configuración de MongoDB en Laravel

Asegúrate de que `config/database.php` tenga la configuración de MongoDB:

```php
'mongodb' => [
    'driver' => 'mongodb',
    'host' => env('DB_HOST', '127.0.0.1'),
    'port' => env('DB_PORT', 27017),
    'database' => env('DB_DATABASE', 'vilba'),
    'username' => env('DB_USERNAME', ''),
    'password' => env('DB_PASSWORD', ''),
    'options' => [
        'database' => env('DB_AUTHENTICATION_DATABASE', 'admin'),
    ],
],
```

### 4.4 Subir a GitHub

1. **Asegúrate de que .env NO esté en el repositorio**:
   ```bash
   # Verifica que .gitignore incluya .env
   cat .gitignore | grep .env
   ```

2. **Commit y push de los nuevos archivos**:
   ```bash
   cd C:\Users\al222\OneDrive\Documentos\GitHub\vilba-web
   git add Dockerfile .dockerignore docker/ .env.koyeb
   git commit -m "Add Docker configuration for Koyeb deployment"
   git push origin main
   ```

---

## 5. Despliegue de Laravel en Koyeb

### 5.1 Crear Servicio para Laravel

1. **En Koyeb, click en "Create Service"**

2. **Seleccionar Fuente**:
   - Source: **GitHub**
   - Repository: Selecciona `vilba-web`
   - Branch: `main`

3. **Configurar Builder**:
   - Builder: **Docker**
   - Dockerfile: `Dockerfile` (detectado automáticamente)

4. **Configurar Variables de Entorno**:
   
   Copia TODAS las variables del archivo `.env.koyeb` y agrégalas una por una en Koyeb:

   | Variable | Valor |
   |----------|-------|
   | `APP_NAME` | `Vilba Web` |
   | `APP_ENV` | `production` |
   | `APP_KEY` | `base64:tu-key-generada` |
   | `APP_DEBUG` | `false` |
   | `APP_URL` | `https://vilba-web-tu-usuario.koyeb.app` |
   | `DB_CONNECTION` | `mongodb` |
   | `DB_HOST` | `cluster0.xxxxx.mongodb.net` |
   | `DB_PORT` | `27017` |
   | `DB_DATABASE` | `vilba` |
   | `DB_USERNAME` | `vilba_admin` |
   | `DB_PASSWORD` | `tu-password-mongodb` |
   | `API_URL` | `https://vilba-api-tu-usuario.koyeb.app` |

5. **Configurar Exposición de Puerto**:
   - Ports: `8000`
   - Protocol: **HTTP**
   - Path: `/`

6. **Configurar Instancia**:
   - Instance type: **Free** (Eco)
   - Regions: Selecciona la misma región que la API

7. **Nombre del Servicio**:
   - Service name: `vilba-web`

8. **Click en "Deploy"**

### 5.2 Esperar Despliegue

- El primer despliegue puede tomar 5-10 minutos (Docker build)
- Monitorea los logs para ver el progreso
- Busca mensajes de error si algo falla

### 5.3 Actualizar CORS en la API

Una vez que tengas la URL de Laravel:

1. Ve al servicio `vilba-api` en Koyeb
2. Settings → Environment Variables
3. Actualiza `CORS_ORIGIN`:
   ```
   https://vilba-web-tu-usuario.koyeb.app
   ```
4. Redeploy el servicio

---

## 6. Verificación Final

### 6.1 Verificar API NestJS

1. **Abre en el navegador**:
   ```
   https://vilba-api-tu-usuario.koyeb.app
   ```

2. **Deberías ver**:
   - Una respuesta JSON (si tienes un endpoint raíz)
   - O un mensaje de "Cannot GET /" (normal si no hay ruta raíz)

3. **Prueba un endpoint específico**:
   ```
   https://vilba-api-tu-usuario.koyeb.app/api/health
   ```

### 6.2 Verificar Laravel

1. **Abre en el navegador**:
   ```
   https://vilba-web-tu-usuario.koyeb.app
   ```

2. **Deberías ver**:
   - La página de inicio de tu aplicación Laravel
   - Sin errores 500

### 6.3 Verificar Conexión a MongoDB

1. **Desde Laravel**, prueba crear un registro o consultar la base de datos

2. **Desde la API**, verifica que los endpoints que usan MongoDB funcionen

3. **En MongoDB Atlas**:
   - Ve a "Database" → "Browse Collections"
   - Deberías ver tu base de datos `vilba` con las colecciones creadas

### 6.4 Verificar Comunicación entre Servicios

1. **Prueba un flujo completo** que involucre:
   - Laravel haciendo una petición a la API NestJS
   - La API consultando/guardando en MongoDB
   - Laravel mostrando el resultado

---

## 7. Solución de Problemas

### Problema: "Application failed to start" en NestJS

**Solución**:
1. Revisa los logs en Koyeb
2. Verifica que `MONGODB_URI` esté correctamente configurado
3. Asegúrate de que el puerto sea `8000`
4. Verifica que `dist/main.js` exista después del build

### Problema: "500 Internal Server Error" en Laravel

**Solución**:
1. Revisa los logs en Koyeb
2. Verifica que `APP_KEY` esté configurado
3. Asegúrate de que las credenciales de MongoDB sean correctas
4. Verifica permisos de `storage/` y `bootstrap/cache/`

### Problema: "Connection refused" a MongoDB

**Solución**:
1. Verifica que la IP `0.0.0.0/0` esté permitida en MongoDB Atlas
2. Revisa que el usuario de base de datos tenga permisos
3. Asegúrate de que el connection string sea correcto
4. Verifica que hayas reemplazado `<password>` con tu contraseña real

### Problema: CORS errors entre Laravel y API

**Solución**:
1. Verifica que `CORS_ORIGIN` en la API apunte a la URL de Laravel
2. Asegúrate de que `enableCors()` esté configurado en NestJS
3. Redeploy la API después de cambiar CORS

### Problema: Docker build falla en Laravel

**Solución**:
1. Verifica que `Dockerfile` esté en la raíz del proyecto
2. Asegúrate de que `docker/nginx.conf` y `docker/supervisord.conf` existan
3. Revisa los logs de build para ver el error específico
4. Verifica que `composer.json` sea válido

### Problema: "Out of memory" durante el build

**Solución**:
1. Koyeb Free tier tiene límites de memoria
2. Optimiza `composer install` con `--no-dev`
3. Considera usar `--optimize-autoloader`
4. Limpia caché antes del build

---

## 📝 Checklist Final

Antes de considerar el despliegue completo, verifica:

- [ ] MongoDB Atlas cluster creado y configurado
- [ ] Usuario de base de datos creado con permisos correctos
- [ ] IP `0.0.0.0/0` permitida en Network Access
- [ ] Connection string de MongoDB guardado
- [ ] Proyecto NestJS subido a GitHub
- [ ] Servicio NestJS desplegado en Koyeb
- [ ] API NestJS respondiendo correctamente
- [ ] Proyecto Laravel con archivos Docker subido a GitHub
- [ ] Variables de entorno configuradas en Koyeb para Laravel
- [ ] Servicio Laravel desplegado en Koyeb
- [ ] Laravel mostrando la página de inicio
- [ ] CORS configurado correctamente entre servicios
- [ ] Comunicación entre Laravel y API funcionando
- [ ] Datos guardándose correctamente en MongoDB

---

## 🎉 ¡Felicidades!

Si llegaste hasta aquí y todos los checks están marcados, tu aplicación Vilba está completamente desplegada y funcionando en producción de forma gratuita.

### URLs Finales

- **Laravel Web**: `https://vilba-web-tu-usuario.koyeb.app`
- **NestJS API**: `https://vilba-api-tu-usuario.koyeb.app`
- **MongoDB**: Gestionado en MongoDB Atlas

### Próximos Pasos

1. **Configurar dominio personalizado** (opcional):
   - Koyeb permite agregar dominios personalizados
   - Configura DNS CNAME apuntando a tu servicio

2. **Monitoreo**:
   - Revisa los logs regularmente en Koyeb
   - Configura alertas en MongoDB Atlas

3. **Backups**:
   - MongoDB Atlas hace backups automáticos en el free tier
   - Considera exportar datos importantes regularmente

4. **Optimización**:
   - Monitorea el uso de recursos
   - Optimiza queries a MongoDB
   - Implementa caché donde sea necesario

---

## 📞 Soporte

Si encuentras problemas no cubiertos en esta guía:

1. Revisa los logs en Koyeb (muy detallados)
2. Verifica la documentación oficial de Koyeb
3. Consulta la documentación de MongoDB Atlas
4. Revisa los issues de GitHub de tus dependencias

---

**Última actualización**: Diciembre 2025
**Versiones**: Laravel 12.x, NestJS 10.x, MongoDB 7.x, PHP 8.2, Node.js 18+
