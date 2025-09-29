# CHANGELOG

Este documento registra de manera estructurada el historial de cambios del proyecto **MedicNova**.

---

## [1.2.0] - 2025-09-29
### Versión
1.2.0  

### Fecha y hora
2025-09-29  

### Descripción del cambio
- Se agregó la **campana de notificaciones** en la interfaz.  
- Se implementó la **funcionalidad de facturación**.  
- Nuevos archivos:  
  - `PhP/marcar_leidas.php`  
  - `PhP/notificaciones.php`  

### Impacto en el proyecto
- **Nuevas funcionalidades**: permite notificar a los usuarios de eventos importantes.  
- **Mejora en la gestión administrativa**: el sistema ahora cuenta con facturación básica.  
- Mejora la experiencia del usuario al poder marcar notificaciones como leídas.  

---

## [1.1.0] - 2025-09-29
### Versión
1.1.0  

### Fecha
2025-09-29  

### Descripción del cambio
- Se agregaron los dashboards estáticos para **paciente** (`dashboardpa.php`) y **doctor** (`dashboardoc.php`).  

### Impacto en el proyecto
- **Nuevas funcionalidades**: ahora existen pantallas base para los diferentes tipos de usuarios (paciente y doctor).  
- Esto mejora la organización inicial del sistema y servirá como base para futuras funciones dinámicas.  

---

## [1.0.0] - 2025-09-29
### Versión
1.0.0  

### Fecha
2025-09-29  

### Descripción del cambio
- Implementación del **módulo de autenticación de usuarios** (`login.php`, `register.php`, `logout.php`, `config.php`).  
- Creación de **pantalla de splash inicial**.  
- Se agregaron archivos estáticos básicos:  
  - `index.html`  
  - Estilos (`styleIndex.css`, `styleUser.css`)  
  - Script principal (`script.js`)  
  - Logos (`Logo.png`, `Logo1.png`)  

### Impacto en el proyecto
- **Nuevas funcionalidades**: autenticación de usuarios.  
- **Mejora visual**: pantalla splash para experiencia de inicio.  
- Se estableció la **base del proyecto** para la gestión médica digital.  
