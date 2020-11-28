//DATE_FORMAT(now(),'%Y%m%d%k%i%s')
var app = new Vue({
    el: '#app', 
    data: {
        //id de usuario con permisos de administrador
        ids: [
            15,25,50,30,73
        ],
        //arrayop
        arrayop:[],
        cantidadarray: [],
        cantidadarray1: [],
        precioarray: [],
        nombrearray: [],
        descripcionarray: [], 
        comentarioarray: [],
        codigosarray: [],
        idproductoarray: [],
        precioVentaarray: [],
        permiso: '',
        espera:10,
        espera1:10,
        cambiarlista:0,
        //sesion
        sesion:JSON.parse(localStorage.getItem('dataoresa')),
        idsesion:null,
        //necesarios siempre
        modal: 0,
        tituloModal: '',
        tipoAccion: 0,
        error: 0,
        buscar: '',
        entradas: [], 
        pag:1, 
        hj:1,
        hj:1,
        buscart: '',
        pagt:1, 
        hjt:1,
        ray:'',
        index:0,
        //busquedas
        buscarempleados:'', 
        buscarclientes:'', 
        buscarproductos:'',
        empleados: [],
        listproductos:[],
        listclientes:[],
        //complementos de la página
        entradasdetop:[],
        mora: '', 
        idOrdPedido: null, 
        fechaEmision: '', 
        fechaCreacion: '', 
        ordPedido: null, 
        ordPedido2: '', 
        usuarioCreacion: null, 
        subTotal: null, 
        total: null, 
        iva: null, 
        idEmpleado: '', 
        idCliente: null, 
        idContacto:null,
        nombrecontacto:'',
        RUC: '', 
        direccion: '', 
        telefono1: '', 
        celular: '', 
        eMail: '', 
        ciudad: '', 
        PAGO: null, 
        EquipoTrabajo: null, 
        SALDO: null, 
        NOM_EMPLE: '', 
        diasCredito: null, 
        comentario: '', 
        formaPago: '', 
        fecha_desp: '', 
        estado_desp: null, 
        razon_desp: '', 
        persona_desp: null,
        //detalleop
        iddet:0,
        idproducto:null,
        idAuxProducto:null,
        codigodet:'',
        nombredet:'',
        pendiente:'',
        cantidaddet:null,
        preciodet:null,
        cantidaddetc:null,
        preciodetc:null,
        descripciondet:'',
        comentariosdet:'',
        acciondet:0,
        cantidadbaja:null,
        cantidadbajatotal:null,
        comentariobaja:'',
        codigobaja:'',
        idDetOrdPedido:'',
        precioVentabaja:'',
        //errores
        errorfechaEmision: [], 
        erroridEmpleado: [], 
        erroridCliente: [], 
        errornombredet: [],
        errorcantidaddet: [],
        errorpreciodet: [],
        errorordPedido:[],
        a:'',
        //pagos
        fechapago: '',
        formapago: '',
        documentopago: '',
        valorpago: null,
        comentariopago: '',
        errorfechapago: [],
        errorvalorpago: [],
        //guia
        numeroguia:null,
        comentarioguia:'',
        observacionguia:'',
        sucursualguia:'',
        listsucursales:[],
        idsucursal:null,
        cantidaddetgc:null,
        errornumeroguia:[],
        //trabajo
        fechatrabajo:'',
        comentariotrabajo:'',
        errorfechatrabajo:[],
        //compra
        fechacompra:'',
        comentariocompra:'',
        errorfechacompra:[],
        //bajas
        errorcantidadbaja:[],
        //verguias
        entradasdetguias:[],
        cantidaddet1:null,

        //trabajo
        tipotrabajo:'',
        errortipotrabajo:[],
        solocolor:'',
        errorsolocolor:[],
        imagenus:'',
        usuarioimagen:'',

        modal1:0,
        ROL:'',
        errordocumentopago:[],

        guialista:[],
        guialista1:[],
        cantidadcmabioguia:null,
        listnombres:[],

        codigodetl:[],
        idAuxProductol:[],
        idproductol:[],
        observacionguial:[],
        cantidaddetl:[],
        comentarioguial:[],
        iddetl:[],
        nombredetl:[],
    },
    filters: {
        dec(value) {
          return (parseFloat(value)).toFixed(3);
        },
        dec1(value) {
            return (parseFloat(value)).toFixed(2);
        },
        salto(value){
            return value.replace(/(?:\r\n|\r|\n)/g, "\r\n");
        }, 
        solon(value){
            if((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105) && event.keyCode !==190  && event.keyCode !==110 && event.keyCode !==8 && event.keyCode !==9  ){
                return false;
            }
        }
    },
    methods: {
        listarempleados() {
            let me = this;
            axios({
                url: "modelo/busquedasgenerales/listar_empleados.php",
                method: "get",
            }).then((respuesta) => {
                me.empleados = respuesta.data;
            }).catch((error) => {
                console.log(error);
                console.debug(error);
                console.dir(error);
            });
        },
        listarclientes() {
            let me = this;
            if(this.buscarclientes.length>=3){
                axios({
                    url: "modelo/busquedasgenerales/listar_clientes.php",
                    method: "get",
                    params: {
                        'CLIENTE':this.buscarclientes,
                        'empleado': this.sesion[0].IDEMPLEADO,
                    }
                }).then((respuesta) => {
                    me.listclientes = respuesta.data;
                }).catch((error) => {
                    console.log(error);
                    console.debug(error);
                    console.dir(error);
                });
            }else if(this.buscarclientes.length<3 && this.buscarclientes.length>0){
                me.listclientes='sin';
            }else{
                me.listclientes='';
            }
        },
        listarproductos() {
            let me = this;
            if(this.buscarproductos.length>=2){
                axios({
                    url: "modelo/busquedasgenerales/listar_productos.php",
                    method: "get",
                    params: { 
                        'buscarproductos':this.buscarproductos,
                    }
                }).then((respuesta) => {
                    me.listproductos = respuesta.data;
                }).catch((error) => {
                    console.log(error);
                    console.debug(error);
                    console.dir(error);
                });
            }else if(this.buscarproductos.length<3 && this.buscarproductos.length>0){
                me.listproductos='sin';
            }else{
                me.listproductos='';
            }
        },
        listarnombres() {
            let me = this;
            if(this.nombredet.length>=2){
                axios({
                    url: "modelo/busquedasgenerales/listar_nombres.php",
                    method: "get",
                    params: { 
                        'nombredet':this.nombredet,
                    }
                }).then((respuesta) => {
                    console.log(respuesta.data);
                    me.listnombres = respuesta.data;
                }).catch((error) => {
                    console.log(error);
                    console.debug(error);
                    console.dir(error);
                });
            }else if(this.nombredet.length<3 && this.nombredet.length>0){
                me.listnombres='sin';
            }else{
                me.listnombres='';
            }
        },
        listarsucursales() {
            $("#container").show();
            let me = this;
            if(this.sucursualguia.length>=3){
                axios({
                    url: "modelo/busquedasgenerales/listar_sucursales.php",
                    method: "get",
                    params: {
                        'sucursualguia':this.sucursualguia,
                    }
                }).then((respuesta) => {
                    me.listsucursales = respuesta.data;
                }).catch((error) => {
                    console.log(error);
                    console.debug(error);
                    console.dir(error);
                });
            }else if(this.sucursualguia.length<3 && this.sucursualguia.length>0){
                me.listsucursales='sin';
            }else{
                me.listsucursales='';
            }
        },
        seleccionarcliente(cliente=[]){
            this.buscarclientes = cliente.razonSocialNombres + " " + cliente.razonComercialApellidos;
            this.idCliente = cliente.idCliente;
            this.RUC = cliente.cedulaRuc;
            this.direccion = cliente.direccion;
            this.telefono1 = cliente.telefono1;
            this.celular = cliente.celular;
        },
        seleccionarsucursal(sucursal=[]){
            this.idsucursal = sucursal.idSucursal;
            this.sucursualguia = sucursal.direccion;
        },
        seleccionarproducto(producto=[]){
            this.nombredet = producto.nombre;
            this.idproducto = producto.idProducto;
            this.descripciondet = producto.descripcion;
            this.codigodet = producto.codigo;
            this.buscarproductos = producto.codigo;
            this.preciodet = producto.pvp;
            this.cantidaddet = producto.stock;
            this.cantidaddet1 = producto.stock;
        },
        crearbaja(){
            if (this.validarbaja()) {
                return;
            }
            this.errorfechaEmision = []; 
            this.erroridEmpleado = []; 
            this.erroridCliente = []; 
            this.errornombredet = [];
            this.errorcantidaddet = [];
            this.errorpreciodet = [];
            this.errorfechapago = [];
            this.errorvalorpago = [];
            this.errorfechatrabajo = [];
            this.errornumeroguia = [];
            axios({
                url: "modelo/op/guardar_baja.php",
                method: "get",
                params: {
                    'ordPedido':this.ordPedido,
                    'idDetOrdPedido':this.idDetOrdPedido,
                    'idOrdPedido':this.idOrdPedido,
                    'idProducto':this.idProducto,
                    'cantidadbaja':this.cantidadbaja,
                    'tipo':'1',
                }
            }).then((respuesta) => {
                console.log(respuesta.data);
                this.cantidadbajatotal =respuesta.data - this.cantidadbaja;
                if(this.cantidadbajatotal>=0) {
                    axios({
                        url: "modelo/op/guardar_baja.php",
                        method: "get",
                        params: {
                            'ordPedido':this.ordPedido,
                            'idDetOrdPedido':this.idDetOrdPedido,
                            'idOrdPedido':this.idOrdPedido,
                            'idProducto':this.idProducto,
                            'cantidadbaja':this.cantidadbaja,
                            'codigobaja':this.codigobaja,
                            'tipo':'2',
                            'cantidaddet':this.cantidaddet,
                            'comentariobaja':this.comentariobaja,
                            'idsesion':this.idsesion,
                            
                        }
                    }).then((respuesta) => {
                        console.log(respuesta.data);
                        /*this.subTotal = parseFloat(respuesta.data).toFixed(2);
                        this.iva =  parseFloat(this.subTotal * 0.12).toFixed(2);
                        this.total = parseFloat(parseFloat(respuesta.data) + parseFloat(this.iva)).toFixed(2);
                        */this.tipoAccion = 2;
                        this.listarop(this.idOrdPedido);
                        this.listar();
                        alertify.success('Producto añadido');
                    }).catch((error) => {
                        console.log(error);
                        console.debug(error);
                        console.dir(error);
                    });
                }else{
                    swal("Stock inexistente \n ¿Quiere reserva en Stock negativo o restar directamente de Orden de Pedido?", {
                        buttons: {
                            cancel: "Cancelar",
                            catch: {
                                text: "Stock",
                                value: "catch",
                            },
                            OrdenPedido: true,
                        },
                    }).then((value) => {
                        switch (value) {
                            case "OrdenPedido":
                                axios({
                                    url: "modelo/op/guardar_baja.php",
                                    method: "get",
                                    params: {
                                        'ordPedido':this.ordPedido,
                                        'idProducto':this.idProducto, 
                                        'cantidadbaja':this.cantidadbaja,
                                        'codigobaja':this.codigobaja,
                                        'tipo':'3',
                                        'cantidaddet':this.cantidaddet,
                                        'comentariobaja':this.comentariobaja,
                                        'idsesion':this.idsesion,
                                        'idDetOrdPedido':this.idDetOrdPedido,
                                        'idOrdPedido':this.idOrdPedido,
                                        'precioVentabaja':this.precioVentabaja,
                                        'subTotal':this.subTotal,
                                        'iva':this.iva,
                                        'total':this.total,
                                    }
                                }).then((respuesta) => {
                                    console.log(respuesta.data);
                                    this.tipoAccion = 2;
                                    this.listarop(this.idOrdPedido);
                                    this.listar();
                                    alertify.success('Producto añadido');
                                }).catch((error) => {
                                    console.log(error);
                                    console.debug(error);
                                    console.dir(error);
                                });
                                break;
                        
                            case "catch":
                                axios({
                                    url: "modelo/op/guardar_baja.php",
                                    method: "get",
                                    params: {
                                        'ordPedido':this.ordPedido,
                                        'idOrdPedido':this.idOrdPedido,
                                        'idProducto':this.idProducto,
                                        'cantidadbaja':this.cantidadbaja,
                                        'codigobaja':this.codigobaja,
                                        'tipo':'2',
                                        'cantidaddet':this.cantidaddet,
                                        'comentariobaja':this.comentariobaja,
                                        'idsesion':this.idsesion,
                                        'idDetOrdPedido':this.idDetOrdPedido,
                                        
                                    }
                                }).then((respuesta) => {
                                    console.log(respuesta.data);
                                    this.tipoAccion = 2;
                                    this.listarop(this.idOrdPedido);
                                    this.listar();
                                    alertify.success('Producto añadido');
                                }).catch((error) => {
                                    console.log(error);
                                    console.debug(error);
                                    console.dir(error);
                                });
                                break;
                        
                            default:
                                alertify.error('Stock Inexistente del P: '+ this.codigobaja);
                        }
                    });
                }
            }).catch((error) => {
                console.log(error);
                console.debug(error);
                console.dir(error);
            });
        },
        listar() {
            this.idsesion = this.sesion[0].IDEMPLEADO;
            this.rol = this.sesion[0].ROL;
            let me = this;
            axios({
                url: "modelo/op/listar_op.php",
                method: "get",
                params: {
                    'buscar':this.buscar,
                    'hj':this.hj,
                    'buscarempleados':this.buscarempleados,
                    'sesion':this.idsesion,
                    'rol':this.rol,
                }
            }).then((respuesta) => {
                me.entradas = respuesta.data;
                if(respuesta.data){
                    me.pag = Math.ceil(respuesta.data[0].pag/10);
                }
            }).catch((error) => {
                console.log(error);
                console.debug(error);
                console.dir(error);
            });
        },
        listarop(op){
            let me = this;
            axios({
                url: "modelo/op/listar_detop.php",
                method: "get",
                params: {
                    'op':op,
                    'hjt':this.hjt,
                    'buscart':this.buscart,
                }
            }).then((respuesta) => {
                if($.trim(respuesta.data)){
                    me.entradasdetop = respuesta.data;
                }else{
                    me.entradasdetop = '';
                }
                if(respuesta.data){
                    me.pagt = Math.ceil(respuesta.data[0].pag/5);
                }
            }).catch((error) => {
                console.log(error);
                console.debug(error);
                console.dir(error);
            });
        },
        registrar() {       
            if (this.validar()) {
                return;
            }
            if(this.arrayop.length<1){
                alertify.error('Debe agregar productos a la OP');
                return;
            }
            let me = this;
            axios({
                url: "modelo/op/guardar.php",
                method: "get",
                params: {
                    'idOrdPedido':this.idOrdPedido,
                    'fechaEmision':this.fechaEmision,
                    'ordPedido':this.ordPedido,
                    'ordPedido2':this.ordPedido2,
                    'idEmpleado':this.idEmpleado,
                    'idCliente':this.idCliente,
                    'comentario':this.comentario,
                    'idsesion':this.idsesion,
                    'subtotal':this.subTotal,
                    'iva':this.iva,
                    'total':this.total,
                    'nombrecontacto':this.nombrecontacto,
                    'diasCredito':this.diasCredito,
                    'formaPago':this.formaPago,
                    'permiso':this.permiso,

                    'idproductos':this.idproductoarray,
                    'codigos':this.codigosarray,
                    'nombres':this.nombrearray,
                    'cantidades':this.cantidadarray,
                    'cantidades1':this.cantidadarray1,
                    'precios':this.precioVentaarray,
                    'comentarios':this.comentarioarray,
                }
            }).then((respuesta) => { 
                if($.trim(respuesta.data.indexOf('Error')) == -1){
                    if(respuesta.data=="existe"){
                        alertify.error('Esta orden de pedido ya existe');
                    }else{
                        me.hj=1;
                        me.cerrarModal();
                        me.listar();
                        alertify.success('Registro agregado');
                    }
                }else{
                    this.espera = 10;
                    $(".errorww").show();
                    $(".aerrorww").show();
                    var res = respuesta.data.split(";");
                    var vererr="";
                    for(var w=0; w<res.length; w++){
                        vererr +="<div>"+res[w]+"<div>";
                    }
                    $(".erroresexistentesmas").html(vererr);
                    this.todo();
                }                    
            }).catch((error) => {
                console.log(error);
                console.debug(error);
                console.dir(error);
            })
        },
        actualizar() {
            if(this.cantidaddet<0){
                alertify.error('No se puede poner productos en negativo');
                return;
            }
            if (this.validar()) {
                return;
            }
            let me = this;
            axios({
                url: "modelo/op/actualizar.php",
                method: "get",
                params: {
                    'idOrdPedido':this.idOrdPedido,
                    'fechaEmision':this.fechaEmision,
                    'ordPedido':this.ordPedido,
                    'ordPedido2':this.ordPedido2,
                    'idEmpleado':this.idEmpleado,
                    'idCliente':this.idCliente,
                    'comentario':this.comentario,
                    'idsesion':this.idsesion,
                    'nombrecontacto':this.nombrecontacto,
                    'diasCredito':this.diasCredito,
                    'formaPago':this.formaPago,
                }
            }).then((respuesta) => {
                if(respuesta.data=="bien"){
                    me.cerrarModal();
                    me.listar();
                    alertify.success('Registro actualizado');
                }else{
                    me.cerrarModal();
                    me.listar();
                    alertify.success('Registro actualizado');
                }
            }).catch((error) => {
                console.log(error);
                console.debug(error);
                console.dir(error);
            });
        },
        actualizardetop(){
            if (this.validardetop()) {
                return;
            }
            if(this.cantidaddet !=this.cantidaddetc && this.preciodet == this.preciodetc){ 
                this.acciondet =1;
            }else if(this.preciodet != this.preciodetc && this.cantidaddet ==this.cantidaddetc){
                this.acciondet=2;
            }else if(this.preciodet != this.preciodetc && this.cantidaddet !=this.cantidaddetc){
                this.acciondet=3;
            }else{
                this.acciondet=0;
            }
            let me = this;
            axios({
                url: "modelo/op/actualizar_detop.php",
                method: "get",
                params: {
                    'iddet':this.iddet,
                    'nombredet':this.nombredet,
                    'idproducto':this.idproducto,
                    'cantidaddet':this.cantidaddet,
                    'preciodet':this.preciodet,
                    'cantidaddetc':this.cantidaddetc,
                    'preciodetc':this.preciodetc,
                    'comentariosdet':this.comentariosdet,
                    'accion':this.acciondet,
                    'idOrdPedido':this.idOrdPedido,
                    'subTotal':this.subTotal, 
                    'op':this.ordPedido,
                    'codigodet':this.codigodet,
                    'cambio':this.sesion[0].NOMBRES+' '+this.sesion[0].APELLIDOS,
                    'idEmpleado':this.idEmpleado
                }
            }).then((respuesta) => {
                if(respuesta.data=="detop "){
                    alertify.error('Error en el detalle op no se registro');
                    this.cerrarModal();
                }else if(respuesta.data=="op "){
                    alertify.error('Error en op no se registro');
                    this.cerrarModal();
                }else if(respuesta.data=="prd "){
                    alertify.error('Error en producto, no se bajo el stock');
                    this.cerrarModal();
                }else{
                    if(this.acciondet!=0){
                        this.subTotal = parseFloat(respuesta.data).toFixed(2);
                        this.iva =  parseFloat(respuesta.data * 0.12).toFixed(2);
                        this.total = parseFloat(respuesta.data + (respuesta.data*0.12)).toFixed(2);
                    }
                    this.tipoAccion = 2;
                    me.listarop(this.idOrdPedido);
                    me.listar();
                    alertify.success('Registro actualizado');
                }
            }).catch((error) => {
                console.log(error);
                console.debug(error);
                console.dir(error);
            });
        },
        verdetop(data = []){
            this.errorfechacompra = [];
            this.errorfechaEmision = []; 
            this.erroridEmpleado = []; 
            this.erroridCliente = []; 
            this.errornombredet = [];
            this.errorcantidaddet = [];
            this.errorpreciodet = [];
            this.errorfechapago = [];
            this.errorvalorpago = [];
            this.errorfechacompra = [];
            this.errornumeroguia = [];
            this.errorfechacompra  = [];
            this.tipoAccion = 3;
            this.idproducto = data['idProducto']
            this.iddet = data['idDetOrdPedido'];
            this.codigodet = data['codigo']; 
            this.nombredet = data['nombre'];
            this.cantidaddet = data['cantidad'];
            this.preciodet = parseFloat(data['precioVenta']).toFixed(2);
            this.cantidaddetc = data['cantidad'];
            this.preciodetc = data['precioVenta'];
            this.descripciondet = data['descripcion'];
            this.comentariosdet = data['comentarios'];
        },
        agregardetop(){
            this.errorfechacompra = [];
            this.errorfechaEmision = []; 
            this.erroridEmpleado = []; 
            this.erroridCliente = []; 
            this.errornombredet = [];
            this.errorcantidaddet = [];
            this.errorpreciodet = [];
            this.errorfechapago = [];
            this.errorvalorpago = [];
            this.errorfechacompra = [];
            this.errornumeroguia = [];
            this.errorfechacompra  = [];
            this.errorfechatrabajo = [];
            this.tipoAccion = 5;
            this.idproducto = null;
            this.iddet = null;
            this.codigodet = '';
            this.nombredet = '';
            this.cantidaddet = null;
            this.preciodet = null;
            this.descripciondet = '';
            this.comentariosdet = '';
            this.buscarproductos = '';
        },
        agregardetops(){
            this.errorfechacompra = [];
            this.errorfechaEmision = []; 
            this.erroridEmpleado = []; 
            this.erroridCliente = []; 
            this.errornombredet = [];
            this.errorcantidaddet = [];
            this.errorpreciodet = [];
            this.errorfechapago = [];
            this.errorvalorpago = [];
            this.errorfechacompra = [];
            this.errornumeroguia = [];
            this.errorfechacompra  = [];
            this.errorfechatrabajo = [];
            this.tipoAccion = 7;
            this.tituloModal = "Registrar Producto";
            this.idproducto = null;
            this.iddet = null;
            this.codigodet = '';
            this.nombredet = '';
            this.cantidaddet = null;
            this.preciodet = null;
            this.descripciondet = '';
            this.comentariosdet = '';
            this.buscarproductos = '';
        },
        guardardetop(){
            if (this.validardetop()) {
                return;
            }
            if(this.cantidaddet<0 || this.preciodet<0){
                alertify.error('No se puede ingresar valores en negativo');
                return;
            }
            let me = this;
            axios({
                url: "modelo/op/guardar_detop.php",
                method: "get",
                params: {
                    'nombredet':this.nombredet,
                    'codigodet':this.codigodet,
                    'idproducto':this.idproducto,
                    'cantidaddet':this.cantidaddet,
                    'cantidaddet1':this.cantidaddet1,
                    'preciodet':this.preciodet,
                    'descripciondet':this.descripciondet,
                    'comentariosdet':this.comentariosdet,
                    'idOrdPedido':this.idOrdPedido,
                    'subTotal':this.subTotal,
                    'idsesion':this.idsesion,
                    'opps':this.ordPedido,
                }
            }).then((respuesta) => {
                me.subTotal = parseFloat(respuesta.data).toFixed(2);
                me.iva =  parseFloat(me.subTotal * 0.12).toFixed(2);
                me.total = parseFloat(parseFloat(respuesta.data) + parseFloat(me.iva)).toFixed(2);
                me.listarop(me.idOrdPedido);
                me.listar();
                alertify.success('Producto añadido');
                this.tipoAccion=2;
            }).catch((error) => {
                console.log(error);
                console.debug(error);
                console.dir(error);
            });
        },
        guardardetops(){
            this.errorfechaEmision = []; 
            this.erroridEmpleado = []; 
            this.erroridCliente = []; 
            this.errornombredet = [];
            this.errorcantidaddet = [];
            this.errorpreciodet = [];
            this.errorfechapago = [];
            this.errorvalorpago = [];
            this.errorfechatrabajo = [];
            this.errornumeroguia = [];
            if (this.validardetop()) {
                return;
            }
            if(this.cantidaddet<0 || this.preciodet<0){
                alertify.error('No se puede ingresar valores en negativo');
                return;
            }
            this.arrayop.push(
                {idproducto: this.idproducto,
                codigo:this.buscarproductos,
                nombre:this.nombredet,
                cantidad: this.cantidaddet,
                cantidad1: this.cantidaddet1,
                precioVenta: this.preciodet,
                pendiente: this.cantidaddet,
                descripcion:this.descripciondet,
                comentario:this.comentariosdet}
            );
            let cost = 0;
            this.arrayop.map(function(costItem){ 
                cost += costItem.precioVenta*costItem.cantidad;
            });

            this.idproductoarray.push(this.idproducto);
            this.codigosarray.push(this.buscarproductos);
            this.nombrearray.push(this.nombredet);
            this.cantidadarray.push(this.cantidaddet);
            this.cantidadarray1.push(this.cantidaddet1);
            this.precioVentaarray.push(this.preciodet);
            this.descripcionarray.push(this.descripciondet);
            this.comentarioarray.push(this.comentariosdet);


            this.subTotal = cost;
            this.iva = cost * 0.12;
            this.total = cost + (cost * 0.12);
            this.idproducto = null;
            this.buscarproductos = '';
            this.nombredet = '';
            this.cantidaddet = null;
            this.cantidaddet1 = null;
            this.preciodet = null;
            this.descripciondet = '';
            this.comentariosdet = ''; 
        },      
        guardartrabajo(){
            if (this.validartrabajo()) {
                return;
            }
            let totalesu =this.pendiente-this.cantidaddet;
            if(totalesu>=0){
                this.errorfechaEmision = []; 
                this.erroridEmpleado = []; 
                this.erroridCliente = []; 
                this.errornombredet = [];
                this.errorcantidaddet = [];
                this.errorpreciodet = [];
                this.errorfechapago = [];
                this.errorvalorpago = [];
                this.errorfechatrabajo = [];
                this.errornumeroguia = [];
                this.errorfechatrabajo = [];
                this.errortipotrabajo = [];
                this.errorsolocolor = [];
                let me = this;
                axios({
                    url: "modelo/op/guardar_trabajo.php",
                    method: "get",
                    params: {
                        'idOrdPedido':this.idOrdPedido,
                        'idCliente':this.idCliente,
                        'idEmpleado':this.idEmpleado,
                        'comentarioguia':this.comentarioguia,
                        'numeroguia':this.numeroguia,
                        'idsucursal':this.idsucursal,
                        'fechatrabajo':this.fechatrabajo,
                        'comentariotrabajo':this.comentariotrabajo,
                        'codigodet':this.codigodet,
                        'idAuxProducto':this.idAuxProducto,
                        'idproducto':this.idproducto,
                        'descripciondet':this.nombredet,
                        'cantidaddet':this.cantidaddet,
                        'iddet':this.iddet,
                        'idsesion':this.idsesion,
                        'pendiente':this.pendiente,
                        'tipotrabajo':this.tipotrabajo,
                        'solocolor':this.solocolor
                    }
                }).then((respuesta) => {
                    me.tipoAccion = 2;
                    me.listarop(me.idOrdPedido);
                    me.listar();
                    alertify.success('Trabajo creado');
                }).catch((error) => {
                    console.log(error);
                    console.debug(error);
                    console.dir(error);
                });
            }else{
                alertify.error('No hay productos que enviar de este detalle de OP');
            }
        },
        guardarcompra(){
            if (this.validarcompra()) {
                return;
            }
            let me = this;
            axios({
                url: "modelo/op/guardar_compra.php",
                method: "get",
                params: {
                    'ordPedido':this.ordPedido,
                    'idCliente':this.idCliente,
                    'idEmpleado':this.idEmpleado,
                    'comentarioguia':this.comentarioguia,
                    'numeroguia':this.numeroguia,
                    'idsucursal':this.idsucursal,
                    'fechacompra':this.fechacompra,
                    'comentariocompra':this.comentariocompra,
                    'codigodet':this.codigodet,
                    'idAuxProducto':this.idAuxProducto,
                    'idproducto':this.idproducto,
                    'descripciondet':this.descripciondet, 
                    'cantidaddet':this.cantidaddet,
                    'preciodet':this.preciodet,
                    'iddet':this.iddet,
                    'idsesion':this.idsesion,
                    'pendiente':this.pendiente,
                    'subTotal':this.subTotal,
                    'iva':this.iva,
                    'total':this.total,
                }
            }).then((respuesta) => {
                console.log(respuesta); 
                me.tipoAccion = 2;
                me.listarop(me.idOrdPedido);
                me.listar();
                alertify.success('Trabajo creado');
            }).catch((error) => {
                console.log(error);
                console.debug(error);
                console.dir(error);
            });
        },
        eliminarlista(index){
            swal({
                title: "Eliminar este producto?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    this.arrayop.splice(index, 1);
                    this.idproductoarray.splice(index,1);
                    this.codigosarray.splice(index,1);
                    this.nombrearray.splice(index,1);
                    this.cantidadarray.splice(index,1);
                    this.precioVentaarray.splice(index,1);
                    this.descripcionarray.splice(index,1);
                    this.comentarioarray.splice(index,1);

                    let cost = 0;
                    this.arrayop.map(function(costItem){ 
                        cost += costItem.precioVenta*costItem.cantidad;
                    });
                    this.subTotal = cost;
                    this.iva = cost * 0.12;
                    this.total = cost + (cost * 0.12);
                }
            });
        },
        eliminar(id, op) {
            this.idsesion = this.sesion[0].IDUSUARIO;
            let me = this;
            swal({
                title: "Deseas desactivar esta Orden de pedido?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    swal("¿Cual es la razón de desactivar este producto?", {
                        content: "input",
                    }).then((value) => {
                        axios({
                            url: "modelo/op/eliminar.php",
                            method: "get",
                            params: {
                                'id':id,
                                'idsesion':this.idsesion,
                                'mensaje':`${value}`,
                                'op':op,
                            }
                        }).then((respuesta) => {
                            if(respuesta.data == 'mal '){
                                alertify.error('Debes eliminar los productos de esta Orden de pedido primero');  
                            }else{
                                me.listar();
                                alertify.success('Producto desactivado');
                            }
                        }).catch((error) => {
                            console.log(error);
                            console.debug(error);
                            console.dir(error);
                        });
                    });
                }
            });
        },
        eliminardetop(id, op, cantidad,precioVenta, codigo, subTotal,idProducto, opp, idusuario) {
            let me = this;
            swal({
                title: "Deseas eliminar este producto?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    axios({
                        url: "modelo/op/eliminar_detop.php",
                        method: "get",
                        params: {
                            'id':id,
                            'op':op,
                            'opp':opp,
                            'cantidad':cantidad,
                            'codigo':codigo,
                            'subTotal':subTotal,
                            'precioVenta':precioVenta,
                            'idProducto':idProducto,
                            'idusuario':idusuario
                        }
                    }).then((respuesta) => {
                        me.subTotal = parseFloat(me.subTotal - respuesta.data).toFixed(2);
                        me.iva =  parseFloat(me.subTotal * 0.12).toFixed(2);
                        me.total = parseFloat(parseFloat(me.subTotal) + parseFloat(me.iva)).toFixed(2);
                        me.listarop(op);
                        me.listar();
                        alertify.success('Producto eliminado');
                    }).catch((error) => {
                        console.log(error);
                        console.debug(error);
                        console.dir(error);
                    });
                }
            });
        },
        abrirModal(modelo, accion, data = []) {
            this.errorfechacompra = [];
            this.errorfechaEmision = []; 
            this.erroridEmpleado = []; 
            this.erroridCliente = []; 
            this.errornombredet = [];
            this.errorcantidaddet = [];
            this.errorpreciodet = [];
            this.errorfechapago = [];
            this.errorvalorpago = [];
            this.errorfechacompra = [];
            this.errornumeroguia = [];
            this.errorfechacompra  = [];
            this.errorfechatrabajo = [];
            $(".bodymodales").addClass("modal-open");
            switch (modelo) {
                case "op":
                {
                    switch (accion) {
                        case 'registrar':
                        {
                            //necesarios
                            this.modal = 1;
                            this.tituloModal = "Registrar Orden de Pedido";
                            this.tipoAccion = 1;
                            //complementos
                            this.fechaEmision = moment().locale("es").format('YYYY-MM-DDTHH:mm');
                            this.ordPedido = null;
                            this.RUC = '';
                            this.NOM_CLIENTE = '';
                            this.APE_CLIENTE = '';
                            this.direccion = '';
                            this.telefono1 = null;
                            this.celular = null;
                            this.NOM_EMPLE = '';
                            this.comentario = '';
                            this.subTotal = null;
                            this.iva = null;
                            this.total = null;
                            this.idsesion = this.sesion[0].IDUSUARIO;
                            this.idContacto = null;
                            this.diasCredito = null;
                            this.formaPago = '';
                            this.descripciondet = '';
                            break;
                        }
                        case 'actualizar':
                        {
                            //necesarios
                            this.modal = 1;
                            this.tituloModal = "Actualizar Orden de Pedido "+data['ordPedido'];
                            this.tipoAccion = 2;
                            //complementos
                            this.idOrdPedido = data['idOrdPedido'];
                            this.fechaEmision = moment(String(data['fechaEmision'])).format('YYYY-MM-DDThh:mm');
                            this.ordPedido = data['ordPedido'];
                            this.ordPedido2 = data['ordPedido2'];
                            this.RUC = data['RUC'];
                            this.idEmpleado = data['idEmpleado'];
                            this.idCliente = data['idCliente'];
                            this.buscarclientes = data['NOM_CLIENTE']+" "+data['APE_CLIENTE'];
                            this.direccion = data['direccion'];
                            this.telefono1 = data['telefono1'];
                            this.celular = data['celular'];
                            this.NOM_EMPLE = data['NOM_EMPLE'];
                            this.comentario = data['comentario'];
                            this.subTotal = data['vsubt'];
                            this.iva = parseFloat(data['vsubt']*0.12);
                            this.total = parseFloat(data['vsubt'])+parseFloat(this.iva);
                            this.idsesion = this.sesion[0].IDUSUARIO;
                            this.nombrecontacto = data['nombreContacto'];
                            this.diasCredito = data['diasCredito'];
                            if(data['formaPago'])
                                this.formaPago = data['formaPago'];
                            else
                            this.formaPago = '';
                            break; 
                        }
                        case 'pagar':
                        {
                            //necesarios
                            this.modal = 1;
                            this.tituloModal = "Pago en Orden de Pedido "+data['ordPedido'];
                            this.tipoAccion = 4;
                            //complementos
                            this.idOrdPedido = data['idOrdPedido'];
                            this.fechapago = moment().format('YYYY-MM-DDTHH:mm');
                            this.formapago = '';
                            this.documentopago = '';
                            this.valorpago = null;
                            this.comentariopago = '';
                            break; 
                        }
                        case 'bajas':
                        {
                            //necesarios
                            this.modal = 1;
                            this.tituloModal = "Dar baja al producto "+data['codigo']+ " del op "+this.ordPedido;
                            this.tipoAccion = 6;
                            //complementos
                            this.idOrdPedido = data['idOrdPedido'];
                            this.idProducto = data['idProducto'];
                            this.cantidaddet = data['cantidad'];
                            this.precioVentabaja = data['precioVenta'];
                            this.codigobaja = data['codigo'];
                            this.cantidadbaja = null;
                            this.comentariobaja = '';
                            this.idDetOrdPedido = data['idDetOrdPedido'];
                            this.precioVentabaja= data['precioVenta']
                            this.idsesion = this.sesion[0].IDUSUARIO;
                            break; 
                        }
                        case 'guiaremision':
                        {
                            //necesarios
                            this.modal = 1;
                            this.tituloModal = "Crear guia de remisión";
                            this.tipoAccion = 8;
                            //complementos 
                            this.idproducto = data['idProducto'];
                            this.iddet = data['idDetOrdPedido'];
                            this.idAuxProducto = data['idAuxProducto'];
                            this.codigodet = data['codigo']; 
                            this.nombredet = data['nombre'];
                            this.cantidaddet = data['pendiente'];
                            this.cantidaddetgc = data['pendiente'];
                            this.descripciondet = data['descripcion'];
                            this.preciodet = parseFloat(data['precioVenta']).toFixed(2);
                            this.idsesion = this.sesion[0].IDUSUARIO;
                            break; 
                        }
                        case 'ordtrabajo':
                        {
                            //necesarios
                            this.modal = 1;
                            this.tituloModal = "Crear orden de trabajo";
                            this.tipoAccion = 9;
                            //complementos 
                            this.idproducto = data['idProducto'];
                            this.iddet = data['idDetOrdPedido'];
                            this.idAuxProducto = data['idAuxProducto'];
                            this.codigodet = data['codigo']; 
                            this.nombredet = data['nombre'];
                            this.cantidaddet = data['cantidad'];
                            this.descripciondet = data['descripcion'];
                            this.preciodet = parseFloat(data['precioVenta']).toFixed(2);
                            this.idsesion = this.sesion[0].IDUSUARIO;
                            this.pendiente = data['pendiente'];
                            this.fechatrabajo = moment().locale("es").format('YYYY-MM-DDTHH:mm');
                            this.comentariotrabajo = '';
                            this.idsesion = this.sesion[0].IDUSUARIO;
                            break; 
                        }
                        case 'ordcompra':
                        {
                            //necesarios
                            this.modal = 1;
                            this.tituloModal = "Crear orden de compra";
                            this.tipoAccion = 10;
                            //complementos 
                            this.idproducto = data['idProducto'];
                            this.iddet = data['idDetOrdPedido'];
                            this.idAuxProducto = data['idAuxProducto'];
                            this.codigodet = data['codigo']; 
                            this.nombredet = data['nombre'];
                            this.cantidaddet = data['cantidad'];
                            this.descripciondet = data['descripcion'];
                            this.preciodet = parseFloat(data['precioVenta']).toFixed(2);
                            this.idsesion = this.sesion[0].IDUSUARIO;
                            this.pendiente = data['pendiente'];
                            this.fechacompra = moment().format('YYYY-MM-DDThh:mm');
                            this.comentariocompra = '';
                            this.idsesion = this.sesion[0].IDUSUARIO;
                            break; 
                        }
                    }
                }
            }
        },
        guardarpago(){
            this.errorfechaEmision = []; 
            this.erroridEmpleado = []; 
            this.erroridCliente = []; 
            this.errornombredet = [];
            this.errorcantidaddet = [];
            this.errorpreciodet = [];
            this.errorfechapago = [];
            this.errorvalorpago = [];
            this.errorfechatrabajo = [];
            this.errornumeroguia = [];
            if (this.validarpago()) {return;}
            let me = this;
            axios({
                url: "modelo/op/registrar_pago.php",
                method: "get",
                params: {
                    'idOrdPedido':this.idOrdPedido,
                    'fechapago':this.fechapago,
                    'formapago':this.formapago,
                    'documentopago':this.documentopago,
                    'valorpago':this.valorpago,
                    'comentariopago':this.comentariopago,
                    'usuario':this.sesion[0].IDUSUARIO,
                }
            }).then((respuesta) => {
                $(".nomv").removeAttr("disabled");
                me.cerrarModal();
                me.listar();
                alertify.success('Pago registrado');
            }).catch((error) => {
                console.log(error);
                console.debug(error);
                console.dir(error);
            });
        },
        validarbaja() {
            $('.mirartopmodal').animate({
                scrollTop:0
            },250);
            this.error = 0;
            this.errorcantidadbaja= [];

            if (!this.cantidadbaja)
                this.errorcantidadbaja.push("Debe ingresar una cantidad");

            if (this.errorcantidadbaja.length)
                this.error = 1;
            return this.error;
        },
        validarpago() {
            $('.mirartopmodal').animate({
                scrollTop:0
            },250);
            this.error = 0;
            this.errorfechapago = [];
            this.errorvalorpago = [];
            this.errordocumentopago = [];

            if (!this.fechapago)
                this.errorfechapago.push("Debe ingresar una Fecha");
                
            if(this.formapago != "CREDITO" && this.formapago != "CRUCECUENTA" && this.formapago != "ANULADO" && this.formapago != "CONTRAENTREGA"){
                if (!this.valorpago)
                    this.errorvalorpago.push("Debe ingresar un valor");
                if (!this.documentopago)
                    this.errordocumentopago.push("Debe ingresar documento");
            }    
            if (this.errorfechapago.length || this.errorvalorpago.length || this.errordocumentopago.length)
                this.error = 1;
            return this.error;
        },
        validardetop() {
            $('.mirartopmodal').animate({
                scrollTop:0
            },250);
            this.error = 0;
            this.errornombredet = [];
            this.errorcantidaddet = [];
            this.errorpreciodet = [];

            if (!this.nombredet)
                this.errornombredet.push("Debe ingresar un Nombre de producto");
            if (!this.cantidaddet)
                this.errorcantidaddet.push("Debe ingresar cantidad");
            if (!this.preciodet)
                this.errorpreciodet.push("Debe ingresar precio");

            if (this.errornombredet.length || this.errorcantidaddet.length || this.errorpreciodet.length)
                this.error = 1;
            return this.error;
        },
        validartrabajo() {
            $('.mirartopmodal').animate({
                scrollTop:0
            },250);
            this.error = 0;
            this.errorfechatrabajo= [];
            this.errorcantidaddet = [];
            this.errortipotrabajo = [];
            this.errorsolocolor = [];

            if (!this.fechatrabajo)
                this.errorfechatrabajo.push("Debe ingresar fecha de trabajo");
            if (!this.cantidaddet)
                this.errorcantidaddet.push("Debe ingresar cantidad");
            if (!this.tipotrabajo)
                this.errortipotrabajo.push("Debe ingresar Un tipo de trabajo");

            if(this.tipotrabajo=="Serigrafía" || this.tipotrabajo=="Tampografía" || this.tipotrabajo=="Bordado" || this.tipotrabajo=="Impresión UV"){
                if (!this.solocolor)
                    this.errorsolocolor.push("Campo obligatorio"); 
                    if (this.errorfechatrabajo.length || this.errorcantidaddet.length || this.errortipotrabajo.length || this.errorsolocolor.length)
                        this.error = 1;
            }else{
                if (this.errorfechatrabajo.length || this.errorcantidaddet.length || this.errortipotrabajo.length)
                    this.error = 1; 
            }
            return this.error;
        },
        validarcompra() {
            $('.mirartopmodal').animate({
                scrollTop:0
            },250);
            this.error = 0;
            this.errorfechacompra= [];
            this.errorcantidaddet = [];

            if (!this.fechacompra)
                this.errorfechacompra.push("Debe ingresar fecha de compra");
            if (!this.cantidaddet)
                this.errorcantidaddet.push("Debe ingresar cantidad");

            if (this.errorfechacompra.length || this.errorcantidaddet.length)
                this.error = 1;
            return this.error;
        },
        validarguia() {
            $('.mirartopmodal').animate({
                scrollTop:0
            },250);
            this.error = 0;
            this.errornumeroguia= [];
            this.errorcantidaddet = [];

            if (!this.numeroguia)
                this.errornumeroguia.push("Debe ingresar Número de guia");
            if (!this.cantidaddet)
                this.errorcantidaddet.push("Debe ingresar cantidad");

            if (this.errornumeroguia.length || this.errorcantidaddet.length)
                this.error = 1;
            return this.error;
        },
        validar() {
            $('.mirartopmodal').animate({
                scrollTop:0
            },250);
            this.error = 0;
            this.errorfechaEmision = []; 
            this.erroridEmpleado = []; 
            this.erroridCliente = [];
            this.errorordPedido = [];

            if (!this.fechaEmision)
                this.errorfechaEmision.push("Debe ingresar una Fecha");
            if (!this.idEmpleado)
                this.erroridEmpleado.push("Debe ingresar un empleado");
            if (!this.idCliente)
                this.erroridCliente.push("Debe ingresar un cliente");
            if (!this.ordPedido)
                this.errorordPedido.push("Debe ingresar una OP");

            if (this.errorfechaEmision.length || this.erroridEmpleado.length || this.erroridCliente.length || this.errorordPedido.length)
                this.error = 1;
            return this.error;
        },
        cerrarModal1() {
            this.modal1 = 0;
        },
        cerrarModal() {
            $(".errorww").hide();
            $(".aerrorww").hide();
            $(".bodymodales").removeClass("modal-open");
            clearInterval(this.espera1);
            //necesarios
            this.modal = 0;
            this.tituloModal = '';
            //complementos
            this.espera = 10;
            this.permiso='';
            this.buscarclientes =''; 
            this.buscarproductos ='';
            this.mora = ''; 
            this.idOrdPedido = null; 
            this.fechaEmision = ''; 
            this.fechaCreacion = ''; 
            this.ordPedido = null; 
            this.ordPedido2 = null;  
            this.usuarioCreacion = null; 
            this.subTotal = null; 
            this.total = null; 
            this.iva = null; 
            this.idEmpleado = ''; 
            this.idCliente = null; 
            this.RUC = ''; 
            this.direccion = ''; 
            this.telefono1 = ''; 
            this.celular = ''; 
            this.eMail = ''; 
            this.ciudad = ''; 
            this.PAGO = null; 
            this.EquipoTrabajo = null; 
            this.SALDO = null; 
            this.NOM_EMPLE = ''; 
            this.diasCredito = null; 
            this.comentario = ''; 
            this.formaPago = ''; 
            this.fecha_desp = ''; 
            this.estado_desp = null; 
            this.razon_desp = ''; 
            this.persona_desp = null;
            this.iddet =0;
            this.idproducto =null;
            this.codigodet ='';
            this.nombredet ='';
            this.cantidaddet =null;
            this.preciodet =null;
            this.cantidaddetc =null;
            this.preciodetc =null;
            this.descripciondet ='';
            this.comentariosdet ='';
            this.acciondet =0;
            this.cantidadbaja =null;
            this.cantidadbajatotal =null;
            this.comentariobaja ='';
            this.codigobaja ='';
            this.idDetOrdPedido ='';
            this.precioVentabaja ='';
            this.a ='';
            this.idContacto = null,
            this.nombrecontacto = '',
            this.fechapago = '';
            this.formapago = '';
            this.documentopago = '';
            this.valorpago = null;
            this.comentariopago = '';
            this.arrayop =[];
            this.cantidadarray = [];
            this.precioarray = [];
            this.nombrearray = [];
            this.descripcionarray = []; 
            this.comentarioarray = [];
            this.codigosarray = [];
            this.idproductoarray = [];
            this.precioVentaarray = [];
            this.fechatrabajo = '';
            this.comentariotrabajo = '';
            this.numeroguia = null;
            this.comentarioguia = '';
            this.observacionguia = '';
            this.sucursualguia = '';
            this.listsucursales = [];
            this.idsucursal = null;
            //errores
            this.errorfechaEmision = []; 
            this.erroridEmpleado = []; 
            this.erroridCliente = []; 
            this.errornombredet = [];
            this.errorcantidaddet = [];
            this.errorpreciodet = [];
            this.errorfechapago = [];
            this.errorvalorpago = [];
            this.errorfechatrabajo = [];
            this.errornumeroguia = [];
            this.errorfechacompra = [];
            this.guialista = [];

            this.codigodetl =  [];  
            this.idAuxProductol =  [];
            this.idproductol =  [];
            this.cantidaddetl =  [];
            this.iddetl =  [];
            this.guialista = [];
        },
        salir() {
            localStorage.removeItem('dataoresa');
            location.href="ingreso.php";
        },
        errorpyc(){
            alertify.error("No se puede borrar este registro");
            setTimeout(function(){
                alertify.error("La cantidad pendiente es menor a la cantidad original");
            }, 800);
        },
        verguias(id){
            let me = this;
            axios({
                url: "modelo/op/listar_guia.php",
                method: "get",
                params: {
                    'id':id,
                }
            }).then((respuesta) => {
                me.modal1=1;
                me.entradasdetguias = respuesta.data;
            }).catch((error) => {
                console.log(error);
                console.debug(error);
                console.dir(error);
            });
        },
        todo: function(){  
            this.espera1 = setInterval(() => {
                if(this.espera>0){
                    this.espera--;
                }else{
                    $(".aerrorww").hide();
                    clearInterval(this.espera1);
                }
            }, 1000);
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
        abrirlista(entrada,index){
            this.cambiarlista=1;
            this.tipoAccion = 7;
            this.index=index;
            this.idproducto = entrada.idproducto ;
            this.buscarproductos = entrada.codigo ; 
            this.nombredet = entrada.nombre ; 
            this.cantidaddet = entrada.cantidad ; 
            this.cantidaddet1 = entrada.cantidad1;
            this.preciodet = entrada.precioVenta ; 
            this.cantidaddet = entrada.pendiente;
            this.descripciondet = entrada.descripcion ; 
            this.comentariosdet = entrada.comentario ; 
        },
        editarlista(){
            this.cambiarlista = 0;
            this.tipoAccion = 1; 
            this.arrayop.splice(
                this.index,
                1, 
                {idproducto: this.idproducto,
                codigo:this.buscarproductos,
                nombre:this.nombredet,
                cantidad: this.cantidaddet,
                cantidad1: this.cantidaddet1,
                precioVenta: this.preciodet,
                pendiente: this.cantidaddet,
                descripcion:this.descripciondet,
                comentario:this.comentariosdet}
            );
            let cost = 0;
            this.arrayop.map(function(costItem){ 
                cost += costItem.precioVenta*costItem.cantidad; 
            });

            this.idproductoarray.splice(this.index,1,this.idproducto);
            this.codigosarray.splice(this.index,1,this.buscarproductos);
            this.nombrearray.splice(this.index,1,this.nombredet);
            this.cantidadarray.splice(this.index,1,this.cantidaddet);
            this.cantidadarray1.splice(this.index,1,this.cantidaddet1);
            this.precioVentaarray.splice(this.index,1,this.preciodet);
            this.descripcionarray.splice(this.index,1,this.descripciondet);
            this.comentarioarray.splice(this.index,1,this.comentariosdet);


            this.subTotal = cost;
            this.iva = cost * 0.12;
            this.total = cost + (cost * 0.12);
            this.idproducto = null;
            this.buscarproductos = '';
            this.nombredet = '';
            this.cantidaddet = null;
            this.cantidaddet1 = null;
            this.preciodet = null;
            this.descripciondet = '';
            this.comentariosdet = ''; 

            this.errorfechaEmision = []; 
            this.erroridEmpleado = []; 
            this.erroridCliente = []; 
            this.errornombredet = [];
            this.errorcantidaddet = [];
            this.errorpreciodet = [];
            this.errorordPedido =[];        
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
        guardarguia(){
            this.errorfechaEmision = []; 
            this.erroridEmpleado = []; 
            this.erroridCliente = []; 
            this.errornombredet = [];
            this.errorcantidaddet = [];
            this.errorpreciodet = [];
            this.errorfechapago = [];
            this.errorvalorpago = [];
            this.errorfechatrabajo = [];
            this.errornumeroguia = [];
            if (this.validarguia()) {
                return;
            }
            //var totalier = this.cantidaddetgc - this.cantidaddet;
            
                let me = this;
                axios({
                    url: "modelo/op/guardar_guia.php",
                    method: "get",
                    params: {
                        'idOrdPedido':this.idOrdPedido,
                        'idCliente':this.idCliente,
                        'idEmpleado':this.sesion[0].IDEMPLEADO, 
                        'comentarioguia':this.comentarioguia,
                        'numeroguia':this.numeroguia,
                        'idsucursal':this.idsucursal,
                        'sucursualguia':this.sucursualguia,
                        'observacionguia':this.observacionguia,
                        'comentarioguia':this.comentarioguia,

                        'nombredet':this.nombredet,
                        'codigodet':this.codigodet,
                        'idAuxProducto':this.idAuxProducto,
                        'idproducto':this.idproducto,
                        'cantidaddet':this.cantidaddet,
                        'iddet':this.iddet,
                    }
                }).then((respuesta) => {
                    console.log(respuesta.data);
                    me.tipoAccion = 2;
                    me.listarop(me.idOrdPedido);
                    me.listar();
                    alertify.success('Producto añadido');
                    me.comentarioguia="";
                    me.observacionguia="";
                    me.idsucursal=null;
                    me.sucursualguia="";
                    this.codigodetl = [];
                    this.idAuxProductol = [];
                    this.idproductol = [];
                    this.cantidaddetl = [];
                    this.iddetl = [];
                    this.nombredetl = [];
                }).catch((error) => {
                    console.log(error); 
                    console.debug(error);
                    console.dir(error);
                    this.codigodetl = [];
                    this.idAuxProductol = [];
                    this.idproductol = [];
                    this.cantidaddetl = [];
                    this.iddetl = [];
                    this.nombredetl = [];
                });
                
        },
        enviarguia(){
            this.codigodetl =  [];  
            this.idAuxProductol =  [];
            this.idproductol =  [];
            this.cantidaddetl =  [];
            this.iddetl =  [];
            this.guialista = [];

            this.modal = 1;
            this.tituloModal = "Crear guia de remisión";
            this.tipoAccion = 50;
        },
        maxten(){
            if(this.guialista.length>10){
                alertify.error('Solo puede agregar un máximo de 10 productos');
                var num =this.guialista.length-1
                setTimeout(()=>{
                    this.guialista.splice(num,1);
                },100);
                return;
            }
        }, 
        crearguiamas(){
            if (this.validarguialist()) {
                return;
            }
            if(!this.guialista.length){
                alertify.error('Agregar productos a la guia');
                return;
            } 
            for(var i=0; i<this.guialista.length; i++){
                this.codigodetl.push(this.guialista[i].codigo);  
                this.idAuxProductol.push(this.guialista[i].idAuxProducto);
                this.idproductol.push(this.guialista[i].idProducto); 
                this.cantidaddetl.push(this.guialista[i].pendiente);
                this.iddetl.push(this.guialista[i].idDetOrdPedido);
                this.nombredetl.push(this.guialista[i].nombre);
            }
            let me = this;
            axios({
                url: "modelo/op/guardar_listguia.php",
                method: "get",
                params: {
                    'idOrdPedido':this.idOrdPedido,
                    'idCliente':this.idCliente,
                    'idEmpleado':this.idEmpleado,
                    'comentarioguia':this.comentarioguia,
                    'numeroguia':this.numeroguia,
                    'idsucursal':this.idsucursal,
                    'sucursualguia':this.sucursualguia,
                    'observacionguia':this.observacionguia,
                    'comentarioguia':this.comentarioguia,
                    'iddet':this.iddetl,

                    'nombredet':this.nombredetl,
                    'codigodet':this.codigodetl,
                    'idAuxProducto':this.idAuxProductol,
                    'idproducto':this.idproductol,
                    'cantidaddet':this.cantidaddetl, 
                }
            }).then((respuesta) => {
                console.log(respuesta.data);
                me.tipoAccion = 2;
                me.listarop(me.idOrdPedido);
                me.listar();
                alertify.success('Producto añadido');
                me.comentarioguia="";
                me.observacionguia="";
                me.idsucursal=null;
                me.sucursualguia="";

                me.codigodetl = [];
                me.idAuxProductol = [];
                me.idproductol = [];
                me.cantidaddetl = [];
                me.iddetl = [];
                me.nombredetl = [];
            });
            this.codigodetl = [];
            this.idAuxProductol = [];
            this.idproductol = [];
            this.cantidaddetl = [];
            this.iddetl = [];
            this.nombredetl = [];
        },
        validarguialist(){
            this.errorfechaEmision = []; 
            this.erroridEmpleado = []; 
            this.erroridCliente = []; 
            this.errornombredet = [];
            this.errorcantidaddet = [];
            this.errorpreciodet = [];
            this.errorfechapago = [];
            this.errorvalorpago = [];
            this.errorfechatrabajo = [];
            this.errornumeroguia = [];

            $('.mirartopmodal').animate({
                scrollTop:0
            },250);
            this.error = 0;
            this.errornumeroguia= [];

            if (!this.numeroguia)
                this.errornumeroguia.push("Debe ingresar Número de guia");

            if (this.errornumeroguia.length)
                this.error = 1;
            return this.error;
        },
        escrd(){ 
            if(this.formapago == "CREDITO" || this.formapago == "CRUCECUENTA"  || this.formapago == "ANULADO" || this.formapago == "CONTRAENTREGA"){ 
                this.documentopago = 0;
                this.valorpago = 0; 
                $(".nomv").attr('disabled','disabled');
            }else{
                this.documentopago = "";
                this.valorpago = "";
                $(".nomv").removeAttr("disabled");
            }
        }
    },
    mounted() {
        if(!this.sesion){
            location.href="ingreso.php";
        }
        this.listar();
        this.listarempleados();
        if(this.sesion[0].IDUSUARIO==28 && this.sesion[0].estado_sesion == null){
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
    var preg = /^([0-9]+\.?[0-9]{0,3})$/; 
    if(preg.test(__val__) === true){
        return true;
    }else{
       return false;
    }
    
}
$(document).on("click",function(e) {
                    
    var container = $("#container");
                       
       if (!container.is(e.target) && container.has(e.target).length === 0) { 
          $("#container").hide();             
       }else{
            $("#container").show(); 
       }
});
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