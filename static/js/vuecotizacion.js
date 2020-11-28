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

        buscarstock: '',
        entradasstock: [],
        pags: 1,
        hjs: 1,

        ray: '',
        buscarclientes: '',
        empleados: [],
        listclientes: [],
        //buscar 
        //cotizacion
        idCotizacion: null,
        fecha: '',
        usuarioCrea: null,
        formaPago: '',
        observacion: '',
        comentario: '',
        idCliente: null,
        idEmpleado: '',
        idContacto: null,
        empleado: '',
        cliente: '',
        contacto: '',
        iva: '',
        subTotal: '',
        total: '',
        creacion: '',
        //detallecotización
        idDetCotizacion: null,
        idProducto: null,
        idAuxProducto: null,
        nombre: '',
        descripcion: '',
        linkImagen: '',
        cant_1: null,
        cant_2: null,
        cant_3: null,
        cant_4: null,
        Pvp_1: null,
        Pvp_2: null,
        Pvp_3: null,
        Pvp_4: null,
        detalle: '',
        codigo: '',

        //errores
        errorfecha: [],
        erroridCliente: [],
        erroridEmpleado: [],
        imagenus: '',
        usuarioimagen: '',
        vercotizacion: null,

        detentradas: [],
        direccion: '',
        telefono1: '',
        celular: '',
        eMail: '',
        cedulaRuc: '',

        buscarfiltro: '',
        buscargeneral: '',
        cprecios: 'DIST',
        stockminimo: null,
        stockmaximo: null,
        costominimo: null,
        costomaximo: null,
        prdencero: localStorage.getItem("prdencero"),
        prdennegativo: localStorage.getItem("prdennegativo"),
        imagenus: '',
        usuarioimagen: '',
        agregarstocker: 0,
        //muestras
        muestras: [],
        color:'',
        marcas:[],
        categorias:[],
        prdencero:localStorage.getItem("prdencero"),
        prdennegativo:localStorage.getItem("prdennegativo"),

        P12:null,
        P25:null,
        P50:null,
        P75:null,
        P100:null,
        P105:null,
        P200:null,
        P210:null,
        P225:null,
        P250:null,
        P300:null,
        P500:null,
        P525:null,
        P1000:null,
        P1050:null,
        P2500:null,
        P5000:null,
        P10000:null,
        DIST:null,
        errorbuscarclientes:[],

        nombrenuevo: "",
        cantidadnuevo: null,
        precionuevo: null,
        detallenuevo: '',
        imagennuevo: "",

        errornombrenuevo: [],
        errorcantidadnuevo: [],
        errorprecionuevo: [],

        idf:null,
        cantf:null,
        preciof:null,
        detallef:'',

        errorcantf:[],
        errorpreciof:[],
        subtotalv:0, 
        ivav:0, 
        totalv:0, 

        enviac: "",
        recibec: "",
        mensajec: "",
        tituloc: "",
        vend: "",
        
        lisstockl:0,
    },
    filters: {
        dec(value) {
            return (parseFloat(value)).toFixed(2);
        },
        salto(value) {
            return value.replace(/(?:\r\n|\r|\n)/g, "\r\n");
        },
        solon(value) {
            if ((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105) && event.keyCode !== 190 && event.keyCode !== 110 && event.keyCode !== 8 && event.keyCode !== 9) {
                return false;
            }
        }
    },
    methods: {
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
            this.listarstock();
        },
        listar() {
            let me = this;
            axios({
                url: "modelo/cotizacion/listar.php",
                method: "get",
                params: {
                    'buscar': this.buscar,
                    'hj': this.hj,
                    usuarioCrea: this.sesion[0].IDUSUARIO,
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
                //me.buscar="";
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
                console.log(respuesta.data);
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
        listarstock() {
            let me = this;
            axios({
                url: "modelo/stock/listar_stock.php",
                method: "get",
                params: {
                    'buscar': this.buscarstock,
                    'hj': this.hjs,
                    'buscarfiltro': this.buscarfiltro,
                    'buscargeneral': this.buscargeneral,
                    'stockminimo': this.stockminimo,
                    'stockmaximo': this.stockmaximo,
                    'costominimo': this.costominimo,
                    'costomaximo': this.costomaximo,
                    'prdencero': this.prdencero,
                    'prdennegativo': this.prdennegativo,
                    'cprecios': this.cprecios,
                    'color': this.color,
                    'lisstockl':this.lisstockl,
                }
            }).then((respuesta) => {
                console.log(respuesta.data);
                if ($.trim(respuesta.data)) {
                    me.entradasstock = respuesta.data;
                } else {
                    me.entradasstock = '';
                }
                if (respuesta.data) {
                    me.pags = Math.ceil(respuesta.data[0].pag / 10);
                }
            }).catch((error) => {
                console.log(error);
                console.debug(error);
                console.dir(error);
            });
        },
        listardetalle(id) {
            let me = this;
            axios({
                url: "modelo/cotizacion/listardetalle.php",
                method: "get",
                params: {
                    'id': id,
                }
            }).then((respuesta) => {
                if ($.trim(respuesta.data)) {
                    me.detentradas = respuesta.data;
                } else {
                    me.detentradas = '';
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
        listarclientes() {
            let me = this;
            if (this.buscarclientes.length >= 3) {
                axios({
                    url: "modelo/busquedasgenerales/listar_clientes.php",
                    method: "get",
                    params: {
                        'CLIENTE': this.buscarclientes,
                        'empleado': this.sesion[0].IDEMPLEADO,
                    }
                }).then((respuesta) => {
                    console.log(respuesta.data);
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
        seleccionarcliente(cliente = []) {
            this.buscarclientes = cliente.razonSocialNombres + " " + cliente.razonComercialApellidos;
            this.idCliente = cliente.idCliente;
        },
        borraradv() {
            this.buscarfiltro = '';
            this.buscargeneral = '';
            this.stockminimo = null;
            this.stockmaximo = null;
            this.costominimo = null;
            this.costomaximo = null;
            this.color='';
            this.listarstock();
        },
        datos(data = []) {
            console.log(data);
            this.idCotizacion = data.idCotizacion;
            this.fecha = data.fecha;
            this.usuarioCrea = data.usuarioCrea;
            this.formaPago = data.formaPago;
            this.observacion = data.observacion;
            this.comentario = data.comentario;
            this.idCliente = data.idCliente;
            this.idEmpleado = data.idEmpleado;
            this.idContacto = data.idContacto;
            this.empleado = data.empleado; 
            this.buscarclientes = data.cliente;
            this.contacto = data.contacto;
            this.iva = data.iva;
            this.subTotal = data.subTotal;
            this.total = data.total;
            this.direccion = data.direccion;
            this.telefono1 = data.telefono1;
            this.celular = data.celular;
            this.eMail = data.eMail;
            this.cedulaRuc = data.cedulaRuc;
            this.creacion = moment(String(data.fecha)).format('LL');
            this.subtotalv = parseFloat(data.vsubt).toFixed(2);
            this.ivav = parseFloat(data.vsubt*0.12).toFixed(2);
            var sumatotal = parseFloat(this.subtotalv)+parseFloat(this.ivav);
            this.totalv = parseFloat(sumatotal).toFixed(2);
        },
        listarmuestras(id) {
            let me = this;
            axios({
                url: "modelo/stock/listar_muestras.php",
                method: "get",
                params: {
                    'id': id,
                }
            }).then((respuesta) => {
                if ($.trim(respuesta.data)) {
                    me.muestras = respuesta.data;
                } else {
                    me.muestras = '';
                }
            }).catch((error) => {
                console.log(error);
                console.debug(error);
                console.dir(error);
            });
        },
        registrar() {
            if(this.validar()){
                return;
            }
            this.empleado = $("#empleado option:selected").text();
            let me = this;
            axios({
                url: "modelo/cotizacion/guardar.php",
                method: "get",
                params: {
                    fecha: this.fecha,
                    usuarioCrea: this.sesion[0].IDUSUARIO,
                    formaPago: this.formaPago,
                    observacion: this.observacion,
                    comentario: this.comentario,
                    idCliente: this.idCliente,
                    idEmpleado: this.idEmpleado,
                    idContacto: this.idContacto,
                    empleado: this.empleado,
                    cliente: this.buscarclientes,
                    contacto: this.contacto,
                }
            }).then((respuesta) => {
                console.log(respuesta.data);
                if ($.trim(respuesta.data) == "error") {
                    alertify.error('No se pudo crear cotización, intente mas tarde');
                } else {
                    me.cerrarModal();
                    me.vercotizacion = $.trim(respuesta.data[0].idCotizacion);
                    me.datos(respuesta.data[0]);
                    me.listardetalle(me.vercotizacion);
                    me.listar();
                    alertify.success('Cotización creada');
                }
            }).catch((error) => {
                console.log(error);
                console.debug(error);
                console.dir(error);
            });
        },
        registrarsc(){
            if(this.validarsc()){
                return;
            }
            let formData = new FormData();
            formData.append('file', this.imagennuevo);
            formData.append('nombrenuevo', this.nombrenuevo);
            formData.append('cantidadnuevo', this.cantidadnuevo);
            formData.append('precionuevo', this.precionuevo);
            formData.append('detallenuevo', this.detallenuevo);
            formData.append('idCotizacion', this.idCotizacion);
            axios.post( 'modelo/cotizacion/agregarproductosc.php',
                formData,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }
            ).then((respuesta) => {
                alertify.success('Producto agregado');
                this.listardetalle(this.idCotizacion)
                this.cerrarModal();
                this.imagennuevo="";
                this.subtotalv = respuesta.data;
                this.ivav = respuesta.data * 0.12; 
                this.totalv = this.subtotalv + this.ivav;
            }).catch((error) => {
                alertify.error('Error en el archivo, puede ser que los campos esten mal ordenados o incompletos');
            });
        },
        imagensubir(event){
            this.imagennuevo = event.target.files[0];
        },
        eliminar(id) {
            let me = this;
            swal({
                title: "Deseas eliminar esta Cotización?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    axios.get('modelo/cotizacion/eliminar.php?id=' + id, {
                    }).then(function (response) {
                        if (response.data.indexOf('Error') != -1) {
                            alertify.error(response.data);
                            me.listar();
                            me.hj = 1;
                        } else {
                            me.listar();
                            alertify.success('Cotización eliminado');
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
        eliminardetalle(id, idc, subi) {
            var subt = (parseFloat(subi)).toFixed(2);
            let me = this;
            swal({
                title: "Deseas eliminar este Producto de la cotización?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    axios.get('modelo/cotizacion/eliminardetalle.php?id=' + id+'&sub='+ me.subTotal +'&subt='+ subt+ '&idc='+ idc, {
                    }).then(function (respuesta) {
                            console.log(respuesta.data);
                            me.listardetalle(idc);
                            me.listar();
                            alertify.success('Detalle eliminado');
                            me.subtotalv = respuesta.data;
                            me.ivav = respuesta.data * 0.12; 
                            me.totalv = me.subtotalv + me.ivav; 
                    }).catch(function (error) {
                        console.log(error);
                    });
                }
            });
        },
        nuevos(){ 
            //necesarios
            this.modal = 1;
            this.tituloModal = "Nuevo producto";
            this.tipoAccion = 4;
            //productos
            this.nombrenuevo = "";
            this.cantidadnuevo = null;
            this.precionuevo = null;
            this.detallenuevo = "";
            this.buscar='';
            this.hj=1;
        }, 
        abrirModal(modelo, accion, data = []) {
            $(".bodymodales").addClass("modal-open");
            switch (modelo) {
                case "cotizacion":
                {
                    switch (accion) {
                        case 'registrar':
                        {
                            //necesarios
                            this.modal = 1;
                            this.tituloModal = "Crear cotización";
                            this.tipoAccion = 1;
                            //complementos
                            this.idCotizacion = null;
                            this.fecha = moment().locale("es").format('YYYY-MM-DDTHH:mm');
                            this.usuarioCrea = null;
                            this.formaPago = '';
                            this.observacion = '';
                            this.comentario = '';
                            this.idCliente = null;
                            this.idEmpleado = '';
                            this.idContacto = null;
                            this.empleado = '';
                            this.cliente = '';
                            this.contacto = '';
                            this.iva = '';
                            this.subTotal = '';
                            this.total = '';
                            this.creacion = '';
                            this.buscarclientes = '';
                            break;
                        }
                        case 'editar':
                        {
                            //necesarios 
                            this.modal = 1;
                            this.tituloModal = "Editar producto de cotización";
                            this.tipoAccion = 5;
                            //productos
                            this.idf = data["idDetCotizacion"];
                            this.cantf = data["cant_1"];
                            this.preciof = data["Pvp_1"];
                            this.detallef = data["detalle"];
                            break;
                        }
                        case 'editarc':
                        {
                            //necesarios 
                            this.modal = 1;
                            this.tituloModal = "Editar producto de cotización";
                            this.tipoAccion = 8;
                            //productos
                            this.idf = data["idDetCotizacion"];
                            this.cantidadnuevo = data["cant_1"];
                            this.precionuevo = data["Pvp_1"];
                            this.detallenuevo = data["detalle"];
                            this.nombrenuevo = data["nombre"];
                            break;
                        }
                    }
                }
            }
        },
        cerrarModal() {
            $(".bodymodales").addClass("modal-open");
            $(".bodymodales").removeClass("modal-open");
            //necesarios
            this.modal = 0;
            this.tituloModal = '';
            this.tipoAccion = 0;
            this.detalle = "";

            this.idf = null;
            this.cantf = null;
            this.preciof = null;
            this.detallef = '';

            this.errorcantf = [];
            this.errorpreciof = [];
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
        },
        verimagen(img) {
            $(".bodymodales").addClass("modal-open");
            this.modal = 1;
            this.tipoAccion = 11;
            this.imagen = img + ".jpg";
        },
        verimagensc(img) { 
            $(".bodymodales").addClass("modal-open");
            this.modal = 1;
            this.tipoAccion = 12;
            this.imagen = img;
        }, 
        agregaracotizacion(prod = []) {
            $(".bodymodales").addClass("modal-open");
            //necesarios
            this.modal = 1;
            this.tituloModal = "Agregar a cotización";
            this.tipoAccion = 3;
            //interactivo
            this.idProducto = prod.idProducto;
            this.codigo = prod.codigo;
            this.nombre = prod.nombre;
            this.cant_1 = prod.stock;
            this.Pvp_1 = prod.P12;
            this.P12 = prod.P12;
            this.P25 = prod.P25;
            this.P50 = prod.P50;
            this.P75 = prod.P75;
            this.P100 = prod.P100;
            this.P105 = prod.P105;
            this.P200 = prod.P200;
            this.P210 = prod.P210;
            this.P225 = prod.P225;
            this.P250 = prod.P250;
            this.P300 = prod.P300;
            this.P500 = prod.P500;
            this.P525 = prod.P525;
            this.P1000 = prod.P1000;
            this.P1050 = prod.P1050;
            this.P2500 = prod.P2500;
            this.P5000 = prod.P5000;
            this.P10000 = prod.P10000;
            this.DIST = prod.DIST;
        },
        recp(c){ 
            let me = this;
            var valor = parseFloat(c);
            
            if(valor>=10000 && this.DIST){
                me.Pvp_1 = this.DIST;
            }else if(valor>=5000 && this.P5000){
                me.Pvp_1 = this.P5000;
            }else if(valor>=2500 && this.P2500){
                me.Pvp_1 = this.P2500;
            }else if(valor>=1050 && this.P1050){
                me.Pvp_1 = this.P1050;
            }else if(valor>=1000 && this.P1000){
                me.Pvp_1 = this.P1000;
            }else if(valor>=525 && this.P525){
                me.Pvp_1 = this.P525;
            }else if(valor>=500 && this.P500){
                me.Pvp_1 = this.P500;
            }else if(valor>=300 && this.P300){
                me.Pvp_1 = this.P300;
            }else if(valor>=250 && this.P250){
                me.Pvp_1 = this.P250;
            }else if(valor>=225 && this.P225){
                me.Pvp_1 = this.P225;
            }else if(valor>=210 && this.P210){
                me.Pvp_1 = this.P210;
            }else if(valor>=200 && this.P200){
                me.Pvp_1 = this.P200;
            }else if(valor>=105 && this.P105){
                me.Pvp_1 = this.P105;
            }else if(valor>=100 && this.P100){
                me.Pvp_1 = this.P100;
            }else if(valor>=75 && this.P75){
                me.Pvp_1 = this.P75;
            }else if(valor>=50 && this.P50){
                me.Pvp_1 = this.P50;
            }else if(valor>=25 && this.P25){ 
                me.Pvp_1 = this.P25;
            }


            
            /*if(valor<=25 && this.P25){ 
                me.Pvp_1 = this.P25;
            }
            else if(valor<=50 && this.P50){
                me.Pvp_1 = this.P50;
            }
            else if(valor<=75 && this.P75){
                me.Pvp_1 = this.P75;
            }
            else if(valor<=100 && this.P100){
                me.Pvp_1 = this.P100;
            }
            else if(valor<=105 && this.P105){
                me.Pvp_1 = this.P105;
            }
            else if(valor<=200 && this.P200){
                me.Pvp_1 = this.P200;
            }
            else if(valor<=210 && this.P210){
                me.Pvp_1 = this.P210;
            }
            else if(valor<=225 && this.P225){
                me.Pvp_1 = this.P225;
            }
            else if(valor<=250 && this.P250){
                me.Pvp_1 = this.P250;
            }
            else if(valor<=300 && this.P300){
                me.Pvp_1 = this.P300;
            }
            else if(valor<=500 && this.P500){
                me.Pvp_1 = this.P500;
            }
            else if(valor<=525 && this.P525){
                me.Pvp_1 = this.P525;
            }
            else if(valor<=1000 && this.P1000){
                me.Pvp_1 = this.P1000;
            }
            else if(valor<=1050 && this.P1050){
                me.Pvp_1 = this.P1050;
            }
            else if(valor<=2500 && this.P2500){
                me.Pvp_1 = this.P2500;
            }
            else if(valor<=5000 && this.P5000){
                me.Pvp_1 = this.P5000;
            }
            else if(valor>5000 && this.DIST){
                me.Pvp_1 = this.DIST;
            }*/
        },
        agregaracotiz() {
            let me = this;
            axios({
                url: "modelo/cotizacion/agregarproducto.php",
                method: "get",
                params: {
                    'idProducto': this.idProducto,
                    'codigo': this.codigo,
                    'nombre': this.nombre,
                    'cant_1': this.cant_1,
                    'Pvp_1': this.Pvp_1,
                    'detalle': this.detalle,
                    'idCotizacion': this.idCotizacion
                }
            }).then((respuesta) => {
                me.listar();
                me.listardetalle(this.idCotizacion);
                alertify.success('Registro agregado');
                axios({
                    url: "modelo/cotizacion/agregarproducto1.php",
                    method: "get",
                    params: {
                        'idCotizacion': this.idCotizacion
                    }
                });
                this.cerrarModal();
                this.subtotalv = respuesta.data;
                this.ivav = respuesta.data * 0.12; 
                this.totalv = this.subtotalv + this.ivav; 
                this.buscar='';
                this.hj=1;
            }).catch((error) => {
                console.log(error);
                console.debug(error);
                console.dir(error);
            })
        },
        validar(){
            $('.mirartopmodal').animate({
                scrollTop:0
            },250);
            this.error = 0;
            this.errorfecha = [];
            this.errorbuscarclientes = [];
            this.erroridEmpleado = [];
 
            if (!this.fecha)
                this.errorfecha.push("Ingrese una fecha");
            if (!this.buscarclientes)
                this.errorbuscarclientes.push("Debe ingresar un cliente");
            if (!this.idEmpleado)
                this.erroridEmpleado.push("Debe ingresar un empleado");

            if (this.errorfecha.length || this.errorbuscarclientes.length || this.erroridEmpleado.length)
                this.error = 1;
            return this.error;
        },
        validarsc(){
            $('.mirartopmodal').animate({
                scrollTop:0
            },250);
            this.error = 0;
            this.errornombrenuevo = [];
            this.errorcantidadnuevo = [];
            this.errorprecionuevo = [];
 
            if (!this.nombrenuevo)
                this.errornombrenuevo.push("Ingrese un nombre");
            if (!this.cantidadnuevo)
                this.errorcantidadnuevo.push("Ingrese cantidad");
            if (!this.precionuevo)
                this.errorprecionuevo.push("Ingrese precio");

            if (this.errornombrenuevo.length || this.errorcantidadnuevo.length || this.errorprecionuevo.length)
                this.error = 1;
            return this.error;
        },
        validarc(){
            $('.mirartopmodal').animate({
                scrollTop:0
            },250);
            this.errorcantf = [];
            this.errorpreciof = [];
 
            if (!this.cantf)
                this.errorcantf.push("Ingrese cantidad");
            if (!this.preciof)
                this.errorpreciof.push("Ingrese precio");

            if (this.errorcantf.length || this.errorpreciof.length)
                this.error = 1;
            return this.error;
        },
        editarc(){
            if(this.validarc()){
                return;
            }
            axios({
                url: "modelo/cotizacion/editarc.php",
                method: "get",
                params: {
                    id: this.idf,
                    cant: this.cantf,
                    precio: this.preciof,
                    detalle: this.detallef,
                    idCotizacion:this.idCotizacion,
                }
            }).then((respuesta) => {
                console.log(respuesta.data);
                this.listardetalle(this.idCotizacion);
                alertify.success("Detalle modificado");
                this.cerrarModal();
                this.subtotalv = respuesta.data;
                this.ivav = respuesta.data * 0.12; 
                this.totalv = this.subtotalv + this.ivav; 
            }).catch((error) => {
                console.log(error);
                console.debug(error);
                console.dir(error);
            });
        },
        editarc1(){
            let formData = new FormData();
            formData.append('id', this.idf);
            formData.append('nombre', this.nombrenuevo);
            formData.append('cant', this.cantidadnuevo);
            formData.append('precio', this.precionuevo);
            formData.append('detalle', this.detallenuevo);
            formData.append('idCotizacion', this.idCotizacion);
            formData.append('file', this.imagennuevo);
            axios.post('modelo/cotizacion/editarc1.php',
                formData,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }
            ).then((respuesta) => {
                console.log(respuesta.data);
                this.listardetalle(this.idCotizacion);
                alertify.success("Detalle modificado");
                this.cerrarModal();
                this.subtotalv = respuesta.data;
                this.ivav = respuesta.data * 0.12; 
                this.totalv = this.subtotalv + this.ivav; 
            }).catch((error) => {
                alertify.error('Error en el archivo, puede ser que los campos esten mal ordenados o incompletos');
            });
        },
        correo(id){
            this.idCotizacion = id;
            this.modal = 1;
            this.tituloModal = "Enviar por correo";
            this.tipoAccion = 6;
            axios({
                url: "modelo/cotizacion/recuperaemail.php",
                method: "get",
                params: {
                    id: this.sesion[0].IDUSUARIO
                }
            }).then((respuesta) => {
                this.enviac = respuesta.data;
            });
        },
        enviarcorr(){   
            this.vend = this.sesion[0].razonSocialNombres + " " + this.sesion[0].razonComercialApellidos;
            alert("entra");
            axios({
                url: "modelo/cotizacion/enviarcorreo.php",
                method: "get",
                params: {
                    cotizacion: this.idCotizacion,
                    envia: this.enviac,
                    recibe: this.recibec,
                    rcue: this.mensajec,
                    rcab: this.tituloc,
                    vend: this.vend
                }
            }).then((respuesta) => {
                console.log(respuesta.data); 
                alertify.success("Correo enviado");
                this.cerrarModal();
                this.idCotizacion = '';
                this.recibec = '';
                this.mensajec = '';
                this.tituloc = '';
                this.vend = '';
            });
        },
        actualizarcotil(){
            let me = this;
            axios({
                url: "modelo/cotizacion/actualizarcmt.php",
                method: "get",
                params: {
                    id: this.idCotizacion,
                    observacion: this.observacion,
                    comentario: this.comentario,

                    pago: this.formaPago,
                    idcliente: this.idCliente,
                    cliente: this.buscarclientes,
                    contacto: this.contacto     
                }
            }).then((respuesta) => {
                console.log(respuesta.data);
                me.listardetalle(me.idCotizacion)
                alertify.success('Cotización creada');
            }).catch((error) => {
                console.log(error);
                console.debug(error);
                console.dir(error);
            }); 
        },
        generarpdfc(){
            alertify.success('Generando pdf, espere por favor...');
        }
    },
    mounted() {
        if (!this.sesion) {
            location.href = "./";
        }
        this.listar();
        this.listarempleados();
        this.listarcategoria(); 
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
    var preg = /^([0-9]+\.?[0-9]{0,3})$/;
    if (preg.test(__val__) === true) {
        return true;
    } else {
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