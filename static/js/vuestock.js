var app = new Vue({
    el: '#app',
    data: {
        //sesion
        sesion:JSON.parse(localStorage.getItem('dataoresa')),
        //necesarios siempre
        modal: 0,
        tituloModal: '',
        tipoAccion: 0,
        error: 0,
        buscar: '',
        entradas: [],
        id: 0,
        pag:1, 
        hj:1,
        //stock
        idProducto:null,
        codigo: '',
        Safi: '',
        descripcion: '',
        nombre: '',
        stock: null,
        marca: '',
        tipoProducto: null,
        idProveedor: null,
        cantidad: null,
        pvp: null,
        P_DISTRIB: null,
        DIST:null,
        pvpp:null,
        ppdist:null,
        proveedores: [],
        costo: null,
        //muestras
        muestras:[],

        precios: [],
        categorias: [],
        bodegas: [],
        marcas: [],

        preciost: '',
        categoriast: '',
        bodegast: '',
        ubicacion: '',
        cantidadbodega: null,
        cajasbodega: '',

        fechaimpresionmas:'',
        fechaimpresionmenos:'',
        buscartipoimpresion:'',
        buscarimpresion:'',
        stockmas:'',
        stockmenos:'',
        ancho: "modal-xl",

        errorpreciost: [],
        errorcategoriast: [],
        errorbodegast: [],
        errorubicacion: [],
        errorSafi: [],
        errorcodigo: [],
        errornombre: [],
        errorpvpp: [],
        errormarca: [],
        erroridProveedor: [],
        errorcosto: [],
        errortipoProducto: [],

        //bodega
        nombrebodega:'',
        idbodega:null,
        errornombrebodega:[], 

        //categoria
        nombrecategoria:'',
        idcategoria:null,
        errornombrecategoria:[], 

        //precio
        idListaPrecio:null,
        errordescripcionprecio:[],
        descripcionprecio:'',
        comentarioprecio:'',
        matrizprecio:null,
        auxprecio:null,
        P_12:null,
        P_25:null,
        P_50:null,
        P_75:null,
        P_100:null,
        P_105:null,
        P_200:null,
        P_210:null,
        P_225:null,
        P_250:null,
        P_300:null,
        P_500:null,
        P_525:null,
        P_1000:null,
        P_1050:null,
        P_2500:null,
        P_5000:null,
        P_10000:null,
        P_DIST:null,

        //buscador avanzado
        buscarfiltro:'', 
        buscargeneral:'',
        cprecios:'DIST',
        stockminimo:null,
        stockmaximo:null,
        costominimo:null,
        costomaximo:null,
        color:'',
        prdencero:localStorage.getItem("prdencero"),
        prdennegativo:localStorage.getItem("prdennegativo"),
        imagenus:'',
        usuarioimagen:'',
        estadoc:null,

        attachment: [],
        clickbtnfoto:null,
        veruba:0,
        lisstockl:0,
    }, 
    methods: {
        nuevosprd() {
            console.log("ingreso");
            axios({
                url: "modelo/stock/subirnuevosorden.php",
                method: "get"
            }).then((respuesta) => {
                console.log(respuesta.data);
                alertify.success('acabado'); 
            }).catch((error) => {
                console.log(error);
                console.debug(error);
                console.dir(error);
            });
        },
        lisstockls(){
            if(this.lisstockl==0){
                this.lisstockl=1;
                return;
            }else if(this.lisstockl==1){
                this.lisstockl=2;
                return;
            }else{
                this.lisstockl=0;
                return;
            }
        },
        listar() {
            let me = this;
            axios({
                url: "modelo/stock/listar_stock.php",
                method: "get",
                params: {
                    'buscar':this.buscar,
                    'hj':this.hj,
                    'buscarfiltro':this.buscarfiltro, 
                    'buscargeneral':this.buscargeneral,
                    'stockminimo':this.stockminimo,
                    'stockmaximo':this.stockmaximo,
                    'costominimo':this.costominimo,
                    'costomaximo':this.costomaximo,
                    'prdencero':this.prdencero,
                    'prdennegativo':this.prdennegativo,
                    'cprecios':this.cprecios,
                    'color':this.color, 
                    'lisstockl':this.lisstockl,
                }
            }).then((respuesta) => {
                console.log(respuesta.data);
                if($.trim(respuesta.data)){
                    me.entradas = respuesta.data;
                    me.estadoc = respuesta.data[0].estadoc;
                }else{
                    me.entradas = '';
                }
                if(respuesta.data){ 
                    me.pag = Math.ceil(respuesta.data[0].pag/10);
                }
            }).catch((error) => {
                console.log(error);
                console.debug(error);
                console.dir(error);
            });
        },
        listarmarcas() {
            let me = this;
            axios({
                url: "modelo/busquedasgenerales/listar_marcas.php",
                method: "get",
            }).then((respuesta) => {
                if($.trim(respuesta.data)){
                    me.marcas = respuesta.data;
                }else{
                    me.marcas = '';
                }
            }).catch((error) => {
                console.log(error);
                console.debug(error);
                console.dir(error);
            });
        },
        listarproveedor() {
            let me = this;
            axios({
                url: "modelo/busquedasgenerales/listar_proveedor.php",
                method: "get",
            }).then((respuesta) => {
                if($.trim(respuesta.data)){
                    me.proveedores = respuesta.data;
                }else{
                    me.proveedores = '';
                }
            }).catch((error) => {
                console.log(error);
                console.debug(error);
                console.dir(error);
            });
        },
        listarprecios() {
            let me = this;
            axios({
                url: "modelo/busquedasgenerales/listar_precios.php",
                method: "get",
            }).then((respuesta) => {
                if($.trim(respuesta.data)){
                    me.precios = respuesta.data;
                }else{
                    me.precios = '';
                }
            }).catch((error) => {
                console.log(error);
                console.debug(error);
                console.dir(error);
            });
        },
        verimagen(img){
            $(".bodymodales").addClass("modal-open");
            this.ancho="modal-xl"; 
            //necesarios 
            this.modal = 1;
            this.tituloModal = "Imagen de "+img;
            this.tipoAccion = 11;
            this.imagen=img.trim()+".jpg";
        },
        listarcategoria() {
            let me = this;
            axios({
                url: "modelo/busquedasgenerales/listar_categoria.php",
                method: "get",
            }).then((respuesta) => {
                if($.trim(respuesta.data)){
                    me.categorias = respuesta.data;
                }else{
                    me.categorias = '';
                }
            }).catch((error) => {
                console.log(error);
                console.debug(error);
                console.dir(error);
            });
        },
        listarbodega() {
            let me = this;
            axios({
                url: "modelo/busquedasgenerales/listar_bodega.php",
                method: "get",
            }).then((respuesta) => {
                if($.trim(respuesta.data)){
                    me.bodegas = respuesta.data;
                }else{
                    me.bodegas = '';
                }
            }).catch((error) => {
                console.log(error);
                console.debug(error);
                console.dir(error);
            });
        },
        listarmuestras(id) {
            let me = this;
            axios({
                url: "modelo/stock/listar_muestras.php",
                method: "get",
                params:{
                    'id':id,
                }
            }).then((respuesta) => {
                if($.trim(respuesta.data)){
                    me.muestras = respuesta.data;
                }else{
                    me.muestras = '';
                }
            }).catch((error) => {
                console.log(error);
                console.debug(error);
                console.dir(error);
            });
        },
        abrirop(op){ 
            $(".bodymodales").addClass("modal-open");
            let me = this;
            axios({
                url: "modelo/busquedasgenerales/listar_op.php",
                method: "get",
                params: {
                    'op':op,
                }
            }).then((respuesta) => {
                if(respuesta.data) {
                    me.entradasop = respuesta.data;
                    this.modal = 1;
                    this.tituloModal = "Visualizar Orden de Pedido";
                    this.tipoAccion = 3;
                    this.nomempleop=respuesta.data[0].NOM_EMPLE;
                    this.nomcliente=respuesta.data[0].NOM_CLIENTE + ' '+ respuesta.data[0].APE_CLIENTE;
                    this.fechaEmision=respuesta.data[0].fechaEmision;
                    this.RUC=respuesta.data[0].RUC
                    this.telefono1=respuesta.data[0].telefono1;
                    this.celular=respuesta.data[0].celular;
                    this.NOM_EMPLE=respuesta.data[0].NOM_EMPLE;
                    this.comentario=respuesta.data[0].comentario;
                    this.ordpedido=respuesta.data[0].ordPedido;
                    this.direccion=respuesta.data[0].direccion;
                    this.pendiente=respuesta.data[0].pendiente;
                }else{
                    me.entradasop ='';
                    this.modal = 1;
                    this.tituloModal = "Visualizar Orden de Pedido";
                    this.tipoAccion = 3;
                }
            }).catch((error) => {
                console.log(error);
                console.debug(error);
                console.dir(error);
            });
        },
        registrar() {
            if (this.validarg()) {
                return;
            }
            let me = this;
            axios({
                url: "modelo/stock/guardar.php",
                method: "get",
                params: {
                    'codigo':this.codigo, 
                    'Safi':this.Safi, 
                    'descripcion':this.descripcion, 
                    'nombre':this.nombre,
                    'stock':this.stock,
                    'marca':this.marca,
                    'tipoProducto':this.tipoProducto,
                    'idProveedor':this.idProveedor,
                    'cantidad':this.cantidad,
                    'pvpp':this.pvpp,
                    'ppdist':this.ppdist,
                    'costo':this.costo,
                    'preciost':this.preciost,
                    'categoriast':this.categoriast,
                    'bodegast':this.bodegast,
                    'ubicacion':this.ubicacion,
                }
            }).then((respuesta) => {
                if($.trim(respuesta.data)=="bien"){
                    me.hj=1;
                    me.cerrarModal();
                    me.listar();
                    alertify.success('Registro agregado');
                }else if($.trim(respuesta.data)=="existe"){
                    alertify.error('Este código ya existe en productos');
                }else if($.trim(respuesta.data)=="malproductos"){
                    me.cerrarModal();
                    alertify.error('Error en producto no registrado');
                }else if($.trim(respuesta.data)=="malcostos"){
                    me.cerrarModal();
                    alertify.error('Error en costos no registrado');
                }else if($.trim(respuesta.data)=="malprecios"){
                    me.cerrarModal();
                    alertify.error('Error en precios no registrado');
                }else if($.trim(respuesta.data)=="maldetbgproducto"){
                    me.cerrarModal();
                    alertify.error('Error en detbgproducto no registrado');
                }else if($.trim(respuesta.data)=="maldetallecategoria"){
                    me.cerrarModal();
                    alertify.error('Error en detalle categoría no registrado');
                }else{
                    me.cerrarModal();
                    alertify.error('Error inseperado intente mas tarde o reportelo al administrador'); 
                }
            }).catch((error) => {
                console.log(error);
                console.debug(error);
                console.dir(error); 
            });
        },
        actualizar() {
            if (this.validar()) {
                return;
            }
            let me = this;
            axios({
                url: "modelo/stock/actualizar.php",
                method: "get",
                params: {
                    'idProducto':this.idProducto,
                    'codigo':this.codigo, 
                    'Safi':this.Safi, 
                    'descripcion':this.descripcion, 
                    'nombre':this.nombre,
                    'stock':this.stock,
                    'marca':this.marca,
                    'tipoProducto':this.tipoProducto,
                    'idProveedor':this.idProveedor,
                    'cantidad':this.cantidad,
                    'pvpp':this.pvpp,
                    'ppdist':this.ppdist,
                    'costo':this.costo,
                    'precios':this.preciost,
                    'categorias':this.categoriast,
                }
            }).then((respuesta) => {
                if($.trim(respuesta.data)=="bien"){
                    me.cerrarModal();
                    me.listar();
                    alertify.success('Producto actualizado');
                }else if($.trim(respuesta.data)=="existe"){
                    alertify.error('Este código ya existe en productos');
                }else if($.trim(respuesta.data)=="errorproductos"){
                    me.cerrarModal();
                    alertify.error('Error en productos no guardado');
                }else if($.trim(respuesta.data)=="errorcostos"){
                    me.cerrarModal();
                    alertify.error('Error en costos no guardado');
                }else if($.trim(respuesta.data)=="errorprecios"){
                    me.cerrarModal();
                    alertify.error('Error en precios no guardado');
                }else if($.trim(respuesta.data)=="errorcategoria"){
                    me.cerrarModal();
                    alertify.error('Error en categoria no guardado');
                }else{
                    me.cerrarModal();
                    alertify.error('Error inseperado intente mas tarde o reportelo al administrador'); 
                }
            }).catch((error) => {
                console.log(error);
                console.debug(error);
                console.dir(error);
            })
        },
        actualizarbodega() {
            if (this.validarbodega()) {
                return;
            }
            let me = this;
            axios({
                url: "modelo/stock/actualizarbodega.php",
                method: "get",
                params: {
                    'bodegast': this.bodegast,
                    'ubicacion': this.ubicacion,
                    'idProducto': this.idProducto,
                    'cantidadbodega': this.cantidadbodega,
                    'cajasbodega': this.cajasbodega,
                }
            }).then((respuesta) => {
                if($.trim(respuesta.data)=="bien"){
                    me.cerrarModal();
                    alertify.success('Producto actualizado');
                }else if($.trim(respuesta.data)=="errorbodega"){
                    me.cerrarModal();
                    alertify.error('Error en bodega no guardado');
                }else{
                    me.cerrarModal();
                    alertify.error('Error inseperado intente mas tarde o reportelo al administrador'); 
                }
            }).catch((error) => {
                console.log(error);
                console.debug(error);
                console.dir(error);
            });
        },
        actualizartbodega(){
            if (this.validarnbodega()) {
                return;
            }
            let me = this;
            axios({
                url: "modelo/stock/actualizarnbodega.php",
                method: "get",
                params: {
                    'nombrebodega':this.nombrebodega, 
                    'idbodega':this.idbodega, 
                }
            }).then((respuesta) => {
                if($.trim(respuesta.data)!="error"){
                    me.bodegas = respuesta.data;
                    alertify.success('Bodega actualizada');
                    me.nombrebodega='';
                    me.tipoAccion=5;
                }else{
                    me.cerrarModal();
                    alertify.error('Error inseperado intente mas tarde o reportelo al administrador'); 
                }
            }).catch((error) => {
                console.log(error);
                console.debug(error);
                console.dir(error); 
            });
        },
        actualizartcategoria(){
            if (this.validarncategoria()) {
                return;
            }
            let me = this;
            axios({
                url: "modelo/stock/actualizarncategoria.php",
                method: "get",
                params: {
                    'nombrecategoria':this.nombrecategoria, 
                    'idcategoria':this.idcategoria, 
                }
            }).then((respuesta) => {
                if(respuesta.data!="error"){
                    me.categorias = respuesta.data;
                    alertify.success('Categoria actualizada');
                    me.nombrecategoria='';
                    me.tipoAccion=7;
                }else{
                    me.cerrarModal();
                    alertify.error('Error inseperado intente mas tarde o reportelo al administrador'); 
                }
            }).catch((error) => {
                console.log(error);
                console.debug(error);
                console.dir(error); 
            });
        },
        actualizartprecio(){
            if (this.validarnprecio()) {
                return;
            }
            let me = this;
            axios({
                url: "modelo/stock/editarprecio.php",
                method: "get",
                params: {
                    'idListaPrecio':this.idListaPrecio,
                    'descripcionprecio':this.descripcionprecio,
                    'comentarioprecio':this.comentarioprecio,
                    'matrizprecio':this.matrizprecio,
                    'auxprecio':this.auxprecio,
                    'P_12':this.P_12,
                    'P_25':this.P_25,
                    'P_50':this.P_50,
                    'P_75':this.P_75,
                    'P_100':this.P_100,
                    'P_105':this.P_105,
                    'P_200':this.P_200,
                    'P_210':this.P_210,
                    'P_225':this.P_225,
                    'P_250':this.P_250,
                    'P_300':this.P_300,
                    'P_500':this.P_500,
                    'P_525':this.P_525,
                    'P_1000':this.P_1000,
                    'P_1050':this.P_1050,
                    'P_2500':this.P_2500,
                    'P_5000':this.P_5000,
                    'P_10000':this.P_10000,
                    'P_DIST':this.P_DIST,
                }
            }).then((respuesta) => {
                console.log(respuesta.data);
                if(respuesta.data!="error"){
                    me.precios = respuesta.data;
                    alertify.success('Lista de precios actualizado');
                    me.tipoAccion=9;
                    this.idListaPrecio = null;
                    this.errordescripcionprecio = [];
                    this.descripcionprecio = '';
                    this.comentarioprecio = '';
                    this.matrizprecio = null;
                    this.auxprecio = null;
                    this.P_12 = null;
                    this.P_25 = null;
                    this.P_50 = null;
                    this.P_75 = null;
                    this.P_100 = null;
                    this.P_105 = null;
                    this.P_200 = null;
                    this.P_210 = null;
                    this.P_225 = null;
                    this.P_250 = null;
                    this.P_300 = null;
                    this.P_500 = null;
                    this.P_525 = null;
                    this.P_1000 = null;
                    this.P_1050 = null;
                    this.P_2500 = null;
                    this.P_5000 = null;
                    this.P_10000 = null;
                    this.P_DIST = null;
                }else{
                    me.cerrarModal();
                    alertify.error('Error inseperado intente mas tarde o reportelo al administrador'); 
                }
            }).catch((error) => {
                console.log(error);
                console.debug(error);
                console.dir(error); 
            });
        },
        imprimir() {
            location.href="modelo/stock/bajarexcelespecifico.php?fechaimpresionmas="+this.fechaimpresionmas+"&fechaimpresionmenos="+this.fechaimpresionmenos+"&buscartipoimpresion="+this.buscartipoimpresion+"&buscarimpresion="+this.buscarimpresion+"&stockmas="+this.stockmas+"&stockmenos="+this.stockmenos;
        },
        eliminar(id) {
            let me = this;
            swal({
                title: "Deseas eliminar este producto?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    swal("Escriba la palabra 'borrar' para borar este producto", {
                        content: "input",
                    }).then((value) => {
                        if(`${value}`=='borrar'){
                            axios({
                                url: "modelo/stock/eliminar.php",
                                method: "get",
                                params: {
                                    'id':id,
                                } 
                            }).then((respuesta) => {
                                console.log(respuesta);
                                me.listar();
                                alertify.success('Producto eliminado');
                                if(me.entradas[0].pag%10==1 && me.pag==me.hj){
                                    me.hj--;
                                }  
                            }).catch((error) => {
                                console.log(error);
                                console.debug(error);
                                console.dir(error);
                            });
                        }else{
                            alertify.error('Borrado cancelado');
                        }
                    });
                }
            });
        },
        bodega(id){
            this.ancho="modal-md";
            //necesarios
            this.modal = 1;
            this.tituloModal = "Actualizar Bodega";
            this.tipoAccion = 4;
            //complementos
            axios({
                url: "modelo/stock/verbodega.php",
                method: "get",
                params: {
                    'id': id,
                }
            }).then((respuesta) => {
                this.idProducto = id;
                this.bodegast = respuesta.data[0].idbodega;
                this.ubicacion = respuesta.data[0].ubicacion;
                this.cantidadbodega = respuesta.data[0].cantidad;
                this.cajasbodega = respuesta.data[0].cajas;
            });
        },
        eliminarbodega(id){
            let me = this;
            swal({
                title: "Deseas eliminar esta bodega?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    if(id>=8){
                        axios({
                            url: "modelo/stock/eliminarbodega.php",
                            method: "get",
                            params: {
                                'id': id,
                            }
                        }).then((respuesta) => {
                            if(respuesta.data!="error"){
                                me.bodegas = respuesta.data;
                                alertify.success('Bodega eliminada');
                                me.nombrebodega='';
                            }else{
                                me.cerrarModal();
                                alertify.error('Esta bodega esta conectada con varios productos y es imposible borrar'); 
                            }
                        });
                    }else{
                        alertify.error('Esta bodega no se puede borrar, esta conectada con otros productos');
                    }
                }
            });
        },
        eliminarcategoria(id){
            let me = this;
            swal({
                title: "Deseas eliminar esta categoria?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    if(id>=16){
                        axios({
                            url: "modelo/stock/eliminarcategoria.php",
                            method: "get",
                            params: {
                                'id': id,
                            }
                        }).then((respuesta) => {
                            if(respuesta.data!="error"){
                                me.categorias = respuesta.data;
                                alertify.success('categoria eliminada');
                                me.nombrecategoria='';
                            }else{
                                me.cerrarModal();
                                alertify.error('Esta categoria esta conectada con varios productos y es imposible borrar'); 
                            }
                        });
                    }else{
                        alertify.error('Esta categoria no se puede borrar, esta conectada con otros productos');
                    }
                }
            });
        },
        eliminarprecio(id){
            let me = this;
            swal({
                title: "Deseas eliminar este precio?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    if(id>=31){
                        axios({
                            url: "modelo/stock/eliminarprecio.php",
                            method: "get",
                            params: {
                                'id': id,
                            }
                        }).then((respuesta) => {
                            if(respuesta.data!="error"){
                                me.precios = respuesta.data;
                                alertify.success('precio eliminado');
                            }else{
                                me.cerrarModal();
                                alertify.error('Esta categoria esta conectada con varios productos y es imposible borrar'); 
                            }
                        });
                    }else{
                        alertify.error('Esta categoria no se puede borrar, esta conectada con otros productos');
                    }
                }
            });
        },
        crearbodega(){
            if (this.validarnbodega()) {
                return;
            }
            let me = this;
            axios({
                url: "modelo/stock/crearbodega.php",
                method: "get",
                params: {
                    'nombrebodega':this.nombrebodega, 
                }
            }).then((respuesta) => {
                if(respuesta.data!="error"){
                    me.bodegas = respuesta.data;
                    alertify.success('Bodega agregada con éxito');
                    me.nombrebodega='';
                }else{
                    me.cerrarModal();
                    alertify.error('Error inseperado intente mas tarde o reportelo al administrador'); 
                }
            }).catch((error) => {
                console.log(error);
                console.debug(error);
                console.dir(error); 
            });
        },
        crearcategoria(){
            if (this.validarncategoria()) {
                return;
            }
            let me = this;
            axios({
                url: "modelo/stock/crearcategoria.php",
                method: "get",
                params: {
                    'nombrecategoria':this.nombrecategoria, 
                }
            }).then((respuesta) => {
                if(respuesta.data!="error"){
                    me.categorias = respuesta.data;
                    alertify.success('Categoría agregada con éxito');
                    me.nombrecategoria='';
                }else{
                    me.cerrarModal();
                    alertify.error('Error inseperado intente mas tarde o reportelo al administrador'); 
                }
            }).catch((error) => {
                console.log(error);
                console.debug(error);
                console.dir(error); 
            });
        },
        crearprecio(){
            if (this.validarnprecio()) {
                return;
            }
            let me = this;
            axios({
                url: "modelo/stock/crearprecio.php",
                method: "get",
                params: {
                    'descripcionprecio':this.descripcionprecio,
                    'comentarioprecio':this.comentarioprecio,
                    'matrizprecio':this.matrizprecio,
                    'auxprecio':this.auxprecio,
                    'P_12':this.P_12,
                    'P_25':this.P_25,
                    'P_50':this.P_50,
                    'P_75':this.P_75,
                    'P_100':this.P_100,
                    'P_105':this.P_105,
                    'P_200':this.P_200,
                    'P_210':this.P_210,
                    'P_225':this.P_225,
                    'P_250':this.P_250,
                    'P_300':this.P_300,
                    'P_500':this.P_500,
                    'P_525':this.P_525,
                    'P_1000':this.P_1000,
                    'P_1050':this.P_1050,
                    'P_2500':this.P_2500,
                    'P_5000':this.P_5000,
                    'P_10000':this.P_10000,
                    'P_DIST':this.P_DIST,
                }
            }).then((respuesta) => {
                console.log(respuesta.data);
                if(respuesta.data!="error"){
                    me.precios = respuesta.data;
                    alertify.success('Precio agregado con éxito');
                    this.errordescripcionprecio = [];
                    this.descripcionprecio = '';
                    this.comentarioprecio = '';
                    this.matrizprecio = null;
                    this.auxprecio = null;
                    this.P_12 = null;
                    this.P_25 = null;
                    this.P_50 = null;
                    this.P_75 = null;
                    this.P_100 = null;
                    this.P_105 = null;
                    this.P_200 = null;
                    this.P_210 = null;
                    this.P_225 = null;
                    this.P_250 = null;
                    this.P_300 = null;
                    this.P_500 = null;
                    this.P_525 = null;
                    this.P_1000 = null;
                    this.P_1050 = null;
                    this.P_2500 = null;
                    this.P_5000 = null;
                    this.P_10000 = null;
                    this.P_DIST = null;
                }else{
                    me.cerrarModal();
                    alertify.error('Error inseperado intente mas tarde o reportelo al administrador'); 
                }
            }).catch((error) => {
                console.log(error);
                console.debug(error);
                console.dir(error); 
            });
        },
        abrirModal(modelo, accion, data = []) {
            $(".bodymodales").addClass("modal-open");
            switch (modelo) {
                case "stock":
                {
                    switch (accion) {
                        case 'registrar':
                        {
                            this.ancho="modal-xl";
                            //necesarios
                            this.modal = 1;
                            this.tituloModal = "Registrar Producto";
                            this.tipoAccion = 1;
                            //complementos
                            this.codigo =  '';
                            this.Safi =  '';
                            this.descripcion =  '';
                            this.nombre =  '';
                            this.stock =  0;  
                            this.marca =  '';
                            this.tipoProducto =  '';
                            this.idProveedor =  '';
                            this.cantidad =  0;
                            this.P_DISTRIB =  null;
                            this.DIST =  null;
                            this.pvpp = null;
                            this.ppdist = null;
                            this.costo = null;
                            this.preciost = '';
                            this.categoriast = '';
                            this.bodegast = '';
                            this.ubicacion = '';
                            break;
                        }
                        case 'actualizar':
                        {
                            this.ancho="modal-xl";
                            //necesarios
                            this.modal = 1;
                            this.tituloModal = "Actualizar Producto";
                            this.tipoAccion = 2;
                            //complementos
                            this.idProducto = data['idProducto'];
                            this.codigo =  data['codigo'];
                            this.Safi =  data['Safi'];
                            this.descripcion =  data['descripcion'];
                            this.nombre =  data['nombre'];
                            this.stock =  data['stock'];
                            this.marca =  data['marca'];
                            this.tipoProducto =  data['tipoProducto'];
                            this.idProveedor =  data['idProveedor'];
                            this.cantidad =  data['cantidad'];
                            this.P_DISTRIB =  data['P_DISTRIB'];
                            this.preciost = data['idListaPrecio'];
                            this.categoriast = data['idCategoria'];
                            this.DIST =  data['DIST'];
                            this.pvpp = data['pvpp'];
                            this.ppdist = data['ppdist'];
                            this.costo = data['costosActual'];
                            break;
                        }
                        case 'imprimir':
                        {
                            this.ancho="modal-xl";
                            //necesarios
                            this.modal = 1;
                            this.tituloModal = "Actualizar Producto";
                            this.tipoAccion = 3;
                            //complementos
                            this.fechaimpresionmas = '';
                            this.fechaimpresionmenos = '';
                            this.buscartipoimpresion = '';
                            this.buscarimpresion = '';
                            this.stockmas = '';
                            this.stockmenos = '';
                            break;
                        }
                        case 'bodega':
                        {
                            this.ancho="modal-md";
                            //necesarios
                            this.modal = 1;
                            this.tituloModal = "Agragar nueva bodega";
                            this.tipoAccion = 5;
                            //complementos
                            this.nombrebodega = '';
                            break;
                        }
                        case 'actualizarbodega':
                        {
                            this.ancho="modal-md";
                            //necesarios
                            this.modal = 1;
                            this.tituloModal = "Actualizar bodega";
                            this.tipoAccion = 6;
                            //complementos
                            this.nombrebodega = data["descripcion"];
                            this.idbodega = data["idbodega"];
                            break;
                        } 
                        case 'categoria':
                        {
                            this.ancho="modal-md"; 
                            //necesarios
                            this.modal = 1;
                            this.tituloModal = "Agragar nueva categoría";
                            this.tipoAccion = 7;
                            //complementos
                            this.nombrecategoria = '';
                            break;
                        }
                        case 'actualizarcategoria':
                        {
                            this.ancho="modal-md";
                            //necesarios
                            this.modal = 1;
                            this.tituloModal = "Actualizar categoría";
                            this.tipoAccion = 8;
                            //complementos
                            this.nombrecategoria = data["descripcion"];
                            this.idcategoria = data["idCategoria"];
                            break;
                        } 
                        case 'precio':
                        {
                            this.ancho="modal-xl"; 
                            //necesarios
                            this.modal = 1;
                            this.tituloModal = "Agragar nuevo precio";
                            this.tipoAccion = 9;
                            //complementos
                            this.descripcionprecio = '';
                            this.comentarioprecio = '';
                            this.matrizprecio = null;
                            this.auxprecio = null;
                            this.P_12 = null;
                            this.P_25 = null;
                            this.P_50 = null;
                            this.P_75 = null;
                            this.P_100 = null;
                            this.P_105 = null;
                            this.P_200 = null;
                            this.P_210 = null;
                            this.P_225 = null;
                            this.P_250 = null;
                            this.P_300 = null;
                            this.P_500 = null;
                            this.P_525 = null;
                            this.P_1000 = null;
                            this.P_1050 = null;
                            this.P_2500 = null;
                            this.P_5000 = null;
                            this.P_10000 = null;
                            this.P_DIST = null;
                            break;
                        }
                        case 'actualizarprecio':
                        {
                            this.ancho="modal-xl";
                            //necesarios
                            this.modal = 1;
                            this.tituloModal = "Actualizar categoría";
                            this.tipoAccion = 10;
                            //complementos
                            this.idListaPrecio = data["idListaPrecio"];
                            this.descripcionprecio = data["descripcion"];
                            this.comentarioprecio = data["comentario"];
                            this.matrizprecio = data["matriz"];
                            this.auxprecio = data["aux"];
                            this.P_12 = data["P_12"];
                            this.P_25 = data["P_25"];
                            this.P_50 = data["P_50"];
                            this.P_75 = data["P_75"];
                            this.P_100 = data["P_100"];
                            this.P_105 = data["P_105"];
                            this.P_200 = data["P_200"];
                            this.P_210 = data["P_210"];
                            this.P_225 = data["P_225"];
                            this.P_250 = data["P_250"];
                            this.P_300 = data["P_300"];
                            this.P_500 = data["P_500"];
                            this.P_525 = data["P_525"];
                            this.P_1000 = data["P_1000"];
                            this.P_1050 = data["P_1050"];
                            this.P_2500 = data["P_2500"];
                            this.P_5000 = data["P_5000"];
                            this.P_10000 = data["P_10000"];
                            this.P_DIST = data["P_DIST"];
                            break;
                        } 
                        case 'subirimg':
                        { 
                            this.ancho="modal-xl";
                            //necesarios
                            this.modal = 1;
                            this.tituloModal = "Subir Imagenes";
                            this.tipoAccion = 20;
                            this.attachment=[];
                            $("#respuesta").html("");
                            $("#vista-previa").html("");
                            break;
                        }
                    }
                }
            }
        },
        validarg() {
            $('.mirartopmodal').animate({
                scrollTop:0
            },250);
            this.error = 0;
            this.errorSafi =  [];
            this.errorcodigo =  [];
            this.errornombre =  [];
            this.errorpvpp =  [];
            this.errormarca =  [];
            this.erroridProveedor =  [];
            this.errorcosto =  [];
            this.errortipoProducto =  [];
            this.errorpreciost = [];
            this.errorcategoriast = [];
            this.errorbodegast = [];
            this.errorubicacion = [];
 
            if (!this.Safi)
                this.errorSafi.push("Debe ingresar un código safi");
            if (!this.codigo)
                this.errorcodigo.push("Debe ingresar un codigo");
            if (!this.nombre)
                this.errornombre.push("Debe ingresar un nombre");
            if (!this.pvpp)
                this.errorpvpp.push("Debe ingresar precio");
            if (!this.marca)
                this.errormarca.push("Debe ingresar la marca");
            if (!this.idProveedor)
                this.erroridProveedor.push("Debe escoger al proveedor");
            if (!this.costo)
                this.errorcosto.push("Debe ingresar el costo");
            if (!this.tipoProducto)
                this.errortipoProducto.push("Debe ingresar el tipo de producto");

            if (!this.preciost)
                this.errorpreciost.push("Debe escoger un precio");
            if (!this.categoriast)
                this.errorcategoriast.push("Debe escoger una categoría");
            if (!this.bodegast)
                this.errorbodegast.push("Debe escoger una bodega");
            if (!this.ubicacion)
                this.errorubicacion.push("Debe escoger una ubicación");

            if (this.errorSafi.length || this.errorcodigo.length || this.errornombre.length || this.errorpvpp.length || this.errormarca.length || this.erroridProveedor.length || this.errorcosto.length || this.errorpreciost.length || this.errorcategoriast.length || this.errorbodegast.length || this.errorubicacion.length)
                this.error = 1;
            return this.error;
        },
        validar() {
            $('.mirartopmodal').animate({
                scrollTop:0
            },250);
            this.error = 0;
            this.errorSafi =  [];
            this.errorcodigo =  [];
            this.errornombre =  [];
            this.errorpvpp =  [];
            this.errormarca =  [];
            this.erroridProveedor =  [];
            this.errorcosto =  [];
            this.errortipoProducto =  [];
            this.errorpreciost = [];
            this.errorcategoriast = [];
 
            if (!this.Safi)
                this.errorSafi.push("Debe ingresar un código safi");
            if (!this.codigo)
                this.errorcodigo.push("Debe ingresar un codigo");
            if (!this.nombre)
                this.errornombre.push("Debe ingresar un nombre");
            if (!this.pvpp)
                this.errorpvpp.push("Debe ingresar precio");
            if (!this.marca)
                this.errormarca.push("Debe ingresar la marca");
            if (!this.idProveedor)
                this.erroridProveedor.push("Debe escoger al proveedor");
            if (!this.costo)
                this.errorcosto.push("Debe ingresar el costo");
            if (!this.tipoProducto)
                this.errortipoProducto.push("Debe ingresar el tipo de producto");

            if (!this.preciost)
                this.errorpreciost.push("Debe escoger un precio");
            if (!this.categoriast)
                this.errorcategoriast.push("Debe escoger una categoría");

            if (this.errorSafi.length || this.errorcodigo.length || this.errornombre.length || this.errorpvpp.length || this.errormarca.length || this.erroridProveedor.length || this.errorcosto.length || this.errorpreciost.length || this.errorcategoriast.length)
                this.error = 1;
            return this.error;
        },
        validarbodega() {
            $('.mirartopmodal').animate({
                scrollTop:0
            },250);
            this.error = 0;
            this.errorbodegast = [];
            this.errorubicacion = [];
 
            if (!this.bodegast)
                this.errorbodegast.push("Debe escoger una bodega");
            if (!this.ubicacion)
                this.errorubicacion.push("Debe escoger una ubicación");

            if (this.errorbodegast.length || this.errorubicacion.length)
                this.error = 1;
            return this.error;
        },
        validarnbodega(){
            $('.mirartopmodal').animate({
                scrollTop:0
            },250);
            this.error = 0;
            this.errornombrebodega = [];
 
            if (!this.nombrebodega)
                this.errornombrebodega.push("Ingrese el nombre de la bodega");

            if (this.errornombrebodega.length)
                this.error = 1;
            return this.error;
        },
        validarncategoria(){
            $('.mirartopmodal').animate({
                scrollTop:0
            },250);
            this.error = 0;
            this.errornombrecategoria = [];
 
            if (!this.nombrecategoria)
                this.errornombrecategoria.push("Ingrese el nombre de la categoria");

            if (this.errornombrecategoria.length)
                this.error = 1;
            return this.error;
        },
        validarnprecio(){
            $('.mirartopmodal').animate({
                scrollTop:0
            },250);
            this.error = 0;
            this.errordescripcionprecio = [];
 
            if (!this.descripcionprecio)
                this.errordescripcionprecio.push("Ingrese la descripción del precio");

            if (this.errordescripcionprecio.length)
                this.error = 1;
            return this.error;
        },
        cerrarModal() {
            $(".bodymodales").removeClass("modal-open");
            //necesarios
            this.ancho = "modal-xl";
            this.modal = 0;
            this.tituloModal = '';
            //complementos
            this.idProducto = null;
            this.codigo =  '';
            this.Safi =  '';
            this.descripcion =  '';
            this.nombre =  '';
            this.stock =  null;
            this.marca =  '';
            this.tipoProducto =  null;
            this.idProveedor =  null;
            this.cantidad =  null;
            this.pvp =  null;
            this.P_DISTRIB =  null;
            this.DIST = null;
            this.pvpp = null;
            this.ppdist = null;
            this.costo =  null;
            this.ubicacion = '';
            this.bodegast = '';
            //errores
            this.errorSafi =  [];
            this.errorcodigo =  [];
            this.errornombre =  [];
            this.errorpvpp =  [];
            this.errormarca =  [];
            this.erroridProveedor =  [];
            this.errorcosto =  [];
            this.errortipoProducto =  [];
            this.errorpreciost = [];
            this.errorcategoriast = [];
            this.errorbodegast = [];
            this.errorubicacion = [];

            this.attachment=[];
            $("#respuesta").html("");
            $("#vista-previa").html("");
        },
        updateAvatar(){
            let formData = new FormData();
            formData.append('file', this.imagen);
            axios.post( 'modelo/stock/subirexcelp.php',
                formData,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }
            ).then((respuesta) => {
                if(respuesta.data == "bien"){
                    alertify.success('Excel subido con éxito');
                    $(".subirupdateexcel").attr("style","display:none");
                    this.listar();
                }else if(respuesta.data == "error"){
                    alertify.error('Formato de archivo inválido');
                    $(".subirupdateexcel").attr("style","display:none");
                }else {
                    alertify.error('Error en los campo, tipos de datos erroneos en el excel');
                    $(".subirupdateexcel").attr("style","display:none");
                }
            }).catch((error) => {
                alertify.error('Error en el archivo, puede ser que los campos esten mal ordenados o incompletos');
            });
        },
        getImage(event){
            //Asignamos la imagen a  nuestra data
            this.imagen = event.target.files[0];
        },
        updateAvatar1(){
            let formData = new FormData();
            formData.append('file', this.imagen);
            axios.post( 'modelo/stock/subirexcelv.php',
                formData,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }
            ).then((respuesta) => {
                if(respuesta.data == "bien"){
                    alertify.success('Excel subido con éxito');
                    $(".subirupdateexcel").attr("style","display:none");
                    this.listar();
                }else if(respuesta.data == "error"){
                    alertify.error('Formato de archivo inválido');
                    $(".subirupdateexcel").attr("style","display:none");
                }else {
                    alertify.error('Algunos datos son erroneos, sinembargo se guardo los registros correctos');
                    $(".subirupdateexcel").attr("style","display:none");
                }
            }).catch((error) => {
                alertify.error('Error en el archivo, puede ser que los campos esten mal ordenados o incompletos');
            });
        },
        getImage1(event){
            //Asignamos la imagen a  nuestra data
            this.imagen = event.target.files[0];
        },
        updateAvatar2(){
            let formData = new FormData();
            formData.append('file', this.imagen);
            axios.post( 'modelo/stock/subirexcelr1.php',
                formData,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }
            ).then((respuesta) => {
                console.log(respuesta.data); 
                alertify.success('Verificar si los registros se subieron exitosamente');
                $(".subirupdateexcel").attr("style","display:none");
                this.listar();
                /*if($.trim(respuesta.data) == "bien"){
                    alertify.success('Excel subido con éxito');
                    $(".subirupdateexcel").attr("style","display:none");
                    this.listar();
                }else if($.trim(respuesta.data) == "error"){
                    alertify.error('Formato de archivo inválido');
                    $(".subirupdateexcel").attr("style","display:none");
                }else {
                    alertify.error('Error en los campo, tipos de datos erroneos en el excel');
                    $(".subirupdateexcel").attr("style","display:none");
                }*/
            }).catch((error) => {
                alertify.error('Error en el archivo, puede ser que los campos esten mal ordenados o incompletos');
            });
        },
        getImage2(event){
            //Asignamos la imagen a  nuestra data
            this.imagen = event.target.files[0];
        },
        updateAvatar3(){
            console.log("hola mundo");
            let formData = new FormData();
            formData.append('file', this.imagen);
            axios.post( 'modelo/stock/subirfilanes.php',
                formData,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }
            ).then((respuesta) => {
                console.log(respuesta.data);
                if($.trim(respuesta.data.indexOf('existe')) == -1){
                        me.listar();
                        alertify.success('Productos Actualizados');
                }else{
                    this.modal=1;
                    this.tipoAccion = 99;
                    this.tituloModal ="Productos inexistentes";
                    var res = respuesta.data.split(";");
                    var vererr="";
                    for(var w=0; w<res.length; w++){
                        vererr +="<div>"+res[w]+"<div>";
                    }
                    $(".erroresexistentesmas").html(vererr);
                    alertify.success('Productos Actualizados');
                } 
            }).catch((error) => {
                this.listar();
                alertify.success('Productos Actualizados');
            });
        },
        getImage3(event){
            //Asignamos la imagen a  nuestra data
            this.imagen = event.target.files[0];
        }, 

        updateAvatar4(){
            let formData = new FormData();
            formData.append('file', this.imagen);
            axios.post( 'modelo/stock/subirubicacion.php',
                formData,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }
            ).then((respuesta) => {
                me.listar();
                alertify.success('Productos Actualizados');
            }).catch((error) => {
                this.listar();
                alertify.success('Productos Actualizados');
            });
        },
        getImage4(event){
            //Asignamos la imagen a  nuestra data
            this.imagen = event.target.files[0];
        }, 
        verespeciales(){
            if(this.prdencero){
                localStorage.setItem("prdencero",this.prdencero);
            }else{
                localStorage.setItem("prdencero","");
                this.prdencero="";
            }
            if(this.prdennegativo){
                localStorage.setItem("prdennegativo",this.prdennegativo);
            }else{
                localStorage.setItem("prdennegativo","");
                this.prdennegativo="";
            }     
            this.listar();
        },
        borraradv(){
            this.buscarfiltro = ''; 
            this.buscargeneral = '';
            this.stockminimo = null;
            this.stockmaximo = null;
            this.costominimo = null;
            this.costomaximo = null;
            this.color='';
            this.listar();
        }, 
        subirimagenus(event){ 
            this.imagenus = event.target.files[0];
            this.usuarioimagen = this.sesion[0].IDUSUARIO;
            let formData = new FormData();
            formData.append('id', this.usuarioimagen);
            formData.append('file', this.imagenus);
            axios.post( 'modelo/busquedasgenerales/subirfoto.php',
                formData,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }
            ).then((respuesta) => {
                console.log(respuesta.data);
                localStorage.removeItem('dataoresa');
                location.href="ingreso.php";
            }).catch((error) => {
                alertify.error('Error en el archivo, puede ser que los campos esten mal ordenados o incompletos');
            });
        },
        copiar(dato){
            var aux = document.createElement("input");
            aux.setAttribute("value", dato);
            document.body.appendChild(aux);
            aux.select();
            document.execCommand("copy");
            document.body.removeChild(aux);
            alertify.success('Nombre copiado');
        },
        copiarcod(dato){
            var aux = document.createElement("input");
            aux.setAttribute("value", dato);
            document.body.appendChild(aux);
            aux.select();
            document.execCommand("copy");
            document.body.removeChild(aux);
            alertify.success('Código copiado');
        },
        copiarprec(P12,P25,P50,P75,P100,P105,P200,P210,P225,P250,P300,P500,P525,P1000,P1050,P2500,P5000,P10000,DIST){
           var final = "";
           if(P12){
           final +='12 Unidades:' + (parseFloat(P12)).toFixed(2) + "\n";
           }
           if(P25){
           final +='25 Unidades: $' + (parseFloat(P25)).toFixed(2) + "\n";
           }
           if(P50){
           final +='50 Unidades: $' + (parseFloat(P50)).toFixed(2) + "\n";
           }
           if(P75){
           final +='75 Unidades: $' + (parseFloat(P75)).toFixed(2) + "\n";
           }
           if(P100){
           final +='100 Unidades: $' + (parseFloat(P100)).toFixed(2) + "\n";
           }
           if(P105){
           final +='105 Unidades: $' + (parseFloat(P105)).toFixed(2) + "\n";
           }
           if(P200){
           final +='200 Unidades: $' + (parseFloat(P200)).toFixed(2) + "\n";
           }
           if(P210){
           final +='210 Unidades: $' + (parseFloat(P210)).toFixed(2) + "\n";
           }
           if(P225){
           final +='225 Unidades: $' + (parseFloat(P225)).toFixed(2) + "\n";
           }
           if(P250){
           final +='250 Unidades: $' + (parseFloat(P250)).toFixed(2) + "\n";
           }
           if(P300){
           final +='300 Unidades: $' + (parseFloat(P300)).toFixed(2) + "\n";
           }
           if(P500){
           final +='500 Unidades: $' + (parseFloat(P500)).toFixed(2) + "\n";
           }
           if(P525){
           final +='525 Unidades: $' + (parseFloat(P525)).toFixed(2) + "\n";
           }
           if(P1000){
           final +='1000 Unidades: $' + (parseFloat(P1000)).toFixed(2) + "\n";
           }
           if(P1050){
           final +='1050 Unidades: $' + (parseFloat(P1050)).toFixed(2) + "\n";
           }
           if(P2500){
           final +='2500 Unidades: $' + (parseFloat(P2500)).toFixed(2) + "\n";
           }
           if(P5000){
           final +='5000 Unidades: $' + (parseFloat(P5000)).toFixed(2) + "\n";
           }
           if(P10000){
           final +='10000 Unidades: $' + (parseFloat(P10000)).toFixed(2) + "\n";
           }
           if(DIST){
           final +='Distribuidor: $' + (parseFloat(DIST)).toFixed(2);
           }
            var aux = document.createElement("input");
            aux.setAttribute("value", final);
            document.body.appendChild(aux);
            aux.select();
            document.execCommand("copy");
            document.body.removeChild(aux);
            alertify.success('Precios copiados');
        },
        vercodigo(){
            axios({
                url: "modelo/stock/ver.php",
                method: "get",
            }).then((respuesta) => {
                alertify.success('Código Visible');
                this.listar();
            });
        },
        ocultarcodigo(){
            axios({
                url: "modelo/stock/nover.php",
                method: "get",
            }).then((respuesta) => {
                alertify.success('Código oculto');
                this.listar();
            });
        },
        subirimagenes(event){
            let select = event.target.files;

            if(!select.length){
                return false;
            }

            for(let i=0; i<select.length; i++){
                this.attachment.push(select[i]);
            }
            console.log(this.attachment);   
        }, 
        uploadimagen(){
            $(".espera").show();
            if(!this.attachment.length){
                alertify.error('Debes subir almenos un archivo');
                return;
            }
            let formData = new FormData();
            for(let i=0; i<this.attachment.length; i++){
                formData.append('file[]', this.attachment[i]);
            } 
            axios.post('modelo/stock/subirimagenes.php',
                formData,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }
            ).then((respuesta) => {
                console.log(respuesta.data);
                let formData = new FormData();
                for(let i=0; i<this.attachment.length; i++){
                    formData.append('file[]', this.attachment[i]);
                } 
                axios.post('modelo/stock/subirimagenes1.php',
                    formData,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }
                ).then((respuesta) => {
                    $(".espera").hide();
                    console.log(respuesta.data); 
                    alertify.success('Archivos subidos correctamente');
                    this.cerrarModal();
                    this.listar();
                    setTimeout(function () {
                        //location.reload();
                    }, 1500);
                }).catch((error) => {
                    alertify.error('Error en el archivo, puede ser que los campos esten mal ordenados o incompletos');
                });
            }).catch((error) => {
                alertify.error('Error en el archivo, puede ser que los campos esten mal ordenados o incompletos');
            });

        },
        darclickaimg(){
            $("#filetodomas").click();
        },
        borrarimagenesmase(){
            this.attachment=[]; 
            $("#vista-previa").html("");
            $("#respuesta").html("");
        },
        abrircamisas(){
            this.ancho="modal-xl";
            //necesarios
            this.modal = 1;
            this.tipoAccion = 25;
            this.tituloModal="Camisetas";
        }
    },
    mounted() {
        if(!this.sesion){
            location.href="ingreso.php";
        }
        this.dataoresa =JSON.parse(localStorage.getItem('dataoresa'));
        this.listar();
        this.listarproveedor();
        this.listarprecios(); 
        this.listarcategoria(); 
        this.listarbodega();
        this.listarmarcas();
        if(this.sesion[0].estado_sesion == null){
            axios({
                url: "modelo/login/loginactivo.php",
                method: "get",
                params: {
                    'id':this.sesion[0].IDUSUARIO
                }
            }).then((respuesta) => {
                localStorage.removeItem('dataoresa');
                location.href= "ingreso.php";
            });
        }
    }
});

