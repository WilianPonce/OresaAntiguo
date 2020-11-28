var app = new Vue({
    el: '#app',
    data: {
        //sesion
        sesion:JSON.parse(localStorage.getItem('dataoresa')),
        dataoresa:[],
        //necesarios siempre
        buscar: '',
        entradas: [],
        entradasd: [],
        imagenus:'',
        usuarioimagen:'',
    },
    filters: {
        trim(value) {
          return value.trim();
        },
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
                url: "modelo/krdxProducto/listardetantiguo.php",
                method: "get",
                params: {
                    'codigo':this.buscar,
                }
            }).then((respuesta) => {
                console.log(respuesta.data); 
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