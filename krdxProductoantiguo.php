<?php
    include 'modulo/head.php';
    include 'modulo/menu_top.php';
    include 'modulo/menu_left.php';
    include 'modulo/preloader.php';
?>
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0">Kardex del Producto antiguo</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="./">Inicio</a></li>
                <li class="breadcrumb-item active">krdxProducto antiguo</li>
            </ol>
        </div>
        <div class="col-md-7 col-4 align-self-center">
            <div class="d-flex m-t-10 justify-content-end">
                <div class="d-flex m-r-20 m-l-10 hidden-md-down">
                    <div class="chart-text m-r-10">
                        <h6 class="m-b-0"><small>Fecha Actual</small></h6>
                        <div class="m-t-0 text-info" id="clock">{{moment().locale("es").format('DD [de] MMMM [del] YYYY, h:mm:ssA')}}</div> 
                    </div>
                    <div class="spark-chart mr-3">
                        <i class="fas fa-calendar-alt fa-3x text-themecolor"></i>
                    </div>
                </div>
                <div class="">
                    <button class="right-side-toggle waves-effect waves-light btn-success btn btn-circle btn-sm pull-right m-l-10 btncliicked"><i class="ti-settings text-white"></i></button>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-lg-10 col-md-12 col-sm-12 form-material">
                            <input type="text" class="form-control" v-on:keyup.enter="hj=1,listar()" v-model="buscar" placeholder="Buscar..."/>
                            <i class="fa fa-search imgbuscar" @click="hj=1,listar()"></i>
                            <template v-if="buscar"><i class="fa fa-times imgdelete" @click="buscar='',hj=1,listar()"></i></template> 
                        </div>
                        <div class="col-lg-2 col-md-12 col-sm-12 form-material">
                            <a href="http://<?=substr($_SERVER['HTTP_HOST'],0,-5)?>:8080/oresa2019/krdxProducto" class="btn w-100 btn-info btn-roundeds mr-3">
                                Kardex Nuevo
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div v-if="$.trim(entradas)=='error'">
                                <div class="alert alert-danger text-center" role="alert">
                                    CÓDIGO NO ENCONTRADO, ASEGURATE DE HABERLO ESCRITO BIEN
                                </div>
                            </div>
                            <div v-else-if="entradas.length">
                                <div class="card-body">
                                    <div class="form-body">
                                        <div class="row m-0">
                                            <div class="col-md-4">
                                                <label class="control-label">IMAGEN DEL PRODUCTO</label>
                                                <img v-bind:src="'imagenes/productos/'+entradas[0].imagen+'.jpg'" style="width: 100%;max-height: 18rem;height: 15.8rem;">
                                            </div>
                                            <div class="col-md-3">
                                                <div class="row">
                                                    <label class="control-label">PRECIOS DEL CÓDIGO {{entradas[0].codigo}}</label>
                                                    <template v-if="entradas[0].P12"><div class="col-lg-6 pb-1 pt-1 text-center" style="border: 1px solid #ddd;"><label style="margin:0;font-size:13px;">Precio 12 </label><input type="text" style="min-height: 25px;background: transparent;border: none;color: #000!important;background:transparent!important;font-size:16px" class="form-control p-0 text-center" v-bind:value="'$'+entradas[0].P12" readonly=""></div></template>
                                                    <template v-if="entradas[0].P25"><div class="col-lg-6 pb-1 pt-1 text-center" style="border: 1px solid #ddd;"><label style="margin:0;font-size:13px;">Precio 25 </label><input type="text" style="min-height: 25px;background: transparent;border: none;color: #000!important;background:transparent!important;font-size:16px" class="form-control p-0 text-center" v-bind:value="'$'+entradas[0].P25" readonly=""></div></template>
                                                    <template v-if="entradas[0].P50"><div class="col-lg-6 pb-1 pt-1 text-center" style="border: 1px solid #ddd;"><label style="margin:0;font-size:13px;">Precio 50 </label><input type="text" style="min-height: 25px;background: transparent;border: none;color: #000!important;background:transparent!important;font-size:16px" class="form-control p-0 text-center" v-bind:value="'$'+entradas[0].P50" readonly=""></div></template>
                                                    <template v-if="entradas[0].P75"><div class="col-lg-6 pb-1 pt-1 text-center" style="border: 1px solid #ddd;"><label style="margin:0;font-size:13px;">Precio 75 </label><input type="text" style="min-height: 25px;background: transparent;border: none;color: #000!important;background:transparent!important;font-size:16px" class="form-control p-0 text-center" v-bind:value="'$'+entradas[0].P75" readonly=""></div></template>
                                                    <template v-if="entradas[0].P100"><div class="col-lg-6 pb-1 pt-1 text-center" style="border: 1px solid #ddd;"><label style="margin:0;font-size:13px;">Precio 100 </label><input type="text" style="min-height: 25px;background: transparent;border: none;color: #000!important;background:transparent!important;font-size:16px" class="form-control p-0 text-center" v-bind:value="'$'+entradas[0].P100" readonly=""></div></template>
                                                    <template v-if="entradas[0].P105"><div class="col-lg-6 pb-1 pt-1 text-center" style="border: 1px solid #ddd;"><label style="margin:0;font-size:13px;">Precio 105 </label><input type="text" style="min-height: 25px;background: transparent;border: none;color: #000!important;background:transparent!important;font-size:16px" class="form-control p-0 text-center" v-bind:value="'$'+entradas[0].P105" readonly=""></div></template>
                                                    <template v-if="entradas[0].P200"><div class="col-lg-6 pb-1 pt-1 text-center" style="border: 1px solid #ddd;"><label style="margin:0;font-size:13px;">Precio 200 </label><input type="text" style="min-height: 25px;background: transparent;border: none;color: #000!important;background:transparent!important;font-size:16px" class="form-control p-0 text-center" v-bind:value="'$'+entradas[0].P200" readonly=""></div></template>
                                                    <template v-if="entradas[0].P210"><div class="col-lg-6 pb-1 pt-1 text-center" style="border: 1px solid #ddd;"><label style="margin:0;font-size:13px;">Precio 210 </label><input type="text" style="min-height: 25px;background: transparent;border: none;color: #000!important;background:transparent!important;font-size:16px" class="form-control p-0 text-center" v-bind:value="'$'+entradas[0].P210" readonly=""></div></template>
                                                    <template v-if="entradas[0].P225"><div class="col-lg-6 pb-1 pt-1 text-center" style="border: 1px solid #ddd;"><label style="margin:0;font-size:13px;">Precio 225 </label><input type="text" style="min-height: 25px;background: transparent;border: none;color: #000!important;background:transparent!important;font-size:16px" class="form-control p-0 text-center" v-bind:value="'$'+entradas[0].P225" readonly=""></div></template>
                                                    <template v-if="entradas[0].P250"><div class="col-lg-6 pb-1 pt-1 text-center" style="border: 1px solid #ddd;"><label style="margin:0;font-size:13px;">Precio 250 </label><input type="text" style="min-height: 25px;background: transparent;border: none;color: #000!important;background:transparent!important;font-size:16px" class="form-control p-0 text-center" v-bind:value="'$'+entradas[0].P250" readonly=""></div></template>
                                                    <template v-if="entradas[0].P300"><div class="col-lg-6 pb-1 pt-1 text-center" style="border: 1px solid #ddd;"><label style="margin:0;font-size:13px;">Precio 300 </label><input type="text" style="min-height: 25px;background: transparent;border: none;color: #000!important;background:transparent!important;font-size:16px" class="form-control p-0 text-center" v-bind:value="'$'+entradas[0].P300" readonly=""></div></template>
                                                    <template v-if="entradas[0].P500"><div class="col-lg-6 pb-1 pt-1 text-center" style="border: 1px solid #ddd;"><label style="margin:0;font-size:13px;">Precio 500 </label><input type="text" style="min-height: 25px;background: transparent;border: none;color: #000!important;background:transparent!important;font-size:16px" class="form-control p-0 text-center" v-bind:value="'$'+entradas[0].P500" readonly=""></div></template>
                                                    <template v-if="entradas[0].P525"><div class="col-lg-6 pb-1 pt-1 text-center" style="border: 1px solid #ddd;"><label style="margin:0;font-size:13px;">Precio 525 </label><input type="text" style="min-height: 25px;background: transparent;border: none;color: #000!important;background:transparent!important;font-size:16px" class="form-control p-0 text-center" v-bind:value="'$'+entradas[0].P525" readonly=""></div></template>
                                                    <template v-if="entradas[0].P1000"><div class="col-lg-6 pb-1 pt-1 text-center" style="border: 1px solid #ddd;"><label style="margin:0;font-size:13px;">Precio 1000 </label><input type="text" style="min-height: 25px;background: transparent;border: none;color: #000!important;background:transparent!important;font-size:16px" class="form-control p-0 text-center" v-bind:value="'$'+entradas[0].P1000" readonly=""></div></template>
                                                    <template v-if="entradas[0].P1050"><div class="col-lg-6 pb-1 pt-1 text-center" style="border: 1px solid #ddd;"><label style="margin:0;font-size:13px;">Precio 1050 </label><input type="text" style="min-height: 25px;background: transparent;border: none;color: #000!important;background:transparent!important;font-size:16px" class="form-control p-0 text-center" v-bind:value="'$'+entradas[0].P1050" readonly=""></div></template>
                                                    <template v-if="entradas[0].P2500"><div class="col-lg-6 pb-1 pt-1 text-center" style="border: 1px solid #ddd;"><label style="margin:0;font-size:13px;">Precio 2500 </label><input type="text" style="min-height: 25px;background: transparent;border: none;color: #000!important;background:transparent!important;font-size:16px" class="form-control p-0 text-center" v-bind:value="'$'+entradas[0].P2500" readonly=""></div></template>
                                                    <template v-if="entradas[0].P5000"><div class="col-lg-6 pb-1 pt-1 text-center" style="border: 1px solid #ddd;"><label style="margin:0;font-size:13px;">Precio 5000 </label><input type="text" style="min-height: 25px;background: transparent;border: none;color: #000!important;background:transparent!important;font-size:16px" class="form-control p-0 text-center" v-bind:value="'$'+entradas[0].P5000" readonly=""></div></template>
                                                    <template v-if="entradas[0].P10000"><div class="col-lg-6 pb-1 pt-1 text-center" style="border: 1px solid #ddd;"><label style="margin:0;font-size:13px;">Precio 10000 </label><input type="text" style="min-height: 25px;background: transparent;border: none;color: #000!important;background:transparent!important;font-size:16px" class="form-control p-0 text-center" v-bind:value="'$'+entradas[0].P10000" readonly=""></div></template> 
                                                    <template v-if="entradas[0].DIST"><div class="col-lg-6 pb-1 pt-1 text-center" style="border: 1px solid #ddd;"><label style="margin:0;font-size:13px;">Precio DIST </label><input type="text" style="min-height: 25px;background: transparent;border: none;color: #000!important;background:transparent!important;font-size:16px" class="form-control p-0 text-center" v-bind:value="'$'+entradas[0].DIST" readonly=""></div></template>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                            <label class="control-label">DESCRIPCIÓN DEL PRODUCTO</label>
                                                <textarea class="form-control" rows="10">
                                                    {{entradas[0].descripcion}}
                                                </textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <table class="table table-striped mb-0 ov-h text-center">
                                    <thead>
                                        <tr>
                                            <th>Fecha de creación</th>
                                            <th>N° Documento</th>
                                            <th>Cant.</th>
                                            <th>Comentario</th>
                                            <th>Documeto</th>
                                            <th>Tipo</th>
    
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <template v-if="entradasd"> 
                                            <tr v-for="entrada in entradasd">
                                                <td>{{moment(String(entrada.fecha)).format('LLL')}}</td>
                                                <td>
                                                    {{entrada.numeroDocumento}}
                                                </td> 
                                                <td>
                                                    {{entrada.cantidad}} 
                                                </td> 
                                                <td v-if="entrada.comentario">{{entrada.comentario}}</td>
                                                <td v-else> - </td>
                                                <td>{{entrada.documeto}}</td>
                                                <td v-if="entrada.documeto.match(/INGRESO.*/)">Ingreso</td>
                                                <td v-else>Egreso</td>
                                            </tr>
                                        </template>
                                        <template v-else>
                                            <tr>
                                                <td colspan="20">
                                                    <div class="alert alert-warning text-center" role="alert">
                                                        SIN REGISTROS
                                                    </div>
                                                </td>
                                            </tr>
                                        </template>
                                    </tbody>
                                </table>
                            </div>
                            <div v-else>
                                <div class="alert alert-dark text-center" role="alert">
                                    DEBES INGRESAR UN CÓDGIO PARA REALIZAR UNA BUSQUEDA
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
    include 'modulo/chat.php';
    include 'modulo/foot.php';
    include 'modulo/footer.php';
?> 
<script src="static/js/vuekrdxProductoantiguo.js"></script>
</div>
</body>
</html> 