$(document).on("click",".updateexcel",function(){
    $("#file").click();
});

$(document).on("change","#file",function(){
    $(".subirupdateexcel").attr("style","display:block;float: right;");
});

$(document).on("click",".updateexcel1",function(){
    $("#file1").click();
});

$(document).on("change","#file1",function(){
    $(".subirupdateexcel1").attr("style","display:block;float: right;");
});

$(document).on("click",".updateexcel2",function(){
    $("#file2").click();
});

$(document).on("change","#file2",function(){
    $(".subirupdateexcel2").attr("style","display:block;float: right;");
});

$(document).on("click",".updateexcel3",function(){
    $("#file3").click();
});

$(document).on("change","#file3",function(){
    $(".subirupdateexcel3").attr("style","display:block;float: right;");
});

$(document).on("click",".updateexcel4",function(){
    $("#file4").click();
});

$(document).on("change","#file4",function(){
    $(".subirupdateexcel4").attr("style","display:block;float: right;");
});


$(document).on("change","#filetodomas",function(){ 
    $("#respuesta").html("");
    var archivos = document.getElementById("filetodomas").files;
    var navegador = window.URL || window.webkitURL;
    for(x=0; x<archivos.length; x++){
        var size = archivos[x].size;
        var type = archivos[x].type; 
        var name = archivos[x].name;
        if(size >2048*2048){
            $("#respuesta").append("<p style='color:red;margin-bottom:0.2rem;'>El archivo "+name+" supera el maximo permitido de 2MB</p>");
        }else if(type!='image/jpg' && type!='image/jpeg' && type!='image/png'){
            $("#respuesta").append("<p style='color:red;margin-bottom:0.2rem;'>El archivo "+name+" no es el tipo de imagen permitida</p>");
        }else{
            var objeto_url = navegador.createObjectURL(archivos[x]);
            $("#vista-previa").append("<div class='col-xl-4 col-lg-6 col-md-12'><img src="+objeto_url+" style='width:100%'></div>");
        }
    }
}); 
/*$(document).on("click","#btn",function(e){ 
    var subir = new formData();
    formData.append($("#formulariotodo"));
    var ruta = "../modelo/stock/subirimagenes.php";
    $.ajax({ 
        url:ruta,
        type:"POST",
        data:subir,
        contentType:false,
        processData:false,
        succes:function(datos){
            alert("subido");
        }
    })
});*/
function filterFloat(evt,input){
    // Backspace = 8, Enter = 13, ‘0′ = 48, ‘9′ = 57, ‘.’ = 46, ‘-’ = 43
    var key = window.Event ? evt.which : evt.keyCode;    
    var chark = String.fromCharCode(key);
    var tempValue = input.value+chark;
    if(key >= 48 && key <= 57){
        if(filter(tempValue)=== false){
            return false;
        }else{       
            return true;
        }
    }else{
          if(key == 8 || key == 13 || key == 0) {     
              return true;              
          }else if(key == 46){
                if(filter(tempValue)=== false){
                    return false;
                }else{       
                    return true;
                }
          }else{
              return false;
          }
    }
}
function filter(__val__){
    var preg = /^([0-9]+\.?[0-9]{0,2})$/; 
    if(preg.test(__val__) === true){
        return true;
    }else{
       return false;
    }
    
}

