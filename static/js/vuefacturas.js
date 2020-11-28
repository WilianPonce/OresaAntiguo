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
        //complementos de la página
        clave_cliente: '',
        email_cliente: '',
        direccion: '',
        telefono: null,
        nombre_cliente: '',
        nombre: '',
        nombre_bodega: '',
        tipo: '',
        factura: null,
        autorizacion: '',
        clave_acceso: '',
        fecha: '',
        improducto: '',
        imnombre: '',
        cantidad: null,
        precio_unitario: null,
        valor_bruto: null,
        iva_rentas: null,
        total_ventas: null,
        op: null,
        sumtotal: 0,
        ivatotal: 0,
        totaltotal: 0,
        comentarion:'',
        valor_nazira:0,
        errorvalor_nazira:[],
        //validaciones
        errorclave_cliente:[],
        errorfactura:[],
        errornop:[],
        a:'',
        //facturas
        entradasfactura:[],
        //llamado vista op
        entradasop:[],
        numvista: 90,
        etc:'...',
        nomempleop:'',
        nomcliente:'',
        fechaEmision: '',
        RUC: '',
        telefono1: '',
        celular: '',
        NOM_EMPLE: '',
        comentario: '',
        ordpedido: 0,
        direccion: '',
        pendiente:'',
        imagen:'',
        imagenus:'',
        usuarioimagen:'',
    },
    filters: {
        dec(value) {
          return (parseFloat(value)).toFixed(2);
        },
    },
    methods: {
        listar() {
            axios({
                url: "modelo/facturas/listar_facturas.php",
                method: "get",
                params: {
                    'buscar':this.buscar,
                    'hj':this.hj,
                }
            }).then(respuesta => {
                if($.trim(respuesta.data)){
                    this.entradas = respuesta.data;
                }else{ 
                    this.entradas = "";
                }
                if(respuesta.data){
                    this.pag = Math.ceil(862/10);
                }
            }).catch((error) => {
                console.log(error);
                console.debug(error);
                console.dir(error);
            }); 
        },
        listarfactura(factura){
            let me = this;
            axios({
                url: "modelo/facturas/listar_facturas1.php",
                method: "get",
                params: {
                    'factura':factura,
                }
            }).then((respuesta) => {
                if($.trim(respuesta.data)){
                    me.entradasfactura = respuesta.data;
                }else{
                    me.entradasfactura = "";
                }
            }).catch((error) => {
                console.log(error);
                console.debug(error);
                console.dir(error);
            }); 
        },
        abrirop(op){
            let me = this;
            axios({
                url: "modelo/busquedasgenerales/listar_op.php",
                method: "get",
                params: {
                    'op':op,
                }
            }).then((respuesta) => {
                $(".bodymodales").addClass("modal-open");
                me.entradasop = respuesta.data;
                this.modal = 1;
                this.tituloModal = "Visualizar Orden de Pedido";
                this.tipoAccion = 3;
                this.nomempleop=respuesta.data[0].NOM_EMPLE;
                this.nomcliente=respuesta.data[0].NOM_CLIENTE + ' '+ respuesta.data[0].APE_CLIENTE;
                this.fechaEmision=respuesta.data[0].fechaEmision;
                this.RUC=respuesta.data[0].RUC;
                this.telefono1=respuesta.data[0].telefono1;
                this.celular=respuesta.data[0].celular;
                this.NOM_EMPLE=respuesta.data[0].NOM_EMPLE;
                this.comentario=respuesta.data[0].comentario;
                this.ordpedido=respuesta.data[0].ordPedido;
                this.direccion=respuesta.data[0].direccion;
            }).catch((error) => {
                console.log(error);
                console.debug(error);
                console.dir(error);
            });
        },
        /*registrar() {
            if (this.validar()) {
                return;
            }
            let me = this;
            axios({
                url: "modelo/facturas/guardar_cuentasporcobrar.php",
                method: "get",
                params: {
                    'cedula':this.cedula,
                    'cliente':this.cliente,
                    'telefonos':this.telefonos,
                    'vendedor':this.vendedor,
                    'nfactura':this.nfactura,
                    'fecha_emision':this.fecha_emision,
                    'subtotal':this.subtotal,
                    'iva':this.iva,
                    'valor_factura':this.valor_factura,
                    'cancelaciones':this.cancelaciones,
                    'abonos':this.abonos,
                    'notas_credito':this.notas_credito,
                    'retenciones_renta':this.retenciones_renta,
                    'retenciones_iva':this.retenciones_iva,
                    'saldo':this.saldo,
                    'comentario':this.comentario,
                    'op':this.op,
                    'idcliente':this.idcliente,
                    'idvendedor':this.idvendedor,
                }
            }).then((respuesta) => {
                me.hj=1;
                me.cerrarModal();
                me.listar();
                alertify.success('Registro agregado');
            }).catch((error) => {
                console.log(error);
                console.debug(error);
                console.dir(error);
            })
        },*/
        actualizar() {
            if (this.validar()) {return;}
            let me = this;
            axios({
                url: "modelo/facturas/actualizar.php",
                method: "get",
                params: {
                    'op':this.op,
                    'valor_nazira':this.valor_nazira,
                    'comentarion':this.comentarion,
                }
            }).then((respuesta) => {
                me.cerrarModal();
                me.listar();
                alertify.success('Registro actualizado');
            }).catch((error) => {
                console.log(error);
                console.debug(error);
                console.dir(error);
            })
        },
        eliminar(id) {
            let me = this;
            swal({
                title: "Deseas eliminar esta factura?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    axios.get('modelo/facturas/eliminar.php?id=' + id, {
                    }).then(function (response) {     
                        me.listar();
                        alertify.success('Factura Eliminada'); 
                        if(me.entradas[0].pag%10==1 && me.pag==me.hj){
                            me.hj--;
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
                case "cxc":
                {
                    switch (accion) {
                        case 'actualizar':
                        {
                            //necesarios
                            this.modal = 1;
                            this.tituloModal = "Actualizar Valor de Sra. Nazira";
                            this.tipoAccion = 2;
                            //complementos
                            this.op = data['ordPedido'];
                            this.valor_nazira = data['valornazira'];
                            this.comentarion = data['comentario'];
                            break;
                        }
                        case 'visualizar':
                        {
                            //necesarios
                            this.modal = 1;
                            this.tituloModal = "Actualizar Facturación detallada";
                            this.tipoAccion = 4;
                            //complementos
                            this.id = data['id'];
                            this.clave_cliente = data['clave_cliente'];
                            this.email_cliente = data['email_cliente'];
                            this.direccion = data['direccion'];
                            this.telefono = data['telefono'];
                            this.nombre_cliente = data['nombre_cliente'];
                            this.nombre = data['nombre'];
                            this.nombre_bodega = data['nombre_bodega'];
                            this.tipo = data['tipo'];
                            this.factura = data['factura'];
                            this.autorizacion = data['autorizacion'];
                            this.clave_acceso = data['clave_acceso'];
                            this.fecha = data['fecha'];
                            this.improducto = data['improducto'];
                            this.imnombre = data['imnombre'];
                            this.cantidad = data['cantidad'];
                            this.precio_unitario = data['precio_unitario'];
                            this.valor_bruto = data['valor_bruto'];
                            this.iva_rentas = data['iva_rentas'];
                            this.total_ventas = data['total_ventas'];
                            this.op = data['op'];
                            this.comentario = data['comentario'];
                            this.sumtotal = data['sumtotal'];
                            this.ivatotal = data['ivatotal'];
                            this.totaltotal = data['totaltotal'];
                            break;
                        }
                    }
                }
            }
        },
        /*validar() {
            this.error = 0;
            this.errorcedula = [];
            this.errorcliente = [];
            this.errortelefonos = [];
            this.errorvendedor = [];
            this.errornfactura = [];
            this.errorfecha_emision = [];
            this.errorsubtotal = [];
            this.errorop = [];
            this.errorvalor_factura = [];

            if (!this.cedula)
                this.errorcedula.push("Debe ingresar una cédula");
            if (!this.cliente)
                this.errorcliente.push("Debe ingresar un cliente");
            if (!this.telefonos)
                this.errortelefonos.push("Debe ingresar un contacto");
            if (!this.vendedor)
                this.errorvendedor.push("Debe ingresar un vendedor");
            if (!this.nfactura)
                this.errornfactura.push("Ingresa un número de factura");
            if (!this.fecha_emision)
                this.errorfecha_emision.push("Debe ingresar una fecha de emisión");
            if (!this.subtotal)
                this.errorsubtotal.push("Debe ingresar el subtotal");
            if (!this.op)
                this.errorop.push("Debe ingresar un ord. pedido");
            if (!this.valor_factura)
                this.errorvalor_factura.push("Debe ingresar el valor de factura");

            if (this.errorcedula.length || this.errorcliente.length || this.errortelefonos.length || this.errorvendedor.length || this.errornfactura.length || this.errorfecha_emision.length || this.errorsubtotal.length || this.errorop.length || this.errorvalor_factura.length)
                this.error = 1;
            return this.error;
        },*/
        cerrarModal() {
            $(".modaledit").addClass("modal-xl");
            $(".modaledit").removeClass("modal-md");
            $(".bodymodales").removeClass("modal-open");
            //necesarios
            this.modal = 0;
            this.tituloModal = '';
            //complementos
            this.clave_cliente =  '';
            this.email_cliente =  '';
            this.direccion =  '';
            this.telefono =  null;
            this.nombre_cliente =  '';
            this.nombre =  '';
            this.nombre_bodega =  '';
            this.tipo =  '';
            this.factura =  null;
            this.autorizacion =  '';
            this.clave_acceso =  '';
            this.fecha =  '';
            this.improducto =  '';
            this.imnombre =  '';
            this.cantidad =  null;
            this.precio_unitario =  null;
            this.valor_bruto =  null;
            this.iva_rentas =  null;
            this.total_ventas =  null;
            this.op =  null;
            this.comentario =  '';

            this.entradasfactura = [];

            this.sumtotal = 0;
            this.ivatotal = 0;
            this.totaltotal = 0;

            this.entradasop = [];
            this.numvista = 85;
            this.etc = '...';
            this.nomempleop = '';
            this.nomcliente = '';
            this.fechaEmision =  '';
            this.RUC =  '';
            this.telefono1 =  '';
            this.celular =  '';
            this.NOM_EMPLE =  '';
            this.comentario =  '';
            this.ordpedido =  0;
            this.direccion =  '';
            this.pendiente = '';
        },
        validar() {
            this.error = 0;
            this.errorvalor_nazira = [];

            if (!this.valor_nazira)
                this.errorvalor_nazira.push("Debe ingresar un valor");

            if (this.errorvalor_nazira.length)
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
                if($.trim(respuesta.data) == "bien"){
                    alertify.success('Excel subido con éxito');
                    $(".subirupdateexcel").attr("style","display:none");
                    this.listar();
                }else if($.trim(respuesta.data) == "error"){
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
            axios.post( 'modelo/facturas/subirexcel1.php',
                formData,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }
            ).then((respuesta) => {
                if($.trim(respuesta.data) == "bien"){
                    alertify.success('Excel subido con éxito');
                    $(".subirupdateexcel").attr("style","display:none");
                    this.listar();
                }else if($.trim(respuesta.data) == "error"){
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
        getImage1(event){
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
        }   
    },
    mounted() {
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

$(document).on("click",".updateexcel1",function(){
    $("#file1").click();
});

$(document).on("change","#file1",function(){
    $(".subirupdateexcel1").attr("style","display:block;float: right;");
});

$(document).on("click",".edit",function(){
    $(".modaledit").removeClass("modal-xl");
    $(".modaledit").addClass("modal-md");
});