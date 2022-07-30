
window._ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    window.$ = window.jQuery = require('jquery');
    window.Popper = require('popper.js').default;

    require('bootstrap');
} catch (e) {}

//Alertify
window.alertify=require('alertifyjs');
window.alertify.defaults.transition="flipx";
window.alertify.defaults.glossary.title="<i class='fab fa-laravel'></i> Base Laravel";

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.headers.common['Content-Type'] = 'multipart/form-data';

window.SyncPromise = require('sync-promise');

/*
 *
 *Configuracion de pushjs
 *
 */
window.Push = require('push.js');
window.Push.config({
    timeout:4000,
    icon:'/favicon.ico',
});


/*
 *
 *Configuracion de bootstrap-table
 *
 */

require('bootstrap-table');

//Idioma
jQuery.fn.bootstrapTable.locales['es-MX'] = {
        formatLoadingMessage: function () {
            return 'Cargando, espere por favor...';
        },
        formatRecordsPerPage: function (pageNumber) {
            return pageNumber + ' registros por página';
        },
        formatShowingRows: function (pageFrom, pageTo, totalRows) {
            return 'Mostrando ' + pageFrom + ' a ' + pageTo + ' de ' + totalRows + ' filas';
        },
        formatSearch: function () {
            return 'Buscar';
        },
        formatNoMatches: function () {
            return 'No se encontraron registros';
        },
        formatAllRows: function () {
            return 'Todo';
        },
        formatRefresh: function () {
            return 'Refrescar';
        },
        formatToggle: function () {
            return 'Cambiar';
        },
        formatColumns: function () {
            return 'Columnas';
        },
    };

jQuery.extend(jQuery.fn.bootstrapTable.defaults, jQuery.fn.bootstrapTable.locales['es-MX']);
jQuery.fn.bootstrapTable.defaults.locale="es-MX";
//Clases predeterminadas
jQuery.fn.bootstrapTable.defaults.classes="table table-hover table-striped";
//id de el toolbar
jQuery.fn.bootstrapTable.defaults.toolbar="#toolbar";
//Añade buscador
jQuery.fn.bootstrapTable.defaults.search=true;
//Boton para cambiar la vista a cartas
jQuery.fn.bootstrapTable.defaults.showToggle=true;
//Paginacion
jQuery.fn.bootstrapTable.defaults.pagination=true;
//Campo que contiene el identificador
jQuery.fn.bootstrapTable.defaults.idField="id";
//Exportacion de tabla
jQuery.fn.bootstrapTable.defaults.showExport=true;
//Ocultar mostrar columnas
jQuery.fn.bootstrapTable.defaults.showColumns=true;



/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

window.tools={
    params:function(form,other_data=null){
        var data = new FormData();

        jQuery.each($(form).find('input[type=file]'), function(i, file) {
            if(file.files[0])
              data.append(file.name, file.files[0]);
        });

        if(other_data){
            jQuery.each(other_data,function(k,v){
                if(v!="" && v!=undefined){
                    if(typeof v=='object' || Array.isArray(v)){
                        for(var val in v){
                            if(typeof v[val]!='object'){
                                if(isNaN(val)){
                                    data.append(k+'['+val+']',v[val]);
                                }
                                else{
                                    data.append(k+'[]',v[val]);
                                }
                            }
                        }
                        
                    }
                    else
                        data.append(k,v);
                }
            });
        }

        return data;
    },
    push:function(title,body='',timeout=2000){
        Push.create(title, {
            body: body,
            icon: '/favicon.ico',
            timeout: timeout,
            onClick: function () {
                window.focus();
                this.close();
            }
        });    
    },
    url:function(url){
        if(url[0]=="/"){
            return window._proyectUrl+url.substring(1,url.length);
        }
        else{
            return window._proyectUrl+url;
        }
        
    },
}

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo'

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: 'your-pusher-key'
// });