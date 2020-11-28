var app = new Vue({
    el: '#app',
    data: {
        //sesion
        sesion:JSON.parse(localStorage.getItem('dataoresa')),
        //necesarios siempre
        buscar: '',
        entradas: [],
        id: 0,
        pag:1, 
        hj:1,
        imagenus:'',
        usuarioimagen:'',
    },
    methods: {
        listar() {
            let me = this;
            axios({
                url: "modelo/stockbodega/listar.php",
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