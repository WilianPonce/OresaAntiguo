<?php
    include 'modulo/head.php';
    include 'modulo/menu_top.php';
    include 'modulo/menu_left.php';
    include 'modulo/preloader.php';
?>
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0">Kardex del Producto</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="./">Inicio</a></li>
                <li class="breadcrumb-item active">krdxProducto</li>
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
                            <a href="http://<?=substr($_SERVER['HTTP_HOST'],0,-5)?>:8080/oresa2019/krdxProductoantiguo" class="btn w-100 btn-info btn-roundeds mr-3">
                                Kardex antiguo
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
                                            <th>Ingreso</th>
                                            <th>Egreso</th>
                                            <th>Ajuste</th>
                                            <th>Cantidad</th>
                                            <th>Empleado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <template v-if="entradasd"> 
                                            <tr v-for="entrada in entradasd">
                                                <td style="position: relative;"><span style="margin-top: -10px;display: block;">{{moment(String(entrada.fecha)).format('LLL')}}</span> <span style="position: absolute; top: 28px; left: 0; width: 100%; height: 100%; font-size: 12px;">{{entrada.documento}}</span> </td>
                                                <td v-if="/INVENTARIO/i.test(entrada.documento)">
                                                    INVENTARIO
                                                </td>
                                                <td v-else-if="entrada.documento=='Baja'">
                                                    Baja {{entrada.numero}}
                                                </td>
                                                <td class="clickop text-center" @click="abriri(entrada.numero)" style="color:blue" v-else-if="entrada.documento!='EGRESO DE MERCADERÍA'">
                                                    Ingreso {{entrada.numero}}
                                                </td> 
                                                <td class="clickop text-center" @click="abrirop(entrada.numero)" style="color:blue" v-else>
                                                    Pedido {{entrada.numero}} 
                                                </td> 
                                                <td style="background: rgb(39, 44, 51,.5);color: #fff;" v-if="entrada.documento=='INGRESO DE MERCADERÍA'">{{entrada.cantidad}}</td>
                                                <td style="background: rgb(39, 44, 51,.5);color: #fff;" v-else>-</td>
                                                <td style="background: rgb(39, 44, 51,.5);color: #fff;" v-if="entrada.documento=='EGRESO DE MERCADERÍA' || entrada.documento=='Baja'">{{entrada.cantidad}}</td>
                                                <td style="background: rgb(39, 44, 51,.5);color: #fff;" v-else>-</td>
                                                <td style="background: rgb(39, 44, 51,.5);color: #fff;" v-if="entrada.documento!='EGRESO DE MERCADERÍA' && entrada.documento!='Baja' && entrada.documento!='INGRESO DE MERCADERÍA'">{{entrada.cantidad}}</td>
                                                <td style="background: rgb(39, 44, 51,.5);color: #fff;" v-else>-</td>
                                                <td>{{entrada.cantidad_actual}}</td>
                                                <td>{{entrada.empleado}}</td>
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
    <div class="modal fade" tabindex="-1" :class="{'show mirar':modal}" style="overflow:auto;" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div @click="cerrarModal()" class="crmodal"></div>
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel" v-text="tituloModal"></h5>
                    <button type="button" class="close" @click="cerrarModal()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body form-material">
                    <div class="row" v-if="tipoAccion==1">
                        <template v-if="entradasop.length">
                            <div class="col-lg-3 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label class="b" for="exampleFormControlInput1">Fecha de emisión</label>
                                    <template v-if="fechaEmision">
                                        <input type="text" class="form-control" v-model="moment(String(fechaEmision)).format('LLL')">
                                    </template>
                                    <template v-else>
                                        <input type="text" class="form-control" value="Sin Fecha de emisión"> 
                                    </template>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label class="b" for="exampleFormControlInput1">Orden Pedido</label>
                                    <input type="text" class="form-control" v-model="ordpedido">
                                </div>
                            </div>
                            <div class="col-lg-5 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label class="b" for="exampleFormControlInput1">Cliente</label>
                                    <template v-if="nomcliente">
                                        <input type="text" class="form-control" v-model="nomcliente">
                                    </template>
                                    <template v-else>
                                        <input type="text" class="form-control" value="Sin Cliente"> 
                                    </template>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label class="b" for="exampleFormControlInput1">Celular</label>
                                    <template v-if="celular">
                                        <input type="text" class="form-control" v-model="celular">
                                    </template>
                                    <template v-else>
                                        <input type="text" class="form-control" value="Sin celular"> 
                                    </template>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label class="b" for="exampleFormControlInput1">Teléfono</label>
                                    <template v-if="telefono1">
                                        <input type="text" class="form-control" v-model="telefono1">
                                    </template>
                                    <template v-else>
                                        <input type="text" class="form-control" value="Sin teléfono"> 
                                    </template>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label class="b" for="exampleFormControlInput1">Dirección</label>
                                    <template v-if="direccion">
                                        <input type="text" class="form-control" v-model="direccion">
                                    </template>
                                    <template v-else>
                                        <input type="text" class="form-control" value="Sin dirección"> 
                                    </template>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label class="b" for="exampleFormControlInput1">Vendedor</label>
                                    <template v-if="NOM_EMPLE">
                                        <input type="text" class="form-control" v-model="NOM_EMPLE">
                                    </template>
                                    <template v-else>
                                        <input type="text" class="form-control" value="Sin Vendedor"> 
                                    </template>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label class="b" for="exampleFormControlInput1">Comentario</label>
                                    <template v-if="comentario">
                                        <textarea type="text" rows="3" class="form-control" v-model="comentario"></textarea>
                                    </template>
                                    <template v-else>
                                        <input type="text" class="form-control" value="Sin Comentario"> 
                                    </template>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 mt-2">
                                <div class="table-responsive">
                                    <table class="table text-center tableborderw tabledtb">
                                        <thead>
                                            <tr>
                                                <th scope="col">Código</th>
                                                <th scope="col">Nombre</th>
                                                <th scope="col">Imagen</th>
                                                <th scope="col">Comentario</th>
                                                <th scope="col">Can.</th>
                                                <th scope="col">Pend.</th>
                                                <th scope="col">Precio</th>
                                                <th scope="col">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody class="cambiable">
                                            <template v-if="entradasop.length">
                                                <tr v-for="entrada in entradasop">
                                                    <template v-if="sesion[0].IDUSUARIO==15 || sesion[0].IDUSUARIO==28 || sesion[0].IDUSUARIO ==58">
                                                        <td v-if="entrada.codigo" style="cursor:pointer;">
                                                            <template v-if="entrada.codigo!='undefined'">
                                                                {{entrada.codigo}}
                                                            </template>
                                                            <template v-else>
                                                                Sin_código
                                                            </template>
                                                        </td>
                                                        <td v-else>Sin_código</td>
                                                    </template>
                                                    <template v-else>
                                                        <td v-if="entrada.codigo && entrada.detg<=0">
                                                            <template v-if="entrada.codigo!='undefined'">
                                                                {{entrada.codigo}}
                                                            </template>
                                                            <template v-else>
                                                                Sin_código
                                                            </template>
                                                        </td>
                                                        <td v-else-if="entrada.codigo && entrada.detg>0" @click="verguias(entrada.idDetOrdPedido)" style="background: #ff00008c;color: #fff;cursor:help;" title="Ver Los números de guia" v-tippy="{ placement : 'top',  arrow: true }" data-toggle="modal" data-target="#guia">
                                                            <template v-if="entrada.codigo!='undefined'">
                                                                {{entrada.codigo}}
                                                            </template>
                                                            <template v-else>
                                                                Sin_código
                                                            </template>
                                                        </td>
                                                        <td v-else>Sin_código</td>
                                                    </template>
                                                    <td v-if="entrada.nombrep" >
                                                        <template v-if="entrada.nombrep!='undefined'">
                                                            <template v-if="entrada.nombrep.length>=55">
                                                                <div class="tooltipss" >
                                                                    {{entrada.nombrep.substring(0, 55)}}...
                                                                    <span>{{entrada.nombrep | salto}}</span>
                                                                </div>
                                                            </template>
                                                            <template v-else>
                                                                {{entrada.nombrep}}
                                                            </template>
                                                        </template>
                                                        <template v-else>
                                                            Sin Nombre
                                                        </template>
                                                    </td>
                                                    <td v-else>
                                                        <template v-else>
                                                            Sin Nombre
                                                        </template>
                                                    </td>
                                                    <td class="p-0 m-0"><img v-bind:src="'imagenes/productos/'+entrada.imagen+'.jpg'" class="imgopprd2"/></td>
                                                    <td v-if="entrada.comentarios" >
                                                        {{entrada.comentarios}}
                                                    </td>
                                                    <td v-else>  
                                                            Sin comentario
                                                    </td>
                                                    <td>{{entrada.cantidad}}</td>
                                                    <td>{{entrada.pendiente}}</td>
                                                    <td>${{entrada.precioVenta | dec1}}</td>
                                                    <td>${{entrada.precioVenta*entrada.cantidad | dec1}}</td>
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
                                        <tfoot v-if="entradasop.length">
                                            </tr>
                                                <td class="b-0" colspan="5"></td>
                                                <td class="text-right b pr-2 p-0 b-1" colspan="2">SUBTOTAL</td>
                                                <td class="pr-2 p-0 b-1">{{ entradasop[0].vsubt | dec1 }}</td>
                                            </tr>
                                            </tr>
                                                <td class="b-0" colspan="5"></td>
                                                <td class="text-right b pr-2 p-0 b-1" colspan="2">IVA</div>
                                                <td class="pr-2 p-0 b-1">{{ entradasop[0].vsubt*0.12 | dec1 }}</td> 
                                            </tr>
                                            </tr>
                                                <td class="b-0" colspan="5"></td>
                                                <td class="text-right b pr-2 p-0 b-1" colspan="2">TOTAL</td>
                                                <td class="pr-2 p-0 b-1">{{ parseFloat(entradasop[0].vsubt)+parseFloat(entradasop[0].vsubt*0.12) | dec1}}</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </template>
                        <template v-else> 
                            <div class="col-lg-12">
                                <div class="alert alert-warning text-center mb-0" role="alert">
                                    ORDEN DE PEDIDO NO EXISTENTE
                                </div>
                            </div>
                        </template>
                    </div>
                    <div class="row" v-if="tipoAccion==2">
                        <div class="col-lg-3 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Fecha de Ingreso</label>
                                <input type="datetime-local" class="form-control" v-model="fechaIngreso">
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Ord. compra</label>
                                <input type="number" class="form-control" v-model="idOrdCompra">
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Ord. pedido</label>
                                <input type="text" class="form-control" v-model="op">
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Proveedor</label>
                                <input type="text" class="form-control" v-model="NOM_PROVEEDOR">
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Tipo de doc.</label>
                                <select class="form-control" v-model="tipoDocumento"> 
                                    <option value="" selected="">Selecciona el tipo</option>                                                   
                                    <option value="FACTURA " selected="">FACTURA</option>
                                    <option value="GUIA " selected="">GUIA</option>
                                    <option value="AJUSTE " selected="">AJUSTE</option>
                                    <option value="NOTA_ENTREGA " selected="">NOTA_ENTREGA</option>
                                    <option value="SIN_DOCUMENTO " selected="">SIN_DOCUMENTO</option>                                        
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Documento</label>
                                <input type="text" class="form-control" v-model="documento">
                            </div>
                        </div>
                        <div class="col-lg-7 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Empleado</label>
                                <input type="text" class="form-control" v-model="VENDEDOR">
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Proveedor</label>
                                <input type="text" class="form-control" v-model="CLI_razonSocialNombres">
                            </div>
                        </div>


                        

                        <div class="col-lg-12 col-md-12 col-sm-12 mt-2">    
                            <div class="table-responsive">
                                <table class="table text-center tableborderw tabledtb mb-2">
                                    <thead>
                                        <tr>
                                            <th scope="col">Código</th>
                                            <th scope="col">Nombre</th>
                                            <th scope="col">Imagen</th>
                                            <th scope="col">Comentario</th>
                                            <th scope="col">Can.</th>
                                            <th scope="col">Precio</th>
                                            <th scope="col">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody class="cambiable">
                                            <tr v-for="(entrada, index) in entradasi">
                                                <td v-if="entrada.codigo">
                                                    <template v-if="entrada.codigo!='undefined'">
                                                        {{entrada.codigo}}
                                                    </template>
                                                    <template v-else>
                                                        Sin_código
                                                    </template>
                                                </td>
                                                <td v-else>Sin_código</td>
                                                <td v-if="entrada.descripcion">
                                                    <template v-if="entrada.descripcion!='undefined'">
                                                        <template v-if="entrada.descripcion.length>=40">
                                                            <div v-tippy="{ html : '#descripcion'  , interactive : true, reactive : true }">
                                                                {{entrada.descripcion.substring(0, 40)}}...
                                                            </div>
                                                            <vue-component-test id="descripcion">
                                                                <div style="white-space:pre-line;max-width:400px;">{{entrada.descripcion}}</div>
                                                            </vue-component-test>
                                                        </template>
                                                        <template v-else>
                                                            {{entrada.descripcion}}
                                                        </template>
                                                    </template>
                                                    <template v-else>
                                                        Sin Nombre
                                                    </template>
                                                </td>
                                                <td v-else>
                                                    <template v-else>
                                                        Sin Nombre
                                                    </template>
                                                </td>
                                                <td class="p-0 m-0"><img v-bind:src="'imagenes/productos/'+entrada.imagen+'.jpg'" class="imgopprd"/></td>
                                                <td v-if="entrada.observacion">
                                                    <template v-if="entrada.observacion!='undefined'">
                                                        <template v-if="entrada.observacion.length>=45">
                                                            <div v-tippy="{ html : '#observacionsss'  , interactive : true, reactive : true }">
                                                                {{entrada.observacion.substring(0, 45)}}...
                                                            </div>
                                                            <vue-component-test id="observacionsss">
                                                                <div style="white-space:pre-line;max-width:400px;">
                                                                    {{entrada.observacion}}
                                                                </div>
                                                            </vue-component-test>
                                                        </template>
                                                        <template v-else>
                                                            {{entrada.observacion}}
                                                        </template>
                                                    </template>
                                                    <template v-else>
                                                        Sin Observaciones
                                                    </template>
                                                </td>
                                                <td v-else>
                                                    Sin Observaciones
                                                </td>
                                                <td>{{entrada.cantidad}}</td>
                                                <td v-if="entrada.costo">${{entrada.costo | dec}}</td>
                                                <td v-else>$0.00</td>
                                                <td>${{entrada.cantidad*entrada.costo | dec}}</td>
                                            </tr>
                                    </tbody>
                                    <!--<tfoot v-if="entradasdet">
                                        </tr>
                                            <td class="b-0" colspan="5" v-if="sesion[0].IDUSUARIO ==15 || sesion[0].IDUSUARIO ==28 || sesion[0].IDUSUARIO ==58 || sesion[0].IDUSUARIO ==73"></td>
                                            <td class="b-0" colspan="4" v-else></td>
                                            <td class="text-right b pr-2 p-0 b-1" colspan="2">SUBTOTAL</td>
                                            <td class="pr-2 p-0 b-1" v-if="subTotal">${{subTotal | decf}}</td>
                                            <td class="pr-2 p-0 b-1" v-else>$0.00</td>
                                        </tr>
                                        </tr>
                                            <td class="b-0" colspan="5"></td>
                                            <td class="text-right b pr-2 p-0 b-1" colspan="2"> 
                                                Descuento
                                            </td>
                                            <td class="p-0 m-0" colspan="2" style="position:relative;">
                                                <input type="text" class="descuento" v-model="descuento" @keyup="descuentos()">
                                            </td>
                                        </tr>
                                        </tr>
                                            <td class="b-0" colspan="5" v-if="sesion[0].IDUSUARIO ==15 || sesion[0].IDUSUARIO ==28 || sesion[0].IDUSUARIO ==58 || sesion[0].IDUSUARIO ==73"></td>
                                            <td class="b-0" colspan="4" v-else></td>
                                            <td class="text-right b pr-2 p-0 b-1" colspan="2">
                                                <div style="position: absolute;margin-left: 7px;">
                                                    <input type="checkbox" class="form-check-input" id="subtotal1" v-model="siniva" @change="cambiariva()">
                                                    <label class="form-check-label" for="subtotal1">sin iva</label>
                                                </div>
                                                IVA
                                            </td>
                                            <td class="pr-2 p-0 b-1" v-if="iva && !siniva">${{iva | decf}}</td>
                                            <td class="pr-2 p-0 b-1" v-else>$0.00</td>
                                        </tr>
                                        
                                        </tr>   
                                            <td class="b-0" colspan="5" v-if="sesion[0].IDUSUARIO ==15 || sesion[0].IDUSUARIO ==28 || sesion[0].IDUSUARIO ==58 || sesion[0].IDUSUARIO ==73"></td>
                                            <td class="b-0" colspan="4" v-else></td>
                                            <td class="text-right b pr-2 p-0 b-1" colspan="2">TOTAL</td>
                                            <td class="pr-2 p-0 b-1" v-if="total && !siniva">${{totalfinal | decf}}</td>
                                            <td class="pr-2 p-0 b-1" v-else-if="total && siniva">${{subTotal | decf}}</td>
                                            <td class="pr-2 p-0 b-1" v-else-if="!total">$0.00</td>
                                        </tr>
                                    </tfoot>-->
                                </table>
                            </div>
                        </div>






                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
<?php
    include 'modulo/chat.php';
    include 'modulo/foot.php';
    include 'modulo/footer.php';
?> 
<script src="static/js/vuekrdxProducto.js"></script>
</div>
</body>
</html> 