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
        //guia
        fechaEmision:'',
        idSucursal:'',
        idCliente:'',
        idEmpleado:'',
        lugarEntrega:'',
        fechaEntrega:'',
        comprobantePago:'',
        tipoDocumento:'',
        COMENTA:'',
        entregadoPor:'',
        recibidoPor:'',
        linkImagen:'',
        VENDEDOR:'',
        cedulaRuc:'',
        razonSocialNombres:'',
        razonComercialApellidos:'',
        direccion:'',
        telefono1:'',
        celular:'',
        eMail:'',
        codigo:'',
        idProducto:'',
        idAuxProducto:'',
        descripcion:'',
        cantidad:'',
        comentario:'',
        idDetGuia:'',
        numeroGuia:'',
        observaciones:'',
        estado:'',
        idDetOrdPedido:'',
        sucursal:'',
        detalle:[],
        op:'',
        imagenus:'',
        usuarioimagen:'',
        sucursalf:'',
    },
    filters: {
        dec(value) {
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
                url: "modelo/guiaremision/listar.php",
                method: "get",
                params: {
                    'buscar':this.buscar,
                    'hj':this.hj,
                    sesion:this.sesion[0].IDEMPLEADO, 
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
        eliminar(id) {
            let me = this;
            swal({
                title: "Seguro deseas eliminar esta Guia de Remisión?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    axios({
                        url: "modelo/guiaremision/eliminar.php",
                        method: "get",
                        params: {
                            'id':id,
                        }
                    }).then((respuesta) => { 
                        console.log(respuesta.data);
                        if(respuesta.data == 'error'){
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
        abrirModal(modelo, accion, data = []) {
            $(".bodymodales").addClass("modal-open");
            switch (modelo) {
                case "guia":
                {
                    switch (accion) {
                        case 'registrar':
                        {
                            //necesarios
                            this.modal = 1;
                            this.tituloModal = "Crear ingreso";
                            this.tipoAccion = 1;
                            //complementos
                            this.fechaEmision = moment().locale("es").format('YYYY-MM-DDTHH:mm');
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
                            this.sucursal = '';
                            this.op = '';
                            break;
                        }
                        case 'actualizar':
                        {
                            //necesarios
                            this.modal = 1;
                            this.tituloModal = "Guia de remisión";
                            this.tipoAccion = 2;
                            //complementos
                            this.fechaEmision = moment(String(data['fechaEmision'])).format('YYYY-MM-DDThh:mm');
                            this.idSucursal = data["idSucursal"];
                            this.idCliente = data["idCliente"];
                            this.idEmpleado = data["idEmpleado"];
                            this.lugarEntrega = data["lugarEntrega"];
                            this.fechaEntrega = moment(String(data['fechaEntrega'])).format('YYYY-MM-DDThh:mm');
                            this.comprobantePago = data["comprobantePago"];
                            this.tipoDocumento = data["tipoDocumento"];
                            this.COMENTA = data["COMENTA"];
                            this.entregadoPor = data["entregadoPor"];
                            this.recibidoPor = data["recibidoPor"];
                            this.linkImagen = data["linkImagen"];
                            this.VENDEDOR = data["VENDEDOR"];
                            this.cedulaRuc = data["cedulaRuc"];
                            this.razonSocialNombres = data["razonSocialNombres"];
                            this.razonComercialApellidos = data["razonComercialApellidos"];
                            this.direccion = data["direccion"];
                            this.telefono1 = data["telefono1"];
                            this.celular = data["celular"];
                            this.eMail = data["eMail"];
                            this.sucursal = data["sucursal"];
                            this.sucursalf = data["sucursalf"];
                            this.numeroGuia = data["numeroGuia"];
                            this.op = data["op"];
                            break;
                        }
                    }
                }
            }
        },
        listardetalle(id) {
            let me = this;
            axios({
                url: "modelo/guiaremision/listardetalle.php",
                method: "get",
                params:{
                    'id':id
                }
            }).then((respuesta) => {
                console.log(respuesta.data);
                if($.trim(respuesta.data)){
                    me.detalle = respuesta.data;  
                }else{
                    me.detalle = '';
                }
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