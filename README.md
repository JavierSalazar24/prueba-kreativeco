# 💻 Proyecto Kreativeco

## **📌 Descripción General**

Este proyecto es una aplicación web que permite la gestión de usuarios, roles y publicaciones, implementando una API REST en **PHP puro** y un frontend con **Vue 3**.

---

## **📌 Tecnologías Utilizadas**

### **Frontend (Cliente)**

- **Vue 3** → Framework JavaScript para la UI.
- **Vue Router** → Para la navegación entre vistas.
- **Axios** → Para el consumo de la API REST.
- **CSS Puro (Flexbox y Grid)** → Para el diseño adaptable.

### **Backend (Servidor)**

- **PHP 8** → Lenguaje del backend.
- **MySQL 8** → Base de datos relacional.
- **JWT (JSON Web Tokens)** → Para autenticación de usuarios.
- **Composer** → Para la gestión de dependencias.
- **PDO** → Para la conexión segura con MySQL.

---

## **📌 Instalación y Configuración**

### **1️⃣ Instalación del Backend**

```bash
cd backend
composer install
php -S localhost:8000
```

> Esto iniciará el servidor en `http://localhost:8000/`.

### **2️⃣ Instalación del Frontend**

```bash
cd frontend
npm install
npm run dev
```

> Esto ejecutará la aplicación en `http://localhost:5173/`.

### **3️⃣ Configuración de Variables de Entorno**

En el archivo **`.env`** del frontend, define la URL del backend:

```
VITE_API_URL=http://localhost:8000
```

Así, el frontend se conectará correctamente a la API.

---

## **📌 Documentación de la API**

Cada endpoint sigue el estándar **RESTful** y requiere autenticación **JWT** para la mayoría de las operaciones.

### **🟢 1️⃣ Registro de Usuario**

- **Método:** `POST`
- **URL:** `/register`
- **Headers:** `Content-Type: application/json`
- **Body (JSON):**
  ```json
  {
    "name": "Javier",
    "last_name": "Salazar",
    "email": "javier@example.com",
    "password": "12345678",
    "rol_id": 5
  }
  ```
- **Respuesta Exitosa (200):**
  ```json
  { "message": "Usuario registrado exitosamente" }
  ```

### **🟢 2️⃣ Login de Usuario**

- **Método:** `POST`
- **URL:** `/login`
- **Body (JSON):**
  ```json
  {
    "email": "javier@example.com",
    "password": "12345678"
  }
  ```
- **Respuesta Exitosa (200):**

  ```json
  { "token": "JWT_TOKEN_AQUÍ" }
  ```

### **🟠 3️⃣ Actualización de Usuario**

- **Método:** `PUT`
- **URL:** `/users/{id}`
- **Headers:** `Authorization: Bearer JWT_TOKEN`
- **Body (JSON):**
  ```json
  {
    "name": "Nuevo Nombre",
    "last_name": "Nuevo Apellido",
    "email": "nuevo@example.com",
    "password": "nueva_clave"
  }
  ```
- **Respuesta Exitosa (200):**
  ```json
  { "message": "Usuario actualizado exitosamente" }
  ```

### **🔴 4️⃣ Eliminación Lógica de Usuario**

- **Método:** `DELETE`
- **URL:** `/users/{id}`
- **Headers:** `Authorization: Bearer JWT_TOKEN`
- **Respuesta Exitosa (200):**
  ```json
  { "message": "Usuario eliminado" }
  ```

### **🟢 8️⃣ Consulta de Usuarios**

- **Método:** `GET`
- **URL:** `/users`
- **Headers:** `Authorization: Bearer JWT_TOKEN`
- **Respuesta Exitosa (200):**
  ```json
  [
    {
      "id": 1,
      "name": "Javier",
      "last_name": "Salazar",
      "email": "javier@example.com",
      "password": "12345678",
      "rol_name": "Rol medio"
    }
  ]
  ```

### **🟡 5️⃣ Creación de Publicación**

- **Método:** `POST`
- **URL:** `/posts`
- **Headers:** `Authorization: Bearer JWT_TOKEN`
- **Body (JSON):**
  ```json
  {
    "title": "Mi nuevo post",
    "description": "Contenido del post"
  }
  ```
- **Respuesta Exitosa (201):**
  ```json
  { "message": "Post creado exitosamente" }
  ```

### **🟠 6️⃣ Actualización de Publicación**

- **Método:** `PUT`
- **URL:** `/posts/{id}`
- **Headers:** `Authorization: Bearer JWT_TOKEN`
- **Body (JSON):**
  ```json
  {
    "title": "Título actualizado",
    "description": "Contenido actualizado"
  }
  ```
- **Respuesta Exitosa (200):**
  ```json
  { "message": "Post actualizado exitosamente" }
  ```

### **🔴 7️⃣ Eliminación Lógica de Publicación**

- **Método:** `DELETE`
- **URL:** `/posts/{id}`
- **Headers:** `Authorization: Bearer JWT_TOKEN`
- **Respuesta Exitosa (200):**
  ```json
  { "message": "Post eliminado" }
  ```

### **🟢 8️⃣ Consulta de Publicaciones**

- **Método:** `GET`
- **URL:** `/posts`
- **Headers:** `Authorization: Bearer JWT_TOKEN`
- **Respuesta Exitosa (200):**
  ```json
  [
    {
      "id": 1,
      "title": "Mi post",
      "description": "Contenido",
      "date_created": "2025-02-19 22:25:55",
      "author": "Javier Salazar",
      "role": "Rol medio"
    }
  ]
  ```

---

## **📄 Contraseñas de las cuentas**

- **Contraseñas:** `12345678`

---

---

## **📄 Requisitos y Evaluación**

### ✅ **¿Qué cumple este proyecto?**

✔ **Backend en PHP 8 sin frameworks.**  
✔ **Autenticación con JWT.**  
✔ **CRUD de publicaciones con eliminación lógica.**  
✔ **Validaciones en formularios.**  
✔ **Errores manejados con `try/catch`.**  
✔ **Frontend modular en Vue 3.**  
✔ **Diseño adaptable con CSS (Flexbox & Grid).**

---

## **📌 Extras**

📂 **Repositorio GitHub:** `https://github.com/JavierSalazar24/prueba-kreativeco`  
🌍 **Demo en la nube:** `[URL del despliegue]`  
📜 **Colección Postman:** [Descargar aquí](resources/endpoints.json)
🗄️ **Script SQL:** [Descargar aquí](resources/kreativeco.sql)

---

## **🎯 Conclusión**

Esta documentación cubre tanto la instalación como el uso de la API, facilitando la comprensión para cualquier desarrollador que necesite revisar el proyecto. 🚀🔥
