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
        dataoresa:[],
        //necesarios siempre
        buscar: '',
        entradas: [],
        entradasd: [],
        imagenus:'',
        usuarioimagen:'',
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
        //ingreso
        fechaIngreso: '',
        NOM_PROVEEDOR: '',
        tipoDocumento: '',
        documento:null,
        VENDEDOR: '',
        CLI_razonSocialNombres: '',
        CLI_razonComercialApellidos: '',
        entradasi:[],
        op:null,
        idOrdCompra:null,
    },
    filters: {
        trim(value) {
          return value.trim();
        },
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
        listar() {
            if(this.buscar){
                let me = this;
                axios({
                    url: "modelo/krdxProducto/listar.php",
                    method: "get",
                    params: {
                        'codigo':this.buscar,
                    }
                }).then((respuesta) => {
                    me.entradas = respuesta.data;
                    this.listardetalle();
                }).catch((error) => {
                    console.log(error);
                    console.debug(error);
                    console.dir(error);
                });
            }else{
                this.entradas="";
            }
        }, 
        listardetalle(){
            let me = this;
            axios({
                url: "modelo/krdxProducto/listardet.php",
                method: "get",
                params: {
                    'codigo':this.buscar,
                }
            }).then((respuesta) => {
                if($.trim(respuesta.data)=="error"){
                    me.entradasd = "";
                }else{
                    me.entradasd = respuesta.data;
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
                me.entradasop = respuesta.data;
                this.modal = 1;
                this.tituloModal = "Visualizar Orden de Pedido";
                this.tipoAccion = 1;
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
            }).catch((error) => {
                console.log(error);
                console.debug(error);
                console.dir(error);
            });
        },
        abriri(id){
            $(".bodymodales").addClass("modal-open");
            let me = this;
            axios({
                url: "modelo/busquedasgenerales/listari.php",
                method: "get",
                params: {
                    'id':id
                }
            }).then((respuesta) => {
                this.listardetalles(id);
                this.modal = 1;
                this.tituloModal = "Visualizar Ingresos";
                this.tipoAccion = 2;
                this.fechaIngreso = moment(String(respuesta.data[0].fechaIngreso)).format('YYYY-MM-DDThh:mm');
                this.NOM_PROVEEDOR =  respuesta.data[0].NOM_PROVEEDOR;
                this.tipoDocumento =  respuesta.data[0].tipoDocumento;
                this.documento = respuesta.data[0].documento;
                this.VENDEDOR =  respuesta.data[0].VENDEDOR;
                this.CLI_razonSocialNombres =  respuesta.data[0].CLI_razonSocialNombres + " " + respuesta.data[0].CLI_razonComercialApellidos;
                this.op = respuesta.data[0].op;
                this.idOrdCompra = respuesta.data[0].idOrdCompra;
            }).catch((error) => {
                console.log(error);
                console.debug(error);
                console.dir(error);
            });
        },
        listardetalles(id){
            let me = this;
            axios({ 
                url: "modelo/busquedasgenerales/listaridet.php",
                method: "get",
                params: {
                    'id':id,
                }
            }).then((respuesta) => {
                me.entradasi = respuesta.data;
            });
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
        cerrarModal() {
            $(".bodymodales").removeClass("modal-open");
            //necesarios
            this.modal = 0;
            this.tituloModal = '';
            //complementos
            this.entradasop = [];
            this.numvista =  90;
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
            this.imagenus = '';
            this.usuarioimagen = '';
        },
    },
    mounted() {
        if(!this.sesion){
            location.href="./";
        }
        this.dataoresa =JSON.parse(localStorage.getItem('dataoresa'));
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