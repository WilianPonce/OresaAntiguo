<?php
    include 'modulo/head.php';
    include 'modulo/menu_top.php';
    include 'modulo/menu_left.php';
    include 'modulo/preloader.php';
?>
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0">Orden de trabajo</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                <li class="breadcrumb-item active">OrdTrabajo</li>
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
                            <div class="btn-group mr-3" style="float:right;" v-if="sesion[0].IDUSUARIO==3 || sesion[0].IDUSUARIO ==15 || sesion[0].IDUSUARIO ==28 || sesion[0].IDUSUARIO ==58">
                                <button type="button" class="btn btn-danger dropdown-toggle pl-5 pr-5" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-file"></i>  Archivos 
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" target="_top" href="modelo/ordtrabajo/reporte.php">Descargar O.Trab.</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped mb-0" style="font-size:13px;">
                            <thead>
                                <tr>
                                    <th>fecha de Ingreso</th>
                                    <th>OrdPedido</th>
                                    <th>Cliente</th>
                                    <th>Empleado</th>
                                    <th>Comentario</th>
                                    <th class="text-center">Estado</th>
                                    <th class="text-center">Aceptado</th>
                                    <th class="text-nowrap text-center" v-if="sesion[0].ROL=='DISEÑO'">Acción</th>
                                    <th class="text-nowrap text-center" v-else>Ver</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template v-if="entradas.length">
                                    <tr  v-for="entrada in entradas">
                                        <td>{{moment(String(entrada.fechaInicio)).format('LLL')}}</td>
                                        <td>{{entrada.ordpedido}}</td> 
                                        <td>{{entrada.razonSocialNombres}} {{entrada.razonComercialApellidos}}</td>
                                        <td>{{entrada.empleado}}</td>
                                        <td>{{entrada.comentario}}</td>
                                        <td class="text-center" style="color:#fff;background: rgba(67, 189, 52, 0.6)"  v-if="entrada.estado==0">Activo</td>
                                        <td class="text-center" style="color:#fff;background: rgba(241, 50, 50, 0.6);"v-else>Inactivo</td>
                                        <td class="text-center p-0 pt-1 pb-1" v-if="entrada.linkImagen">
                                            <img v-if="entrada.linkImagen!='sinimagen.jpg' && entrada.linkImagen.slice((entrada.linkImagen.lastIndexOf('.') - 1 >>> 0) + 2)!='pdf'" v-bind:src="'imagenes/aprobados/'+entrada.linkImagen" title="Ver imagen" v-tippy="{ position : 'top',  arrow: true, size: 'small' }" style="width:100px;height:55px;cursor:pointer;" @click="verimagen(entrada.linkImagen)">
                                            <a v-else-if="entrada.linkImagen!='sinimagen.jpg' && entrada.linkImagen.slice((entrada.linkImagen.lastIndexOf('.') - 1 >>> 0) + 2)=='pdf'" v-bind:href="'imagenes/aprobados/'+entrada.linkImagen" target="_BLANK" title="Descargar PDF" v-tippy="{ position : 'top',  arrow: true, size: 'small' }"><i class="fas fa-file-pdf" style="font-size: 45px;color:red!important;"></i></a>
                                            <img v-else v-bind:src="'imagenes/aprobados/sinimagen.jpg'" style="width:100px;height:55px;">
                                        </td>
                                        <td class="text-center p-0 pt-1 pb-1" v-else>
                                            <img v-bind:src="'imagenes/aprobados/sinimagen.jpg'" style="width:100px;height:55px;">
                                        </td>
                                        <td class="text-nowrap text-center" v-if="sesion[0].ROL=='DISEÑO'">
                                            <a href="javascript:void(0)" v-if="entrada.linkImagen && entrada.estadoLG!=1" title="Trabajo Terminado" v-tippy="{ position : 'top',  arrow: true, size: 'small' }" @click="aceptarord(entrada)"> <i class="fas fa-check text-inverse m-r-3" style="font-size:15px;"></i> </a>
                                            <a href="javascript:void(0)" v-if="entrada.estado==0" title="Subir" v-tippy="{ position : 'top',  arrow: true, size: 'small' }" @click="abrirModal('ordtrabajo','actualizar',entrada), listardetalle(entrada.idOrdPedido)"> <i v-if="entrada.estadoLG!=1" class="fas fa-upload text-inverse m-r-3" style="font-size:15px;"></i> <i v-else class="fas fa-eye text-inverse m-r-3" style="font-size:15px;"></i> </a>
                                            <a href="javascript:void(0)" v-else title="Visualizar" v-tippy="{ position : 'top',  arrow: true, size: 'small' }" @click="abrirModal('ordtrabajo','actualizar',entrada), listardetalle(entrada.idOrdPedido)"> <i class="fas fa-eye text-inverse" style="font-size:15px;"></i> </a>
                                            <a href="javascript:void(0)" v-if="entrada.estado==0" title="Eliminar" v-tippy="{ position : 'top',  arrow: true, size: 'small' }" @click="eliminar(entrada.idOrdTrabajo)"> <i class="fas fa-power-off text-danger" style="font-size:15px;"></i> </a>
                                        </td>
                                        <td class="text-nowrap text-center" v-else>
                                            <a href="javascript:void(0)" title="Visualizar" v-tippy="{ position : 'top',  arrow: true, size: 'small' }" @click="abrirModal('ordtrabajo','actualizar',entrada), listardetalle(entrada.idOrdPedido)"> <i class="fas fa-eye text-inverse" style="font-size:20px;"></i> </a>
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
                <div class="modal-header" v-if="tipoAccion!=11">
                    <h5 class="modal-title" id="exampleModalLabel" v-text="tituloModal"></h5>
                    <button type="button" class="close" @click="cerrarModal()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body form-material"> 
                    <div class="row" v-if="tipoAccion==11">
                        <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                            <img v-bind:src="'imagenes/aprobados/'+imagen" style="max-width: 100%;max-height: 600px;min-width:80%;" @click="verimagen(entrada.codigo)"> 
                        </div>
                    </div>
                    <div v-else class="row">
                        <div class="col-lg-8 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Fecha de Ingreso</label>
                                <input type="datetime-local" class="form-control" v-model="fechaInicio" disabled>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">O.Pedido</label>
                                <input type="text" class="form-control" v-model="ordPedido" disabled>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Empleado</label>
                                <input type="text" class="form-control" v-model="empleado" disabled>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Cliente</label>
                                <input type="text" class="form-control" v-model="cliente" disabled>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 mt-2" v-if="$.trim(detalle)">
                            <div class="table-responsive">
                                <table class="table text-center tableborderw tabledtb">
                                    <thead>
                                        <tr>
                                            <th scope="col">Código</th>
                                            <th scope="col">Nombre</th>
                                            <th scope="col">Imagen</th>
                                            <th scope="col">Comentario</th>
                                            <th scope="col">Cantidad</th>
                                            <!--<th scope="col" v-if="estado==0">Acción</th>-->
                                        </tr>
                                    </thead>
                                    <tbody class="cambiable"> 
                                        <tr v-for="entrada in detalle">
                                            <td>{{entrada.codigo}}</td>
                                            <td v-if="entrada.nombre">
                                                <template v-if="entrada.nombre.length<=40">
                                                    {{entrada.nombre}}
                                                </template>
                                                <template v-else>
                                                    {{entrada.nombre.substring(0, 40)}}...<span class="backgroundvista quest vermas" v-tippy="{ html : '#nombre'  , interactive : true, reactive : true }">ver mas</span>
                                                    <vue-component-test id="nombre">
                                                        <div style="white-space:pre-line;max-width:400px;">{{entrada.nombre}}</div>
                                                    </vue-component-test> 
                                                </template>
                                            </td>
                                            <td v-else> Sin nombre </td>
                                            <td class="p-0 m-0"><img v-bind:src="'imagenes/productos/'+entrada.imagen+'.jpg'" :class="{'imgopprd2':entrada.imagen!='sinimagen'}"/></td>
                                            <td v-if="entrada.comentario">
                                                <template v-if="entrada.comentario.length<=25">
                                                    {{entrada.comentario}}
                                                </template>
                                                <template v-else>
                                                    {{entrada.comentario.substring(0, 25)}}...<span class="backgroundvista quest vermas" v-tippy="{ html : '#comentario'  , interactive : true, reactive : true }">ver mas</span>
                                                    <vue-component-test id="comentario">
                                                        <div style="white-space:pre-line;max-width:400px;">{{entrada.comentario}}</div>
                                                    </vue-component-test> 
                                                </template>
                                            </td>
                                            <td v-else> Sin comentario </td>
                                            <td>{{entrada.cantidad}}</td>
                                            <!--<td v-if="estado==0">
                                                <a href="javascript:void(0)" title="Editar" v-tippy="{ position : 'top',  arrow: true, size: 'small' }" @click="verdetop(entrada)"> <i class="fas fa-pencil-alt text-inverse m-r-5"></i> </a>
                                            </td>-->
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer"> 
                    <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                    <button type="button" v-if="estado==0 && sesion[0].ROL=='DISEÑO' && estadoLG!=1 " class="btn btn-primary updateexcel">Subir Aceptado</button>
                    <input type="file" v-if="estadoLG!=1" style="display:none;" @change="getImage" name="file" id="file" accept=".jpg,.png,.jpeg,.gif,.pdf" class="imagenst">
                    <button @click="updateAvatar" v-if="estadoLG!=1" data-toggle="tooltip" data-placement="top" data-original-title="Subir Archivo" style="display:none;" id="submit" name="import" class="btn btn-success mr-1 subirupdateexcel"><i class="fa fa-check"></i></button>
                </div>
            </div>
        </div>
    </div>
<?php
    include 'modulo/chat.php';
    include 'modulo/foot.php';
    include 'modulo/footer.php';
?> 
<script src="static/js/vueordtrabajo.js"></script>
</div>
</body>
</html> 