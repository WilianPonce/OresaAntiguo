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
        //Persona
        idPersona:null,
        cedulaRuc:'',
        tipo:'',
        razonSocialNombres:'',
        razonComercialApellidos:'',
        direccion:'',
        telefono1:'',
        telefono2:'',
        celular:'',
        eMail:'',
        pagWeb:'',
        ciudad1:'',
        ciudad:'',
        fechaCrea:'',
        fechaModifica:'',
        usuarioCrea:null,
        usuarioModifica:null,
        //Proveedor
        idProveedor:null,
        linkFacturaE:'',
        usuarioFacturaE:'',
        claveFacturaE:'',
        fechaCreacion:'',
        fechaModificacion:'',
        productoOferta:'',
        tipoProveedor:'',
        //errores
        errortipoProveedor:[],
        errortipo:[],
        errorrazonSocialNombres:[],
        errorrazonComercialApellidos:[],
        errorcedulaRuc:[],
        erroreMail:[],
        errorciudad1:[],
        errorciudad:[],
        errordireccion:[],
        imagenus:'',
        usuarioimagen:'',
    },
    methods: {
        listar() {
            let me = this;
            axios({
                url: "modelo/proveedor/listar.php",
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
        actualizar() {
            if (this.validar()) {return;}
            let me = this;
            axios({
                url: "modelo/proveedor/actualizar.php",
                method: "get",
                params: {
                    'idPersona':this.idPersona,
                    'cedulaRuc':this.cedulaRuc,
                    'tipo':this.tipo,
                    'razonSocialNombres':this.razonSocialNombres,
                    'razonComercialApellidos':this.razonComercialApellidos,
                    'direccion':this.direccion,
                    'telefono1':this.telefono1,
                    'telefono2':this.telefono2,
                    'celular':this.celular,
                    'eMail':this.eMail,
                    'pagWeb':this.pagWeb,
                    'ciudad1':this.ciudad1,
                    'ciudad':this.ciudad,
                    'usuarioModifica':this.sesion[0].IDUSUARIO,
                    'idProveedor':this.idProveedor,
                    'linkFacturaE':this.linkFacturaE,
                    'usuarioFacturaE':this.usuarioFacturaE,
                    'claveFacturaE':this.claveFacturaE,
                    'productoOferta':this.productoOferta,
                    'tipoProveedor':this.tipoProveedor,
                }
            }).then((respuesta) => {
                if($.trim(respuesta.data)=="bien"){
                    me.cerrarModal();
                    me.listar();
                    alertify.success('Registro actualizado'); 
                }else if($.trim(respuesta.data)=="error"){
                    alertify.error('El proveedor no pudo ser actualizado intentelo nuevamente'); 
                }else{
                    alertify.error('Error en la base consulte con el administrador');       
                }
            }).catch((error) => {
                console.log(error);
                console.debug(error);
                console.dir(error);
            })
        },
        registrar() {
            if (this.validar()) {
                return;
            }
            let me = this;
            axios({
                url: "modelo/proveedor/guardar.php",
                method: "get",
                params: {
                    'cedulaRuc':this.cedulaRuc,
                    'tipo':this.tipo,
                    'razonSocialNombres':this.razonSocialNombres,
                    'razonComercialApellidos':this.razonComercialApellidos,
                    'direccion':this.direccion,
                    'telefono1':this.telefono1,
                    'telefono2':this.telefono2,
                    'celular':this.celular,
                    'eMail':this.eMail,
                    'pagWeb':this.pagWeb,
                    'ciudad1':this.ciudad1,
                    'ciudad':this.ciudad,
                    'usuarioCrea':this.sesion[0].IDUSUARIO,
                    'linkFacturaE':this.linkFacturaE,
                    'usuarioFacturaE':this.usuarioFacturaE,
                    'claveFacturaE':this.claveFacturaE,
                    'productoOferta':this.productoOferta,
                    'tipoProveedor':this.tipoProveedor,
                }
            }).then((respuesta) => {
                console.log(respuesta.data);
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
        eliminar(id) {
            let me = this;
            swal({
                title: "Deseas eliminar este Proveedor?",
                text: "Se eliminará permanentemente de los registros",
                icon: "warning",  
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    if (willDelete) {
                        swal("Escriba la palabra 'borrar' para borar este proveedor", {
                            content: "input",
                        }).then((value) => {
                            if(`${value}`=='borrar'){
                                axios.get('modelo/proveedor/eliminar.php?id=' + id, {
                                }).then(function (respuesta) { 
                                    if($.trim(respuesta.data)=="bien"){
                                        me.listar();
                                        me.hj=1;
                                        alertify.success('Proveedor eliminado'); 
                                    }else if($.trim(respuesta.data)=="error"){
                                        alertify.error('El proveedor no pudo ser eliminado intentelo nuevamente'); 
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
        abrirModal(modelo, accion, data = []) {
            $(".bodymodales").addClass("modal-open");
            switch (modelo) {
                case "proveedor":
                {
                    switch (accion) {
                        case 'registrar':
                        {
                            //necesarios
                            this.modal = 1;
                            this.tituloModal = "Crear proveedor";
                            this.tipoAccion = 1;
                            //complementos
                            //Persona
                            this.idPersona = null;
                            this.cedulaRuc = '';
                            this.tipo = '';
                            this.razonSocialNombres = '';
                            this.razonComercialApellidos = '';
                            this.direccion = '';
                            this.telefono1 = '';
                            this.telefono2 = '';
                            this.celular = '';
                            this.eMail = '';
                            this.pagWeb = '';
                            this.ciudad = '';
                            this.ciudad1 = '';
                            //Proveedor
                            this.idProveedor = null;
                            this.linkFacturaE = '';
                            this.usuarioFacturaE = '';
                            this.claveFacturaE = '';
                            this.productoOferta = '';
                            this.tipoProveedor = '';
                            break;
                        }
                        case 'actualizar':
                        {
                            //necesarios
                            this.modal = 1;
                            this.tituloModal = "Actualizar proveedor";
                            this.tipoAccion = 2;
                            //complementos
                            this.idPersona = data["idPersona"];
                            this.cedulaRuc = data["cedulaRuc"];
                            this.tipo = data["tipo"];
                            this.razonSocialNombres = data["razonSocialNombres"];
                            this.razonComercialApellidos = data["razonComercialApellidos"];
                            this.direccion = data["direccion"];
                            this.telefono1 = data["telefono1"];
                            this.telefono2 = data["telefono2"];
                            this.celular = data["celular"];
                            this.eMail = data["eMail"];
                            this.pagWeb = data["pagWeb"];
                            this.ciudad = data["ciudad"];
                            if(data["ciudad1"]==null){
                                this.ciudad1 = '';
                            }else{
                                this.ciudad1 = data["ciudad1"];
                            }
                            //Proveedor
                            this.idProveedor = data["idProveedor"];
                            this.linkFacturaE = data["linkFacturaE"];
                            this.usuarioFacturaE = data["usuarioFacturaE"];
                            this.claveFacturaE = data["claveFacturaE"];
                            this.productoOferta = data["productoOferta"];
                            this.tipoProveedor = data["tipoProveedor"];
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
            this.idPersona = null;
            this.cedulaRuc = '';
            this.tipo = '';
            this.razonSocialNombres = '';
            this.razonComercialApellidos = '';
            this.direccion = '';
            this.telefono1 = '';
            this.telefono2 = '';
            this.celular = '';
            this.eMail = '';
            this.pagWeb = '';
            this.ciudad1 = '';
            this.ciudad = '';
            this.fechaCrea = '';
            this.fechaModifica = '';
            this.usuarioCrea = null;
            this.usuarioModifica = null;
            //Proveedor
            this.idProveedor = null;
            this.linkFacturaE = '';
            this.usuarioFacturaE = '';
            this.claveFacturaE = '';
            this.fechaCreacion = '';
            this.fechaModificacion = '';
            this.productoOferta = '';
            this.tipoProveedor = '';
            //errores
            this.errortipoProveedor = [];
            this.errortipo = [];
            this.errorrazonSocialNombres = [];
            this.errorrazonComercialApellidos = [];
            this.errorcedulaRuc = [];
            this.erroreMail = [];
            this.errorciudad1 = [];
            this.errorciudad = [];
            this.errordireccion = [];
        },
        validar() {
            $('.mirartopmodal').animate({
                scrollTop:0
            },250);
            this.error = 0;
            this.errortipoProveedor = [];
            this.errortipo = [];
            this.errorrazonSocialNombres = [];
            this.errorrazonComercialApellidos = [];
            this.errorcedulaRuc = [];
            this.erroreMail = [];
            this.errorciudad1 = [];
            this.errorciudad = [];
            this.errordireccion = [];

            if (!this.tipoProveedor)
                this.errortipoProveedor.push("tipo de Proveedor");
            if (!this.tipo)
                this.errortipo.push("Debe ingresar un Tipo");
            if (!this.razonSocialNombres)
                this.errorrazonSocialNombres.push("Debe ingresar un RS-Nombre");
            if (!this.razonComercialApellidos)
                this.errorrazonComercialApellidos.push("Debe ingresar un RC-Apellido");
            if (!this.cedulaRuc)
                this.errorcedulaRuc.push("Debe ingresar la cédula");
            if (!this.eMail)
                this.erroreMail.push("Debe ingresar un Correo elecrónico");
            if (!this.ciudad1)
                this.errorciudad1.push("Debe seleccionar Provincia");
            if (!this.ciudad)
                this.errorciudad.push("Debe ingresar una ciudad");
            if (!this.direccion)
                this.errordireccion.push("Debe ingresar una dirección");

            if (this.errortipoProveedor.length || this.errortipo.length || this.errorrazonSocialNombres.length || this.errorrazonComercialApellidos.length || this.errorcedulaRuc.length || this.erroreMail.length || this.errorciudad1.length || this.errorciudad.length || this.errordireccion.length)
                this.error = 1;
            return this.error;
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