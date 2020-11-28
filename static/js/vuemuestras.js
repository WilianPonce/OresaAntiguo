var app = new Vue({
    el: '#app',
    data: {
        //sesion
        sesion: JSON.parse(localStorage.getItem('dataoresa')),
        //necesarios siempre
        modal: 0,
        modal1: 0,
        tituloModal: '',
        tipoAccion: 0,
        error: 0,
        buscar: '',
        entradas: [],
        id: 0,
        pag: 1,
        hj: 1,
        buscart: '',
        pagt: 1,
        hjt: 1,
        ray: '',
        preciodet: null,

        subTotal: null,
        iva: null,
        total: null,
        //buscar
        buscarclientes: '',
        listclientes: [],
        buscarempleados: '',
        buscarproductos: '',
        empleados: [],
        listproductos: [],

        //muestras
        idMuestras: null,
        fecha: '',
        idCliente: null,
        idEmpleado: null,
        cliente: '',
        empleado: '',
        contacto: '',
        comentario: '',
        lugarEntrega: '',
        numero: null,
        //detmuestras
        detmuestras: [],

        idDetMuestras: null,
        idProducto: null,
        codigo: '',
        descripcion: '',
        salida: null,
        entrada: null,
        entradav: null,
        linkIMagen: '',
        observaciones: '',
        fechaDevolucion: '',
        comentarios: '',
        estado: null,
        idbodega: null,
        totalingreso: 0,

        //productosnuevo
        idproducto: null,
        iddet: null,
        codigodet: '',
        nombredet: '',
        cantidaddet: null,
        descripciondet: '',
        comentariosdet: '',
        errornombredet: [],
        errorcantidaddet: [],
        arrayop: [],
        arrayops: [],
        cantidadarray: [],
        precioarray: [],
        nombrearray: [],
        descripcionarray: [],
        comentarioarray: [],
        codigosarray: [],
        idproductoarray: [],
        precioVentaarray: [],

        errorfecha: [],
        erroridEmpleado: [],
        erroridCliente: [],
        errobuscarclientes: [],
        errornumero: [],
        errorcontacto: [],
        errorlugarEntrega: [],
        imagenus: '',
        usuarioimagen: '',
        comentariodev: '',

        entradastock: 0,
        listnombres:[],

    },
    filters: {
        dec(value) {
            return (parseFloat(value)).toFixed(2);
        },
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
            $(".menuw").show();
            let me = this;
            if (this.buscarclientes.length >= 3) {
                axios({
                    url: "modelo/busquedasgenerales/listar_clientes.php",
                    method: "get",
                    params: {
                        'CLIENTE': this.buscarclientes,
                    }
                }).then((respuesta) => {
                    me.listclientes = respuesta.data;
                }).catch((error) => {
                    console.log(error);
                    console.debug(error);
                    console.dir(error);
                });
            } else if (this.buscarclientes.length < 3 && this.buscarclientes.length > 0) {
                me.listclientes = 'sin';
            } else {
                me.listclientes = '';
            }
        },
        listar() {
            let me = this;
            axios({
                url: "modelo/muestras/listar.php",
                method: "get",
                params: {
                    'buscar': this.buscar,
                    'hj': this.hj,
                    usuarioCrea: this.sesion[0].IDEMPLEADO,
                }
            }).then((respuesta) => {
                if ($.trim(respuesta.data)) {
                    me.entradas = respuesta.data;
                } else {
                    me.entradas = '';
                }
                if (respuesta.data) {
                    me.pag = Math.ceil(respuesta.data[0].pag / 10);
                }
                me.buscar="";
            }).catch((error) => {
                console.log(error);
                console.debug(error);
                console.dir(error);
            });
        },
        listarproductos() {
            $(".menuw").show();
            let me = this;
            if (this.buscarproductos.length >= 2) {
                axios({
                    url: "modelo/busquedasgenerales/listar_productos.php",
                    method: "get",
                    params: {
                        'buscarproductos': this.buscarproductos,
                    }
                }).then((respuesta) => {
                    me.listproductos = respuesta.data;
                }).catch((error) => {
                    console.log(error);
                    console.debug(error);
                    console.dir(error);
                });
            } else if (this.buscarproductos.length < 3 && this.buscarproductos.length > 0) {
                me.listproductos = 'sin';
            } else {
                me.listproductos = '';
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
        seleccionarproducto(producto = []) {
            this.nombredet = producto.nombre;
            this.idproducto = producto.idProducto;
            this.descripciondet = producto.descripcion;
            this.codigodet = producto.codigo;
            this.buscarproductos = producto.codigo;
            this.preciodet = producto.pvp;
            this.cantidaddet = producto.stock;
        },
        seleccionarcliente(cliente = []) {
            this.buscarclientes = cliente.razonSocialNombres + " " + cliente.razonComercialApellidos;
            this.idCliente = cliente.idCliente;
        },
        abrirdetmuestras(id) {
            let me = this;
            axios({
                url: "modelo/muestras/listar_detmuestras.php",
                method: "get",
                params: {
                    'id': id,
                    'hjt': this.hjt,
                    'buscart': this.buscart,
                }
            }).then((respuesta) => {
                console.log(respuesta.data);
                me.arrayops = respuesta.data;
                if (respuesta.data) {
                    me.pagt = Math.ceil(respuesta.data[0].pag / 5);
                }
            }).catch((error) => {
                console.log(error);
                console.debug(error);
                console.dir(error);
            });
        },
        actualizar() {
            if (this.validar()) { return; }
            let me = this;
            axios({
                url: "modelo/muestras/actualizar.php",
                method: "get",
                params: {
                    'idMuestras': this.idMuestras,
                    'fecha': this.fecha,
                    'idCliente': this.idCliente,
                    'idEmpleado': this.idEmpleado,
                    'buscarclientes': this.buscarclientes,
                    'empleado': this.empleado,
                    'contacto': this.contacto,
                    'comentario': this.comentario,
                    'lugarEntrega': this.lugarEntrega,
                    'numero': this.numero
                }
            }).then((respuesta) => {
                console.log(respuesta.data);
                if ($.trim(respuesta.data) != "error") {
                    me.cerrarModal();
                    me.listar();
                    alertify.success('Registro actualizado');
                } else {
                    alertify.error('El producto no pudo ser actualizado');
                }
            }).catch((error) => {
                console.log(error);
                console.debug(error);
                console.dir(error);
            })
        },
        registrar() {
            this.empleado = $("#empleado option:selected").text();
            if (this.validar()) {
                return;
            }
            if (this.arrayop.length < 1) {
                alertify.error('Debe agregar productos a la Muestra');
                return;
            }
            let me = this;
            axios({
                url: "modelo/muestras/guardar.php",
                method: "get",
                params: {
                    'fecha': this.fecha,
                    'idCliente': this.idCliente,
                    'idEmpleado': this.idEmpleado,
                    'buscarclientes': this.buscarclientes,
                    'empleado': this.empleado,
                    'contacto': this.contacto,
                    'comentario': this.comentario,
                    'lugarEntrega': this.lugarEntrega,
                    'numero': this.numero,

                    'idproductos': this.idproductoarray,
                    'codigos': this.codigosarray,
                    'nombres': this.nombrearray,
                    'cantidades': this.cantidadarray,
                    'precios': this.precioarray,
                    'comentarios': this.comentarioarray,
                }
            }).then((respuesta) => {          
                this.arrayop = [];
                this.idproductoarray = [];
                this.codigosarray = [];
                this.nombrearray = [];
                this.cantidadarray = [];
                this.precioarray = [];
                this.descripcionarray = [];
                this.comentarioarray = [];
                console.log(respuesta.data);
                me.hj = 1;
                alertify.success('Registro agregado');
                me.cerrarModal();
                setTimeout(function(){
                    location.reload();
                },1200);
                me.cerrarModal();
                me.listar();
                
            }).catch((error) => {
                console.log(error);
                console.debug(error);
                console.dir(error);
            })
        },
        agregardetguias() {
            this.errornombredet = [];
            this.errorcantidaddet = [];
            this.tipoAccion = 3;
            this.tituloModal = "Registrar Producto";
            this.idproducto = null;
            this.codigodet = '';
            this.nombredet = '';
            this.cantidaddet = null;
            this.preciodet = null;
            this.descripciondet = '';
            this.comentariosdet = '';
            this.buscarproductos = '';
        },
        agregarproducto() {
            this.errornombredet = [];
            this.errorcantidaddet = [];
            this.tipoAccion = 6;
            this.tituloModal = "Registrar Producto";
            this.idproducto = null;
            this.codigodet = '';
            this.nombredet = '';
            this.preciodet = null;
            this.cantidaddet = null;
            this.descripciondet = '';
            this.comentariosdet = '';
            this.buscarproductos = '';
        },
        guardardetguias() {
            this.errornombredet = [];
            this.errorcantidaddet = [];
            if (this.validardetguias()) {
                return;
            }
            if (this.cantidaddet < 0 || this.preciodet < 0) {
                alertify.error('No se puede ingresar valores en negativo');
                return;
            }
            this.arrayop.push(
                {
                    idproducto: this.idproducto,
                    codigo: this.buscarproductos,
                    nombre: this.nombredet,
                    cantidad: this.cantidaddet,
                    precio: this.preciodet,
                    pendiente: this.cantidaddet,
                    descripcion: this.descripciondet,
                    comentario: this.comentariosdet
                }
            );
            let cost = 0;
            this.arrayop.map(function (costItem) {
                cost += costItem.precioVenta * costItem.cantidad;
            });

            this.idproductoarray.push(this.idproducto);
            this.codigosarray.push(this.buscarproductos);
            this.nombrearray.push(this.nombredet);
            this.cantidadarray.push(this.cantidaddet);
            this.precioarray.push(this.preciodet);
            this.descripcionarray.push(this.descripciondet);
            this.comentarioarray.push(this.comentariosdet);

            this.idproducto = null;
            this.buscarproductos = '';
            this.nombredet = '';
            this.cantidaddet = null;
            this.descripciondet = '';
            this.comentariosdet = '';
        },
        guardarproductoguia() {
            this.errornombredet = [];
            this.errorcantidaddet = [];
            if (this.validardetguias()) {
                return;
            }
            let me = this;
            axios({
                url: "modelo/muestras/guardarproductodet.php",
                method: "get",
                params: {
                    'idMuestras': this.idMuestras,
                    'idproducto': this.idproducto,
                    'codigo': this.buscarproductos,
                    'nombre': this.nombredet,
                    'descripcion': this.descripciondet,
                    'cantidad': this.cantidaddet,
                    'precio': this.preciodet,
                    'comentario': this.comentariosdet,
                }
            }).then((respuesta) => {
                console.log(respuesta.data);
                if (respuesta.data == "error") {
                    alertify.error('Error, producto no registrado');
                } else {
                    alertify.success('Registro agregado');
                    this.tipoAccion = 2;
                    this.abrirdetmuestras(me.idMuestras);
                }
            }).catch((error) => {
                console.log(error);
                console.debug(error);
                console.dir(error);
            })
        },
        eliminarlista(index) {
            swal({
                title: "Eliminar este producto?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    this.arrayop.splice(index, 1);
                    this.idproductoarray.splice(index, 1);
                    this.codigosarray.splice(index, 1);
                    this.nombrearray.splice(index, 1);
                    this.cantidadarray.splice(index, 1);
                    this.descripcionarray.splice(index, 1);
                    this.comentarioarray.splice(index, 1);
                }
            });
        },
        devolvertodox() {
            let me = this;
            swal({
                title: "Seguro deseas devolver todos los productos de esta muestra?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    axios({
                        url: "modelo/muestras/devxx.php",
                        method: "get",
                        params: {
                            'id': this.idMuestras,
                        }
                    }).then((respuesta) => {
                        alertify.success('Productos devueltos');
                    }).catch((error) => {
                        console.log(error);
                        console.debug(error);
                        console.dir(error);
                    });
                }
            });
        },
        eliminar(id) {
            let me = this;
            swal({
                title: "Deseas eliminar esta Muestra?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    axios.get('modelo/muestras/eliminar.php?id=' + id, {
                    }).then(function (response) {
                        if (response.data.indexOf('Error') != -1) {
                            alertify.error(response.data);
                            me.listar();
                            me.hj = 1;
                        } else {
                            me.listar();
                            alertify.success('Factura Eliminada');
                            if (me.entradas[0].pag % 10 == 1 && me.pag == me.hj) {
                                me.hj--;
                            }
                        }
                    }).catch(function (error) {
                        console.log(error);
                    });
                }
            });
        },
        eliminardet(id, index) {
            let me = this;
            swal({
                title: "Deseas eliminar este productos de la muestra?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    axios.get('modelo/muestras/eliminardetmuestras.php?id=' + id, {
                    }).then(function (response) {
                        console.log(response.data);
                        if ($.trim(response.data) == "bien") {
                            me.arrayop.splice(index, 1);
                            me.arrayops.splice(index, 1);
                            alertify.success('Detalle de Factura Eliminada');
                        } else {
                            alertify.error('No se pudo eliminar este producto');
                        }
                    }).catch(function (error) {
                        console.log(error);
                    });
                } else {
                }
            });
        },
        eliminardet1(id, index) {
            let me = this;
            swal({
                title: "Deseas eliminar este productos de la muestra?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    axios.get('modelo/muestras/eliminardetmuestras.php?id=' + id, {
                    }).then(function (response) {
                        console.log(response.data);
                        if ($.trim(response.data) == "bien") {
                            me.arrayops.splice(index, 1);
                            if (me.arrayops == "") {
                                $(".alvem").hide();
                            }
                            alertify.success('Detalle de Factura Eliminada');
                        } else {
                            alertify.error('No se pudo eliminar este producto');
                        }
                    }).catch(function (error) {
                        console.log(error);
                    });
                } else {
                }
            });
        },
        abrirModal(modelo, accion, data = []) {
            $(".bodymodales").addClass("modal-open");
            switch (modelo) {
                case "muestras":
                    {
                        switch (accion) {
                            case 'registrar':
                                {
                                    //necesarios
                                    this.modal = 1;
                                    this.tituloModal = "Crear muestra";
                                    this.tipoAccion = 1;
                                    //complementos
                                    this.fecha = moment().locale("es").format('YYYY-MM-DDTHH:mm');
                                    this.idCliente = null;
                                    this.idEmpleado = '';
                                    this.cliente = '';
                                    this.empleado = '';
                                    this.contacto = '';
                                    this.comentario = '';
                                    this.lugarEntrega = '';
                                    this.buscarclientes = '';
                                    this.numero = null;
                                    break;
                                }
                            case 'actualizar':
                                {
                                    //necesarios
                                    this.modal = 1;
                                    this.tituloModal = "Actualizar Muestra";
                                    this.tipoAccion = 2;
                                    //complementos
                                    this.idMuestras = data["idMuestras"];
                                    this.fecha = moment(String(data['fecha'])).format('YYYY-MM-DDThh:mm');
                                    this.idCliente = data["idCliente"];
                                    this.idEmpleado = data["idEmpleado"];
                                    this.buscarclientes = data["cliente"];
                                    this.empleado = data["empleado"];
                                    this.contacto = data["contacto"];
                                    this.comentario = data["comentario"];
                                    this.lugarEntrega = data["lugarEntrega"];
                                    this.numero = data["numero"];
                                    this.subTotal = data["total"];
                                    this.iva = data["total"] * 0.12;
                                    this.total = parseFloat(this.subTotal) + parseFloat(this.iva);
                                    break;
                                }
                            case 'actualizardet':
                                {
                                    //necesarios
                                    this.modal = 1;
                                    this.tituloModal = "Actualizar Detalle de muestra";
                                    this.tipoAccion = 5;
                                    //complementos
                                    this.idProducto = data["idProducto"];
                                    this.idMuestras = data["idMuestras"];
                                    this.idDetMuestras = data["idDetMuestras"];
                                    this.buscarproductos = data["codigo"];
                                    this.nombredet = data["descripcion"];
                                    this.descripciondet = data["observaciones"];
                                    this.cantidaddet = data["salida"];
                                    this.preciodet = data["precio"];
                                    this.comentariosdet = data["comentarios"];
                                    break;
                                }
                            case 'actualizarpagod':
                                {
                                    this.modal1 = 1;
                                    this.tituloModal = "Crear muestra";
                                    //complementos
                                    this.idProducto = data["idProducto"];
                                    this.idMuestras = data["idMuestras"];
                                    this.idDetMuestras = data["idDetMuestras"];
                                    this.buscarproductos = data["codigo"];
                                    this.nombredet = data["descripcion"];
                                    this.descripciondet = data["observaciones"];
                                    this.cantidaddet = data["salida"];
                                    this.comentariosdet = data["comentarios"];
                                    this.entrada = data["entrada"];
                                    this.entradav = data["entrada"];
                                    this.entradastock = data["stock"];
                                    break;
                                }
                        }
                    }
            }
        },
        actualizarentregadet() {
            if (this.entrada) {
                var entrrr = this.entrada;
            } else {
                var entrrr = 0;
            }
            if (this.entradav) {
                var entrrrv = this.entradav;
            } else {
                var entrrrv = 0;
            }
            //alert(entrrr);
            //alert(entrrrv);
            this.totalingreso = parseFloat(entrrr) + parseFloat(entrrrv);
            if (this.totalingreso < 0) {
                alertify.error('No puede ingresar una cantidad en negativo');
                return;
            }
            /*alert(this.totalingreso)
            var total = this.cantidaddet - this.totalingreso;
            alert(this.cantidaddet);
            alert(this.totalingreso);
            if(total<0){
                alertify.error('Esta ingresando una cantidad mayor a la que salió');
                return;
            }*/
            let me = this;
            axios({
                url: "modelo/muestras/actdetentradap.php",
                method: "get",
                params: {
                    'idProducto': this.idProducto,
                    'idMuestras': this.idMuestras,
                    'idDetMuestras': this.idDetMuestras,
                    'buscarproductos': this.buscarproductos,
                    'nombredet': this.nombredet,
                    'descripciondet': this.descripciondet,
                    'cantidaddet': this.cantidaddet,
                    'comentariosdet': this.comentariosdet,
                    'entrada': this.entrada,
                    'comentariodev': this.comentariodev,
                }
            }).then((respuesta) => {
                if ($.trim(respuesta.data) == "bien") {
                    alertify.success('Detalle actalizado');
                    me.listar();
                    me.abrirdetmuestras(me.idMuestras);
                    me.tipoAccion = 2;
                    me.modal1 = 0;
                    $(".cerrarmodal").click();
                } else {
                    alertify.error('Este producto no pudo ser actualizado');
                }
            }).catch((error) => {
                console.log(error);
                console.debug(error);
                console.dir(error);
            });
        },
        actualizardet() {
            if (this.validardetguias()) {
                return;
            }
            if (this.cantidaddet < 0 || this.preciodet < 0) {
                alertify.error('No se puede ingresar valores en negativo');
                return;
            }
            let me = this;
            axios({
                url: "modelo/muestras/actdetp.php",
                method: "get",
                params: {
                    'idProducto': this.idProducto,
                    'idMuestras': this.idMuestras,
                    'idDetMuestras': this.idDetMuestras,
                    'buscarproductos': this.buscarproductos,
                    'nombredet': this.nombredet,
                    'descripciondet': this.descripciondet,
                    'cantidaddet': this.cantidaddet,
                    'preciodet': this.preciodet,
                    'comentariosdet': this.comentariosdet,
                }
            }).then((respuesta) => {
                if (respuesta.data == "bien") {
                    alertify.success('Detalle actalizado');
                    me.abrirdetmuestras(me.idMuestras);
                    me.tipoAccion = 2;
                } else {
                    alertify.error('Este producto no pudo ser actualizado');
                }
            }).catch((error) => {
                console.log(error);
                console.debug(error);
                console.dir(error);
            });
        },
        cerrarModal() {
            $(".modaledit").addClass("modal-xl");
            $(".modaledit").removeClass("modal-md");
            $(".bodymodales").removeClass("modal-open");
            //necesarios
            this.modal = 0;
            this.tituloModal = '';
            //complementos
            this.detmuestras = [];
            this.arrayop = [];

            this.idCliente = null;
            this.clave_cliente = '';
            this.email_cliente = '';
            this.direccion = '';
            this.telefono = null;
            this.nombre_cliente = '';
            this.nombre = '';
            this.nombre_bodega = '';
            this.tipo = '';
            this.factura = null;
            this.autorizacion = '';
            this.clave_acceso = '';
            this.fecha = '';
            this.improducto = '';
            this.imnombre = '';
            this.cantidad = null;
            this.precio_unitario = null;
            this.valor_bruto = null;
            this.iva_rentas = null;
            this.total_ventas = null;
            this.op = null;
            this.comentario = '';
            this.preciodet = null;

            this.entradasfactura = [];

            this.sumtotal = 0;
            this.ivatotal = 0;
            this.totaltotal = 0;

            this.entradasop = [];
            this.numvista = 85;
            this.etc = '...';
            this.nomempleop = '';
            this.nomcliente = '';
            this.fechaEmision = '';
            this.RUC = '';
            this.telefono1 = '';
            this.celular = '';
            this.NOM_EMPLE = '';
            this.comentario = '';
            this.ordpedido = 0;
            this.direccion = '';
            this.pendiente = '';

            this.errorfecha = [];
            this.erroridEmpleado = [];
            this.erroridCliente = [];
            this.errorbuscarclientes = [];

            this.idproductoarray = [];
            this.codigosarray = [];
            this.nombrearray = [];
            this.cantidadarray = [];
            this.precioarray = [];
            this.descripcionarray = [];
            this.comentarioarray = [];

        },
        cerrarModal1() {
            //necesarios
            this.modal1 = 0;
        },
        validar() {
            $('.mirartopmodal').animate({
                scrollTop: 0
            }, 250);
            this.error = 0;
            this.errorfecha = [];
            this.erroridEmpleado = [];
            this.errorbuscarclientes = [];
            this.errornumero = [];
            this.errorcontacto = [];
            this.errorlugarEntrega = [];

            if (!this.fecha)
                this.errorfecha.push("Debe ingresar una Fecha");
            if (!this.idEmpleado)
                this.erroridEmpleado.push("Debe ingresar un empleado");
            if (!this.buscarclientes)
                this.errorbuscarclientes.push("Debe ingresar un cliente");
            if (!this.numero)
                this.errornumero.push("Debe ingresar una nota de entrega");
            if (!this.contacto)
                this.errorcontacto.push("Debe ingresar un contacto");
            if (!this.lugarEntrega)
                this.errorlugarEntrega.push("Debe ingresar un lugar de entrega");

            if (this.errorfecha.length || this.erroridEmpleado.length || this.errorbuscarclientes.length || this.errornumero.length || this.errorcontacto.length || this.errorlugarEntrega.length)
                this.error = 1;
            return this.error;
        },
        validardetguias() {
            $('.mirartopmodal').animate({
                scrollTop: 0
            }, 250);
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
        updateAvatar() {
            let formData = new FormData();
            formData.append('file', this.imagen);
            axios.post('modelo/muestras/subirexcel.php',
                formData,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }
            ).then((respuesta) => {
                console.log(respuesta.data);
                if ($.trim(respuesta.data) == "bien") {
                    alertify.success('Excel subido con éxito');
                    $(".subirupdateexcel").attr("style", "display:none");
                    this.listar();
                } else if ($.trim(respuesta.data) == "error") {
                    alertify.error('Formato de archivo inválido');
                    $(".subirupdateexcel").attr("style", "display:none");
                } else {
                    alertify.error('Error en los campo, tipos de datos erroneos en el excel');
                    $(".subirupdateexcel").attr("style", "display:none");
                }
            }).catch((error) => {
                alertify.error('Error en el archivo, puede ser que los campos esten mal ordenados o incompletos');
            });
        },
        getImage(event) {
            //Asignamos la imagen a  nuestra data
            this.imagen = event.target.files[0];
        },
        subirimagenus(event) {
            this.imagenus = event.target.files[0];
            this.usuarioimagen = this.sesion[0].IDUSUARIO;
            let formData = new FormData();
            formData.append('id', this.usuarioimagen);
            formData.append('file', this.imagenus);
            axios.post('modelo/busquedasgenerales/subirfoto.php',
                formData,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }
            ).then((respuesta) => {
                console.log(respuesta.data);
                localStorage.removeItem('dataoresa');
                location.href = "ingreso.php";
            }).catch((error) => {
                alertify.error('Error en el archivo, puede ser que los campos esten mal ordenados o incompletos');
            });
        }
    },
    mounted() {
        if (!this.sesion) {
            location.href = "./";
        }
        if(getParameterByName("id")){
            this.buscar=getParameterByName("id");
            
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
$(document).on("click", ".updateexcel", function () {
    $("#file").click();
});
$(document).on("change", "#file", function () {
    $(".subirupdateexcel").attr("style", "display:block;float: right;");
});
$(document).on("click", function (e) {
    var container = $(".menuw");
    if (!container.is(e.target) && container.has(e.target).length === 0) {
        $(".menuw").hide();
    }
});
function filterFloat(evt, input) {
    // Backspace = 8, Enter = 13, ‘0′ = 48, ‘9′ = 57, ‘.’ = 46, ‘-’ = 43
    var key = window.Event ? evt.which : evt.keyCode;
    var chark = String.fromCharCode(key);
    var tempValue = input.value + chark;
    if (key >= 48 && key <= 57) {
        if (filter(tempValue) === false) {
            return false;
        } else {
            return true;
        }
    } else {
        if (key == 8 || key == 13 || key == 0) {
            return true;
        } else if (key == 46) {
            if (filter(tempValue) === false) {
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }
}
function filter(__val__) {
    var preg = /^([0-9]+\.?[0-9]{0,2})$/;
    if (preg.test(__val__) === true) {
        return true;
    } else {
        return false;
    }

}
function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&amp;amp;]" + name + "=([^&amp;amp;#]*)"),
        results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
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