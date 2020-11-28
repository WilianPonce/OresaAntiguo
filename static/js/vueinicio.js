var app = new Vue({
    el: '#app',
    data: {
        sesion:JSON.parse(localStorage.getItem('dataoresa')),
        idsesion:null,
        razonComercialApellidos:'',
        imagenus:'',
        usuarioimagen:'',
    },   
    methods:{
        salir() {
            localStorage.removeItem('dataoresa');
            location.href="ingreso.php";
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
        this.sesion =JSON.parse(localStorage.getItem('dataoresa'));
        if(!this.sesion){
            location.href="ingreso.php";
        }
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