dragElement(document.getElementById("mydiv"));

function dragElement(elmnt) {
  var pos1 = 0, pos2 = 0, pos3 = 0, pos4 = 0;
  if (document.getElementById(elmnt.id + "header")) {
    // if present, the header is where you move the DIV from:
    document.getElementById(elmnt.id + "header").onmousedown = dragMouseDown;
  } else {
    // otherwise, move the DIV from anywhere inside the DIV: 
    elmnt.onmousedown = dragMouseDown;
  }

  function dragMouseDown(e) {
    e = e || window.event;
    e.preventDefault();
    // get the mouse cursor position at startup:
    pos3 = e.clientX;
    pos4 = e.clientY;
    document.onmouseup = closeDragElement;
    // call a function whenever the cursor moves:
    document.onmousemove = elementDrag;
  }

  function elementDrag(e) {
    e = e || window.event;
    e.preventDefault();
    // calculate the new cursor position:
    pos1 = pos3 - e.clientX;
    pos2 = pos4 - e.clientY;
    pos3 = e.clientX;
    pos4 = e.clientY;
    // set the element's new position:
    elmnt.style.top = (elmnt.offsetTop - pos2) + "px";
    elmnt.style.left = (elmnt.offsetLeft - pos1) + "px";
  }

  function closeDragElement() {
    // stop moving when mouse button is released:
    document.onmouseup = null;
    document.onmousemove = null;
  }
}