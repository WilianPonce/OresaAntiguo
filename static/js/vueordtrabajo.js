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
        detalle:[],
        //complementos de la página
        //ordtrabajo
        idOrdTrabajo:null,
        fechaInicio:'',
        imagen:'',
        fechaModifica:'',
        fechaEntrega:'',
        usuarioCrea:null,
        usuarioModifica:null,
        idEmpleado:null,
        idAuxProducto:null,
        descripcion:'',
        cantidad:null,
        comentario:'',
        linkImagen:'',
        idProducto:null,
        codigo:'',
        nombre:'',
        observaciones:'',
        estadoLG:null,
        estado:null,
        idCliente:null,
        razonSocialNombres:'',
        razonComercialApellidos:'',
        idOrdPedido:null,
        ordpedido:null,
        empleado:'',
        iddetordpedido:null,
        pendiente:null,
        cliente:'',
        //detalleordtrabajo
        ordPedido:null,
        idDetOrdTrabajo:null,
        entrada:null,
        fechaFinImpresion:'',
        empacadoPor:'',
        fechaAsignacion:'',
        fechaFinalizacion:'',
        idLogotipo:null,
        fechaAprobado:'',
        alto:'',
        ancho:'',
        colores:null,
        aprobadoPor:'',
        tipoTrabajo:'',
        logo:'',
        OBSERVACION_LOGO:'',
        impresor:'',
        tipotrabajo:'',
        solocolor:'',
        imagenus:'',
        usuarioimagen:'',
        estadoLG:null,
    },
    methods: {
        listar() {
            let me = this;
            axios({
                url: "modelo/ordtrabajo/listar.php",
                method: "get",
                params: {
                    'buscar':this.buscar,
                    'hj':this.hj,
                }
            }).then((respuesta) => {
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
        eliminar(id) {
            let me = this;
            swal({
                title: "Seguro deseas Desactivar esta orden de trabajo?",
                icon: "warning",
                buttons: ["Cancelar", "Desactivar"],
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    axios({
                        url: "modelo/ordtrabajo/eliminar.php",
                        method: "get",
                        params: {
                            'id':id,
                        }
                    }).then((respuesta) => { 
                        console.log(respuesta.data);
                        if($.trim(respuesta.data) == 'error'){
                            alertify.error('Error en la eliminación de este ingreso');  
                        }else{
                            me.listar();
                            alertify.success('Ingreso desactivado');
                        }
                    }).catch((error) => {
                        console.log(error);
                        console.debug(error);
                        console.dir(error);
                    });
                }
            });
        },
        abrirModal(modelo, accion, data = []) {
            $(".bodymodales").addClass("modal-open");
            switch (modelo) {
                case "ordtrabajo":
                {
                    switch (accion) {
                        case 'actualizar':
                        {
                            //necesarios
                            this.modal = 1;
                            this.tituloModal = "Orden de trabajo";
                            this.tipoAccion = 2;
                            //complementos 
                            this.ordPedido = data["ordpedido"]; 
                            this.fechaInicio = moment(String(data['fechaInicio'])).format('YYYY-MM-DDThh:mm');
                            this.empleado = data["empleado"];
                            this.cliente = data["razonSocialNombres"]+' '+data["razonComercialApellidos"];
                            this.estado = data["estado"];
                            this.idOrdPedido = data["idOrdPedido"];
                            this.estadoLG = data["estadoLG"];
                            break;
                        }
                    }
                }
            }
        },
        listardetalle(id) {
            let me = this;
            axios({
                url: "modelo/ordtrabajo/listardetalle.php",
                method: "get", 
                params:{
                    'id':id
                }
            }).then((respuesta) => {
                console.log(respuesta.data);
                    me.detalle = respuesta.data;  
            }).catch((error) => {
                console.log(error);
                console.debug(error);
                console.dir(error);
            });
        },
        eliminardet(id, guia,cantidad,det){
            let me = this;
            swal({
                title: "Seguro deseas eliminar esta Guia de Remisión?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    axios({ 
                        url: "modelo/guiaremision/eliminardet.php",
                        method: "get",
                        params: {
                            'id':id,
                            'cantidad':cantidad,
                            'det':det 
                        }
                    }).then((respuesta) => {
                        alertify.success('Ingreso Eliminado');
                        this.listardetalle(guia);
                    }).catch((error) => {
                        console.log(error);
                        console.debug(error);
                        console.dir(error);
                    });
                }
            });   
        },
        cerrarModal() {
            $(".bodymodales").removeClass("modal-open");
            //necesarios
            this.modal = 0;
            this.tituloModal = '';
            //complementos
            this.fechaEmision = '';
            this.idSucursal = '';
            this.idCliente = '';
            this.idEmpleado = '';
            this.lugarEntrega = '';
            this.fechaEntrega = '';
            this.comprobantePago = '';
            this.tipoDocumento = '';
            this.COMENTA = '';
            this.entregadoPor = '';
            this.recibidoPor = '';
            this.linkImagen = '';
            this.VENDEDOR = '';
            this.cedulaRuc = '';
            this.razonSocialNombres = '';
            this.razonComercialApellidos = '';
            this.direccion = '';
            this.telefono1 = '';
            this.celular = '';
            this.eMail = '';
            this.codigo = '';
            this.idProducto = '';
            this.idAuxProducto = '';
            this.descripcion = '';
            this.cantidad = '';
            this.comentario = '';
            this.idDetGuia = '';
            this.numeroGuia = '';
            this.observaciones = '';
            this.estado = '';
            this.idDetOrdPedido = '';
        },
        aceptarord(data = []){
            this.idOrdPedido = data["idOrdPedido"];
            let me = this;
            swal({
                title: "Seguro deseas ACEPTAR este trabajo como hecho",
                icon: "warning",
                buttons: ["Cancelar", "Aceptar"],
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    axios({
                        url: "modelo/ordtrabajo/aprobar.php",
                        method: "get",
                        params: {
                            'idOrdPedido':this.idOrdPedido,
                        }
                    }).then((respuesta) => { 
                        console.log(respuesta.data);
                        if($.trim(respuesta.data) == 'error'){
                            alertify.error('Error en la eliminación de este ingreso');  
                        }else{
                            me.listar();
                            alertify.success('Orden de trabajo terminado');
                        }
                    }).catch((error) => {
                        console.log(error);
                        console.debug(error);
                        console.dir(error);
                    });
                }
            });
        },
        verimagen(img){
            $(".bodymodales").addClass("modal-open");
            this.ancho="modal-xl"; 
            //necesarios 
            this.modal = 1;
            this.tituloModal = "Imagen de "+img;
            this.tipoAccion = 11;
            this.imagen=img; 
        },
        updateAvatar(){
            $(".preload").show();
            $(".bodymodal").addClass("modal-open");
            let formData = new FormData();
            formData.append('file', this.imagen);
            formData.append('id', this.idOrdPedido);
            axios.post('modelo/ordtrabajo/subir.php',
                formData,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }
            ).then((respuesta) => {
                console.log(respuesta.data);
                alertify.success('Comprobante de trabajo subido exitosamente');
                this.cerrarModal();
                this.listar();
                $("#submit").hide();
                $(".imagenst").val("");
            }).catch((error) => {
                $(".preload").hide();
                $(".bodymodal").removeClass("modal-open");
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
        if(!this.sesion){
            location.href="./";
        }
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