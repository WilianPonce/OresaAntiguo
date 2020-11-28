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
        fecha:'',
        idordpedido:null,
        formaPago:'',
        documento:'',
        comentario:'',
        valor:'',
        usuariocreacion:'',
        usuariomodificacion:'',
        errorfecha:[],
        erroridordpedido:[],
        errorformaPago:[],
        errordocumento:[],
        errorvalor:[],
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
            let me = this;
            axios({
                url: "modelo/pagos/listar_pagos.php",
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
                    me.entradas = ""; 
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
        registrar() {
            if (this.validar()) {
                return;
            }
            let me = this;
            axios({
                url: "modelo/pagos/guardar_pagos.php",
                method: "get",
                params: {
                    'fecha':this.fecha,
                    'idordpedido':this.idordpedido,
                    'formaPago':this.formaPago,
                    'documento':this.documento,
                    'comentario':this.comentario,
                    'valor':this.valor,
                    'usuariocreacion':this.usuariocreacion,
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
        },
        actualizar() {
            if (this.validar()) {
                return;
            }
            let me = this;
            axios({
                url: "modelo/pagos/actualizar_pagos.php",
                method: "get",
                params: {
                    'id':this.id,
                    'fecha':this.fecha,
                    'idordpedido':this.idordpedido,
                    'formaPago':this.formaPago,
                    'documento':this.documento,
                    'comentario':this.comentario,
                    'valor':this.valor,
                    'usuariomodificacion':this.usuariomodificacion,
                }
            }).then((respuesta) => {
                console.log(respuesta);
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
                title: "Deseas eliminar este pago?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    axios.delete('modelo/pagos/eliminar_pagos.php?id=' + id, {
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
                case "pagos":
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
                            this.fecha = moment().locale("es").format('YYYY-MM-DDTHH:mm');
                            this.idordpedido = null;
                            this.formaPago = '';
                            this.documento = '';
                            this.comentario = '';
                            this.valor = ''; 
                            this.usuariocreacion = 1;
                            this.usuariomodificacion = 1;
                            break;
                        }
                        case 'actualizar':
                        {
                            //necesarios
                            this.modal = 1;
                            this.tituloModal = "Actualizar Cuenta por cobrar";
                            this.tipoAccion = 2;
                            //complementos
                            this.id = data['idPagos'];   
                            this.fecha = moment(data['fecha']).format('YYYY-MM-DDTHH:mm'); 
                            this.idordpedido = data['idOrdPedido'];
                            this.formaPago = data['formaPago'];
                            this.documento = data['documento'];
                            this.comentario = data['comentario'];
                            this.valor = data['valor'];
                            this.usuariocreacion = data['usuarioCreacion'];
                            this.usuariomodificacion = 1;
                            break;
                        }
                    }
                    break;
                }
            }
        },
        validar() {
            this.error = 0;
            this.errorfecha = [];
            this.erroridordpedido = [];
            this.errorformaPago = [];
            this.errordocumento = [];
            this.errorvalor = [];

            if (!this.fecha)
                this.errorfecha.push("Debe ingresar una Fecha");
            if (!this.idordpedido)
                this.erroridordpedido.push("Debe ingresar un id de ord. pedido");
            if (!this.formaPago)
                this.errorformaPago.push("Debe ingresar una forma de pago");
            if(this.formaPago != "CREDITO "){
                if (!this.documento)
                    this.errordocumento.push("Debe ingresar un documento");
                if (!this.valor)
                    this.errorvalor.push("Ingresa un valor");
            }
            if (this.errorfecha.length || this.erroridordpedido.length || this.errorformaPago.length || this.errordocumento.length || this.errorvalor.length)
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
            this.fecha = '';
            this.idordpedido = null;
            this.formaPago = '';
            this.documento = '';
            this.comentario = '';
            this.valor = '';
            this.usuariocreacion = '';
            this.usuariomodificacion = '';
            this.errorfecha = [];
            this.erroridordpedido = [];
            this.errorformaPago = [];
            this.errordocumento = [];
            this.errorvalor = [];
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
            axios.post( 'modelo/pagos/subirexcel.php',
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
        escrd(){
            if(this.formaPago == "CREDITO "){
                this.documento = 0;
                this.valor = 0;
                $(".nomv").attr('disabled','disabled');
            }else{
                this.documento = "";
                this.valor = "";
                $(".nomv").removeAttr("disabled");
            }
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
// Make the DIV element draggable:
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