serialize = function(obj, prefix) {
    var str = [],
      p;
    for (p in obj) {
      if (obj.hasOwnProperty(p)) {
        var k = prefix ? prefix + "[" + p + "]" : p,
          v = obj[p];
        str.push((v !== null && typeof v === "object") ?
          serialize(v, k) :
          encodeURIComponent(k) + "=" + encodeURIComponent(v));
      }
    }
    return str.join("&");
}
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
        buscart: '',
        pagt:1, 
        hjt:1,
        ray:'',
        //buscar
        buscarclientes:'',
        listclientes:[],
        buscarempleados:'', 
        buscarproductos:'',
        empleados: [],
        listproductos:[],
        buscarproveedores:'',
        listproveedores:[],
        //complementos de la página
        //vistaingreso
        idIngreso: null,
        idProveedor: '',
        fechaIngreso: '',
        tipoDocumento: '',
        documento: null,
        usuarioCrea: null,
        comentarios: '',
        idOrdCompra: null,
        idEmpleado: null,
        idCliente: null,
        NOM_PROVEEDOR: '',
        razonSocialNombres: '',
        razonComercialApellidos: '',
        VENDEDOR: '',
        idOrdPedido:null,
        ordPedido:null,
        cantidaddetv:null,
        //errorvistaingreso
        errorfechaIngreso: [],
        errortipoDocumento: [],
        errordocumento: [],
        erroridEmpleado: [],
        erroridCliente: [],
        erroridProveedor: [],
        //add
        cedula:'',
        direccion:'',
        telefono:'',
        celular:'',
        
        //detalle
        iddet:0,
        idproducto:null,
        idAuxProducto:null,
        codigodet:'',
        nombredet:'',
        pendiente:'',
        cantidaddet:null,
        cantidaddet1:null,
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
        errornombredet: [],
        errorcantidaddet: [],
        errorpreciodet: [],
        errorop: [],
        erroroc: [], 

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

        //vistadetingreso
        entradasdet: [],
        imagenus:'',
        usuarioimagen:'',

        subTotal: null,
        iva: null,
        total: null,

        siniva:false,
        descuento:0,
        totalfinal:null,
        subTotalfinal:null,
    },
    filters: {
        dec(value) {
          return (parseFloat(value)).toFixed(6);
        },
        decf(value) {
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
                url: "modelo/busquedasgenerales/listar_usuarios.php",
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
            if(this.buscarproductos.length>=3){
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
        listarproveedores() {
            let me = this;
            if(this.buscarproveedores.length>=3){
                axios({
                    url: "modelo/busquedasgenerales/listar_proveedores.php",
                    method: "get",
                    params: {
                        'CLIENTE':this.buscarproveedores,
                    }
                }).then((respuesta) => {
                    me.listproveedores = respuesta.data;
                }).catch((error) => {
                    console.log(error);
                    console.debug(error);
                    console.dir(error);
                });
            }else if(this.buscarproveedores.length<3 && this.buscarproveedores.length>0){
                me.listproveedores='sin';
            }else{
                me.listproveedores='';
            }
        },
        seleccionarcliente(cliente=[]){
            this.buscarclientes = cliente.razonSocialNombres + " " + cliente.razonComercialApellidos;
            this.idCliente = cliente.idCliente;
        },
        seleccionarproveedor(proveedor=[]){
            if(proveedor.telefono2){
                this.ray="/";
                var dos = proveedor.telefono2;
            }else{
                this.ray="";
                var dos = "";
            }
            this.buscarproveedores = proveedor.razonSocialNombres + ' ' + proveedor.razonComercialApellidos;
            this.idProveedor = proveedor.idProveedor;
            this.cedula = proveedor.cedulaRuc;
            this.direccion = proveedor.direccion;
            this.telefono = proveedor.telefono1 + this.ray + dos;
            this.celular = proveedor.celular;
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
        listar() {
            let me = this;
            axios({
                url: "modelo/ingresos/listar.php",
                method: "get",
                params: {
                    'buscar':this.buscar,
                    'hj':this.hj,
                }
            }).then((respuesta) => {
                console.log(respuesta.data);
                if($.trim(respuesta.data)){
                    me.entradas = respuesta.data;
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
        registrar() {
            if (this.validar()) {
                return;
            }
            if(this.arrayop.length<1){
                alertify.error('Debe agregar productos a la OP');
                return;
            }
            let me = this;
            if(this.siniva==true){
                me.siniva =1;
            }else{
                me.siniva =null;
            }
            axios.post('modelo/ingresos/guardar.php', serialize({
                'idProveedor':this.idProveedor, 
                'fechaIngreso':this.fechaIngreso, 
                'tipoDocumento':this.tipoDocumento, 
                'documento':this.documento, 
                'usuarioCrea':this.sesion[0].IDUSUARIO,
                'comentario':this.comentarios, 
                'idOrdCompra':this.idOrdCompra, 
                'idEmpleado':this.idEmpleado, 
                'idCliente':this.idCliente, 
                'idOrdPedido':this.idOrdPedido,
                'siniva':this.siniva,
                'descuento':this.descuento,

                'idproductos':this.idproductoarray,
                'codigos':this.codigosarray,
                'nombres':this.nombrearray,
                'cantidades':this.cantidadarray,
                'cantidades1':this.cantidadarray1,
                'precios':this.precioVentaarray,
                'comentarios':this.comentarioarray,
            })).then((respuesta) => {
                console.log(respuesta.data);
                me.hj=1;
                me.cerrarModal();
                me.listar();
                alertify.success('Registro agregado');
            });
        },
        createdFormData(){
            var formDa = new FormData();
            for(var key in this.objeto){
                formDa.append(key, this.objeto[key]);
            }
            return formDa;
        },
        actualizar() {
            if (this.validar()) {
                return;
            }
            let me = this;
            if(this.siniva==true){
                me.siniva =1;
            }else{
                me.siniva =null;
            }
            axios({
                url: "modelo/ingresos/actualizar.php",
                method: "get",
                params: {
                    'idIngreso':this.idIngreso,
                    'idProveedor':this.idProveedor, 
                    'fechaIngreso':this.fechaIngreso, 
                    'tipoDocumento':this.tipoDocumento, 
                    'documento':this.documento, 
                    'usuarioCrea':this.sesion[0].IDUSUARIO,
                    'comentarios':this.comentarios, 
                    'siniva':this.siniva,
                    'descuento':this.descuento,

                    'idOrdCompra':this.idOrdCompra, 
                    'idEmpleado':this.idEmpleado, 
                    'idCliente':this.idCliente, 
                    'idOrdPedido':this.idOrdPedido,
                }
            }).then((respuesta) => {
                console.log(respuesta.data);
                if($.trim(respuesta.data)=="error"){
                    alertify.error('No se pudo actualizar, intentelo mas tarde');
                }else{
                    me.hj=1;
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
        buscarced(){
            let me = this;
            axios({
                url: "modelo/ingresos/cedula.php",
                method: "get",
                params: {
                    'cedula':this.cedula,
                }
            }).then((respuesta) => {
                console.log(respuesta.data);
                if($.trim(respuesta.data)=="error"){
                    alertify.error('Cédula o RUC no existente'); 
                    me.idProveedor = '';
                   me.buscarproveedores = '';
                   me.direccion = '';
                   me.telefono = '';
                   me.celular = '';
                }else{
                   me.idProveedor = respuesta.data[0].idProveedor;
                   me.buscarproveedores = respuesta.data[0].razonSocialNombres+ ' '+respuesta.data[0].razonComercialApellidos;
                   me.direccion = respuesta.data[0].direccion;
                   me.telefono = respuesta.data[0].telefono1;
                   me.celular = respuesta.data[0].celular;
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
                case "ingresos":
                {
                    switch (accion) {
                        case 'registrar':
                        {
                            //necesarios
                            this.modal = 1;
                            this.tituloModal = "Crear ingreso";
                            this.tipoAccion = 1;
                            //complementos
                            this.idIngreso = null;
                            this.idProveedor = '';
                            this.fechaIngreso = moment().locale("es").format('YYYY-MM-DDTHH:mm');
                            this.tipoDocumento = '';
                            this.documento = null;
                            this.usuarioCrea = null;
                            this.comentarios = '';
                            this.idOrdCompra = null;
                            this.idEmpleado = "";
                            this.idCliente = null;
                            this.NOM_PROVEEDOR = '';
                            this.razonSocialNombres = '';
                            this.razonComercialApellidos = '';
                            this.VENDEDOR = '';
                            this.idOrdPedido =null;
                            this.ordPedido =null;
                            this.siniva=false;
                            break;
                        }
                        case 'actualizar':
                        {
                            //necesarios
                            this.modal = 1;
                            this.tituloModal = "Actualizar Ingreso";
                            this.tipoAccion = 2;
                            //complementos
                            this.idIngreso = data["idIngreso"];
                            this.idProveedor = data["idProveedor"];
                            this.fechaIngreso = moment(String(data['fechaIngreso'])).format('YYYY-MM-DDThh:mm');
                            this.tipoDocumento = data["tipoDocumento"];
                            this.documento = data["documento"];
                            this.usuarioCrea = data["usuarioCrea"];
                            this.comentarios = data["comentarios"];
                            this.idOrdCompra = data["idOrdCompra"];
                            this.idEmpleado = data["idEmpleado"];
                            this.idCliente = data["idCliente"];
                            this.buscarproveedores = data["NOM_PROVEEDOR"];
                            this.buscarclientes = data["razonSocialNombres"] + ' ' + data["razonComercialApellidos"]; 
                            this.VENDEDOR = data["VENDEDOR"];
                            this.idOrdPedido = data["idOrdPedido"];
                            this.ordPedido = data["ordPedido"];
                            this.descuento = data["descuento"]; 
                            this.subTotalfinal = data["total"]-this.descuento;  
                            this.subTotal = data["total"]-this.descuento;  
                            this.iva = parseFloat(this.subTotal)*0.12; 
                            this.total = parseFloat(data["total"])+parseFloat(this.iva)-this.descuento;
                            this.totalfinal = parseFloat(data["total"])+parseFloat(this.iva)-this.descuento;
                            this.siniva = data["siniva"];   
                            break;
                        }
                        case 'editardet':
                        {
                            //necesarios
                            this.modal = 1;
                            this.tituloModal = "Actualizar Detalle";
                            this.tipoAccion = 5;
                            //complementos
                            this.idDetIngreso = data["idDetIngreso"];
                            this.idIngreso = data["idIngreso"];
                            this.buscarproductos = data["codigo"];
                            this.idProducto = data["idProducto"];
                            this.nombredet = data["descripcion"];
                            this.cantidaddet = data["cantidad"];
                            this.cantidaddetv = data["cantidad"];
                            this.preciodet = data["costo"];
                            this.comentariosdet = data["observacion"];
                            break;
                        }
                    }
                }
            }
        },
        listardetalle(id){
            let me = this;
            axios({ 
                url: "modelo/ingresos/listar_det.php",
                method: "get",
                params: {
                    'id':id,
                    'buscart':this.buscart,
                    'hjt':this.hjt,
                }
            }).then((respuesta) => {
                console.log(respuesta.data);
                me.entradasdet = respuesta.data;
                if(respuesta.data){
                    me.pagt = Math.ceil(respuesta.data[0].pag/5); 
                }
            }).catch((error) => {
                console.log(error);
                console.debug(error);
                console.dir(error);
            });
        },
        guardardetingresos(){
            this.errorfechaIngreso = [];
            this.errortipoDocumento = [];
            this.errordocumento = [];
            this.erroridEmpleado = [];
            this.erroridCliente = [];
            this.erroridProveedor = [];
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
                cantidad1:this.cantidaddet1,
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

            if(!this.descuento){
                this.descuento=0;
            }

            this.subTotal = cost - parseFloat(this.descuento);
            this.subTotalfinal = cost - parseFloat(this.descuento);
            this.iva = parseFloat(this.subTotalfinal) * 0.12;
            this.total = parseFloat(this.subTotalfinal)+parseFloat(this.iva);
            this.totalfinal = parseFloat(this.subTotalfinal)+parseFloat(this.iva);
            this.idproducto = null;
            this.buscarproductos = '';
            this.nombredet = '';
            this.cantidaddet = null;
            this.cantidaddet1 = null;
            this.preciodet = null;
            this.descripciondet = '';
            this.comentariosdet = ''; 
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
            this.tipoAccion = 3;
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
        agregardet(){
            if (this.validardetop()) {
                return;
            }
            let me = this;
            axios({
                url: "modelo/ingresos/agregardet.php",
                method: "get",
                params: {
                    'idIngreso':this.idIngreso, 
                    'codigo':this.buscarproductos,
                    'idproducto':this.idproducto,
                    'nombre':this.nombredet,
                    'cantidad':this.cantidaddet,
                    'cantidad1':this.cantidaddet1,
                    'precio':this.preciodet,
                    'comentario':this.comentariosdet,
                    'usuarioCrea':this.sesion[0].IDUSUARIO,
                    'documento':this.documento,
                }
            }).then((respuesta) => {
                console.log(respuesta.data);
                if(respuesta.data=="error"){
                    alertify.error('No se pudo actualizar, intentelo mas tarde');
                }else{
                    me.tipoAccion=2;
                    me.listardetalle(me.documento);
                    alertify.success('Registro actualizado');
                    me.cerrarModal();
                }
            }).catch((error) => {
                console.log(error);
                console.debug(error);
                console.dir(error);
            });
        },
        actualizardet(){
            if (this.validardetop()) {
                return;
            }
            let me = this;
            axios({
                url: "modelo/ingresos/actualizardetalle.php",
                method: "get",
                params: {
                    'idDetIngreso':this.idDetIngreso,
                    'codigo':this.buscarproductos,
                    'idproducto':this.idProducto,
                    'nombre':this.nombredet,
                    'cantidad':this.cantidaddet,
                    'cantidadt':this.cantidaddetv,
                    'preciodet':this.preciodet,
                    'comentario':this.comentariosdet,
                    'documento':this.documento,
                    'idIngreso':this.idIngreso,
                }
            }).then((respuesta) => {
                console.log(respuesta.data);
                if(respuesta.data=="error"){
                    alertify.error('No se pudo actualizar, intentelo mas tarde');
                }else{
                    me.tipoAccion=2;
                    me.listardetalle(me.idIngreso);
                    alertify.success('Registro actualizado');
                }
            }).catch((error) => {
                console.log(error);
                console.debug(error);
                console.dir(error);
            });
        },
        eliminar(id,ingreso,idusuario) {
            let me = this;
            swal({
                title: "Seguro deseas eliminar este ingreso?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    axios({
                        url: "modelo/ingresos/eliminar.php",
                        method: "get",
                        params: {
                            'id':id,
                            'ingreso':ingreso,
                            'idusuario':idusuario
                        }
                    }).then((respuesta) => { 
                        if(respuesta.data == 'error '){
                            alertify.error('Error en la eliminación de este ingreso');  
                        }else{
                            me.listar();
                            alertify.success('Ingreso Eliminado');
                        }
                    }).catch((error) => {
                        console.log(error);
                        console.debug(error);
                        console.dir(error);
                    });
                }
            });
        },
        eliminardet(id, idi, idProducto, cantidad, ingreso,idusuario) {
            let me = this;
            swal({
                title: "Deseas eliminar este ingreso?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    axios({
                        url: "modelo/ingresos/eliminar_det.php",
                        method: "get",
                        params: {
                            'id':id,
                            'idProducto':idProducto,
                            'cantidad':cantidad,
                            'ingreso':ingreso,
                            'idi':idi,
                            'idusuario':idusuario
                        }
                    }).then((respuesta) => {
                        console.log(respuesta.data);
                        if(respuesta.data=="error"){
                            alertify.error('No se pudo eliminar este detalle, intentelo mas tarde');
                        }else{
                            me.listardetalle(idi);
                            alertify.success('Detalle eliminado');
                        }
                    }).catch((error) => {
                        console.log(error);
                        console.debug(error);
                        console.dir(error);
                    });
                }
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
        cerrarModal() {
            $(".bodymodales").removeClass("modal-open");
            //necesarios
            this.modal = 0;
            this.tituloModal = '';
            //complementos
            this.buscarclientes ='';
            this.listclientes =[];
            this.buscarempleados =''; 
            this.buscarproductos ='';
            this.listproductos =[];
            this.buscarproveedores ='';
            this.listproveedores =[];
            this.cantidaddetv =null;
            this.descuento=0;
            //complementos de la página
            //vistaingreso
            this.idIngreso = null;
            this.idProveedor = '';
            this.fechaIngreso = '';
            this.tipoDocumento = '';
            this.documento = null;
            this.usuarioCrea = null;
            this.comentarios = '';
            this.idOrdCompra = null;
            this.idEmpleado = null;
            this.idCliente = null;
            this.NOM_PROVEEDOR = '';
            this.razonSocialNombres = '';
            this.razonComercialApellidos = '';
            this.VENDEDOR = '';
            this.idOrdPedido =null;
            this.ordPedido =null;
            //errorvistaingreso
            this.errorfechaIngreso = [];
            this.errortipoDocumento = [];
            this.errordocumento = [];
            this.erroridEmpleado = [];
            this.erroridCliente = [];
            this.erroridProveedor = [];
            this.errorop = [];
            this.erroroc = [];
            //add
            this.cedula ='';
            this.direccion ='';
            this.telefono ='';
            this.celular ='';
            //detalle
            this.iddet =0;
            this.idproducto =null;
            this.idAuxProducto =null;
            this.codigodet ='';
            this.nombredet ='';
            this.pendiente ='';
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
            this.siniva = false;
            //arrayop
            this.arrayop =[];
            this.cantidadarray = [];
            this.precioarray = [];
            this.nombrearray = [];
            this.descripcionarray = []; 
            this.comentarioarray = [];
            this.codigosarray = [];
            this.idproductoarray = [];
            this.precioVentaarray = [];

            this.buscart = '';
            this.hjt = 1;

            this.subTotal = null;
            this.iva = null;
            this.total = null;
        },
        borrarprd() {
            this.buscarproductos = "";
            this.idproducto = null;
            this.nombredet = "";
            this.cantidaddet = null;
            this.preciodet = null;
            this.descripciondet = "";
            this.comentariosdet = "";
            this.cantidaddetv =null;

            this.errornombredet = [];
            this.errorcantidaddet = [];
            this.errorpreciodet = [];
        },
        validar() {
            $('.mirartopmodal').animate({
                scrollTop:0
            },250);
            this.error = 0;
            this.errorfechaIngreso = [];
            this.errortipoDocumento = [];
            this.errordocumento = [];
            this.erroridEmpleado = [];
            this.erroridCliente = [];
            this.erroridProveedor = [];
            this.errorop = [];
            this.erroroc = [];

            if (!this.fechaIngreso)
                this.errorfechaIngreso.push("Debe ingresar una fecha de Ingreso");
            if (!this.tipoDocumento)
                this.errortipoDocumento.push("especifique tipo de Documento");
            if (!this.idProveedor)
                this.erroridProveedor.push("Debe ingresar un Proveedor");
            if (!this.documento)
                this.errordocumento.push("ingrese N° documento");
            if (!this.idEmpleado)
                this.erroridEmpleado.push("Debe ingresar un Empleado");
            if (!this.idCliente)
                this.erroridCliente.push("Debe ingresar un Cliente");
            if (!this.idOrdCompra)
                this.erroroc.push("Ingrese OC");

            if (this.errorfechaIngreso.length || this.errortipoDocumento.length || this.erroridProveedor.length || this.errordocumento.length || this.erroridEmpleado.length || this.erroridCliente.length || this.errorop.length || this.erroroc.length)
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

            if (!this.nombredet)
                this.errornombredet.push("Debe ingresar un Nombre de producto");
            if (!this.cantidaddet)
                this.errorcantidaddet.push("Debe ingresar cantidad");

            if (this.errornombredet.length || this.errorcantidaddet.length)
                this.error = 1;
            return this.error;
        },
        updateAvatar(){
            let formData = new FormData();
            formData.append('file', this.imagen);
            axios.post( 'modelo/facturas/subirexcel.php',
                formData,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }
            ).then((respuesta) => {
                if(respuesta.data == "bien"){
                    console.log(respuesta.data);
                    alertify.success('Excel subido con éxito');
                    $(".subirupdateexcel").attr("style","display:none");
                    this.listar();
                }else if(respuesta.data == "error"){
                    console.log(respuesta.data);
                    alertify.error('Formato de archivo inválido');
                    $(".subirupdateexcel").attr("style","display:none");
                }else {
                    console.log(respuesta.data);
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
        buscarordcompra(id){
            let me = this;
            axios({
                url: "modelo/ingresos/veroc.php",
                method: "get",
                params: {
                    'id':id
                }
            }).then((respuesta) => {  
                if($.trim(respuesta.data)!=""){
                    if(respuesta.data[0].idOrdPedido){
                        me.idOrdPedido = respuesta.data[0].idOrdPedido;
                        me.buscarclientes = respuesta.data[0].NOM_CLIENTE + ' ' + respuesta.data[0].APE_CLIENTE;
                        me.idCliente = respuesta.data[0].idCliente;
                    }else{
                        me.idOrdPedido = 'stock';
                        me.buscarclientes = respuesta.data[0].NOM_CLIENTE + ' ' + respuesta.data[0].APE_CLIENTE;
                        me.idCliente = respuesta.data[0].idCliente;
                    }
                }else{
                    me.idOrdCompra="";
                    alertify.error('Esta orden de compra no existe');
                }
            }).catch((error) => {
                console.log(error);
                console.debug(error);
                console.dir(error);
            });
        },
        cambiariva(){
            let me = this;
            if(this.siniva==true){
                me.siniva =1;
            }else{
                me.siniva =null;
            }
            axios({
                url: "modelo/ingresos/cambiariva.php",
                method: "get",
                params: {
                    'idIngreso':this.idIngreso,
                    'siniva':this.siniva,
                }
            }).then((respuesta) => {  
                    alertify.success('Ingreso cambiado');
            }).catch((error) => {
                console.log(error);
                console.debug(error);
                console.dir(error);
            });
        },
        descuentos(){
            if(!this.descuento){
                this.descuento=0;
            }
            this.subTotalfinal =  parseFloat(this.subTotal) - parseFloat(this.descuento);
            this.iva = parseFloat(this.subTotalfinal) *0.12;
            this.totalfinal = parseFloat(this.subTotalfinal) + parseFloat(this.iva);
        }
    },
    mounted() {
        if(!this.sesion){
            location.href="./";
        }
        this.dataoresa =JSON.parse(localStorage.getItem('dataoresa'));
        this.listarempleados();
        this.listar();
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
    var preg = /^([0-9]+\.?[0-9]{0,6})$/; 
    if(preg.test(__val__) === true){
        return true;
    }else{
       return false; 
    }
    
}