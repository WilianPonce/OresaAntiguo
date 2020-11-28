<?php
    include 'modulo/head.php';
    include 'modulo/menu_top.php';
    include 'modulo/menu_left.php';
    include 'modulo/preloader.php';
?>
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0">Muestras</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="./">Inicio</a></li>
                <li class="breadcrumb-item active">Muestras</li>
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
                        <div class="col-lg-8 col-md-6 col-sm-12">
                            <button type="button" v-if="sesion[0].ROL !='AUXILIAR DE BODEGA' && sesion[0].ROL !='ASISTENTE DE BODEGA'" class="btn btn-info btn-rounded" style="float:right;" @click="abrirModal('muestras','registrar')">
                                Nueva muestra
                            </button>
                            <div class="btn-group mr-3" style="float:right;">
                                <button type="button" class="btn btn-danger dropdown-toggle pl-5 pr-5" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-file"></i>  Archivos 
                                </button>
                                <div class="dropdown-menu"> 
                                    <a class="dropdown-item" target="_top" href="modelo/muestras/bajarexcel.php">Descargar Muestras</a>
                                    <!--<div class="dropdown-divider"></div>
                                    <a class="dropdown-item updateexcel" href="javascript:void(0)">Subir Muestras</a>-->
                                </div>
                            </div>
                                <input type="file" style="display:none;" @change="getImage" name="file" id="file" accept=".xls,.xlsx">
                                <button @click="updateAvatar" data-toggle="tooltip" data-placement="top" data-original-title="Subir Excel" style="display:none;" id="submit" name="import" class="btn btn-success mr-1 subirupdateexcel"><i class="fa fa-check"></i></button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead>
                                <tr>
                                    <th class="text-center">fecha</th>
                                    <th>Nombre_cliente</th>
                                    <th>empleado</th>
                                    <th>contacto</th>
                                    <th>IdMuestra</th>
                                    <!--<th>comentario</th>-->
                                    <th v-if="sesion[0].IDUSUARIO==3 || sesion[0].IDUSUARIO ==15 || sesion[0].IDUSUARIO ==28 || sesion[0].IDUSUARIO ==58 || sesion[0].IDUSUARIO ==73 || sesion[0].IDUSUARIO==74|| sesion[0].IDUSUARIO==77" class="text-nowrap">Acciones</th>
                                    <th v-else class="text-nowrap text-center">Ver</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template v-if="$.trim(entradas.length)>=1")>
                                    <tr v-for="entrada in entradas" :class="{'adds':entrada.resultados-entrada.resultadosa==0}">
                                        <td>  {{moment(String(entrada.fecha)).format('LL')}}</td>
                                        <td>{{entrada.cliente}}</td>
                                        <td>{{entrada.empleado}}</td>
                                        <td v-if="entrada.contacto">
                                            <template v-if="entrada.contacto.length<=15">
                                                {{entrada.contacto}}
                                            </template>
                                            <template v-else>
                                                {{entrada.contacto.substring(0, 15)}}...<span class="backgroundvista quest vermas" v-tippy="{ html : '#contacto'  , interactive : true, reactive : true }">ver mas</span>
                                                <vue-component-test id="contacto">
                                                    <div style="white-space:pre-line;max-width:400px;">{{entrada.contacto}}</div>
                                                </vue-component-test> 
                                            </template>
                                        </td>
                                        <td v-else> - </td>
                                       <!--<td v-if="entrada.comentario">
                                            <template v-if="entrada.comentario.length<=15">
                                                {{entrada.comentario}}
                                            </template>
                                            <template v-else>
                                                {{entrada.comentario.substring(0, 15)}}...<span class="backgroundvista quest vermas" v-tippy="{ html : '#comentario'  , interactive : true, reactive : true }">ver mas</span>
                                                <vue-component-test id="comentario">
                                                    <div style="white-space:pre-line;max-width:400px;">{{entrada.comentario}}</div>
                                                </vue-component-test> 
                                            </template>
                                        </td>
                                        <td v-else> - </td>-->
                                        <td>
                                            {{entrada.idMuestras}}
                                        </td>    
                                        <td v-else class="text-center"> - </td>
                                        <td class="text-center" v-if="sesion[0].IDUSUARIO==3 || sesion[0].IDUSUARIO ==5 || sesion[0].IDUSUARIO ==15 || sesion[0].IDUSUARIO ==28 || sesion[0].IDUSUARIO ==58 || sesion[0].IDUSUARIO ==73 || sesion[0].IDUSUARIO==74 || sesion[0].IDUSUARIO==77"> 
                                            <a href="javascript:void(0)" title="Editar" v-tippy="{ position : 'top',  arrow: true, size: 'small' }" class="edit" @click="abrirModal('muestras','actualizar',entrada),abrirdetmuestras(entrada.idMuestras)"> <i class="fas fa-pencil-alt text-inverse m-r-3"></i> </a>
                                            <a title="Imprimir" v-tippy="{ position : 'top',  arrow: true, size: 'small' }" v-bind:href="'Impresiones/muestras.php?id='+entrada.idMuestras" target="_blank"> <i class="fas fa-print text-inverse m-r-3"></i></a>
                                            <a href="javascript:void(0)" title="Eliminar" v-if="sesion[0].IDUSUARIO==15 || sesion[0].IDUSUARIO ==28 || sesion[0].IDUSUARIO ==58 || sesion[0].IDUSUARIO ==73 || sesion[0].IDUSUARIO==74" v-tippy="{ position : 'top',  arrow: true, size: 'small' }" @click="eliminar(entrada.idMuestras)" > <i class="fas fa-window-close text-danger"></i> </a>                                            
                                        </td>
                                        <td class="text-nowrap text-center" v-else> 
                                            <a href="javascript:void(0)" title="Editar" v-tippy="{ position : 'top',  arrow: true, size: 'small' }" class="edit" @click="abrirModal('muestras','actualizar',entrada),abrirdetmuestras(entrada.idMuestras)"> <i class="fas fa-eye text-inverse m-r-3"></i> </a>
                                            <a title="Imprimir" v-tippy="{ position : 'top',  arrow: true, size: 'small' }" v-bind:href="'Impresiones/muestras.php?id='+entrada.idMuestras" target="_blank"> <i class="fas fa-print text-inverse m-r-3"></i></a>
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
    <div class="modal fade mirartopmodal" tabindex="-1" :class="{'show mirar':modal}" style="overflow:auto;background-color: rgba(60, 41, 41, 0.48) !important"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modaledit modal-xl" role="document">
            <div class="modal-content" id="mydiv">
                <div class="modal-header" id="mydivheader">
                    <h5 class="modal-title" id="exampleModalLabel" v-text="tituloModal"></h5>
                    <button type="button" style="position: absolute;margin-left: 10rem;top: 0.6rem;" class="btn btn-primary" v-if="tipoAccion==3" @click="guardardetguias()">Agregar Producto</button>
                    <button type="button" class="close" @click="cerrarModal()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body form-material">
                    <div class="row" v-if="tipoAccion==6">
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Código</label>
                                <input type="text" class="form-control" v-model="buscarproductos" @keyup="listarproductos()">
                                <template v-if="buscarproductos.length">
                                    <div class="menuw" v-if="listproductos=='sin'">
                                        <div>Ingresa min 2 ...</div>
                                    </div>
                                    <div class="menuw" v-else-if="$.trim(listproductos)=='no'">
                                        <div>Sin coincidencias</div> 
                                    </div>
                                    <div class="menuw" v-else-if="listproductos.length">
                                        <div class="select" v-for="listproducto in listproductos" @click="seleccionarproducto(listproducto),listproductos=[]">
                                            {{listproducto.codigo}}
                                        </div>
                                    </div>
                                    <i class="fa fa-times bscdelete" v-if="buscarproductos.length && tipoAccion==3" @click="buscarproductos='',nombredet='',cantidaddet=null,preciodet=null,descripciondet='', listarproductos(), idproducto=null"></i>
                                </template>
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Nombre</label>
                                <input type="text" class="form-control" v-model="nombredet" @keyup="listarnombres()">
                                <template v-if="nombredet.length">
                                    <div class="menuw" v-if="listnombres=='sin'">
                                        <div class="nohay">Ingresa min 2 ...</div>
                                    </div>
                                    <div class="menuw" v-else-if="$.trim(listnombres)=='no'">
                                        <div class="nohay">Sin coincidencias</div> 
                                    </div>
                                    <div class="menuw" v-else-if="listnombres.length">
                                        <div class="select" v-for="listproducto in listnombres" @click="seleccionarproducto(listproducto),listnombres=[]">
                                            <div class="row">
                                                <div class="col-lg-3 text-center"><img v-bind:src="'imagenes/productos/'+listproducto.imagen+'.jpg'" class="lisimg"/></div>
                                                <div class="col-lg-9" style="line-height: 17px;">{{listproducto.nombre}} </div>
                                            </div>   
                                        </div>
                                    </div>
                                </template>
                                <div v-show="error">
                                    <div v-for="err in errornombredet" :key="err" v-text="err" class="errorcamp"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Cantidad</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">C</span>
                                    </div>
                                    <input type="text" class="form-control text-center" onkeypress="return filterFloat(event,this);" v-model="cantidaddet">
                                    <div v-show="error">
                                        <div v-for="err in errorcantidaddet" :key="err" v-text="err" class="errorcamp"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Precio</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">C</span>
                                    </div>
                                    <input type="text" class="form-control text-center" onkeypress="return filterFloat(event,this);" v-model="preciodet">
                                    <div v-show="error">
                                        <div v-for="err in errorcantidaddet" :key="err" v-text="err" class="errorcamp"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Descripción</label>
                                <textarea type="text" rows="6" class="form-control" v-model="descripciondet"></textarea>  
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Comentario</label>
                                <textarea type="text" rows="4" class="form-control" v-model="comentariosdet"></textarea>  
                            </div>
                        </div>
                    </div>
                    <div class="row" v-else-if="tipoAccion==3 || tipoAccion==5">
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Código</label>
                                <input type="text" v-if="tipoAccion==3" class="form-control" v-model="buscarproductos" @keyup="listarproductos()">
                                <input type="text" v-if="tipoAccion==5" class="form-control" v-model="buscarproductos" @keyup="listarproductos()" readonly>
                                <template v-if="buscarproductos.length">
                                    <div class="menuw" v-if="listproductos=='sin'">
                                        <div>Ingresa min 2 ...</div>
                                    </div>
                                    <div class="menuw" v-else-if="$.trim(listproductos)=='no'">
                                        <div>Sin coincidencias</div> 
                                    </div>
                                    <div class="menuw" v-else-if="listproductos.length">
                                        <div class="select" v-for="listproducto in listproductos" @click="seleccionarproducto(listproducto),listproductos=[]">
                                            {{listproducto.codigo}}
                                        </div>
                                    </div>
                                    <i class="fa fa-times bscdelete" v-if="buscarproductos.length && tipoAccion==3" @click="buscarproductos='',nombredet='',cantidaddet=null,preciodet=null,descripciondet='', listarproductos(), idproducto=null"></i>
                                </template>
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Nombre</label>
                                <input type="text" class="form-control" v-model="nombredet" @keyup="listarnombres()">
                                <template v-if="nombredet.length">
                                    <div class="menuw" v-if="listnombres=='sin'">
                                        <div class="nohay">Ingresa min 2 ...</div>
                                    </div>
                                    <div class="menuw" v-else-if="$.trim(listnombres)=='no'">
                                        <div class="nohay">Sin coincidencias</div> 
                                    </div>
                                    <div class="menuw" v-else-if="listnombres.length">
                                        <div class="select" v-for="listproducto in listnombres" @click="seleccionarproducto(listproducto),listnombres=[]">
                                            <div class="row">
                                                <div class="col-lg-3 text-center"><img v-bind:src="'imagenes/productos/'+listproducto.imagen+'.jpg'" class="lisimg"/></div>
                                                <div class="col-lg-9" style="line-height: 17px;">{{listproducto.nombre}} </div>
                                            </div>   
                                        </div>
                                    </div>
                                </template>
                                <div v-show="error">
                                    <div v-for="err in errornombredet" :key="err" v-text="err" class="errorcamp"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Cantidad</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">C</span>
                                    </div>
                                    <input type="text" class="form-control text-center" onkeypress="return filterFloat(event,this);" v-model="cantidaddet">
                                    <div v-show="error">
                                        <div v-for="err in errorcantidaddet" :key="err" v-text="err" class="errorcamp"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Precio</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">C</span>
                                    </div>
                                    <input type="text" class="form-control text-center" onkeypress="return filterFloat(event,this);" v-model="preciodet" disabled>
                                    <div v-show="error">
                                        <div v-for="err in errorcantidaddet" :key="err" v-text="err" class="errorcamp"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Descripción</label>
                                <textarea type="text" rows="6" class="form-control" v-model="descripciondet"></textarea>  
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Comentario</label>
                                <textarea type="text" rows="4" class="form-control" v-model="comentariosdet"></textarea>  
                            </div>
                        </div>
                        <template v-if="arrayop.length>=1 && tipoAccion==3">
                            <div class="col-lg-12 col-md-12 col-sm-12 mt-2">
                                <div class="table-responsive">
                                    <table class="table text-center tableborderw tabledtb">
                                        <thead>
                                            <tr>
                                                <th scope="col">Código</th>
                                                <th scope="col">Nombre</th>
                                                <th scope="col">Imagen</th>
                                                <th scope="col">Cantidad</th>
                                                <th scope="col">Precio</th>
                                                <th scope="col">Total</th>
                                                <th scope="col"><i class="fas fa-window-close"></i></th>
                                            </tr>
                                        </thead>
                                        <tbody class="cambiable">
                                                <tr v-for="(entrada, index) in arrayop">
                                                    <td v-if="entrada.codigo">
                                                        <template v-if="entrada.codigo!='undefined'">
                                                            {{entrada.codigo}}
                                                        </template>
                                                        <template v-else>
                                                            Sin_código
                                                        </template>
                                                    </td>
                                                    <td v-else>Sin_código</td>
                                                    <td v-if="entrada.nombre">
                                                        <template v-if="entrada.nombre!='undefined'">
                                                            <template v-if="entrada.nombre.length>=50">
                                                                <div v-tippy="{ html : '#nombre'  , interactive : true, reactive : true }">
                                                                    {{entrada.nombre.substring(0, 50)}}...
                                                                </div>
                                                                <vue-component-test id="nombre">
                                                                <div style="white-space:pre-line;max-width:400px;">{{entrada.nombre}}</div>
                                                                </vue-component-test>
                                                            </template>
                                                            <template v-else>
                                                                {{entrada.nombre}}
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
                                                    
                                                    <td>{{entrada.cantidad}}</td>
                                                    <td>${{entrada.precio | dec}}</td>
                                                    <td>${{entrada.precio*entrada.cantidad | dec}}</td>
                                                    <td>
                                                        <a href="javascript:void(0)" title="Eliminar" @click="eliminarlista(index)"> <i class="fas fa-window-close text-danger"></i> </a>
                                                    </td>
                                                </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </template>
                    </div>
                    <div class="row" v-else>
                        <div class="col-lg-4 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">fecha</label>
                                <input type="datetime-local" class="form-control" v-model="fecha">
                                <div v-show="error">
                                    <div v-for="err in errorfecha" :key="err" v-text="err" class="errorcamp"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Nombres y Apellidos del cliente</label>
                                <input type="text" class="form-control" v-model="buscarclientes" @keyup="listarclientes()" autocomplete="off">
                                <template v-if="buscarclientes.length">
                                    <div class="menuw" v-if="listclientes=='sin'">
                                        <div class="nohay">Ingresa mas de 2 caracteres</div>
                                    </div>
                                    <div class="menuw" v-else-if="$.trim(listclientes)=='no'">
                                        <div class="nohay">No se ecnontraron registros que coincidan</div> 
                                    </div>
                                    <div class="menuw" v-else-if="listclientes.length">
                                        <div class="select" v-for="listcliente in listclientes" @click="seleccionarcliente(listcliente),listclientes=[]">
                                            {{listcliente.razonSocialNombres}} {{listcliente.razonComercialApellidos}}
                                        </div>
                                    </div>
                                    <i class="fa fa-times bscdelete" @click="buscarclientes='', listarclientes(), idCliente=null"></i>
                                </template>
                                <div v-show="error">
                                    <div v-for="err in erroridCliente" :key="err" v-text="err" class="errorcamp"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Empleado</label>
                                <select class="form-control" id="empleado" v-model="idEmpleado">
                                    <option value="">Seleccione el Empleado</option>
                                        <option v-for="empleado in empleados" v-bind:value="empleado.idempleado">{{empleado.nombres}} {{empleado.apellidos}}</option>  
                                </select>
                                <div v-show="error">
                                    <div v-for="err in erroridEmpleado" :key="err" v-text="err" class="errorcamp"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Nota de entrega</label>
                                <input type="text" class="form-control" v-model="numero">
                                <div v-show="error">
                                    <div v-for="err in errornumero" :key="err" v-text="err" class="errorcamp"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Contacto</label>
                                <input type="text" class="form-control" v-model="contacto">
                                <div v-show="error">
                                    <div v-for="err in errorcontacto" :key="err" v-text="err" class="errorcamp"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Lugar de entrega</label>
                                <input type="text" class="form-control" v-model="lugarEntrega">
                                <div v-show="error">
                                    <div v-for="err in errorlugarEntrega" :key="err" v-text="err" class="errorcamp"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Comentario</label>
                                <textarea type="text" class="form-control" rows="4" v-model="comentario"></textarea>
                            </div>
                        </div>
                        <template v-if="arrayop.length>=1 && tipoAccion==1">
                            <div class="col-lg-12 col-md-12 col-sm-12 mt-2">
                                <div class="table-responsive">
                                    <table class="table text-center tableborderw tabledtb">
                                        <thead>
                                            <tr>
                                                <th scope="col">Código</th>
                                                <th scope="col">Nombre</th>
                                                <th scope="col">Imagen</th>
                                                
                                                <th scope="col">Cantidad</th>
                                                <th scope="col">Precio</th>
                                                <th scope="col">Total</th>
                                                <th scope="col"><i class="fas fa-window-close"></i></th>
                                            </tr>
                                        </thead>
                                        <tbody class="cambiable">
                                                <tr v-for="(entrada, index) in arrayop">
                                                    <td v-if="entrada.codigo">
                                                        <template v-if="entrada.codigo!='undefined'">
                                                            {{entrada.codigo}}
                                                        </template>
                                                        <template v-else>
                                                            Sin_código
                                                        </template>
                                                    </td>
                                                    <td v-else>Sin_código</td>
                                                    <td v-if="entrada.nombre">
                                                        <template v-if="entrada.nombre!='undefined'">
                                                            <template v-if="entrada.nombre.length>=50">
                                                                <div v-tippy="{ html : '#nombre'  , interactive : true, reactive : true }">
                                                                    {{entrada.nombre.substring(0, 50)}}...
                                                                </div>
                                                                <vue-component-test id="nombre">
                                                                <div style="white-space:pre-line;max-width:400px;">{{entrada.nombre}}</div>
                                                                </vue-component-test>
                                                            </template>
                                                            <template v-else>
                                                                {{entrada.nombre}}
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
                                                    
                                                    <td>{{entrada.cantidad}}</td>
                                                    <td>${{entrada.precio | dec}}</td>
                                                    <td>${{entrada.precio*entrada.cantidad | dec}}</td>
                                                    <td>
                                                        <a href="javascript:void(0)" title="Eliminar" @click="eliminarlista(index)"> <i class="fas fa-window-close text-danger"></i> </a>
                                                    </td>
                                                </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </template>
                        <template v-if="$.trim(arrayops)!='no' && tipoAccion==2">
                            <div class="col-lg-12 col-md-12 col-sm-12 mt-2 alvem">
                                <div class="col-lg-4 col-md-6 col-sm-12 form-material mb-2 pl-0">
                                    <input type="text" class="form-control" v-on:keyup.enter="hjt=1,abrirdetmuestras(idMuestras)" v-model="buscart" placeholder="Buscar..."/>
                                    <i class="fa fa-search imgbuscar" @click="hjt=1,abrirdetmuestras(idMuestras)"></i>
                                    <template v-if="buscart"><i class="fa fa-times imgdelete" @click="buscart='',hjt=1,abrirdetmuestras(idMuestras)"></i></template> 
                                </div>
                                <div class="table-responsive">
                                    <table class="table text-center tableborderw tabledtb">
                                        <thead>
                                            <tr>
                                                <th scope="col">Código</th>
                                                <th scope="col">Nombre</th>
                                                <th scope="col">Imagen</th>
                                                
                                                <th scope="col">Salida</th>
                                                <th scope="col">Entradas</th>
                                                <th scope="col">Stock</th>
                                                <th scope="col">Precio</th>
                                                <th scope="col">Total</th>
                                                <th scope="col" v-if="sesion[0].IDUSUARIO==15 || sesion[0].IDUSUARIO ==28 || sesion[0].IDUSUARIO ==58">Opciones</th>
                                                <th scope="col" v-if="sesion[0].IDUSUARIO==3 || sesion[0].IDUSUARIO==5 || sesion[0].IDUSUARIO ==73 || sesion[0].IDUSUARIO ==77">Dev</th>
                                            </tr>
                                        </thead>
                                        <tbody class="cambiable">
                                                <tr v-for="(entrada, index) in arrayops">
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
                                                            <template v-if="entrada.descripcion.length>=50">
                                                                <div class="tooltipss" >
                                                                    {{entrada.descripcion.substring(0, 50)}}...
                                                                    <span>{{entrada.descripcion | salto}}</span>
                                                                </div>
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
                                                    <td class="p-0 m-0"><img v-bind:src="'imagenes/productos/'+entrada.imagen+'.jpg'" class="imgopprd2"/></td>
                                                    
                                                    <td>{{entrada.salida}}</td>
                                                    <td v-if="entrada.entrada">{{entrada.entrada}}</td>
                                                    <td v-else>0</td>
                                                    <td>{{entrada.stock}}</td>
                                                    <td>${{entrada.precio | dec}}</td>
                                                    <td>${{entrada.precio*entrada.salida | dec}}</td>
                                                    <td v-if="sesion[0].IDUSUARIO==3 || sesion[0].IDUSUARIO ==5 || sesion[0].IDUSUARIO ==15 ||  sesion[0].IDUSUARIO ==28 || sesion[0].IDUSUARIO ==58 || sesion[0].IDUSUARIO ==73 || sesion[0].IDUSUARIO ==77">
                                                        <a href="javascript:void(0)" v-if="sesion[0].IDUSUARIO==15 || sesion[0].IDUSUARIO==28 || sesion[0].IDUSUARIO ==58 || sesion[0].IDUSUARIO ==77" title="Editar" v-tippy="{ position : 'top',  arrow: true, size: 'small' }" class="edit" @click="abrirModal('muestras','actualizardet',entrada)"> <i class="fas fa-pencil-alt text-inverse m-r-5"></i> </a>
                                                        <a href="javascript:void(0)" title="Devolución" v-tippy="{ position : 'top',  arrow: true, size: 'small' }" class="edit" @click="abrirModal('muestras','actualizarpagod',entrada)"><i class="fas fa-shopping-basket text-inverse m-r-5"></i></a>
                                                        <a href="javascript:void(0)" v-if="sesion[0].IDUSUARIO==15 || sesion[0].IDUSUARIO==28 || sesion[0].IDUSUARIO ==58 || sesion[0].IDUSUARIO ==77" title="Eliminar" @click="eliminardet1(entrada.idDetMuestras,index)"> <i class="fas fa-window-close text-danger"></i> </a>
                                                    </td>
                                                </tr>
                                        </tbody>
                                        <tfoot v-if="arrayops">
                                            </tr>
                                                <td class="b-0" colspan="5" v-if="sesion[0].IDUSUARIO==3 || sesion[0].IDUSUARIO ==5 || sesion[0].IDUSUARIO ==15 ||  sesion[0].IDUSUARIO ==28 || sesion[0].IDUSUARIO ==58 || sesion[0].IDUSUARIO ==73 || sesion[0].IDUSUARIO ==77"></td>
                                                <td class="b-0" colspan="4" v-else></td>
                                                <td class="text-right b pr-2 p-0 b-1" colspan="2">SUBTOTAL</td>
                                                <td class="pr-2 p-0 b-1">${{subTotal | dec}}</td>
                                            </tr>
                                            </tr>
                                                <td class="b-0" colspan="5" v-if="sesion[0].IDUSUARIO==3 || sesion[0].IDUSUARIO ==5 || sesion[0].IDUSUARIO ==15 ||  sesion[0].IDUSUARIO ==28 || sesion[0].IDUSUARIO ==58 || sesion[0].IDUSUARIO ==73 || sesion[0].IDUSUARIO ==77"></td>
                                                <td class="b-0" colspan="4" v-else></td>
                                                <td class="text-right b pr-2 p-0 b-1" colspan="2">IVA</td>
                                                <td class="pr-2 p-0 b-1">${{iva | dec}}</td>
                                            </tr>
                                            </tr>
                                                <td class="b-0" colspan="5" v-if="sesion[0].IDUSUARIO==3 || sesion[0].IDUSUARIO ==5 || sesion[0].IDUSUARIO ==15 ||  sesion[0].IDUSUARIO ==28 || sesion[0].IDUSUARIO ==58 || sesion[0].IDUSUARIO ==73 || sesion[0].IDUSUARIO ==77"></td>
                                                <td class="b-0" colspan="4" v-else></td>
                                                <td class="text-right b pr-2 p-0 b-1" colspan="2">TOTAL</td>
                                                <td class="pr-2 p-0 b-1">${{total | dec}}</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <div class="text-center" v-if="pagt>1">
                                    <nav aria-label="Page navigation example"style="display: inline-flex;" v-if="arrayops.length">
                                        <ul class="pagination mb-0" v-if="arrayops.lenght>=5">
                                            <template v-if="hjt!=1">
                                                <li class="page-item"><a class="page-link" @click="hjt--,abrirdetmuestras(idMuestras)" href="javascript:void(0)" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>
                                            </template>
                                            <template v-for="pg in pagt">
                                                <template v-if="hjt==pg">
                                                    <li class="page-item active"><a class="page-link" @click="hjt=pg,abrirdetmuestras(idMuestras)" href="javascript:void(0)" v-text="pg"></a></li>
                                                </template> 
                                                <template v-else>
                                                    <li class="page-item"><a class="page-link" @click="hjt=pg,abrirdetmuestras(idMuestras)" href="javascript:void(0)" v-text="pg"></a></li>
                                                </template> 
                                            </template>   
                                            <template v-if="hjt!=pagt">
                                                <li class="page-item"><a class="page-link" @click="hjt++,abrirdetmuestras(idMuestras)" href="javascript:void(0)" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>
                                            </template>
                                        </ul>
                                        <ul class="pagination mb-0" v-else>
                                            <template v-if="hjt!=1">
                                                <li class="page-item"><a class="page-link" @click="hjt--,abrirdetmuestras(idMuestras)" href="javascript:void(0)" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>
                                            </template>
                                            <template v-else>
                                                <li class="page-item disabled"><a class="page-link" href="javascript:void(0)" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>
                                            </template>
                                            <template v-if="hjt>4">
                                                <li class="page-item"><a class="page-link" @click="hjt=1,abrirdetmuestras(idMuestras)" href="javascript:void(0)" v-text="1"></a></li>
                                                    <template v-if="hjt>10">
                                                        <li class="page-item"><a class="page-link" @click="hjt=hjt-10,abrirdetmuestras(idMuestras)" href="javascript:void(0)">-10</a></li>
                                                    </template>
                                                <li class="page-item disabled"><a class="page-link" @click="hjt=1,abrirdetmuestras(idMuestras)" href="javascript:void(0)">...</a></li>
                                            </template>
                                            <template v-for="pg in pagt">
                                                <template v-if="pg>hjt-3 && pg<hjt+3">
                                                    <template v-if="hjt==pg">
                                                        <li class="page-item active"><a class="page-link" @click="hjt=pg,abrirdetmuestras(idMuestras)" href="javascript:void(0)" v-text="pg"></a></li>
                                                    </template>
                                                    <template v-else>
                                                        <li class="page-item"><a class="page-link" @click="hjt=pg,abrirdetmuestras(idMuestras)" href="javascript:void(0)" v-text="pg"></a></li>
                                                    </template>   
                                                </template>
                                            </template>   
                                            <template v-if="hjt<pagt-2">
                                                <li class="page-item disabled"><a class="page-link" @click="hjt=1,abrirdetmuestras(idMuestras)" href="javascript:void(0)">...</a></li>
                                                    <template v-if="hjt<pagt-10">
                                                        <li class="page-item"><a class="page-link" @click="hjt=hjt+10,abrirdetmuestras(idMuestras)" href="javascript:void(0)">+10</a></li>
                                                    </template>
                                                <li class="page-item"><a class="page-link" @click="hjt=pagt,abrirdetmuestras(idMuestras)" href="javascript:void(0)" v-text="pagt"></a></li>
                                            </template>
                                            <template v-if="hjt!=pagt">
                                                <li class="page-item"><a class="page-link" @click="hjt++,abrirdetmuestras(idMuestras)" href="javascript:void(0)" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>
                                            </template>
                                            <template v-else>
                                                <li class="page-item disabled"><a class="page-link" href="javascript:void(0)" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>
                                            </template>
                                        </ul>
                                    </nav>
                                    <div style="font-size: 11px;font-weight:bold;" v-if="arrayops.length">{{hjt}} de {{pagt}} / registos {{arrayops[0].pag}}</div>
                                    <div style="font-size: 11px;" v-else>Sin páginas</div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" v-if="tipoAccion==2 && (sesion[0].IDUSUARIO==3 || sesion[0].IDUSUARIO==5 || sesion[0].IDUSUARIO==15 || sesion[0].IDUSUARIO==28 || sesion[0].IDUSUARIO ==58 || sesion[0].IDUSUARIO ==73 || sesion[0].IDUSUARIO ==77)" @click="devolvertodox()">Devolver todo</button>
                    <button type="button" class="btn btn-primary" v-if="tipoAccion==2 && (sesion[0].IDUSUARIO==3 || sesion[0].IDUSUARIO==5 || sesion[0].IDUSUARIO==15 || sesion[0].IDUSUARIO==28 || sesion[0].IDUSUARIO ==58 || sesion[0].IDUSUARIO ==73 || sesion[0].IDUSUARIO ==77)" @click="agregarproducto()">Agregar producto</button>
                    <button type="button" class="btn btn-secondary" @click="tipoAccion=1" v-if="tipoAccion==3">Atras</button>
                    <button type="button" class="btn btn-secondary" @click="tipoAccion=2" v-if="tipoAccion==4 || tipoAccion==5 || tipoAccion==6">Atras</button>
                    <button type="button" class="btn btn-primary" v-if="tipoAccion==1" @click="agregardetguias()">Agregar Producto</button>
                    <button type="button" class="btn btn-secondary" v-if="tipoAccion<=2" @click="cerrarModal()">Cerrar</button>
                    <button type="button" class="btn btn-primary" v-if="tipoAccion==2 && (sesion[0].IDUSUARIO==3 || sesion[0].IDUSUARIO==5 || sesion[0].IDUSUARIO==15 || sesion[0].IDUSUARIO==28 || sesion[0].IDUSUARIO ==58 || sesion[0].IDUSUARIO ==73 || sesion[0].IDUSUARIO ==77)" @click="actualizar()">Actualizar</button>
                    <button type="button" class="btn btn-primary" v-if="tipoAccion==5 && (sesion[0].IDUSUARIO==3 || sesion[0].IDUSUARIO==5 || sesion[0].IDUSUARIO==15 || sesion[0].IDUSUARIO==28 || sesion[0].IDUSUARIO ==58 || sesion[0].IDUSUARIO ==73 || sesion[0].IDUSUARIO ==77)" @click="actualizardet()">Actualizar detalle</button>
                    <button type="button" class="btn btn-primary" v-if="tipoAccion==1" @click="registrar()">Guardar</button>
                    <button type="button" class="btn btn-primary" v-if="tipoAccion==3" @click="guardardetguias()">Agregar Producto</button>
                    <button type="button" class="btn btn-primary" v-if="tipoAccion==6" @click="guardarproductoguia()">Agregar Productos</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" :class="{'show mirar':modal1}"  id="entregainmediata" tabindex="-1" role="dialog" style="background: rgba(0,0,0,.5);" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Devolución</h5>
                    <button type="button" class="close" @click="cerrarModal1()">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body form-material">
                    <div class="row">
                        <div class="col-lg-6 col-md-12 col-sm-12">
                            <div class="form-group">
                                <input type="number" class="form-control text-center" v-model="entrada" placeholder="Cantidad devuelta">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12"> 
                            <div class="form-group">
                                <input type="number" class="form-control text-center" disabled v-model="entradastock" placeholder="Stock del producto">
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <textarea type="text" rows="3" v-model="comentariodev" class="form-control" v-model="entrada" placeholder="Ingresa comentario"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary cerrarmodal" @click="cerrarModal1()">Cancelar</button>
                    <button type="button" class="btn btn-primary" @click="actualizarentregadet()">Actualizar</button>
                </div>
            </div>
        </div>
    </div>
<?php
    include 'modulo/chat.php';
    include 'modulo/foot.php';
    include 'modulo/footer.php';
?> 
<script src="static/js/vuemuestras.js"></script> 
</div>
</body>
</html>