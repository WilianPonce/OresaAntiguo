var app = new Vue({
    el: '#app',
    data: {
        error: 0,
        us:'',
        pas:'',
        errorus:[],
        errorpas:[],
        sesion:'', 
    },
    methods:{
        login(){
            if (this.validar()) {return;}
            let me = this;
            axios({
                url: "modelo/login/login.php",
                method: "get",
                params: {
                    'us':this.us,
                    'pas':this.pas,
                }
            }).then((respuesta) => {
                if($.trim(respuesta.data)!="error"){
                    $("#errorinicio").hide();
                    localStorage.setItem('dataoresa', JSON.stringify(respuesta.data));
                    location.href="./";
                }else{
                    $("#errorinicio").show();
                }
            }).catch((error) => {
                console.log(error);
                console.debug(error);
                console.dir(error);
            });
        },
        validar(){
            this.error = 0;
            this.errorus = [];
            this.errorpas = [];
            
            if (!this.us)
                this.errorus.push("Debe ingresar su correo");
            if (!this.pas)
                this.errorpas.push("Debe ingresar su contraseña");
            if (this.errorus.length || this.errorpas.length)
                this.error = 1;
            return this.error;
        },
    },
    mounted(){
        this.sesion = JSON.parse(localStorage.getItem('dataoresa'));
        if(this.sesion){
            location.href="./";
        }
        if(this.sesion != null){
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
    }
});
