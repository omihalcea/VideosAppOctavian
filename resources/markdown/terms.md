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


# Sprint 5

## 📌 Funcionalitats Implementades

### 🔹 **UsersController**
S'ha creat el controlador `UsersManageController` amb les següents funcions:
- `index`
- `show`

### 🔹 **UsersManageController**
S'ha creat el controlador `UsersManageController` amb les següents funcions:
- `index`
- `create`
- `store`
- `edit`
- `update`
- `delete`
- `destroy`

### 🔹 **Permisos i Autenticació**
- S'ha implementat la gestió de permisos amb **Spatie Permissions**.
- S'han definit rols: `super-admin`, `video-manager`, `regular-user`.
- Assignació de permisos:
    - `manage_users` per gestionar usuaris.

### 🔹 **Seeder i Helpers**
- S'han creat 3 usuaris de prova amb rols assignats automàticament.
- S'ha actualitzat el `DatabaseSeeder` per incloure permisos específics.

### 🔹 **Vistes per al llistat d'Usuaris** (Accessibles per tots els usuaris)
- `resources/views/users/manage/index.blade.php`
- `resources/views/users/manage/show.blade.php`

### 🔹 **Vistes per al CRUD d'Usuaris** (Només accessibles per usuaris amb permisos)
- `resources/views/users/manage/index.blade.php`
- `resources/views/users/manage/create.blade.php`
- `resources/views/users/manage/edit.blade.php`
- `resources/views/users/manage/delete.blade.php`

### 🔹 **Modificacions a les Vistes**
- **`index.blade.php`**: Llistat d'usuaris amb botons per editar i eliminar.
- **`create.blade.php`**: Formulari per afegir nous usuaris.
- **`edit.blade.php`**: Formulari per modificar dades d'un usuari.
- **`delete.blade.php`**: Confirmació per eliminar un usuari.

### 🔹 **Vista Pública d'Usuaris**
- `resources/views/users/index.blade.php`: Mostra tots els usuaris visibles segons permisos.

## 🛠 **Tests Implementats**
### 🔹 **Modificació de Testos Existents**
- `user_with_permissions_can_manage_users()`: Ara inclou 3 usuaris de prova.

### 🔹 **Tests a `UsersManageControllerTest`**
- `loginAsSuperAdmin`
- `loginAsUserManager`
- `loginAsRegularUser`
- `user_with_permissions_can_see_add_users`
- `user_without_permissions_cannot_see_add_users`
- `user_with_permissions_can_store_users`
- `user_without_permissions_cannot_store_users`
- `user_with_permissions_can_destroy_users`
- `user_without_permissions_cannot_destroy_users`
- `user_with_permissions_can_see_edit_users`
- `user_without_permissions_cannot_see_edit_users`
- `user_with_permissions_can_update_users`
- `user_without_permissions_cannot_update_users`
- `user_with_permissions_can_manage_users`
- `regular_users_cannot_manage_users`
- `guest_users_cannot_manage_users`
- `superadmins_can_manage_users`

## 🚀 **Rutes Implementades**
- Rutes de `users/manage` per al CRUD d'usuaris, amb middleware adequat.
- L'accés està protegit amb el middleware `can:manage_users`.

## 📜 **Documentació Markdown**
- Afegida informació de l’sprint a `resources/markdown/terms.md`.

## 🛡 **Verificació de Codi**
- S'ha revisat tot el codi amb **Larastan** per garantir qualitat i seguretat.
- S'ha executat `php artisan test` per validar el correcte funcionament de totes les funcionalitats.

## Creació de series (Sprint 6)

Durant l'Sprint 6 ens hem centrat en crear series i la seva implementació al projecte.

## Permisos i Rols

1. **Spatie Permissions:**
    - S'ha integrat la llibreria `spatie/laravel-permission` per gestionar rols i permisos de forma estructurada.
    - S'ha creat el rol: `manage-series`.

2. **Helpers per a usuaris:**
    - S'ha creat `UserHelpers` per generar fàcilment usuaris amb els rols assignats.
    - Cada rol es crea amb les seves respectives funcions:
        - `create_superadmin_user()`
        - `create_video_manager_user()`
        - `create_regular_user()`

3. **Assignació de permisos:**
    - El `super-admin` rep **tots els permisos automàticament**.
    - Els `video-managers` tenen permisos específics per gestionar sèries i vídeos.
    - Els `series-managers` poden gestionar sèries.
    - Els `regular-users` no tenen permisos especials.

## Gestió de Sèries

1. **Controlador `SeriesManageController`:**
    - Permet accedir a accions com crear, editar, eliminar i actualitzar sèries.
    - Aquestes accions estan protegides mitjançant permisos.

