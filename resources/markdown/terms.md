## Sobre el Projecte (Sprint 2)
Aquest projecte consisteix a crear una plataforma on es poden gestionar vídeos. Els usuaris poden veure'ls, gestionar-los i buscar-ne informació. He utilitzat Laravel, que és una eina moderna per treballar amb dades, bases de dades i dissenyar aplicacions web.

## Creació del Projecte
Durant el primer sprint he treballat en les parts bàsiques del projecte:

1. **Configuració inicial:**
    - Instal·lar Laravel i preparar l'entorn de treball.
    - Crear la base de dades amb una taula anomenada `videos` que té els camps següents: `id`, `title`, `description`, `url`, `published_at`, `previous`, `next`, i `series_id`.

2. **Migrations i Seeders:**
    - Es va fer una migració per crear la taula `videos`.
    - Es van fer seeders per afegir dades de prova a la base de dades.

3. **Helpers:**
    - Es va crear el helper `VideoHelpers` per generar vídeos per defecte.

4. **Controlador bàsic:**
    - Es va crear el controlador `VideosController` per gestionar funcionalitats bàsiques com mostrar informació d'un vídeo.

5. **Vistes inicials:**
    - Es va fer una primera vista per mostrar els detalls d'un vídeo.
    - Es va crear el layout amb el contingut bàsic de la pàgina.

## Funcionalitats Avançades
En el segon sprint, vam afegir funcionalitats i millores:

1. **Model de Vídeos:**
    - Es va preparar el model `Video` perquè pugui treballar amb dates utilitzant la llibreria Carbon.
    - Es van afegir funcions per formatar les dates de tres maneres diferents: en format complet, en format "fa X temps" i com a timestamp.

2. **Tests:**
    - Es van crear tests per comprovar que les dates es mostren correctament.
    - També es van fer tests perquè els usuaris poguessin veure vídeos i per comprovar que no es mostraven errors amb vídeos inexistents.

3. **Millores a les vistes:**
    - La vista `show` ara mostra les dates amb el format "fa X temps", que és més fàcil d'entendre per l'usuari.

4. **Integració:**
    - Es van configurar les rutes per accedir a les funcionalitats principals.
    - Els helpers, models i controladors estan connectats entre ells per funcionar correctament.

## Sobre el projecte (Sprint 3)

1. **Base de Dades i Migracions**

- Creada una **migració** per afegir el camp `super_admin` a la taula `users`.
- Afegida la relació entre **rols i permisos** a la taula `role_has_permissions`.
- Configurats els **usuaris per defecte** amb els seus permisos corresponents al `DatabaseSeeder`.

2. **Model d'Usuaris**

- Afegides les funcions:
    - `testedBy()`: gestiona qui ha testejat l'usuari.
    - `isSuperAdmin()`: verifica si un usuari és **super administrador**.

3. **Helpers i Creació d'Usuaris**

- Refactoritzada la creació d'usuaris en funcions separades:
    - `create_regular_user()`
    - `create_video_manager_user()`
    - `create_superadmin_user()`
- Creada la funció `add_personal_team()` per gestionar la creació d'equips.

4. **Polítiques i Gates d'Accés**

- Definides les **portes d'accés (Gates)** a `AppServiceProvider`.
- Assignats permisos a cada rol a `DatabaseSeeder`.

5. **Testing**

- Creat el test `VideosManageControllerTest` a `tests/Feature/Videos` amb les funcions:
    - `user_with_permissions_can_manage_videos()`
    - `regular_users_cannot_manage_videos()`
    - `guest_users_cannot_manage_videos()`
    - `superadmins_can_manage_videos()`
    - `loginAsVideoManager()`
    - `loginAsSuperAdmin()`
    - `loginAsRegularUser()`

### **Correcció d'Errors**

- **Error `RoleDoesNotExist`**: solucionat assegurant que els rols es creen abans d’assignar-los.
- **Error `MissingAppKeyException`**: solucionat generant una nova `APP_KEY` i esborrant la memòria cau de Laravel.
- **Error `RouteNotFoundException`**: corregida la ruta `videos.show` passant un `id` vàlid.
- **Error `Integrity constraint violation`**: assegurada la creació de vídeos amb tots els camps requerits.

