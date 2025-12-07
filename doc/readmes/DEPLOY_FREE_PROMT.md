## UBICACION DE LOS REPOSITORIOS

Proyecto de Laravel: 

C:\Users\al222\OneDrive\Documentos\GitHub\vilba-web

Proyecto de NestJS: 

C:\Nest\vilba-api


## PROMT TO DEPLOY FREE VILBA WEB

Tenemos que realizar una cosita y es que ahora mismo voy a crear una nueva branch, sin embargo, tú ya no tienes que ver esos. Pero vamos a tratar de desplegar en estas tecnologías que es de aquí. No tendría que ser tan complicado teóricamente, no sé si puedes ocupar un MSP o algo parecido para lograr esto. Sin embargo, este proyecto, así como el API, es lo que necesitamos renderizar y crear una base de datos en Mongo. Tenemos que desplegar este proyecto para que podamos verlo en línea sin necesidad de pagar. Si te das cuenta, estamos ocupando tecnologías que son gratuitas para que podamos hacerlo de la manera gratis y que lo podamos traer al cliente y que vea si le gusta el resultado. Sin embargo, aquí te voy a pasar algunas cosas que me salió en ChatGPT o cosas así. Sin embargo, son dos repositorios, dos carpetas. Si quieres te puedo dejar aquí la dirección de ambas carpetas donde tengo dichos repositorios que tienes que desplegar en esas tecnologías. Así que si quieres mírate el código entero de estos directorios y posteriormente puedes editar lo que se te antoje para que podamos hacer esto. No te preocupes, ahora mismo estamos en una branch que no te van a... no hay problema si haces algo malo. Así que, todo bien.




📘 README — Deploy de Laravel + NestJS + MongoDB en Koyeb + Atlas (100% Gratis, Sin Tarjeta)
Este documento explica paso a paso cómo desplegar:

Laravel → Koyeb (con Dockerfile)

NestJS API → Koyeb (Node.js nativo)

MongoDB → MongoDB Atlas (free tier)

Todo 100% gratis y sin necesidad de tarjeta de crédito.

🚀 Arquitectura
Proyecto	Plataforma	Estado
Laravel	Koyeb	Dockerfile
NestJS API	Koyeb	Node.js
MongoDB	MongoDB Atlas	Free Tier

🟦 1. Crear Cluster GRATIS en MongoDB Atlas
Ir a: https://www.mongodb.com/cloud/atlas/register

Crear una cuenta (sin tarjeta).

Click en: Build a Database.

Seleccionar: FREE Shared Cluster (M0).

Elegir región (recomendado: Oregon / North Virginia).

Crear usuario:

makefile
Copiar código
Username: admin
Password: TU_PASSWORD
Agregar IP:

Copiar código
0.0.0.0/0
Obtener el connection string:

Click Connect

Seleccionar Drivers

Elegir Node.js

Copiar el string parecido a:

bash
Copiar código
mongodb+srv://admin:TU_PASSWORD@cluster0.xxxxxx.mongodb.net/nombredb
Guárdalo para NestJS.

🟧 2. Deploy de NestJS en Koyeb (SIN Docker)
2.1 Subir Proyecto a GitHub
El repositorio debe incluir:

package.json

tsconfig.json

src/

main.ts

2.2 Crear el Servicio en Koyeb
Entrar a https://app.koyeb.com/

Click en Create Service

Fuente: GitHub

Seleccionar el repo del proyecto NestJS

Runtime: Node.js 18+

2.3 Comandos de Build y Run
Build:
arduino
Copiar código
npm install && npm run build
Run:
bash
Copiar código
node dist/main.js
2.4 Variables de Entorno en Koyeb
En la sección Environment Variables:

ini
Copiar código
PORT=3000
MONGODB_URI=mongodb+srv://admin:TU_PASSWORD@cluster0.xxxxxx.mongodb.net/nombredb
2.5 Exponer el puerto
Internal Port → 3000

Protocol → HTTP

Koyeb auto-detecta PORT=3000.

2.6 Código en NestJS para conectar a MongoDB
En app.module.ts:

ts
Copiar código
import { MongooseModule } from '@nestjs/mongoose';

@Module({
  imports: [
    MongooseModule.forRoot(process.env.MONGODB_URI),
  ],
})
export class AppModule {}
🟩 3. Deploy de Laravel en Koyeb (USANDO DOCKERFILE)
Laravel requiere PHP + Composer, así que usaremos un Dockerfile optimizado.

3.1 Crear el archivo Dockerfile
Crea un archivo Dockerfile en la raíz del proyecto Laravel con este contenido:

Dockerfile
Copiar código
FROM php:8.2-fpm

# System dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    curl

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Workdir
WORKDIR /var/www/html

# Copy project
COPY . .

# Install dependencies
RUN composer install --no-interaction --optimize-autoloader --no-dev

# Permissions
RUN chown -R www-data:www-data storage bootstrap/cache

# Expose port 8000
EXPOSE 8000

# Run Laravel
CMD php artisan serve --host=0.0.0.0 --port=8000
3.2 Subir Laravel a GitHub
Asegurarte que incluye:

composer.json

app/

routes/

Dockerfile

3.3 Crear Servicio en Koyeb
Entrar a Koyeb

Create Service

Source: GitHub

Seleccionar repo de Laravel

Runtime: Dockerfile

Deploy

3.4 Variables de Entorno de Laravel (si usa DB)
En Koyeb → Environment Variables:

ini
Copiar código
APP_KEY=TU_APP_KEY
APP_ENV=production
APP_DEBUG=false
APP_URL=https://tuapp.koyeb.app
Si usa base de datos SQL, usar Railway o Koyeb PostgreSQL free.
Si no usa base de datos, esto basta.

🟦 4. Verificación Final
✔️ 4.1 API NestJS
Probar en navegador:

arduino
Copiar código
https://tuproject-nestjs.koyeb.app
✔️ 4.2 Laravel
Probar:

arduino
Copiar código
https://tuproject-laravel.koyeb.app
✔️ 4.3 Conexión con MongoDB
Probar un endpoint que use la DB.

🎉 Resultado Final
Ya tienes:

NestJS API gratis online en Koyeb

Laravel Dockerizado online en Koyeb

MongoDB gratis en Atlas

Todo sin tarjeta, estable y con dominios públicos HTTPS




