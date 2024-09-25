## Sistema de Gestión de Asistencia y Observaciones de Estudiantes 🎓

Este proyecto es una aplicación web diseñada para facilitar la gestión de estudiantes, cursos, materias, observaciones y asistencias. Permite agregar, editar y eliminar información sobre estudiantes y sus actividades académicas, además de generar reportes en PDF basados en filtros aplicados.

## ✨ Características principales
* 👨‍🎓 **Gestión de estudiantes:** Agrega, edita y elimina estudiantes en el sistema.
* 📚 **Gestión de cursos y materias:** Asigna cursos y materias a los estudiantes y personaliza el contenido.
* 📝 **Observaciones:** Registra observaciones para cada estudiante de acuerdo con su desempeño o comportamiento.
* 📅 **Asistencias:** Lleva el control de la asistencia de los estudiantes.
* 🔍 **Filtros personalizados:** Filtra las observaciones y asistencias por estudiante, curso, materia, o fechas específicas.
* 📄 **Exportación a PDF:** Genera reportes personalizados en formato PDF basados en los filtros aplicados.

## 🛠️ Tecnologías utilizadas
* **Frontend:** Javascript & Tailwind css
* **Backend:** Laravel
* **Base de datos:** MySQL
* **Autenticación:** Laravel Jetstream

## ⚙️ Instalación
### Requisitos previos
* Node.js
* PHP >= 7.4
* Composer
* MySQL
  
## Pasos para la instalación
    1) Clona el repositorio:
    git clone https://github.com/ivanng01/igsystem.git
    
    2) Instala las dependencias del backend:
    cd backend
    composer install
    
    3) Configura el archivo .env en la carpeta backend con tus credenciales de base de datos.
    
    4) Instala las dependencias del frontend:
    cd ../frontend
    npm install
    
    5) Configura el archivo .env.local en la carpeta frontend.
    
    6) Corre las migraciones de base de datos:
    cd backend
    php artisan migrate
    
    7) Ejecuta los servidores de desarrollo:
    cd backend
    php artisan serve
    cd ../frontend
    npm run dev`
     
## 🧑‍💻 Uso
* Crea una cuenta e inicia sesión.
* Gestión de Estudiantes: Crea nuevos estudiantes, asigna cursos y materias.
* Registro de Observaciones y Asistencias: Agrega observaciones sobre el comportamiento y el rendimiento de los estudiantes, y marca su asistencia en cada clase.
* Generación de Reportes: Utiliza filtros para ver la información específica de cada estudiante y exporta los resultados a archivos PDF.

