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
        cedula:null,
        cliente:'',
        telefonos:'',
        vendedor:'',
        nfactura:'',
        fecha_emision:'',
        subtotal:null,
        iva:null,
        valor_factura:null,
        cancelaciones:null,
        abonos:null,
        notas_credito:null,
        retenciones_renta:null,
        retenciones_iva:null,
        saldo:null,
        comentario:'',
        op:null,
        idcliente:null,
        idvendedor:null,
        errorcedula:[],
        errorcliente:[],
        errortelefonos:[],
        errorvendedor:[],
        errornfactura:[],
        errorfecha_emision:[],
        errorsubtotal:[],
        errorvalor_factura:[],
        errorop:[],
        a:'',
        dataoresa:'',
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
        imagenus:'',
        usuarioimagen:'',
    },
    methods: {
        listar() {
            let me = this;
            if(this.buscar.length){
                axios({
                    url: "modelo/cxc/listar_cuentasporcobrar.php",
                    method: "get",
                    params: {
                        'buscar':this.buscar,
                        'hj':this.hj,
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
            }else{
                axios({
                    url: "modelo/cxc/listar_cuentasporcobrar.php",
                    method: "get",
                    params: {
                        'buscar':this.buscar,
                        'hj':this.hj,
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
            }
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
            if (this.validar()) {
                return;
            }
            let me = this;
            axios({
                url: "modelo/cxc/guardar_cuentasporcobrar.php",
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
                console.log(respuesta);
                me.hj=1;
                me.cerrarModal();
                me.listar();
                alertify.success('Registro agregado');
            }).catch((error) => {
                console.log(error);
                console.debug(error);
                console.dir(error);
            })
        },
        actualizar() {
            if (this.validar()) {
                return;
            }
            let me = this;
            axios({
                url: "modelo/cxc/actualizar_cuentasporcobrar.php",
                method: "get",
                params: {
                    'id':this.id,
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
                title: "Deseas eliminar esta categoria?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    axios.delete('modelo/cxc/eliminar_cuentasporcobrar.php?id=' + id, {
                    }).then(function (response) {    
                        me.listar();
                        alertify.success('Categoría Eliminado'); 
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
                        case 'registrar':
                        {
                            //necesarios
                            this.modal = 1;
                            this.tituloModal = "Registrar Cuenta por cobrar";
                            this.tipoAccion = 1;
                            //complementos
                            this.id = "";
                            this.cedula = null;
                            this.cliente = '';
                            this.telefonos = '';
                            this.vendedor = '';
                            this.nfactura = '';
                            this.fecha_emision = moment().locale("es").format('YYYY-MM-DD'); 
                            this.subtotal = null;
                            this.iva = null;
                            this.valor_factura = null;
                            this.cancelaciones = null;
                            this.abonos = null;
                            this.notas_credito = null;
                            this.retenciones_renta = null;
                            this.retenciones_iva = null;
                            this.saldo = null;
                            this.comentario = '';
                            this.op = null;
                            this.idcliente = null;
                            this.idvendedor = null;
                            break;
                        }
                        case 'actualizar':
                        {
                            //necesarios
                            this.modal = 1;
                            this.tituloModal = "Actualizar Cuenta por cobrar";
                            this.tipoAccion = 2;
                            //complementos
                            this.id = data['id'];
                            this.cedula = data['cedula'];
                            this.cliente = data['cliente'];
                            this.telefonos = data['telefonos'];
                            this.vendedor = data['vendedor'];
                            this.nfactura = data['nfactura'];
                            this.fecha_emision = data['fecha_emision'];
                            this.subtotal = data['subtotal'];
                            this.iva = data['iva'];
                            this.valor_factura = data['valor_factura'];
                            this.cancelaciones = data['cancelaciones'];
                            this.abonos = data['abonos'];
                            this.notas_credito = data['notas_credito'];
                            this.retenciones_renta = data['retenciones_renta'];
                            this.retenciones_iva = data['retenciones_iva'];
                            this.saldo = data['saldo'];
                            this.comentario = data['comentario'];
                            this.op = data['op'];
                            this.idcliente = data['idcliente'];
                            this.idvendedor = data['idvendedor'];
                            break;
                        }
                    }
                }
            }
        },
        validar() {
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
        },
        cerrarModal() {
            $(".bodymodales").removeClass("modal-open");
            //necesarios
            this.modal = 0;
            this.tituloModal = '';
            //complementos
            this.id = "";
            this.cedula = null;
            this.cliente = '';
            this.telefonos = '';
            this.vendedor = '';
            this.nfactura = '';
            this.fecha_emision = '';
            this.subtotal = null;
            this.iva = null;
            this.valor_factura = null;
            this.cancelaciones = null;
            this.abonos = null;
            this.notas_credito = null;
            this.retenciones_renta = null;
            this.retenciones_iva = null;
            this.saldo = null;
            this.comentario = '';
            this.op = null;
            this.idcliente = null;
            this.idvendedor = null;
            this.errorcedula = [];
            this.errorcliente = [];
            this.errortelefonos = [];
            this.errorvendedor = [];
            this.errornfactura = [];
            this.errorfecha_emision = [];
            this.errorsubtotal = [];
            this.errorop = [];
            this.errorvalor_factura = [];
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
        updateAvatar(){
            let formData = new FormData();
            formData.append('file', this.imagen);
            axios.post( 'modelo/cxc/subirexcel.php',
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
        this.dataoresa =JSON.parse(localStorage.getItem('dataoresa'));
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
