<?php
    include 'modulo/head.php';
    /*$user = "<script>document.write(localStorage.getItem('dataoresa'));</script>";
    if($user!='null'){
        header('Location:index.php');
    }*/
?>
<section id="wrapper" class="login-register login-sidebar" style="background-image:url(static/assets/images/background/login-register.jpg);">
    <div class="login-box card">
        <form v-on:submit.prevent="login()">
            <div class="card-body">
                <a href="javascript:void(0)" class="text-center db"><img src="static/assets/images/logo-icon.png" alt="Home" /><br/><img src="static/assets/images/logo-text.png" alt="Home" /></a>
                <div class="form-group m-t-40">
                    <div class="col-xs-12">
                        <input class="form-control" placeholder="Ingresa tu cédula" v-model="us">
                        <div v-show="error">
                            <div v-for="err in errorus" :key="err" v-text="err" class="errorcamp"></div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12">
                        <input type="password" class="form-control" placeholder="Ingresa tu Contraseña" v-model="pas">
                        <div v-show="error">
                            <div v-for="err in errorpas" :key="err" v-text="err" class="errorcamp"></div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12"> 
                        <div class="checkbox checkbox-primary pull-left p-t-0">
                            <input id="checkbox-signup" type="checkbox" checked>
                            <label for="checkbox-signup"> Recordarme </label> <i class="fa fa-question-circle" data-toggle="tooltip" data-original-title="evita que su cuenta cierre aunque cierre esta página, solo se cerrara sesión cuando usted clickee en el botón cerrar sesión"></i>
                        </div>
                </div>
                <div id="errorinicio" style="display:none;"><div class="alert alert-warning text-center mt-3 mb-3" role="alert">Datos erroneos<br/> verifica los datos ingresados</div></div>
                <div class="form-group text-center m-t-20">
                    <div class="col-xs-12">
                        <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">INGRESAR</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
<?php
    include 'modulo/footer.php';
?> 
<script src="static/js/vueingreso.js"></script>
</div>
</body>
</html>