var app = new Vue({
    el: '#app',
    data: {
        //sesion
        sesion:JSON.parse(localStorage.getItem('dataoresa')),
        //necesarios siempre
        modal: 0,
        modal1: 0,
        tituloModal: '',
        tipoAccion: 0,
        error: 0,
        buscar: '',
        entradas: [],
        id: 0,
        pag:1, 
        hj:1,
        ray:'',
        //ordcompra     
        idOrdCompra:null,
        fechaEmision:'',
        fechaEstimada:'',
        fechaEntrega:'',
        subTotal:null,
        iva:null,
        total:null,
        factura:'',
        idProveedor:null,
        idOrdPedido:null,
        ordCompra:null,
        fecha:'',
        estado:null,
        idPersona:null,
        fechaSolicita:'',
        usuarioCrea:null,
        usuarioModifica:null,
        comentarioV:'',
        formaPago:'',
        idEmpleado:null,
        descripcionp:'',
        //detordcompra
        idDetCompra:null,
        idAuxproducto:null,
        observacion:'',
        idProducto:null,
        codigo:'',
        nombre:'',
        cantidad:'',
        costo:null,
        pvp:null,
        comentario:'',
        RUC:'',
        direccion:'',
        telefono1:'',
        celular:'',
        descripcion:'',
        //buscar
        buscarclientes:'',
        listclientes:[],
        buscarempleados:'', 
        buscarproductos:'',
        empleados: [],
        listproductos:[],
        buscarproveedores:'',
        listproveedores:[],
        entradasdetalle:[],
        //error
        erroridProveedor:[],
        errorfechaEstimada:[],
        erroridCliente:[],
        erroridPersona:[],
        errorformaPago:[],
        erroridEmpleado:[],
        errorordCompra:[],
        //arrayop
        arrayop:[],
        cantidadarray: [],
        cantidadarray1: [],
        precioarray: [],
        codigoarray: [],
        nombrearray: [],
        descripcionarray: [], 
        comentarioarray: [],
        codigosarray: [],
        idproductoarray: [],
        precioVentaarray: [],
        codigodet:'',
        nombredet:'',
        pendiente:'',
        cantidaddet:null,
        preciodet:null,
        cantidaddetc:null,
        preciodetc:null,
        descripciondet:'',
        comentariosdet:'',
        //errores
        errorfechaEmision: [], 
        erroridEmpleado: [], 
        erroridCliente: [], 
        errornombredet: [],
        errorcantidaddet: [],
        errorpreciodet: [],
        errorordPedido:[],
        imagenus:'',
        usuarioimagen:'',
        errorop:[],
        checked:0, 
        solover:'stock',

        siniva:false,
        recdetop:[],
        escogerdetop:[],
        cantdopf:"",
        indexfin:'',
    },
    filters: {
        dec1(value) {
            return parseFloat(value);
        }, 
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
        listar() {
            let me = this;
            axios({
                url: "modelo/ordcompra/listar.php", 
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
        listardetalle(id){
            let me = this;
            axios({
                url: "modelo/ordcompra/listardetalle.php",
                method: "get",
                params: {
                    'id':id,
                }
            }).then((respuesta) => {
                console.log(respuesta.data);
                if($.trim(respuesta.data)){
                    me.entradasdetalle = respuesta.data;
                }else{
                    me.entradasdetalle = '';
                }
                axios({
                    url: "modelo/ordcompra/veropdet1.php",
                    method: "get",
                    params: {
                        'id':id,
                    }
                }).then((respuesta) => {
                    if($.trim(respuesta.data)){
                        this.recdetop = respuesta.data;
                    }else{
                        this.recdetop = "";
                    }
                });
            }).catch((error) => {
                console.log(error);
                console.debug(error);
                console.dir(error);
            });
        },
        eliminardelistadet(id,idc){
            let me = this;
            swal({
                title: "Deseas eliminar este detalle de compra?",
                icon: "warning",  
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                axios.get('modelo/ordcompra/eliminardetops.php?id=' + id, {
                }).then(function (respuesta) { 
                    alertify.success('Detalle de Compra eliminado'); 
                    axios({
                        url: "modelo/ordcompra/veropdet1.php", 
                        method: "get",
                        params: {
                            'id':idc,
                        }
                    }).then((respuesta) => {
                        console.log(respuesta.data);
                        if($.trim(respuesta.data)){
                           me.recdetop = respuesta.data;
                        }else{
                           me.recdetop = "";
                        }
                    });   
                });
            }); 
        },
        cambiarcantdop(id,idc){
            let me = this;
            const valor = document.querySelector("input[name=test"+id+"]").value;
            axios({
                url: "modelo/ordcompra/editopdet.php", 
                method: "get",
                params: {
                    'id':id,
                    'valor':valor,
                }
            }).then((respuesta) => {
                alertify.success('Cantidad de detalle eliminado');
                axios({
                    url: "modelo/ordcompra/veropdet1.php", 
                    method: "get",
                    params: {
                        'id':idc,
                    }
                }).then((respuesta) => {
                    console.log(respuesta.data);
                    if($.trim(respuesta.data)){
                       me.recdetop = respuesta.data;
                    }else{
                       me.recdetop = "";
                    }
                });
            });  
        },
        seleccionarcliente(cliente=[]){ 
            this.buscarclientes = cliente.razonSocialNombres + " " + cliente.razonComercialApellidos;
            this.idCliente = cliente.idCliente;
            this.idPersona = cliente.idPersona;
        },
        seleccionarproveedor(proveedor=[]){
            this.buscarproveedores = proveedor.razonSocialNombres + ' ' + proveedor.razonComercialApellidos;
            this.idProveedor = proveedor.idProveedor;
            this.RUC = proveedor.cedulaRuc;
            this.direccion = proveedor.direccion;
            this.telefono1 = proveedor.telefono1;
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
            if(this.cantidaddet<=0 || this.preciodet<=0){
                alertify.error('No se puede ingresar valores en negativo o en cero');
                return;
            }
            this.arrayop.push(
                {codigo:this.codigodet,
                nombre:this.nombredet,
                cantidad: this.cantidaddet,
                precioVenta: this.preciodet,
                pendiente: this.cantidaddet,
                comentario:this.comentariosdet}
            );
            let cost = 0;
            this.arrayop.map(function(costItem){ 
                cost += costItem.precioVenta*costItem.cantidad;
            });
            this.codigoarray.push(this.codigodet);  
            this.nombrearray.push(this.nombredet);
            this.cantidadarray.push(this.cantidaddet);
            this.precioVentaarray.push(this.preciodet);
            this.comentarioarray.push(this.comentariosdet);


            this.subTotal = cost;
            this.iva = cost * 0.12;
            this.total = cost + (cost * 0.12);
            this.idproducto = null;
            this.buscarproductos = '';
            this.codigodet = '';
            this.nombredet = '';
            this.cantidaddet = null;
            this.cantidaddet1 = null;
            this.preciodet = null;
            this.descripciondet = '';
            this.comentariosdet = ''; 
        },
        guardardetops1(){
            if (this.validardetop()) {
                return;
            }
            let me = this;
            axios({
                url: "modelo/ordcompra/guardar1.php",
                method: "get",
                params: {
                    'idOrdCompra':this.idOrdCompra,
                    'codigodet':this.codigodet,
                    'nombredet':this.nombredet,
                    'cantidaddet':this.cantidaddet,
                    'preciodet':this.preciodet
                }
            }).then((respuesta) => { 
                alertify.success('Registro actualizado');
                me.subTotal = $.trim(respuesta.data);
                me.listardetalle(me.idOrdCompra);
                me.listar();
                me.codigodet = '';
                me.nombredet = '';
                me.cantidaddet = null;
                me.preciodet = null;
            });
        },
        abrirlista(entrada,index){
            this.tituloModal = "Editar Detalle compra";
            this.tipoAccion = 5;
            this.indexfin=index;
            this.nombredet=entrada.nombre;
            this.cantidaddet=entrada.cantidad;
            this.preciodet=entrada.precioVenta; 
        },
        abrirmodelosmas(){
            this.tipoAccion=6;
            axios({ 
                url: "modelo/ordcompra/veropdet.php",
                method: "get",
                params: {
                    'id':this.idOrdPedido,
                }
            }).then((respuesta) => {
                this.recdetop = respuesta.data;
            });
        },
        abrirmodelosmas1(){
            axios({
                url: "modelo/ordcompra/guardar2.php",
                method: "get",
                params: {
                    'escogerdetop':this.escogerdetop,
                    'idOrdCompra':this.idOrdCompra
                }
            }).then((respuesta) => { 
                axios({
                    url: "modelo/ordcompra/veropdet1.php",
                    method: "get",
                    params: {
                        'id':this.idOrdCompra,
                    }
                }).then((respuesta) => {
                    this.recdetop = respuesta.data;
                    this.tipoAccion=2;
                    alertify.success('Detalle actualizado'); 
                });
            });
        },
        masatrasw(){
            this.tipoAccion=2;
            axios({
                url: "modelo/ordcompra/veropdet1.php",
                method: "get",
                params: {
                    'id':this.idOrdCompra,
                }
            }).then((respuesta) => {
                this.recdetop = respuesta.data;
                this.tipoAccion=2;
            });
        },
        actualizardetuno(){
            this.tipoAccion = 1; 
            if (this.validardetop()) {
                return;
            }
            if(this.cantidaddet<=0 || this.preciodet<=0){
                alertify.error('No se puede ingresar valores en negativo o en cero');
                return;
            }
            this.arrayop.splice(
                this.indexfin,
                1, 
                {nombre:this.nombredet,
                cantidad: this.cantidaddet,
                precioVenta: this.preciodet,
                pendiente: this.cantidaddet,
                comentario:this.comentariosdet}
            );
            let cost = 0;
            this.arrayop.map(function(costItem){ 
                cost += costItem.precioVenta*costItem.cantidad;
            });

            this.nombrearray.splice(this.indexfin,1,this.nombredet);
            this.cantidadarray.splice(this.indexfin,1,this.cantidaddet);
            this.precioVentaarray.splice(this.indexfin,1,this.preciodet);
            this.comentarioarray.splice(this.indexfin,1,this.comentariosdet);


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
        eliminar(id) {
            let me = this;
            swal({
                title: "Deseas eliminar esta Orden de compra?",
                text: "Se eliminará permanentemente de los registros",
                icon: "warning",  
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    if (willDelete) {
                        swal("Escriba la palabra 'borrar' para borar esta compra", {
                            content: "input",
                        }).then((value) => {
                            if(`${value}`=='borrar'){
                                axios.get('modelo/ordcompra/eliminar.php?id=' + id, {
                                }).then(function (respuesta) { 
                                    if($.trim(respuesta.data)=="bien"){
                                        me.listar();
                                        me.hj=1;
                                        alertify.success('Orden de compra eliminado'); 
                                    }else if($.trim(respuesta.data)=="error"){
                                        alertify.error('La orden de compra no pudo ser eliminado intentelo nuevamente'); 
                                    }else{
                                        alertify.error('Error en la base consulte con el administrador');       
                                    }             
                                }).catch(function (error) {
                                    console.log(error);
                                });
                            }else{
                                alertify.error('Borrado cancelado / Palabra incorrecta');
                            }
                        });
                    }
                }
            });
        },
        eliminardetalle(id, idc, cantidad, costo) {
            let me = this;
            swal({
                title: "Deseas eliminar este detalle de Orden de compra?",
                text: "Se eliminará permanentemente este registro",
                icon: "warning",  
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    if (willDelete) {
                        swal("Escriba la palabra 'borrar' para borar este detalle", {
                            content: "input",
                        }).then((value) => {
                            if(`${value}`=='borrar'){
                                axios({
                                    url: "modelo/ordcompra/eliminardetalle.php", 
                                    method: "get",
                                    params: {
                                        'id':id,
                                        'idc':idc,
                                        'costo':costo,
                                        'cantidad':cantidad,
                                    }
                                }).then(function (respuesta) { 
                                    if($.trim(respuesta.data)=="bien"){
                                        var menos = costo * cantidad; 
                                        var subnuevo = me.subTotal - menos;
                                        me.subTotal = parseFloat(subnuevo).toFixed(2);
                                        me.iva =  parseFloat(me.subTotal * 0.12).toFixed(2);
                                        me.total = parseFloat(parseFloat(me.subTotal) + parseFloat(me.iva)).toFixed(2);
                                        me.listar();
                                        me.listardetalle(idc);
                                        alertify.success('Detalle de orden de compra eliminado'); 
                                    }else if($.trim(respuesta.data)=="error"){
                                        alertify.error('La orden de compra no pudo ser eliminado intentelo nuevamente'); 
                                    }else{
                                        alertify.error('Error en la base consulte con el administrador');       
                                    }             
                                }).catch(function (error) {
                                    console.log(error);
                                });
                            }else{
                                alertify.error('Borrado cancelado / Palabra incorrecta');
                            }
                        });
                    }
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
                    this.nombrearray.splice(index,1);
                    this.cantidadarray.splice(index,1);
                    this.precioVentaarray.splice(index,1);
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
        actualizar() {
            if (this.validar()) {return;}
            let me = this;
            axios({
                url: "modelo/ordcompra/actualizar.php",
                method: "get",
                params: {
                    'idOrdCompra':this.idOrdCompra,
                    'fechaEmision':this.fechaEmision,
                    'fechaEstimada':this.fechaEstimada,
                    'idProveedor':this.idProveedor,
                    'idOrdPedido':this.idOrdPedido,
                    'ordCompra':this.ordCompra,
                    'fecha':this.fecha,
                    'idPersona':this.idPersona,
                    'comentarioV':this.comentarioV,
                    'idEmpleado':this.idEmpleado, 
                    'descripcion':this.descripcionp,
                    'usuarioCrea':this.sesion[0].IDUSUARIO,
                }
            }).then((respuesta) => {
                console.log(respuesta.data);
                if($.trim(respuesta.data)=="bien"){
                    me.cerrarModal();
                    me.listar();
                    alertify.success('Registro actualizado'); 
                }else if($.trim(respuesta.data)=="error"){
                    alertify.error('El cliente no pudo ser actualizado intentelo nuevamente'); 
                }else{
                    alertify.error('Error en la base consulte con el administrador');       
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
                this.tipoAccion=3;
                return;
            }
            let me = this;
            if(this.siniva==true){
                me.siniva =1;
            }else{
                me.siniva =null;
            }
            axios({
                url: "modelo/ordcompra/guardar.php",
                method: "get",
                params: {
                    'fechaEmision':this.fechaEmision,
                    'fechaEstimada':this.fechaEstimada,
                    'idProveedor':this.idProveedor,
                    'idOrdPedido':this.idOrdPedido,
                    'ordCompra':this.ordCompra,
                    'fecha':this.fecha,
                    'idPersona':this.idPersona,
                    'comentarioV':this.comentarioV,
                    'idEmpleado':this.idEmpleado,
                    'descripcion':this.descripcionp,
                    'usuarioCrea':this.sesion[0].IDUSUARIO,
                    'subTotal':this.subTotal,
                    'iva':this.iva,
                    'total':this.total,
                    'siniva':this.siniva,
                    'escogerdetop':this.escogerdetop,

                    'codigos':this.codigoarray,
                    'nombres':this.nombrearray,
                    'cantidades':this.cantidadarray,
                    'precios':this.precioVentaarray,
                    'comentarios':this.comentarioarray,
                }
            }).then((respuesta) => { 
                console.log(respuesta.data);
                this.escogerdetop=[];
                if($.trim(respuesta.data)=="bien"){
                    me.cerrarModal();
                    me.listar();
                    alertify.success('Registro actualizado'); 
                }else if($.trim(respuesta.data)=="error"){
                    alertify.error('El cliente no pudo ser actualizado intentelo nuevamente'); 
                    me.cerrarModal();
                }else{
                    alertify.error('Error en la base consulte con el administrador');    
                    me.cerrarModal();   
                }
            }).catch((error) => {
                console.log(error);
                console.debug(error);
                console.dir(error);
            })
        },
        abrirModal(modelo, accion, data = []) {
            $(".bodymodales").addClass("modal-open");
            switch (modelo) {
                case "ordcompra":
                {
                    switch (accion) {
                        case 'registrar':
                        {
                            //necesarios
                            this.modal = 1;
                            this.tituloModal = "Crear Orden de compra";
                            this.tipoAccion = 1;
                            //complementos
                            //Persona
                            this.fechaEstimada = moment().locale("es").format('YYYY-MM-DD');
                            this.subTotal = null;
                            this.iva = null;
                            this.total = null;
                            this.factura = '';
                            this.idProveedor = null;
                            this.idOrdPedido = null;
                            this.ordCompra = null;
                            this.fecha = '';
                            this.estado = null;
                            this.idPersona = null;
                            this.fechaSolicita = '';
                            this.comentarioV = '';
                            this.formaPago = '';
                            this.idEmpleado = '';
                            this.descripcion = '';
                            this.idDetCompra = null;
                            this.comentario = '';
                            this.buscarclientes = '';
                            this.buscarproveedores = '';
                            this.siniva = false;
                            break;
                        }
                        case 'actualizar':
                        {
                            //necesarios
                            this.modal = 1;
                            this.tituloModal = "Actualizar Orden de compra";
                            this.tipoAccion = 2;
                            //complementos
                            this.idOrdCompra = data["idOrdCompra"];
                            if(data["fechaEstimada"]){
                                this.fechaEstimada = moment(String(data["fechaEstimada"])).format('YYYY-MM-DD');
                            }else{
                                this.fechaEstimada = '';
                            }
                            this.subTotal = data["subf"];
                            this.iva = parseFloat(data['subf']*0.12);
                            this.total = parseFloat(data['subf'])+parseFloat(this.iva);
                            this.factura = data["factura"];
                            this.idOrdPedido = data["idOrdPedido"];
                            this.ordCompra = data["ordCompra"];
                            this.fechaSolicita = data["fechaSolicita"];
                            this.comentarioV = data["comentarioV"];
                            this.formaPago = data["formaPago"];
                            this.descripcionp = data["descripcionp"];
                            this.buscarclientes = data["NOM_CLIENTE"]+' '+data["APE_CLIENTE"];
                            this.buscarproveedores = data["NOM_PROVEEDOR"];
                            this.idEmpleado = data["idEmpleado"];
                            this.idProveedor = data["idProveedor"];
                            this.idPersona = data["idPersona"];
                            this.siniva = data["siniva"];
                            break;
                        }
                    }
                }
            }
        },
        cerrarModal() {
            $(".bodymodales").removeClass("modal-open");
            //necesarios
            this.modal = 0;
            this.tituloModal = '';
            //complementos
            this.idOrdCompra = null;
            this.fechaEmision = '';
            this.fechaEstimada = '';
            this.fechaEntrega = '';
            this.subTotal = null;
            this.iva = null;
            this.total = null;
            this.factura = '';
            this.idProveedor = null;
            this.idOrdPedido = null;
            this.ordCompra = null;
            this.fecha = '';
            this.estado = null;
            this.idPersona = null;
            this.fechaSolicita = '';
            this.usuarioCrea = null;
            this.usuarioModifica = null;
            this.comentarioV = '';
            this.formaPago = '';
            this.idEmpleado = null;
            this.descripcion = '';
            this.descripcionp = '';
            //detordcompra
            this.idDetCompra = null;
            this.idAuxproducto = null;
            this.observacion = '';
            this.idProducto = null;
            this.codigo = '';
            this.nombre = '';
            this.cantidad = '';
            this.costo = null;
            this.pvp = null;
            this.comentario = '';
            this.RUC = '';
            this.direccion = '';
            this.telefono1 = '';
            this.celular = '';
            //buscar
            this.buscarclientes = '';
            this.listclientes = [];
            this.buscarempleados = ''; 
            this.buscarproductos = '';
            this.listproductos = [];
            this.buscarproveedores = '';
            this.listproveedores = [];
            //error
            this.erroridProveedor = [];
            this.errorfechaEstimada = [];
            this.erroridCliente = [];
            this.erroridPersona = [];
            this.errorformaPago = [];
            this.erroridEmpleado = [];
            this.errorordCompra = [];
 
            this.arrayop = [];

            this.codigoarray = [];
            this.nombrearray = [];
            this.cantidadarray = [];  
            this.precioVentaarray = [];
            this.comentarioarray = [];

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

            this.errorop = [];
            this.recdetop = [];
            this.escogerdetop=[];
            this.nombredet = "";
            this.cantidaddet = null;
            this.preciodet = null;
        },
        validar() {
            $('.mirartopmodal').animate({
                scrollTop:0
            },250);
            this.error = 0;
            this.erroridProveedor = [];
            this.errorfechaEstimada = [];
            this.erroridPersona = [];
            this.erroridEmpleado = [];
            this.errorordCompra = [];
            this.errorop = [];

            if (!this.idProveedor)
                this.erroridProveedor.push("Debes escoger un proveedor");
            if (!this.fechaEstimada)
                this.errorfechaEstimada.push("Ingresa una fecha");
            if (!this.idPersona)
                this.erroridPersona.push("Debe escoger un Cliente");
            if (!this.idEmpleado)
                this.erroridEmpleado.push("Escoga la persona");
            if (!this.ordCompra)
                this.errorordCompra.push("Ingrese OC");
            if(!this.checked)   
                if (!this.idOrdPedido)
                    this.errorop.push("OP");

            if (this.erroridProveedor.length || this.errorfechaEstimada.length || this.erroridPersona.length || this.erroridEmpleado.length || this.errorordCompra.length || this.errorop.length)
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
        abririmpr(id){
            window.open('./impresiones/compracliente.php?compra='+id, '_top');
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
        recarga(){
                this.idOrdPedido=null;
                this.errorop =[];  
        },
        verdatosop(id){
            axios({
                url: "modelo/ordcompra/verop.php",
                method: "get",
                params: {
                    'id':id,
                }
            }).then((respuesta) => {
                this.idPersona=respuesta.data[0].idCliente;
                this.buscarclientes=respuesta.data[0].NOM_CLIENTE + ' ' + respuesta.data[0].APE_CLIENTE;
                this.idEmpleado=respuesta.data[0].idEmpleado;   
                axios({
                    url: "modelo/ordcompra/veropdet.php",
                    method: "get",
                    params: {
                        'id':id,
                    }
                }).then((respuesta) => {
                    console.log(respuesta.data); 
                    this.recdetop = respuesta.data;
                });
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
                url: "modelo/ordcompra/cambiariva.php",
                method: "get",
                params: {
                    'idOrdCompra':this.idOrdCompra,
                    'siniva':this.siniva,
                }
            }).then((respuesta) => {   
                console.log(respuesta.data);
                me.listar();
                alertify.success('Ingreso cambiado');
            }).catch((error) => {
                console.log(error);
                console.debug(error);
                console.dir(error);
            });
        },
        copiarcod(dato){
            var aux = document.createElement("input");
            aux.setAttribute("value", dato);
            document.body.appendChild(aux);
            aux.select();
            document.execCommand("copy");
            document.body.removeChild(aux);
            alertify.success('Nombre copiado');
        },
    },
    mounted() {
        if(!this.sesion){
            location.href="./";
        }
        this.listar();
        this.listarempleados();
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