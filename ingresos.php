<?php
    include 'modulo/head.php';
    include 'modulo/menu_top.php';
    include 'modulo/menu_left.php';
    include 'modulo/preloader.php';
?>
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0">Ingreso</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                <li class="breadcrumb-item active">Ingreso</li>
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
                            <button type="button" v-if="sesion[0].IDUSUARIO==3 || sesion[0].IDUSUARIO ==5 || sesion[0].IDUSUARIO ==15 || sesion[0].IDUSUARIO ==28 || sesion[0].IDUSUARIO ==58 || sesion[0].IDUSUARIO ==39 || sesion[0].IDUSUARIO==73 || sesion[0].IDUSUARIO==74 || sesion[0].IDUSUARIO ==77" class="btn btn-info btn-rounded mr-3" style="float:right;" @click="abrirModal('ingresos','registrar')">
                                Nuevo Ingreso
                            </button>
                            <div class="btn-group mr-3" style="float:right;" v-if="sesion[0].IDUSUARIO==3 || sesion[0].IDUSUARIO ==5 || sesion[0].IDUSUARIO ==15 || sesion[0].IDUSUARIO==28 || sesion[0].IDUSUARIO ==39 || sesion[0].IDUSUARIO==73 || sesion[0].IDUSUARIO==74 || sesion[0].IDUSUARIO ==77">
                                <button type="button" class="btn btn-danger dropdown-toggle pl-5 pr-5" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-file"></i>  Archivos 
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" target="_top" href="modelo/ingresos/reporte.php">Descargar Ingreso</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>fechaIngreso</th>
                                    <th>tipoDocumento</th>
                                    <th>documento</th>
                                    <th>Proveedor</th>
                                    <th>Usuario</th>
                                    <th>Empleado</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template v-if="$.trim(entradas)">
                                    <tr  v-for="entrada in entradas">
                                        <td>{{entrada.idIngreso}}</td>
                                        <td>{{moment(String(entrada.fechaIngreso)).format('LL')}}</td>
                                        <td>{{entrada.tipoDocumento}}</td> 
                                        <td>N° {{entrada.documento}}</td>
                                        <td>{{entrada.NOM_PROVEEDOR}}</td>
                                        <td>{{entrada.razonSocialNombres}} {{entrada.razonComercialApellidos}}</td>
                                        <td>{{entrada.VENDEDOR}}</td>
                                        <td class="text-center">
                                            <a href="javascript:void(0)" title="Editar" v-tippy="{ position : 'top',  arrow: true, size: 'small' }" @click="abrirModal('ingresos','actualizar',entrada), listardetalle(entrada.idIngreso)"> <i class="fas fa-pencil-alt text-inverse m-r-3"></i> </a>
                                            <a title="Imprimir" v-tippy="{ position : 'top',  arrow: true, size: 'small' }" v-bind:href="'Impresiones/ingresos.php?id='+entrada.idIngreso" target="_blank"> <i class="fas fa-print text-inverse m-r-3"></i></a>
                                            <a href="javascript:void(0)" v-if="sesion[0].IDUSUARIO==15 || sesion[0].IDUSUARIO==3 ||  sesion[0].IDUSUARIO==5 || sesion[0].IDUSUARIO==28 || sesion[0].IDUSUARIO ==73 || sesion[0].IDUSUARIO==74 || sesion[0].IDUSUARIO ==77" title="Eliminar" v-tippy="{ position : 'top',  arrow: true, size: 'small' }" @click="eliminar(entrada.idIngreso,entrada.documento,sesion[0].IDUSUARIO)" > <i class="fas fa-window-close text-danger"></i> </a>
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
                        <nav aria-label="Page navigation example"style="display: inline-flex;" v-if="entradas">
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
                    <button type="button" style="position: absolute;margin-left: 10rem;top: 0.6rem;" class="btn btn-primary" v-if="tipoAccion==3" @click="guardardetingresos()">Agregar Producto</button>
                    <button type="button" class="close" @click="cerrarModal()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body form-material"> 
                    <div class="row" v-if="tipoAccion == 4 || tipoAccion == 5">
                        <div class="col-lg-2 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Códigos</label>
                                <input type="text" class="form-control" v-model="buscarproductos" :disabled="tipoAccion==5" @keyup="listarproductos()">
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
                                    <i class="fa fa-times bscdelete" v-if="buscarproductos.length && tipoAccion != 5" @click="buscarproductos='',nombredet='',cantidaddet=null,preciodet=null,descripciondet='', listarproductos(), idproducto=null"></i>
                                </template>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Nombre</label>
                                <input type="text" class="form-control" v-model="nombredet"> 
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
                                    <input type="text" class="form-control text-center" v-model="cantidaddet" onkeypress="return filterFloat(event,this);">
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
                                    <input type="text" class="form-control text-center" v-model="preciodet" onkeypress="return filterFloat(event,this);">
                                    <div v-show="error">
                                        <div v-for="err in errorpreciodet" :key="err" v-text="err" class="errorcamp"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12" v-if="tipoAccion == 4">
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
                        <template v-if="arrayop.length">
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
                                                <th scope="col">Precio</th>
                                                <th scope="col">total</th>
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
                                                            <template v-if="entrada.nombre.length>=40">
                                                                <div v-tippy="{ html : '#nombre'  , interactive : true, reactive : true }">
                                                                    {{entrada.nombre.substring(0, 40)}}...
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
                                                    <td class="p-0 m-0"><img v-bind:src="'imagenes/productos/'+entrada.codigo+'.jpg'" class="imgopprd"/></td>
                                                    <td v-if="entrada.comentario">
                                                        <template v-if="entrada.comentario!='undefined'">
                                                            <template v-if="entrada.comentario.length>=85">
                                                                <div v-tippy="{ html : '#comentario'  , interactive : true, reactive : true }">
                                                                    {{entrada.comentario.substring(0, 85)}}...
                                                                </div>
                                                                <vue-component-test id="nombre">
                                                                    <div style="white-space:pre-line;max-width:400px;">{{entrada.comentario}}</div>
                                                                </vue-component-test>
                                                            </template>
                                                            <template v-else>
                                                                {{entrada.comentario}}
                                                            </template>
                                                        </template>
                                                        <template v-else>
                                                            Sin comentario
                                                        </template>
                                                    </td>
                                                    <td v-else>
                                                        Sin comentario
                                                    </td>
                                                    <td>{{entrada.cantidad}}</td>
                                                    <td v-if="entrada.costo">${{entrada.costo}}</td>
                                                    <td v-else>$0.00</td>
                                                    <td>${{entrada.total}}</td>
                                                    <td>
                                                        <a href="javascript:void(0)" title="Eliminar de este detalle" v-tippy="{ position : 'top',  arrow: true, size: 'small' }" @click="eliminarlista(index)"> <i class="fas fa-window-close text-danger"></i> </a>
                                                    </td>
                                                </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </template>
                    </div>
                    <div class="row" v-else-if="tipoAccion == 3">
                        <div class="col-lg-2 col-md-6 col-sm-12">
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
                                    <i class="fa fa-times bscdelete" v-if="buscarproductos.length" @click="buscarproductos='',nombredet='',cantidaddet=null,preciodet=null,descripciondet='', listarproductos(), idproducto=null"></i>
                                </template>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Nombre</label>
                                <input type="text" class="form-control" v-model="nombredet"> 
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
                                    <input type="text" class="form-control text-center" v-model="cantidaddet" onkeypress="return filterFloat(event,this);">
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
                                    <input type="text" class="form-control text-center" v-model="preciodet" onkeypress="return filterFloat(event,this);">
                                    <div v-show="error">
                                        <div v-for="err in errorpreciodet" :key="err" v-text="err" class="errorcamp"></div>
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
                        <template v-if="arrayop.length">
                            <div class="col-lg-12 col-md-12 col-sm-12 mt-2">
                                <div class="table-responsive">
                                    <table class="table text-center tableborderw tabledtb">
                                        <thead>
                                            <tr>
                                                <th scope="col">Código</th>
                                                <th scope="col">Nombre</th>
                                                <th scope="col">Imagen</th>
                                                <th scope="col">Comentarios</th>
                                                <th scope="col">Can.</th>
                                                <th scope="col">Stock</th>
                                                <th scope="col">Costo</th>
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
                                                            <template v-if="entrada.nombre.length>=40">
                                                                <div v-tippy="{ html : '#nombre'  , interactive : true, reactive : true }">
                                                                    {{entrada.nombre.substring(0, 40)}}...
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
                                                    <td class="p-0 m-0"><img v-bind:src="'imagenes/productos/'+entrada.codigo+'.jpg'" class="imgopprd"/></td>
                                                    <td v-if="entrada.comentario">
                                                        <template v-if="entrada.comentario!='undefined'">
                                                            <template v-if="entrada.comentario.length>=45">
                                                                <div v-tippy="{ html : '#comentariosss'  , interactive : true, reactive : true }">
                                                                    {{entrada.comentario.substring(0, 45)}}...
                                                                </div>
                                                                <vue-component-test id="comentariosss">
                                                                    <div style="white-space:pre-line;max-width:400px;">
                                                                        {{entrada.comentario}}
                                                                    </div>
                                                                </vue-component-test>
                                                            </template>
                                                            <template v-else>
                                                                {{entrada.comentario}}
                                                            </template>
                                                        </template>
                                                        <template v-else>
                                                            Sin comentario
                                                        </template>
                                                    </td>
                                                    <td v-else>
                                                        Sin comentario
                                                    </td>
                                                    <td>{{entrada.cantidad}}</td>
                                                    <td>{{entrada.cantidad1}}</td>
                                                    <td v-if="entrada.precioVenta">${{entrada.precioVenta | dec}}</td>
                                                    <td v-else>$0.00</td>
                                                    <td>${{entrada.precioVenta*entrada.cantidad | dec}}</td>
                                                    <td>
                                                        <a href="javascript:void(0)" title="Eliminar de este detalle" v-tippy="{ position : 'top',  arrow: true, size: 'small' }" @click="eliminarlista(index)"> <i class="fas fa-window-close text-danger"></i> </a>
                                                    </td>
                                                </tr>
                                        </tbody>
                                        <tfoot v-if="arrayop">
                                            </tr>
                                                <td class="b-0" colspan="5"></td>
                                                <td class="text-right b pr-2 p-0 b-1" colspan="2">SUBTOTAL</td>
                                                <td class="pr-2 p-0 b-1" v-if="subTotal" colspan="2">${{subTotalfinal | decf}}</td>
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
                                                <td class="b-0" colspan="5"></td>
                                                <td class="text-right b pr-2 p-0 b-1" colspan="2"> 
                                                    <div style="position: absolute;margin-left: 7px;">
                                                        <input type="checkbox" class="form-check-input" id="subtotal1" v-model="siniva">
                                                        <label class="form-check-label" for="subtotal1">sin iva</label>
                                                    </div>
                                                    IVA
                                                </td>
                                                <td class="pr-2 p-0 b-1" v-if="iva && !siniva" colspan="2">${{iva | decf}}</td>
                                                <td class="pr-2 p-0 b-1" v-else colspan="2">$0.00</td>
                                            </tr>
                        
                                            </tr>
                                                <td class="b-0" colspan="5"></td>
                                                <td class="text-right b pr-2 p-0 b-1" colspan="2">TOTAL</td>
                                                <td class="pr-2 p-0 b-1" v-if="total && !siniva" colspan="2">${{totalfinal | decf}}</td>
                                                <td class="pr-2 p-0 b-1" v-else-if="total && siniva" colspan="2">${{subTotal-descuento | decf}}</td>
                                                <td class="pr-2 p-0 b-1" v-else-if="!total">$0.00</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </template>
                    </div>
                    <div class="row" v-else>
                        <div class="col-lg-3 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Fecha de Ingreso</label>
                                <input type="datetime-local" class="form-control" v-model="fechaIngreso">
                                <div v-show="error">
                                    <div v-for="err in errorfechaIngreso" :key="err" v-text="err" class="errorcamp"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Ord. compra</label>
                                <input type="number" class="form-control text-center" @blur="buscarordcompra(idOrdCompra)" v-model="idOrdCompra">
                                <div v-show="error">
                                    <div v-for="err in erroroc" :key="err" v-text="err" class="errorcamp"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Ord. pedido</label>
                                <input type="text" class="form-control text-center" v-model="idOrdPedido" disabled>
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Proveedor </label>
                                <input type="text" class="form-control" v-model="buscarproveedores" @keyup="listarproveedores()" autocomplete="off">
                                <template v-if="buscarproveedores.length">
                                    <div class="menuw" v-if="listproveedores=='sin'">
                                        <div>Ingresa mas de 2 caracteres</div>
                                    </div>
                                    <div class="menuw" v-else-if="$.trim(listproveedores)=='no'">
                                        <div>No se ecnontraron registros que coincidan</div> 
                                    </div>
                                    <div class="menuw" v-else-if="listproveedores.length">
                                        <div class="select" v-for="listproveedor in listproveedores" @click="seleccionarproveedor(listproveedor),listproveedores=[]">
                                            {{listproveedor.razonSocialNombres}} {{listproveedor.razonComercialApellidos}}
                                        </div>
                                    </div>
                                    <i class="fa fa-times bscdelete" @click="buscarproveedores='', listarproveedores(), idProveedor=null"></i>
                                </template>
                                <div v-show="error">
                                    <div v-for="err in erroridProveedor" :key="err" v-text="err" class="errorcamp"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-12" v-if="tipoAccion==1">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Cédula/RUC</label>
                                <input type="text" class="form-control" v-model="cedula" @blur="buscarced()" v_bind:keyup="buscarced()">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12" v-if="tipoAccion==1">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Dirección</label>
                                <input type="text" class="form-control" v-model="direccion" readonly>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12" v-if="tipoAccion==1">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Teléfono</label>
                                <input type="text" class="form-control" v-model="telefono" readonly>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-12" v-if="tipoAccion==1">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Celular</label>
                                <input type="text" class="form-control" v-model="celular" readonly>
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
                                <div v-show="error">
                                    <div v-for="err in errortipoDocumento" :key="err" v-text="err" class="errorcamp"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Documento</label>
                                <input type="text" class="form-control" onkeypress="return filterFloat(event,this);" v-model="documento">
                                <div v-show="error">
                                    <div v-for="err in errordocumento" :key="err" v-text="err" class="errorcamp"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-7 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Empleado</label>
                                <select class="form-control" id="empleado" v-model="idEmpleado">
                                    <option value="">Seleccione el Empleado</option>
                                        <option v-for="empleado in empleados" v-bind:value="empleado.IDEMPLEADO">{{empleado.NOMBRES}} {{empleado.APELLIDOS}}</option>  
                                </select>
                                <div v-show="error">
                                    <div v-for="err in erroridEmpleado" :key="err" v-text="err" class="errorcamp"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Nombres y Apellidos del cliente</label>
                                <input type="text" class="form-control" v-model="buscarclientes" @keyup="listarclientes()" autocomplete="off">
                                <template v-if="buscarclientes.length">
                                    <div class="menuw" v-if="listclientes=='sin'">
                                        <div>Ingresa mas de 2 caracteres</div>
                                    </div>
                                    <div class="menuw" v-else-if="$.trim(listclientes)=='no'">
                                        <div>No se ecnontraron registros que coincidan</div> 
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
                        <template v-if="arrayop.length && tipoAccion==1">
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
                                                <th scope="col">Stock.</th>
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
                                                            <template v-if="entrada.nombre.length>=40">
                                                                <div v-tippy="{ html : '#nombre'  , interactive : true, reactive : true }">
                                                                    {{entrada.nombre.substring(0, 40)}}...
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
                                                    <td class="p-0 m-0"><img v-bind:src="'imagenes/productos/'+entrada.codigo+'.jpg'" class="imgopprd"/></td>
                                                    <td v-if="entrada.comentario">
                                                        <template v-if="entrada.comentario!='undefined'">
                                                            <template v-if="entrada.comentario.length>=45">
                                                                <div v-tippy="{ html : '#comentariosss'  , interactive : true, reactive : true }">
                                                                    {{entrada.comentario.substring(0, 45)}}...
                                                                </div>
                                                                <vue-component-test id="comentariosss">
                                                                    <div style="white-space:pre-line;max-width:400px;">
                                                                        {{entrada.comentario}}
                                                                    </div>
                                                                </vue-component-test>
                                                            </template>
                                                            <template v-else>
                                                                {{entrada.comentario}}
                                                            </template>
                                                        </template>
                                                        <template v-else>
                                                            Sin comentario
                                                        </template>
                                                    </td>
                                                    <td v-else>
                                                        Sin comentario
                                                    </td>
                                                    <td>{{entrada.cantidad}}</td>
                                                    <td>{{entrada.cantidad1}}</td>
                                                    <td>${{entrada.precioVenta | dec}}</td>
                                                    <td>${{entrada.precioVenta*entrada.cantidad | dec}}</td>
                                                    <td>
                                                        <a href="javascript:void(0)" title="Eliminar de este detalle" v-tippy="{ position : 'top',  arrow: true, size: 'small' }" @click="eliminarlista(index)"> <i class="fas fa-window-close text-danger"></i> </a>
                                                    </td>
                                                </tr>
                                        </tbody>
                                        <tfoot v-if="arrayop">
                                            </tr>
                                                <td class="b-0" colspan="5"></td>
                                                <td class="text-right b pr-2 p-0 b-1" colspan="2">SUBTOTAL</td>
                                                <td class="pr-2 p-0 b-1" v-if="subTotal" colspan="2">${{subTotalfinal | decf}}</td>
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
                                                <td class="b-0" colspan="5"></td>
                                                <td class="text-right b pr-2 p-0 b-1" colspan="2"> 
                                                    <div style="position: absolute;margin-left: 7px;">
                                                        <input type="checkbox" class="form-check-input" id="subtotal1" v-model="siniva">
                                                        <label class="form-check-label" for="subtotal1">sin iva</label>
                                                    </div>
                                                    IVA
                                                </td>
                                                <td class="pr-2 p-0 b-1" v-if="iva && !siniva" colspan="2">${{iva | decf}}</td>
                                                <td class="pr-2 p-0 b-1" v-else colspan="2">$0.00</td>
                                            </tr>
                                            
                                            </tr>
                                                <td class="b-0" colspan="5"></td>
                                                <td class="text-right b pr-2 p-0 b-1" colspan="2">TOTAL</td>
                                                <td class="pr-2 p-0 b-1" v-if="total && !siniva" colspan="2">${{totalfinal | decf}}</td>
                                                <td class="pr-2 p-0 b-1" v-else-if="total && siniva" colspan="2">${{subTotal-descuento | decf}}</td>
                                                <td class="pr-2 p-0 b-1" v-else-if="!total">$0.00</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </template>
                        <template v-if="tipoAccion==2">
                            <div class="col-lg-12 col-md-12 col-sm-12 mt-2">
                                <div class="col-lg-4 col-md-6 col-sm-12 form-material mb-2 pl-0">
                                    <input type="text" class="form-control" v-on:keyup.enter="hjt=1,listardetalle(idIngreso)" v-model="buscart" placeholder="Buscar..."/>
                                    <i class="fa fa-search imgbuscar" @click="hjt=1,listardetalle(idIngreso)"></i>
                                    <template v-if="buscart"><i class="fa fa-times imgdelete" @click="buscart='',hjt=1,listardetalle(idIngreso)"></i></template> 
                                </div>
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
                                                <th scope="col" v-if="sesion[0].IDUSUARIO ==15 || sesion[0].IDUSUARIO ==28 || sesion[0].IDUSUARIO ==58 || sesion[0].IDUSUARIO ==77">Opciones</th>
                                            </tr>
                                        </thead>
                                        <tbody class="cambiable">
                                                <tr v-for="(entrada, index) in entradasdet">
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
                                                    <td v-if="sesion[0].IDUSUARIO ==15 || sesion[0].IDUSUARIO ==28 || sesion[0].IDUSUARIO ==58 || sesion[0].IDUSUARIO ==73 || sesion[0].IDUSUARIO ==77">
                                                        <a href="javascript:void(0)" title="Editar" v-tippy="{ position : 'top',  arrow: true, size: 'small' }" @click="abrirModal('ingresos','editardet',entrada)"> <i class="fas fa-pencil-alt text-inverse m-r-10"></i> </a>
                                                        <a href="javascript:void(0)" title="Eliminar de este detalle" v-tippy="{ position : 'top',  arrow: true, size: 'small' }" @click="eliminardet(entrada.idDetIngreso,entrada.idIngreso,entrada.idProducto,entrada.cantidad,documento,sesion[0].IDUSUARIO)"><i class="fas fa-window-close text-danger"></i></a>
                                                    </td>
                                                </tr>
                                        </tbody>
                                        <tfoot v-if="entradasdet">
                                            </tr>
                                                <td class="b-0" colspan="5" v-if="sesion[0].IDUSUARIO ==15 || sesion[0].IDUSUARIO ==28 || sesion[0].IDUSUARIO ==58 || sesion[0].IDUSUARIO ==73 || sesion[0].IDUSUARIO ==77"></td>
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
                                                <td class="b-0" colspan="5" v-if="sesion[0].IDUSUARIO ==15 || sesion[0].IDUSUARIO ==28 || sesion[0].IDUSUARIO ==58 || sesion[0].IDUSUARIO ==73 || sesion[0].IDUSUARIO ==77"></td>
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
                                                <td class="b-0" colspan="5" v-if="sesion[0].IDUSUARIO ==15 || sesion[0].IDUSUARIO ==28 || sesion[0].IDUSUARIO ==58 || sesion[0].IDUSUARIO ==73 || sesion[0].IDUSUARIO ==77"></td>
                                                <td class="b-0" colspan="4" v-else></td>
                                                <td class="text-right b pr-2 p-0 b-1" colspan="2">TOTAL</td>
                                                <td class="pr-2 p-0 b-1" v-if="total && !siniva">${{totalfinal | decf}}</td>
                                                <td class="pr-2 p-0 b-1" v-else-if="total && siniva">${{subTotal | decf}}</td>
                                                <td class="pr-2 p-0 b-1" v-else-if="!total">$0.00</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <div class="text-center" v-if="pagt>1">
                                    <nav aria-label="Page navigation example"style="display: inline-flex;" v-if="entradasdet.length">
                                        <ul class="pagination mb-0" v-if="entradasdet.lenght>=5">
                                            <template v-if="hjt!=1">
                                                <li class="page-item"><a class="page-link" @click="hjt--,listardetalle(idIngreso)" href="javascript:void(0)" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>
                                            </template>
                                            <template v-for="pg in pagt">
                                                <template v-if="hjt==pg">
                                                    <li class="page-item active"><a class="page-link" @click="hjt=pg,listardetalle(idIngreso)" href="javascript:void(0)" v-text="pg"></a></li>
                                                </template> 
                                                <template v-else>
                                                    <li class="page-item"><a class="page-link" @click="hjt=pg,listardetalle(idIngreso)" href="javascript:void(0)" v-text="pg"></a></li>
                                                </template> 
                                            </template>   
                                            <template v-if="hjt!=pagt">
                                                <li class="page-item"><a class="page-link" @click="hjt++,listardetalle(idIngreso)" href="javascript:void(0)" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>
                                            </template>
                                        </ul>
                                        <ul class="pagination mb-0" v-else>
                                            <template v-if="hjt!=1">
                                                <li class="page-item"><a class="page-link" @click="hjt--,listardetalle(idIngreso)" href="javascript:void(0)" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>
                                            </template>
                                            <template v-else>
                                                <li class="page-item disabled"><a class="page-link" href="javascript:void(0)" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>
                                            </template>
                                            <template v-if="hjt>4">
                                                <li class="page-item"><a class="page-link" @click="hjt=1,listardetalle(idIngreso)" href="javascript:void(0)" v-text="1"></a></li>
                                                    <template v-if="hjt>10">
                                                        <li class="page-item"><a class="page-link" @click="hjt=hjt-10,listardetalle(idIngreso)" href="javascript:void(0)">-10</a></li>
                                                    </template>
                                                <li class="page-item disabled"><a class="page-link" @click="hjt=1,listardetalle(idIngreso)" href="javascript:void(0)">...</a></li>
                                            </template>
                                            <template v-for="pg in pagt">
                                                <template v-if="pg>hjt-3 && pg<hjt+3">
                                                    <template v-if="hjt==pg">
                                                        <li class="page-item active"><a class="page-link" @click="hjt=pg,listardetalle(idIngreso)" href="javascript:void(0)" v-text="pg"></a></li>
                                                    </template>
                                                    <template v-else>
                                                        <li class="page-item"><a class="page-link" @click="hjt=pg,listardetalle(idIngreso)" href="javascript:void(0)" v-text="pg"></a></li>
                                                    </template>   
                                                </template>
                                            </template>   
                                            <template v-if="hjt<pagt-2">
                                                <li class="page-item disabled"><a class="page-link" @click="hjt=1,listardetalle(idIngreso)" href="javascript:void(0)">...</a></li>
                                                    <template v-if="hjt<pagt-10">
                                                        <li class="page-item"><a class="page-link" @click="hjt=hjt+10,listardetalle(idIngreso)" href="javascript:void(0)">+10</a></li>
                                                    </template>
                                                <li class="page-item"><a class="page-link" @click="hjt=pagt,listardetalle(idIngreso)" href="javascript:void(0)" v-text="pagt"></a></li>
                                            </template>
                                            <template v-if="hjt!=pagt">
                                                <li class="page-item"><a class="page-link" @click="hjt++,listardetalle(idIngreso)" href="javascript:void(0)" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>
                                            </template>
                                            <template v-else>
                                                <li class="page-item disabled"><a class="page-link" href="javascript:void(0)" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>
                                            </template>
                                        </ul>
                                    </nav>
                                    <div style="font-size: 11px;font-weight:bold;" v-if="entradasdet.length">{{hjt}} de {{pagt}} / registos {{entradasdet[0].pag}}</div>
                                    <div style="font-size: 11px;" v-else>Sin páginas</div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
                <div class="modal-footer"> 
                    <a v-bind:href="'modelo/ingresos/descargarstock.php?buscar='+idIngreso" target="_TOP" type="button" class="btn btn-primary" v-if="(tipoAccion==2 || tipoAccion==4) && (sesion[0].IDUSUARIO ==15 || sesion[0].IDUSUARIO ==28 || sesion[0].IDUSUARIO ==58 || sesion[0].IDUSUARIO ==3 || sesion[0].IDUSUARIO ==73 || sesion[0].IDUSUARIO ==77)">Descargar excel</a>
                    <button type="button" class="btn btn-primary" v-if="tipoAccion==2 && (sesion[0].IDUSUARIO ==15 || sesion[0].IDUSUARIO ==28 || sesion[0].IDUSUARIO ==58 || sesion[0].IDUSUARIO ==3 || sesion[0].IDUSUARIO ==73 || sesion[0].IDUSUARIO ==77)" @click="tipoAccion=4,borrarprd(),buscart='',hjt=1">Agregar Producto</button>
                    <button type="button" class="btn btn-primary" v-if="tipoAccion==1" @click="agregardetops()">Agregar Producto</button> 
                    <button type="button" class="btn btn-primary" v-if="tipoAccion==4 || tipoAccion == 5" @click="tipoAccion=2, tituloModal='Actualizar Ingreso',buscart='',hjt=1">Volver</button>
                    <button type="button" class="btn btn-primary" v-if="tipoAccion==3" @click="tipoAccion=1, tituloModal='Crear ingreso'">Volver</button>
                    <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                    <button type="button" class="btn btn-primary" v-if="tipoAccion==3" @click="guardardetingresos()">Agregar Producto</button>
                    <button type="button" class="btn btn-primary" v-if="tipoAccion==1" @click="registrar()">Guardar</button>
                    <button type="button" class="btn btn-primary" v-if="tipoAccion==2 && (sesion[0].IDUSUARIO ==15 || sesion[0].IDUSUARIO ==28 || sesion[0].IDUSUARIO ==58 || sesion[0].IDUSUARIO ==3 || sesion[0].IDUSUARIO ==73 || sesion[0].IDUSUARIO ==77)" @click="actualizar()">Actualizar</button>
                    <button type="button" class="btn btn-primary" v-if="tipoAccion==4" @click="agregardet()">Agregar</button>
                    <button type="button" class="btn btn-primary" v-if="tipoAccion==5 " @click="actualizardet()">Actualizar detalle</button>
                </div>
            </div>
        </div>
    </div>
<?php 
    include 'modulo/chat.php';
    include 'modulo/foot.php';
    include 'modulo/footer.php';
?> 
<script src="static/js/vueingresos.js"></script>
</div>
</body>
</html> 