## **Properes Millores**

- Revisar l'assignació de permisos i garantir que tots els usuaris tenen els accessos correctes.
- Afegir més proves unitàries i d'integració per a cobrir tots els casos d’ús.

# Sobre el projecte (Sprint 4)

## 📌 Funcionalitats Implementades

### 🔹 **VideosManageController**
S'ha creat el controlador `VideosManageController` amb les següents funcions:
- `testedby`
- `index`
- `store`
- `show`
- `edit`
- `update`
- `delete`
- `destroy`

### 🔹 **VideosController**
S'ha creat la funció `index` per mostrar tots els vídeos disponibles.

### 🔹 **Seeder i Helpers**
- S'han creat 3 vídeos de prova i s'han afegit al `DatabaseSeeder`.

### 🔹 **Vistes per al CRUD de Vídeos** (Només accessibles per usuaris amb permisos)
- `resources/views/videos/manage/index.blade.php`
- `resources/views/videos/manage/create.blade.php`
- `resources/views/videos/manage/edit.blade.php`
- `resources/views/videos/manage/delete.blade.php`

### 🔹 **Modificacions a les Vistes**
- **`index.blade.php`**: Afegida la taula per gestionar els vídeos.
- **`create.blade.php`**: Afegit el formulari per crear vídeos, utilitzant `data-qa` per facilitar els tests.
- **`edit.blade.php`**: Afegida la taula per editar els vídeos.
- **`delete.blade.php`**: Afegida la confirmació d'eliminació d'un vídeo.

### 🔹 **Vista Pública de Vídeos**
- `resources/views/videos/index.blade.php`: Mostra tots els vídeos en una interfície semblant a YouTube.
- En clicar un vídeo, es redirigeix al detall (`show`).

## 🛠 **Tests Implementats**
### 🔹 **Modificació de Testos Existents**
- `user_with_permissions_can_manage_videos()`: Ara inclou 3 vídeos.

### 🔹 **Helpers per Permisos de Vídeos**
- S'han creat permisos específics per al CRUD de vídeos.
- Assignació de permisos als rols corresponents.

### 🔹 **Tests a `VideoTest`**
- `user_without_permissions_can_see_default_videos_page`
- `user_with_permissions_can_see_default_videos_page`
- `not_logged_users_can_see_default_videos_page`

### 🔹 **Tests a `VideosManageControllerTest`**
- `loginAsVideoManager`
- `loginAsSuperAdmin`
- `loginAsRegularUser`
- `user_with_permissions_can_see_add_videos`
- `user_without_videos_manage_create_cannot_see_add_videos`
- `user_with_permissions_can_store_videos`
- `user_without_permissions_cannot_store_videos`
- `user_with_permissions_can_destroy_videos`
- `user_without_permissions_cannot_destroy_videos`
- `user_with_permissions_can_see_edit_videos`
- `user_without_permissions_cannot_see_edit_videos`
- `user_with_permissions_can_update_videos`
- `user_without_permissions_cannot_update_videos`
- `user_with_permissions_can_manage_videos`
- `regular_users_cannot_manage_videos`
- `guest_users_cannot_manage_videos`
- `superadmins_can_manage_videos`

## 🚀 **Rutes Implementades**
- Rutes de `videos/manage` per al CRUD de vídeos, amb middleware adequat.
- La ruta d'índex és accessible tant per usuaris loguejats com per convidats.

## 🎨 **Disseny i Navegació**
- S'han afegit `navbar` i `footer` a la plantilla `resources/layouts/videosapp`.
- Es pot navegar entre pàgines fàcilment.

## 📜 **Documentació Markdown**
- Afegida informació de l’sprint a `resources/markdown/terms.md`.

## 🛡 **Verificació de Codi**
- Tots els fitxers nous han estat revisats amb **Larastan** per garantir qualitat i seguretat del codi.
