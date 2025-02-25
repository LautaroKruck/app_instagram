# 📌 UT04 - Proyecto: APP WEB MVC

## 🚀 Puesta en marcha

En este ejercicio práctico, desarrollarás una **aplicación web** siguiendo el patrón **MVC**, aplicando todas las técnicas vistas hasta ahora.  

El objetivo es construir una versión personalizada de **Instagram**, implementando únicamente:  
- **Login/Registro de usuarios**  
- **Publicación de posts, comentarios y likes**  

Es importante seguir un enfoque paso a paso para garantizar una base sólida y estable en la aplicación.

---

## 🛠️ Requisitos Técnicos

### 🔹 Users (Usuarios)
- Los usuarios pueden **registrarse** mediante un formulario.
- Los usuarios pueden **iniciar sesión** con su cuenta.
- Los usuarios pueden **cerrar sesión** en la aplicación.
- Los usuarios pueden **eliminar su perfil** (darse de baja).
- Un usuario puede **publicar un post**.
- Un usuario puede **eliminar sus propios posts**.
- Un usuario puede **comentar en un post**.
- Un usuario puede **dar like a un post**.
- Un usuario puede **tener varios posts asociados**.

#### 📌 Estructura de la tabla `users`
| Campo       | Tipo      | Descripción                      |
|------------|----------|----------------------------------|
| `id`       | PK       | Identificador único             |
| `name`     | String   | Nombre del usuario              |
| `email`    | String   | Correo electrónico              |
| `password` | String   | Contraseña cifrada              |
| `banned`   | Boolean  | Indica si el usuario está baneado (false por defecto) |
| `...`      | Otros    | Campos adicionales de migrations |

---

### 🔹 Posts (Publicaciones)
- Un post pertenece a un único **usuario**.
- Un post puede tener **varios comentarios**.

#### 📌 Estructura de la tabla `posts`
| Campo         | Tipo      | Descripción                   |
|--------------|----------|-------------------------------|
| `id`         | PK       | Identificador único          |
| `title`      | String   | Título del post              |
| `description`| Text     | Descripción del post         |
| `publish_date` | Date   | Fecha de publicación         |
| `n_likes`    | Integer  | Número de likes recibidos    |
| `belongs_to` | FK       | Relación con `users` (usuario propietario) |

---

### 🔹 Comments (Comentarios)
- Un comentario pertenece a un único **post**.
- Un comentario pertenece a un único **usuario**.

#### 📌 Estructura de la tabla `comments`
| Campo        | Tipo      | Descripción                   |
|-------------|----------|-------------------------------|
| `id`        | PK       | Identificador único          |
| `comment`   | Text     | Contenido del comentario     |
| `publish_date` | Date  | Fecha de publicación         |
| `user_id`   | FK       | Relación con `users` (autor) |
| `post_id`   | FK       | Relación con `posts` (post asociado) |

---

## ⚙️ Requisitos Funcionales

### ✅ 1. Errores de Validación
- Si el usuario introduce datos incorrectos en cualquier formulario, se mostrarán **mensajes de error claros** para que pueda corregirlos.

### ✅ 2. Registro de Usuarios
- Un usuario puede registrarse mediante un **formulario en una vista propia**.
- Tras un registro exitoso, se guardará en la base de datos y será **redirigido al login**.

### ✅ 3. Inicio de Sesión (Login)
- Un usuario puede iniciar sesión mediante un **formulario en una vista propia**.
- Si el login es exitoso, el usuario será **redirigido a la página principal** donde verá todos los posts.

### ✅ 4. Página de Publicaciones (Posts)
- La página principal mostrará **todos los posts** publicados (propios y de otros usuarios).
- Un usuario puede **eliminar sus propios posts**.
- Debajo de cada post se mostrará:
  - Número de **likes** ❤️
  - Número de **comentarios** 💬
- Al hacer **click en un post**, se abrirá una página detallada con:
  - El post completo 📄
  - Todos los comentarios asociados 💬
  - Opción para **publicar un comentario** ✍️

---

## 📜 Enunciado

Construye una aplicación web basada en el patrón **MVC**, cumpliendo con todos los requisitos técnicos y funcionales mencionados.

🔹 La interfaz debe ser **clara e intuitiva**, con **estilos adecuados** para una mejor experiencia de usuario.  
🔹 Aunque el diseño no es la parte más importante, se tendrá en cuenta en la evaluación.

---

## 📦 Entrega del Proyecto

Para completar la entrega, deberás adjuntar:  
- 📌 **Enlace al repositorio GitHub** donde esté alojada la aplicación.  
- 📌 **Archivo `.zip`** con todo el código del proyecto.  

---

✨ **¡Buena suerte con el desarrollo!** 🚀  