2. **Restriccions d'accés:**
    - S’han afegit middleware de permisos a les rutes i controladors.
    - Només usuaris amb permisos poden veure o gestionar les sèries.

## Tests de Funcionalitat

1. **Tests d’autenticació i autorització:**
    - S’han escrit diversos tests per assegurar que:
        - Els `super-admins` i `video-managers` poden accedir a la gestió de sèries.
        - Els `regular-users` i convidats tenen accés restringit i reben errors 403 o redireccions.

2. **Cobertura de casos:**
    - Tests per accedir a les vistes de creació i edició.
    - Tests per desar, eliminar i actualitzar sèries.
    - Tests que comproven si un usuari sense permisos pot accedir (i fallar correctament).

## Millores i Refactors

1. **Validació de rutes protegides:**
    - S’han identificat i corregit rutes que redirigien (302) en lloc de retornar errors 403, diferenciant entre convidats i usuaris registrats sense permisos.

2. **Neteja de comentaris:**
    - S’ha netejat el codi de comentaris innecessaris dins dels tests, mantenint només els comentaris explicatius generals.

3. **Correcció d’errors Larastan:**
    - S’ha solucionat l’error relacionat amb la propietat `profile_photo_url` definint correctament el getter o afegint el trait corresponent.

    
## Creacio de notificacions al crear nou video (Sprint 7)

# Implementació de Notificacions en Temps Real a Laravel

Aquest document resumeix el procés seguit per implementar notificacions en temps real a una aplicació Laravel, incloent esdeveniments, notificacions broadcast, enviament de correus i configuració de Pusher.

---

## 1. Creació de l’Event

S’ha creat l’event `VideoCreated` per encapsular la lògica relacionada amb la creació d’un vídeo:


---

## 2. Creació de la Notificació

Es va crear una notificació per ser enviada als administradors:

```bash
php artisan make:notification VideoCreatedNotification
```

**Exemples de canals:**
- Base de dades
- Broadcast (temps real)
- Email

---

## 3. Configuració de Pusher

Al fitxer `.env` s'han establert totes les variables d'entorn necessaries per establier connexio amb el mailtrap i el pusher.

A `config/broadcasting.php` s'ha configurat el canal `pusher`:

---

## 4. Enviament de notificacions i correus

Dins del mètode `store()` del controlador de vídeos:

```php
event(new VideoCreated($video));

foreach ($admins as $admin) {
    $admin->notify(new VideoCreatedNotification($video));
}
```

---

## 🧑‍💻 5. Listener per centralitzar la notificació

```bash
php artisan make:listener SendVideoCreatedNotification
```

A `SendVideoCreatedNotification.php`:

```php
public function handle(VideoCreated $event)
{
    $admins = User::where('super_admin', true)->get();
    Notification::send($admins, new VideoCreatedNotification($event->video));
}
```

---

## 🗂️ 6. Emmagatzematge de notificacions a base de dades

Migració creada per Laravel:

```bash
php artisan notifications:table
php artisan migrate
```

La notificació implementa `toDatabase()` per a emmagatzemar informació útil:

```php
public function toDatabase($notifiable)
{
    return [
        'title' => 'Nou vídeo creat',
        'message' => 'S’ha afegit un nou vídeo: ' . $this->video->title,
        'video_id' => $this->video->id,
        'video_url' => $this->video->url,
        'video_thumbnail' => $this->video->thumbnail_url,
    ];
}
```

---

## 🖼️ 7. Visualització de notificacions

A la vista `notifications.blade.php` es mostren notificacions amb miniatura i enllaç al vídeo:

```blade
<img src="https://img.youtube.com/vi/{{ $videoId }}/0.jpg" alt="Miniatura">
<a href="{{ url('/videos/' . $videoId) }}">Veure vídeo</a>
```

---

## 📡 8. Rebre notificacions en temps real al navegador

Client JavaScript configurat amb Laravel Echo i Pusher:

```javascript
Echo.private(`App.Models.User.${userId}`)
    .notification((notification) => {
        // Mostrar notificació a la pàgina
    });
```

---

## ✅ 9. Tests automatitzats

S’han afegit tests per verificar:

- Que es dispara l’event `VideoCreated`
- Que es notifica l’usuari administrador amb `VideoCreatedNotification`

```php
Event::assertDispatched(VideoCreated::class);
Notification::assertSentTo([$admin], VideoCreatedNotification::class);
```

---

## 📬 10. Enviament de correus

El canal `mail` envia un correu automàtic als administradors quan es crea un vídeo nou, amb un enllaç al vídeo.

---

## 🔄 11. Notes addicionals

- Les notificacions es guarden un cop a base de dades (evitant duplicats)
- Larastan ha estat utilitzat per validar l'estructura del codi
- S’ha afegit PHPDoc als models per ajudar l’anàlisi estàtica

---
