<?php
    include 'modulo/head.php';
    include 'modulo/menu_top.php';
    include 'modulo/menu_left.php';
    include 'modulo/preloader.php';
?>
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0">Orden de bajas</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                <li class="breadcrumb-item active">ordbajas</li>
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
                        <div class="col-lg-4 col-md-6 col-sm-12 form-material">
                            <input type="text" class="form-control" v-on:keyup.enter="hj=1,listar()" v-model="buscar" placeholder="Buscar..."/>
                            <i class="fa fa-search imgbuscar" @click="hj=1,listar()"></i>
                            <template v-if="buscar"><i class="fa fa-times imgdelete" @click="buscar='',hj=1,listar()"></i></template> 
                        </div>
                        <div class="col-lg-8 col-md-12 col-sm-12">
                            <div class="btn-group mr-3" style="float:right;" v-if="sesion[0].IDUSUARIO==3 || sesion[0].IDUSUARIO ==15 || sesion[0].IDUSUARIO ==5 || sesion[0].IDUSUARIO ==28 || sesion[0].IDUSUARIO ==58">
                                <button type="button" class="btn btn-danger dropdown-toggle pl-5 pr-5" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-file"></i>  Archivos 
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" target="_top" href="modelo/ordbajas/reportes.php">Descargar Bajas</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead>
                                <tr>
                                    <th>Id O.B.</th>
                                    <th>Fecha de creación</th>
                                    <th>Op</th>
                                    <th>codigo</th>
                                    <th>cant.</th>
                                    <th>Costo</th>
                                    <th>Vendedor</th>
                                    <th>Comentario</th>
                                    <th v-if="sesion[0].IDUSUARIO==3 || sesion[0].IDUSUARIO ==15 || sesion[0].IDUSUARIO==28 || sesion[0].IDUSUARIO ==58 || sesion[0].IDUSUARIO==74"><i class="fas fa-window-close"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                <template v-if="entradas.length">
                                    <tr  v-for="entrada in entradas">
                                        <td>{{entrada.id}}</td>
                                        <td>{{entrada.creado}}</td>
                                        <td>{{entrada.ordPedido}}</td> 
                                        <td>{{entrada.codigo}}</td>
                                        <td>{{entrada.cantidad}}</td>
                                        <td>${{entrada.valor}}</td>
                                        <td>{{entrada.vendedor}}</td>
                                        <td v-if="entrada.comentario">{{entrada.comentario}}</td>
                                        <td v-else> - </td>
                                        <td class="text-nowrap" v-if="sesion[0].IDUSUARIO==3 || sesion[0].IDUSUARIO ==15 || sesion[0].IDUSUARIO==28 || sesion[0].IDUSUARIO ==58 || sesion[0].IDUSUARIO==74">
                                            <a href="javascript:void(0)"  title="Eliminar" v-tippy="{ position : 'top',  arrow: true, size: 'small' }" @click="eliminar(entrada.id, entrada.idProducto, entrada.cantidad,entrada.creado,entrada.lugar,entrada.iddetop,entrada.ordPedido)" > <i class="fas fa-window-close text-danger"></i> </a>
                                        </td>
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
                    <div class="mt-4 text-center">
                        <nav aria-label="Page navigation example"style="display: inline-flex;" v-if="entradas.length">
                            <ul class="pagination mb-0" v-if="entradas.lenght>=10">
                                <template v-if="hj!=1">
                                    <li class="page-item"><a class="page-link" @click="hj--,listar()" href="javascript:void(0)" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>
                                </template>
                                <template v-for="pg in pag">
                                    <template v-if="hj==pg">
                                        <li class="page-item active"><a class="page-link" @click="hj=pg,listar()" href="javascript:void(0)" v-text="pg"></a></li>
                                    </template> 
                                    <template v-else>
                                        <li class="page-item"><a class="page-link" @click="hj=pg,listar()" href="javascript:void(0)" v-text="pg"></a></li>
                                    </template> 
                                </template>   
                                <template v-if="hj!=pag">
                                    <li class="page-item"><a class="page-link" @click="hj++,listar()" href="javascript:void(0)" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>
                                </template>
                            </ul>
                            <ul class="pagination mb-0" v-else>
                                <template v-if="hj!=1">
                                    <li class="page-item"><a class="page-link" @click="hj--,listar()" href="javascript:void(0)" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>
                                </template>
                                <template v-else>
                                    <li class="page-item disabled"><a class="page-link" href="javascript:void(0)" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>
                                </template>
                                <template v-if="hj>4">
                                    <li class="page-item"><a class="page-link" @click="hj=1,listar()" href="javascript:void(0)" v-text="1"></a></li>
                                        <template v-if="hj>10">
                                            <li class="page-item"><a class="page-link" @click="hj=hj-10,listar()" href="javascript:void(0)">-10</a></li>
                                        </template>
                                    <li class="page-item disabled"><a class="page-link" @click="hj=1,listar()" href="javascript:void(0)">...</a></li>
                                </template>
                                <template v-for="pg in pag">
                                    <template v-if="pg>hj-3 && pg<hj+3">
                                        <template v-if="hj==pg">
                                            <li class="page-item active"><a class="page-link" @click="hj=pg,listar()" href="javascript:void(0)" v-text="pg"></a></li>
                                        </template>
                                        <template v-else>
                                            <li class="page-item"><a class="page-link" @click="hj=pg,listar()" href="javascript:void(0)" v-text="pg"></a></li>
                                        </template>   
                                    </template>
                                </template>   
                                <template v-if="hj<pag-2">
                                    <li class="page-item disabled"><a class="page-link" @click="hj=1,listar()" href="javascript:void(0)">...</a></li>
                                        <template v-if="hj<pag-10">
                                            <li class="page-item"><a class="page-link" @click="hj=hj+10,listar()" href="javascript:void(0)">+10</a></li>
                                        </template>
                                    <li class="page-item"><a class="page-link" @click="hj=pag,listar()" href="javascript:void(0)" v-text="pag"></a></li>
                                </template>
                                <template v-if="hj!=pag">
                                    <li class="page-item"><a class="page-link" @click="hj++,listar()" href="javascript:void(0)" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>
                                </template>
                                <template v-else>
                                    <li class="page-item disabled"><a class="page-link" href="javascript:void(0)" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>
                                </template>
                            </ul>
                        </nav>
                        <div style="font-size: 11px;font-weight:bold;" v-if="entradas.length">{{hj}} de {{pag}} / registos {{entradas[0].pag}}</div>
                        <div style="font-size: 11px;" v-else>Sin páginas</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade mirartopmodal" tabindex="-1" :class="{'show mirar':modal}" style="overflow:auto;background-color: rgba(60, 41, 41, 0.48) !important" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel" v-text="tituloModal"></h5>
                    <button type="button" class="close" @click="cerrarModal()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body form-material">
                    <div class="row">
                        <div class="col-lg-3 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Fecha de Ingreso</label>
                                <input type="datetime-local" class="form-control" v-model="fechaEmision" disabled>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">N° Guia</label>
                                <input type="text" class="form-control" v-model="numeroGuia" disabled>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">O.Pedido</label>
                                <input type="text" class="form-control" v-model="op" disabled>
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Sucursal</label>
                                <input type="text" class="form-control" v-model="sucursal" disabled>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Cliente</label>
                                <input type="text" class="form-control" v-model="razonSocialNombres" disabled>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Empleado</label>
                                <input type="text" class="form-control" v-model="VENDEDOR" disabled>
                            </div>
                        </div>

                        <!--<div class="col-lg-4 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Lugar entrega</label>
                                <input type="text" class="form-control" v-model="lugarEntrega">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Fecha entrega</label>
                                <input type="datetime-local" class="form-control" v-model="fechaEntrega">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Comprobante de pago</label>
                                <input type="text" class="form-control" v-model="comprobantePago">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Tipo de documento</label>
                                <input type="text" class="form-control" v-model="tipoDocumento">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Entregado por</label>
                                <input type="text" class="form-control" v-model="entregadoPor">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Recibido por</label>
                                <input type="text" class="form-control" v-model="recibidoPor">
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Comentario</label>
                                <textarea type="text" rows="3" class="form-control" v-model="COMENTA"></textarea>
                            </div>
                        </div>-->
                        <template v-if="detalle.length">
                            <div class="col-lg-12 col-md-12 col-sm-12 mt-2">
                                <div class="table-responsive">
                                    <table class="table text-center tableborderw tabledtb">
                                        <thead>
                                            <tr>
                                                <th scope="col">Código</th>
                                                <th scope="col">Nombre</th>
                                                <th scope="col">Imagen</th>
                                                <th scope="col">Cantidad</th>
                                                <th scope="col">Observacion</th>
                                                <th scope="col" v-if="sesion[0].IDUSUARIO==3 || sesion[0].IDUSUARIO ==15 || sesion[0].IDUSUARIO==28 || sesion[0].IDUSUARIO ==58"><i class="fas fa-window-close"></i></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="detalles in detalle">
                                                <td>{{detalles.codigo}}</td>
                                                <template v-if="detalles.descripcion">
                                                    <td v-if="detalles.descripcion.length>48">
                                                        {{detalles.descripcion.substring(0, 48)}}...<span class="backgroundvista quest vermas" v-tippy="{ html : '#descripcion'  , interactive : true, reactive : true }">ver mas</span>
                                                        <vue-component-test id="descripcion">
                                                            <div style="white-space:pre-line;max-width:400px;">{{detalles.descripcion}}</div>
                                                        </vue-component-test> 
                                                    </td> 
                                                    <td v-else-if="detalles.descripcion.length>0 && detalles.descripcion.length<=48">
                                                        {{detalles.descripcion}}
                                                    </td> 
                                                    <td v-else>
                                                        Sin Nombre
                                                    </td>
                                                </template>
                                                <template v-else>  
                                                    <td>Sin Nombre</td>    
                                                </template>
                                                <td class="p-0 m-0"><img v-bind:src="'imagenes/productos/'+detalles.imagen+'.jpg'" class="imgopprd"/></td>
                                                <td>{{detalles.cantidad}}</td>
                                                <template v-if="detalles.observaciones">
                                                    <td v-if="detalles.observaciones.length>40">
                                                        {{detalles.observaciones.substring(0, 40)}}...<span class="backgroundvista quest vermas" v-tippy="{ html : '#observaciones'  , interactive : true, reactive : true }">ver mas</span>
                                                        <vue-component-test id="observaciones">
                                                            <div style="white-space:pre-line;max-width:400px;">{{detalles.observaciones}}</div>
                                                        </vue-component-test> 
                                                    </td> 
                                                    <td v-else-if="detalles.observaciones.length>0 && detalles.observaciones.length<=40">
                                                        {{detalles.observaciones}}
                                                    </td> 
                                                    <td v-else>
                                                        Sin Observación
                                                    </td>
                                                </template>
                                                <template>
                                                    <td>Sin Observaciones</td>
                                                </template>
                                                <td v-if="sesion[0].IDUSUARIO==3 || sesion[0].IDUSUARIO==5 || sesion[0].IDUSUARIO ==15 || sesion[0].IDUSUARIO==28 || sesion[0].IDUSUARIO ==58">
                                                    <a href="javascript:void(0)" v-if="sesion[0].IDUSUARIO==3 || sesion[0].IDUSUARIO==5 || sesion[0].IDUSUARIO ==15 || sesion[0].IDUSUARIO==28 || sesion[0].IDUSUARIO ==58" title="Eliminar" v-tippy="{ position : 'top',  arrow: true, size: 'small' }" @click="eliminardet(detalles.idDetGuia, detalles.numeroGuia, detalles.cantidad, detalles.idDetOrdPedido)"> <i class="fas fa-window-close text-danger"></i> </a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                    <!--<button type="button" class="btn btn-primary" v-if="tipoAccion==1" @click="registrar()">Guardar</button>
                    <button type="button" class="btn btn-primary" v-if="tipoAccion==2" @click="actualizar()">Actualizar</button>-->
                </div>
            </div>
        </div>
    </div>
<?php
    include 'modulo/chat.php';
    include 'modulo/foot.php';
    include 'modulo/footer.php';
?> 
<script src="static/js/vueordbajas.js"></script>
</div>
</body>
</html> 