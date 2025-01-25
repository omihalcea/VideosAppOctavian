# Terms of Service

## Sobre el Projecte
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
