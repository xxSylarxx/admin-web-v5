# Landing de Admisión - Guía de Implementación

## 📋 Pasos para Implementar

### 1. Ejecutar el SQL en la Base de Datos

Abre phpMyAdmin y ejecuta el archivo SQL ubicado en:
```
database/admision.sql
```

Este script creará:
- Tabla `admision` (configuración general)
- Tabla `admision_secciones` (pasos del proceso)
- Datos de ejemplo

### 2. Verificar que los archivos se crearon

✅ Modelo: `models/AdmisionModel.php`
✅ Controlador: `controller/Admision.php`
✅ Vista Admin: `views/admin/admision/index.php`
✅ Vista Web: `views/web/admision.php`
✅ Menú actualizado: `views/admin/menu.php`

### 3. Configurar la Portada

1. Ve a `/admin/portadas`
2. Crea una nueva portada con:
   - **Página**: `admision`
   - **Nombre**: Admisión
   - **Imagen**: Sube una imagen de 1920x400px
   - **Título**: Proceso de Admisión
   - **Subtítulo**: Inicia tu camino con nosotros
   - **Estado**: Activo

### 4. Acceder al Admin

Ve a: `/admin/admision`

Aquí podrás:
- Editar la configuración general (intro, proceso, requisitos)
- Configurar el Call to Action (CTA)
- Gestionar las secciones/pasos del proceso
- Activar/desactivar secciones

### 5. Ver la Landing

Accede a: `/admision`

## 🎨 Estructura de Contenido

### Configuración General
- **Introducción**: Título y contenido de bienvenida
- **Proceso**: Título y descripción general del proceso
- **Requisitos**: Título y lista de requisitos
- **CTA**: Llamado a la acción con botón personalizable

### Secciones/Pasos
Cada sección tiene:
- Título
- Icono (Font Awesome)
- Contenido
- Orden
- Estado (Activo/Inactivo)

## 🔧 Personalización

### Cambiar colores
Edita en `views/web/admision.php` las variables CSS:
- `var(--color2)` - Color de acentos
- `var(--color3)` - Color principal

### Agregar más campos
1. Modifica la tabla en la BD
2. Actualiza el modelo
3. Agrega campos en la vista admin
4. Muestra los datos en la vista web

## 📱 Características

✅ Portada dinámica
✅ Contenido 100% editable
✅ Secciones ordenables
✅ Estados activables/desactivables
✅ Responsive design
✅ Animaciones incluidas
✅ Integrado con el sistema de portadas

## 🎯 Íconos Font Awesome

Ejemplos de íconos para las secciones:
- `fas fa-laptop` - Inscripción online
- `fas fa-users` - Entrevista
- `fas fa-file-alt` - Evaluación
- `fas fa-check-circle` - Matrícula
- `fas fa-calendar-alt` - Cronograma
- `fas fa-graduation-cap` - Educación

Busca más en: https://fontawesome.com/v5/search

## ⚙️ Rutas del Sistema

**Admin:**
- `/admin/admision` - Gestión de contenido
- `/admin/portadas` - Gestión de portada

**Web:**
- `/admision` - Landing pública

**API:**
- `/admin/admision/actualizar` - Actualizar configuración
- `/admin/admision/guardarSeccion` - Crear sección
- `/admin/admision/actualizarSeccion` - Editar sección
- `/admin/admision/eliminarSeccion/{id}` - Eliminar sección
- `/admin/admision/estadoSeccion/{id}/{estado}` - Cambiar estado
