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
        ray: '',
        //Persona
        idPersona: null,
        cedulaRuc: '',
        tipo: '',
        razonSocialNombres: '',
        razonComercialApellidos: '',
        direccion: '',
        telefono1: '',
        telefono2: '',
        celular: '',
        eMail: '',
        pagWeb: '',
        ciudad1: '',
        ciudad: '',
        fechaCrea: '',
        fechaModifica: '',
        usuarioCrea: null,
        usuarioModifica: null,
        //Cliente
        idCliente: null,
        tipoCliente: 'FINAL',
        categoria: 'CONSUMO',
        idEmpleado: null,
        //errores
        errortipo: [],
        errorrazonSocialNombres: [],
        errorrazonComercialApellidos: [],
        errorcedulaRuc: [],
        erroreMail: [],
        errorciudad1: [],
        errorciudad: [],
        errordireccion: [],
        errortipoCliente: [],
        errorcategoria: [],
        imagenus: '',
        usuarioimagen: '',
        imagen: '',
    },
    methods: {
        listar() {
            let me = this;
            axios({
                url: "modelo/clientes/listar.php",
                method: "get",
                params: {
                    'buscar': this.buscar,
                    'hj': this.hj,
                    'usuarioCrea': this.sesion[0].IDEMPLEADO,
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
            }).catch((error) => {
                console.log(error);
                console.debug(error);
                console.dir(error);
            });
        },
        subiearchivo(event) {
            this.imagen = event.target.files[0];
            console.log(this.imagen);
        },
        actualizar() {
            if (this.validar()) { return; }
            let formData = new FormData();
            formData.append('file', this.imagen);
            formData.append('idPersona', this.idPersona);
            formData.append('cedulaRuc', this.cedulaRuc);
            formData.append('tipo', this.tipo);
            formData.append('razonSocialNombres', this.razonSocialNombres);
            formData.append('razonComercialApellidos', this.razonComercialApellidos);
            formData.append('direccion', this.direccion);
            formData.append('telefono1', this.telefono1);
            formData.append('telefono2', this.telefono2);
            formData.append('celular', this.celular);
            formData.append('eMail', this.eMail);
            formData.append('pagWeb', this.pagWeb);
            formData.append('ciudad1', this.ciudad1);
            formData.append('ciudad', this.ciudad);
            formData.append('usuarioModifica', this.sesion[0].IDUSUARIO);
            formData.append('idCliente', this.idCliente);
            formData.append('tipoCliente', this.tipoCliente);
            formData.append('categoria', this.categoria);
            formData.append('idEmpleado', this.sesion[0].IDEMPLEADO);
            axios.post('modelo/clientes/actualizar.php',
                formData,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }
            ).then((respuesta) => {
                console.log(respuesta.data);
                let me = this;
                if ($.trim(respuesta.data) == "bien") {
                    me.cerrarModal();
                    me.listar();
                    alertify.success('Registro actualizado');
                } else if ($.trim(respuesta.data) == "error") {
                    alertify.error('El cliente no pudo ser actualizado intentelo nuevamente');
                } else {
                    alertify.error('Error en la base consulte con el administrador');
                }
            }).catch((error) => {
                alertify.error('Error en la base, intente mas tarde');
            });
        },
        registrar() {
            if (this.validar()) {
                return;
            }
            let formData = new FormData();
            formData.append('file', this.imagen);
            formData.append('cedulaRuc', this.cedulaRuc);
            formData.append('tipo', this.tipo);
            formData.append('razonSocialNombres', this.razonSocialNombres);
            formData.append('razonComercialApellidos', this.razonComercialApellidos);
            formData.append('direccion', this.direccion);
            formData.append('telefono1', this.telefono1);
            formData.append('telefono2', this.telefono2);
            formData.append('celular', this.celular);
            formData.append('eMail', this.eMail);
            formData.append('pagWeb', this.pagWeb);
            formData.append('ciudad1', this.ciudad1);
            formData.append('ciudad', this.ciudad);
            formData.append('usuarioCrea', this.sesion[0].IDUSUARIO);
            formData.append('tipoCliente', this.tipoCliente);
            formData.append('categoria', this.categoria);
            formData.append('idEmpleado', this.sesion[0].IDEMPLEADO);
            axios.post('modelo/clientes/guardar.php',
                formData,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }
            ).then((respuesta) => {
                let me = this;
                console.log(respuesta.data);
                me.hj = 1;
                me.cerrarModal();
                me.listar();
                alertify.success('Registro agregado');
            }).catch((error) => {
                alertify.error('Error en la base, intente mas tarde');
            });
        },
        eliminar(id) {
            let me = this;
            swal({
                title: "Deseas eliminar este cliente?",
                text: "Se eliminará permanentemente de los registros",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    if (willDelete) {
                        swal("Escriba la palabra 'borrar' para borar este cliente", {
                            content: "input",
                        }).then((value) => {
                            if (`${value}` == 'borrar') {
                                axios.get('modelo/clientes/eliminar.php?id=' + id, {
                                }).then(function (respuesta) {
                                    if ($.trim(respuesta.data) == "bien") {
                                        me.listar();
                                        me.hj = 1;
                                        alertify.success('Cliente eliminado');
                                    } else if ($.trim(respuesta.data) == "error") {
                                        alertify.error('El Cliente no pudo ser eliminado intentelo nuevamente');
                                    } else {
                                        alertify.error('Error en la base consulte con el administrador');
                                    }
                                }).catch(function (error) {
                                    console.log(error);
                                });
                            } else {
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
                case "cliente":
                    {
                        switch (accion) {
                            case 'registrar':
                                {
                                    //necesarios
                                    this.modal = 1;
                                    this.tituloModal = "Crear cliente";
                                    this.tipoAccion = 1;
                                    //complementos
                                    //Persona
                                    this.idPersona = null;
                                    this.cedulaRuc = '';
                                    this.tipo = 'NATURAL';
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
                                    //Cliente
                                    this.idCliente = null;
                                    this.tipoCliente = 'FINAL ';
                                    this.categoria = 'CONSUMO ';
                                    this.idEmpleado = null;
                                    break;
                                }
                            case 'actualizar':
                                {
                                    //necesarios
                                    this.modal = 1;
                                    this.tituloModal = "Actualizar cliente";
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
                                    if (data["ciudad1"] == null) {
                                        this.ciudad1 = '';
                                    } else {
                                        this.ciudad1 = data["ciudad1"];
                                    }
                                    //Cliente
                                    this.idCliente = data["idCliente"];
                                    this.tipoCliente = data["tipoCliente"];
                                    this.categoria = data["categoria"];
                                    this.idEmpleado = data["idEmpleado"];
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
            //Cliente
            this.idCliente = null;
            this.tipoCliente = '';
            this.categoria = '';
            this.idEmpleado = null;
            //errores
            this.errortipo = [];
            this.errorrazonSocialNombres = [];
            this.errorrazonComercialApellidos = [];
            this.errorcedulaRuc = [];
            this.erroreMail = [];
            this.errorciudad1 = [];
            this.errorciudad = [];
            this.errordireccion = [];
            this.errortipoCliente = [];
            this.errorcategoria = [];
        },
        validar() {
            $('.mirartopmodal').animate({
                scrollTop: 0
            }, 250);
            this.error = 0;
            this.errortipo = [];
            this.errorrazonSocialNombres = [];
            this.errorrazonComercialApellidos = [];
            this.errorcedulaRuc = [];
            this.erroreMail = [];
            this.errorciudad1 = [];
            this.errorciudad = [];
            this.errordireccion = [];
            this.errortipoCliente = [];
            this.errorcategoria = [];

            var number = this.cedulaRuc;
            var dto = number.length;
            var valor;
            var acu = 0;
            
            for (var i = 0; i < dto; i++) {
                valor = number.substring(i, i + 1);
                if (valor == 0 || valor == 1 || valor == 2 || valor == 3 || valor == 4 || valor == 5 || valor == 6 || valor == 7 || valor == 8 || valor == 9) {
                    acu = acu + 1;
                }
            }
            if (acu == dto) {   
                if(number.substring(0, 2) > 24) {
                    this.errorcedulaRuc.push("Los dos primeros dígitos no pueden ser mayores a 24.");
                }
            }
            if (this.cedulaRuc.length!=10 && this.cedulaRuc.length!=13)   
                this.errorcedulaRuc.push("Cédula erronea");
            if (!this.tipo)
                this.errortipo.push("Debe ingresar un Tipo");
            if (!this.razonSocialNombres)
                this.errorrazonSocialNombres.push("Debe ingresar un RS-Nombre");
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

            if (this.errortipoCliente.length || this.errortipo.length || this.errorrazonSocialNombres.length || this.errorrazonComercialApellidos.length || this.errorcedulaRuc.length || this.erroreMail.length || this.errorciudad1.length || this.errorciudad.length || this.errordireccion.length || this.errorcategoria.length)
                this.error = 1;
            return this.error;
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


function soloNumeros(e) {
    var key = window.Event ? e.which : e.keyCode
    return (key >= 48 && key <= 57)
}