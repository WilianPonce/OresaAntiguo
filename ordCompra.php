<?php
    include 'modulo/head.php';
    include 'modulo/menu_top.php';
    include 'modulo/menu_left.php';
    include 'modulo/preloader.php';
?>
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0">Orden de Compra</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="./">Inicio</a></li>
                <li class="breadcrumb-item active">Orden de Compra</li>
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
                        <div class="col-lg-8 col-md-6 col-sm-12" v-if="sesion[0].IDUSUARIO==45 || sesion[0].IDUSUARIO==15 || sesion[0].IDUSUARIO ==28 || sesion[0].IDUSUARIO ==58 || sesion[0].IDUSUARIO ==39 || sesion[0].IDUSUARIO ==74 || sesion[0].IDUSUARIO ==76">
                            <button v-if="sesion[0].IDUSUARIO ==15 || sesion[0].IDUSUARIO ==45 || sesion[0].IDUSUARIO ==28 || sesion[0].IDUSUARIO ==58 || sesion[0].IDUSUARIO ==76" type="button" class="btn btn-info btn-rounded" style="float:right;" @click="abrirModal('ordcompra','registrar')">
                                Nueva Ord.Compra
                            </button> 
                            <div class="btn-group mr-3" style="float:right;"> 
                                <button type="button" class="btn btn-danger dropdown-toggle pl-5 pr-5" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-file"></i>  Archivos 
                                </button> 
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" target="_top" href="modelo/ordcompra/reporte.php">Descargar reporte</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped mb-0" style="font-size: 13px;">
                            <thead>
                                <tr>
                                    <th class="text-center">Ord.C</th>
                                    <th>Cliente</th>
                                    <th>Vendedor</th>
                                    <th>Fecha Creada</th>
                                    <th>Fecha Solicitada</th>
                                    <th>Fecha Estimada</th>
                                    <th>Observación</th>
                                    <th class="text-nowrap" v-if="sesion[0].IDUSUARIO==45">Acción</th>
                                    <th class="text-nowrap" v-else><i class="fas fa-print"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                <template v-if="$.trim(entradas.length)>=1")>
                                    <tr  v-for="entrada in entradas">
                                        <td>{{entrada.ordCompra}}</td>
                                        <td>{{entrada.NOM_CLIENTE}} {{entrada.APE_CLIENTE}}</td>
                                        <td>{{entrada.NOM_EMPLE}}</td>
                                        <td>{{moment(String(entrada.fechaEmision)).format('lll')}}</td>
                                        <td>{{moment(String(entrada.fechaSolicita)).format('lll')}}</td>
                                        <td>{{moment(String(entrada.fechaEstimada)).format('LL')}}</td>
                                        <td>{{entrada.observacion}}</td>
                                        <td class="text-nowrap"> 
                                            <a href="javascript:void(0)" title="Editar" v-tippy="{ position : 'top',  arrow: true, size: 'small' }" class="edit" @click="abrirModal('ordcompra','actualizar',entrada),listardetalle(entrada.idOrdCompra)"> <i class="fas fa-pencil-alt text-inverse m-r-3"></i> </a>
                                            <a v-bind:href="'./impresiones/compra.php?compra='+entrada.idOrdCompra" title="Imprimir" target="_blank" v-tippy="{ position : 'top',  arrow: true, size: 'small' }" class="edit" @click="abririmpr(entrada.idOrdCompra)"> <i class="fas fa-print text-inverse m-r-3"></i> </a>
                                            <a href="javascript:void(0)" v-if="sesion[0].IDUSUARIO==45" title="Eliminar" v-tippy="{ position : 'top',  arrow: true, size: 'small' }" @click="eliminar(entrada.idOrdCompra)" > <i class="fas fa-window-close text-danger"></i> </a>
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
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel" v-text="tituloModal"></h5> <div class="pl-3 pr-3" v-if="tipoAccion==1">|</div> <input @click="recarga()" v-if="tipoAccion==1" type="checkbox" id="checkbox" v-model="checked"><label v-if="tipoAccion==1" for="checkbox">Es para stock</label> 
                    <button type="button" class="close" @click="cerrarModal()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body form-material">
                    <div class="row" v-if="tipoAccion == 6">  
                        <div class="col-lg-12 col-md-12 col-sm-12 mt-2">
                            <div class="table-responsive">
                                <table class="table text-center tableborderw tabledtb">
                                    <thead>
                                        <tr>
                                            <th scope="col">Sel</th>
                                            <th scope="col">Código</th>
                                            <th scope="col">Nombre</th>
                                            <th scope="col">Cantidad</th>
                                            <th scope="col">Pendiente</th>
                                            <th scope="col">Precio</th>
                                            <th scope="col">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody class="cambiable">
                                        <tr v-for="entrada in recdetop">
                                            <td>
                                                <input type="checkbox" class="form-check-input" v-bind:value="entrada.idDetOrdPedido" v-bind:id="entrada.idDetOrdPedido" v-model="escogerdetop">
                                                <label class="custom-control-label" v-bind:for="entrada.idDetOrdPedido"></label>
                                            </td>
                                            <td>{{entrada.codigo}}</td>
                                            <td v-if="entrada.nombre">
                                                <template v-if="entrada.nombre!='undefined'">
                                                    <template v-if="entrada.nombre.length>=9999">
                                                        <div class="tooltipss">
                                                            {{entrada.nombre.substring(0, 9999)}}...
                                                            <span>{{entrada.nombre}}</span>
                                                        </div>
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
                                            <td>{{entrada.cantidad}}</td>
                                            <td>{{entrada.pendiente}}</td>
                                            <td>{{entrada.precioVenta}}</td>
                                            <td>{{entrada.precioVenta*entrada.pendiente}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row" v-else-if="tipoAccion == 5">    
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
                                    <i class="fa fa-times bscdelete" v-if="buscarproductos.length" @click="buscarproductos='',nombredet='', listarproductos(), idproducto=null"></i>
                                </template>
                            </div>
                        </div>       
                        <div class="col-lg-5 col-md-6 col-sm-12">
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
                                    <input type="text" class="form-control text-center validarn" v-model="cantidaddet" onkeypress="return filterFloat(event,this);">
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
                                        <span class="input-group-text" id="basic-addon1">$</span>
                                    </div>
                                    <input type="text" class="form-control text-center" v-model="preciodet" onkeypress="return filterFloat(event,this);">
                                    <div v-show="error">
                                        <div v-for="err in errorpreciodet" :key="err" v-text="err" class="errorcamp"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" v-else-if="tipoAccion == 4">      
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
                                    <i class="fa fa-times bscdelete" v-if="buscarproductos.length" @click="buscarproductos='',nombredet='', listarproductos(), idproducto=null"></i>
                                </template>
                            </div>
                        </div>            
                        <div class="col-lg-5 col-md-6 col-sm-12">
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
                                    <input type="text" class="form-control text-center validarn" v-model="cantidaddet" onkeypress="return filterFloat(event,this);">
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
                                        <span class="input-group-text" id="basic-addon1">$</span>
                                    </div>
                                    <input type="text" class="form-control text-center" v-model="preciodet" onkeypress="return filterFloat(event,this);">
                                    <div v-show="error">
                                        <div v-for="err in errorpreciodet" :key="err" v-text="err" class="errorcamp"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <template v-if="entradasdetalle">
                            <div class="col-lg-12 col-md-12 col-sm-12 mt-2">
                                <div class="table-responsive">
                                    <table class="table text-center tableborderw tabledtb">
                                        <thead>
                                            <tr>
                                                <th scope="col">Código</th>
                                                <th scope="col">Nombre</th>
                                                <th scope="col">Comentario</th>
                                                <th scope="col">Can.</th>
                                                <th scope="col">Precio</th>
                                                <th scope="col">Total</th>
                                                <th scope="col" v-if="sesion[0].IDUSUARIO==45"><i class="fas fa-window-close"></i></th>
                                            </tr>
                                        </thead>
                                        <tbody class="cambiable">
                                                <tr v-for="entrada in entradasdetalle">
                                                    <td v-if="entrada.codigo">
                                                        <template v-if="entrada.codigo!='undefined'">
                                                            {{entrada.codigo}}
                                                        </template>
                                                        <template v-else>
                                                            Sin Código
                                                        </template>
                                                    </td>
                                                    <td v-else>
                                                            Sin Código
                                                    </td>
                                                    <td v-if="entrada.descripcion">
                                                        <template v-if="entrada.descripcion!='undefined'">
                                                            <template v-if="entrada.descripcion.length>=50">
                                                                <div class="tooltipss" >
                                                                    {{entrada.descripcion.substring(0, 50)}}...
                                                                    <span>{{entrada.descripcion}}</span>
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
                                                    <td v-if="entrada.comentario">
                                                        <template v-if="entrada.comentario!='undefined'">
                                                            <template v-if="entrada.comentario.length>=85">
                                                                <div class="tooltipss" >
                                                                    {{entrada.comentario.substring(0, 85)}}...
                                                                    <span>{{entrada.comentario}}</span>
                                                                </div>
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
                                                    <td>{{entrada.cantidad | dec1}}</td> 
                                                    <td v-if="entrada.costo">${{entrada.costo | dec}}</td>
                                                    <td v-else>$0.00</td>
                                                    <td>${{entrada.costo*entrada.cantidad | dec}}</td>
                                                    <td v-if="sesion[0].IDUSUARIO==45">
                                                        <a href="javascript:void(0)" title="Eliminar" @click="eliminardetalle(entrada.idDetCompra, entrada.idOrdCompra, entrada.cantidad, entrada.costo)"> <i class="fas fa-window-close text-danger"></i> </a>
                                                    </td>
                                                </tr>
                                        </tbody>
                                        <tfoot>
                                            </tr>
                                                <td class="b-0" colspan="2"></td>
                                                <td class="text-right b pr-2 p-0 b-1" colspan="2">SUBTOTAL</td>
                                                <td class="pr-2 p-0 b-1" colspan="2" v-if="subTotal">${{subTotal | decf}}</td>
                                                <td class="pr-2 p-0 b-1" colspan="2" v-else>$0.00</td>
                                            </tr>
                                            </tr>
                                                <td class="b-0" colspan="2"></td>
                                                <td class="text-right b pr-2 p-0 b-1" colspan="2">
                                                    <div style="position: absolute;margin-left: 7px;">
                                                        <input type="checkbox" class="form-check-input" id="subtotal1" v-model="siniva" @change="cambiariva()">
                                                        <label class="form-check-label" for="subtotal1">sin iva</label>
                                                    </div>
                                                    IVA
                                                </td>
                                                <td class="pr-2 p-0 b-1" colspan="2" v-if="iva && !siniva">${{iva | decf}}</td>
                                                <td class="pr-2 p-0 b-1" colspan="2" v-else>$0.00</td>
                                            </tr>
                                            </tr>
                                                <td class="b-0" colspan="2"></td>
                                                <td class="text-right b pr-2 p-0 b-1" colspan="2">TOTAL</td>
                                                <td class="pr-2 p-0 b-1" colspan="2" v-if="total && !siniva">${{total | decf}}</td>
                                                <td class="pr-2 p-0 b-1" colspan="2" v-else-if="total && siniva">${{subTotal | decf}}</td>
                                                <td class="pr-2 p-0 b-1" colspan="2" v-else-if="!total">$0.00</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </template>
                    </div>
                    <div class="row" v-else-if="tipoAccion == 3">
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
                                    <i class="fa fa-times bscdelete" v-if="buscarproductos.length" @click="buscarproductos='',nombredet='', listarproductos(), idproducto=null"></i>
                                </template>
                            </div>
                        </div>           
                        <div class="col-lg-5 col-md-6 col-sm-12">
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
                                    <input type="text" class="form-control text-center validarn" v-model="cantidaddet" onkeypress="return filterFloat(event,this);">
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
                                        <span class="input-group-text" id="basic-addon1">$</span>
                                    </div>
                                    <input type="text" class="form-control text-center" v-model="preciodet" onkeypress="return filterFloat(event,this);">
                                    <div v-show="error">
                                        <div v-for="err in errorpreciodet" :key="err" v-text="err" class="errorcamp"></div>
                                    </div>
                                </div>
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
                                                <th scope="col">Comentario</th>
                                                <th scope="col">Can.</th>
                                                <th scope="col">Precio</th>
                                                <th scope="col">Total</th>
                                                <th scope="col">Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody class="cambiable">
                                                <tr v-for="(entrada, index) in arrayop">
                                                    <td v-if="entrada.codigo">
                                                        <template v-if="entrada.codigo!='undefined'">
                                                            {{entrada.codigo}}
                                                        </template>
                                                        <template v-else>
                                                            Sin Código
                                                        </template>
                                                    </td>
                                                    <td v-else>
                                                            Sin Código
                                                    </td>
                                                    <td v-if="entrada.nombre">
                                                        <template v-if="entrada.nombre!='undefined'">
                                                            <template v-if="entrada.nombre.length>=50">
                                                                <div class="tooltipss" >
                                                                    {{entrada.nombre.substring(0, 50)}}...
                                                                    <span>{{entrada.nombre}}</span>
                                                                </div>
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
                                                    <td v-if="entrada.comentario">
                                                        <template v-if="entrada.comentario!='undefined'">
                                                            <template v-if="entrada.comentario.length>=85">
                                                                <div class="tooltipss" >
                                                                    {{entrada.comentario.substring(0, 85)}}...
                                                                    <span>{{entrada.comentario}}</span>
                                                                </div>
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
                                                    <td>${{entrada.precioVenta | dec}}</td>
                                                    <td>${{entrada.precioVenta*entrada.cantidad | dec}}</td>
                                                    <td>
                                                        <a href="javascript:void(0)" style="color:#000;" title="Editar" @click="abrirlista(entrada,index)"> <i class="fas fa-pencil-alt m-r-5"></i> </a>
                                                        <a href="javascript:void(0)" title="Eliminar" @click="eliminarlista(index)"> <i class="fas fa-window-close text-danger"></i> </a>
                                                        
                                                    </td>
                                                </tr>
                                        </tbody>
                                        <tfoot>
                                            </tr>
                                                <td class="b-0" colspan="3"></td>
                                                <td class="text-right b pr-2 p-0 b-1" colspan="2">SUBTOTAL</td>
                                                <td class="pr-2 p-0 b-1" colspan="2">${{subTotal | decf}}</td>
                                            </tr>
                                            </tr>
                                                <td class="b-0" colspan="3"></td>
                                                <td class="text-right b pr-2 p-0 b-1" colspan="2">
                                                    <div style="position: absolute;margin-left: 7px;">
                                                        <input type="checkbox" class="form-check-input" id="subtotal2" v-model="siniva">
                                                        <label class="form-check-label" for="subtotal2">sin iva</label>
                                                    </div>
                                                    IVA
                                                </td>
                                                <td class="pr-2 p-0 b-1" v-if="iva && !siniva" colspan="2">${{iva | decf}}</td>
                                                <td class="pr-2 p-0 b-1" v-else colspan="2">$0.00</td>
                                            </tr>
                                            </tr>
                                                <td class="b-0" colspan="3"></td>
                                                <td class="text-right b pr-2 p-0 b-1" colspan="2">TOTAL</td>
                                                <td class="pr-2 p-0 b-1" v-if="total && !siniva" colspan="2">${{total | decf}}</td>
                                                <td class="pr-2 p-0 b-1" v-else-if="total && siniva" colspan="2">${{subTotal | decf}}</td>
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
                                <label for="exampleFormControlInput1">Fecha estimada</label>
                                <input type="date" class="form-control" v-model="fechaEstimada">
                                <div v-show="error">
                                    <div v-for="err in errorfechaEstimada" :key="err" v-text="err" class="errorcamp"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-1 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">OP.</label>
                                <input v-if="checked" type="text" class="form-control" v-model="solover"  disabled onkeypress="return filterFloat(event,this);">
                                <input v-else type="text" class="form-control" v-model="idOrdPedido" @blur="verdatosop(idOrdPedido)" onkeypress="return filterFloat(event,this);">
                                <div v-show="error">
                                    <div v-for="err in errorop" :key="err" v-text="err" class="errorcamp"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">O.Compra</label>
                                <input type="text" class="form-control" v-model="ordCompra" onkeypress="return filterFloat(event,this);">
                                <div v-show="error">
                                    <div v-for="err in errorordCompra" :key="err" v-text="err" class="errorcamp"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
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
                                    <i class="fa fa-times bscdelete" @click="buscarclientes='', listarclientes(), idPersona=null"></i>
                                </template>
                                <div v-show="error">
                                    <div v-for="err in erroridPersona" :key="err" v-text="err" class="errorcamp"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Persona solicitante</label>
                                <select class="form-control" id="exampleFormControlSelect1" v-model="idEmpleado">
                                    <option value="">Seleccione la persona</option>
                                    <template v-for="empleado in empleados"> 
                                        <option id="buscaroptn" value="">Slecciona una persona</option>
                                        <template v-for="empleado in empleados">
                                            <option v-bind:value="empleado.idempleado">{{empleado.nombres}} {{empleado.apellidos}}</option>  
                                        </template>
                                    </template>
                                </select>
                                <div v-show="error">
                                    <div v-for="err in erroridEmpleado" :key="err" v-text="err" class="errorcamp"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-7 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Proveedor</label>
                                <input type="text" class="form-control" v-model="buscarproveedores" @keyup="listarproveedores()" autocomplete="off">
                                <template v-if="buscarproveedores">
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
                                <label for="exampleFormControlInput1">Ruc</label>
                                <input type="text" class="form-control" placeholder="Sin RUC" v-bind:value="RUC" readonly>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12" v-if="tipoAccion==1">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Dirección</label>
                                <input type="text" class="form-control" placeholder="Sin dirección" v-bind:value="direccion" readonly>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-12" v-if="tipoAccion==1">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Teléfono</label>
                                <input type="text" class="form-control" placeholder="Sin teléfono" v-bind:value="telefono1" readonly>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-12" v-if="tipoAccion==1">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Celular</label>
                                <input type="text" class="form-control" placeholder="Sin celular" v-bind:value="celular" readonly>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Comentario</label>
                                <textarea type="text" class="form-control" rows="3" v-model="comentarioV"></textarea>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Descripción</label>
                                <textarea type="text" class="form-control" rows="3" v-model="descripcionp"></textarea>
                            </div>
                        </div>
                        <template v-if="arrayop.length && tipoAccion==1">
                            <div class="col-lg-12 col-md-12 col-sm-12 mt-2">
                                <div class="table-responsive">
                                    <table class="table text-center tableborderw tabledtb">
                                        <thead>
                                            <tr>
                                                <th scope="col">Nombre</th>
                                                <th scope="col">Comentario</th>
                                                <th scope="col">Can.</th>
                                                <th scope="col">Precio</th>
                                                <th scope="col">Total</th>
                                                <th scope="col" v-if="sesion[0].IDUSUARIO==45">Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody class="cambiable">
                                                <tr v-for="(entrada, index) in arrayop">
                                                    <td v-if="entrada.nombre">
                                                        <template v-if="entrada.nombre!='undefined'">
                                                            <template v-if="entrada.nombre.length>=50">
                                                                <div class="tooltipss" >
                                                                    {{entrada.nombre.substring(0, 50)}}...
                                                                    <span>{{entrada.nombre}}</span>
                                                                </div>
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
                                                    <td v-if="entrada.comentario">
                                                        <template v-if="entrada.comentario!='undefined'">
                                                            <template v-if="entrada.comentario.length>=85">
                                                                <div class="tooltipss" >
                                                                    {{entrada.comentario.substring(0, 85)}}...
                                                                    <span>{{entrada.comentario}}</span>
                                                                </div>
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
                                                    <td>${{entrada.precioVenta | dec1}}</td>
                                                    <td>${{entrada.precioVenta*entrada.cantidad | dec}}</td>
                                                    <td v-if="sesion[0].IDUSUARIO==45">
                                                        <a href="javascript:void(0)" style="color:#000;" title="Editar" @click="abrirlista(entrada,index)"> <i class="fas fa-pencil-alt m-r-5"></i> </a>
                                                        <a href="javascript:void(0)" title="Eliminar" @click="eliminarlista(index)"> <i class="fas fa-window-close text-danger"></i></a>
                                                    </td>
                                                </tr>
                                        </tbody>
                                        <tfoot>
                                            </tr>
                                                <td class="b-0" colspan="2"></td>
                                                <td class="text-right b pr-2 p-0 b-1" colspan="2">SUBTOTAL</td>
                                                <td class="pr-2 p-0 b-1" colspan="2">${{subTotal | decf}}</td>
                                            </tr>
                                            </tr>
                                                <td class="b-0" colspan="2"></td>
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
                                                <td class="b-0" colspan="2"></td>
                                                <td class="text-right b pr-2 p-0 b-1" colspan="2">TOTAL</td>
                                                <td class="pr-2 p-0 b-1" v-if="total && !siniva" colspan="2">${{total | dec}}</td>
                                                <td class="pr-2 p-0 b-1" v-else-if="total && siniva" colspan="2">${{subTotal | decf}}</td>
                                                <td class="pr-2 p-0 b-1" v-else-if="!total">$0.00</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </template>
                        <template v-if="recdetop.length && tipoAccion==1">
                            <div class="col-lg-12 col-md-12 col-sm-12 mt-2">
                                <div class="table-responsive">
                                <table class="table text-center tableborderw tabledtb">
                                        <thead>
                                            <tr>
                                                <th scope="col">Sel</th>
                                                <th scope="col">Código</th>
                                                <th scope="col">Nombre</th>
                                                <th scope="col">Cantidad</th>
                                                <th scope="col">Pendiente</th>
                                                <th scope="col">Precio</th>
                                                <th scope="col">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody class="cambiable">
                                            <tr v-for="entrada in recdetop">
                                                <td>
                                                    <input type="checkbox" class="form-check-input" v-bind:value="entrada.idDetOrdPedido" v-bind:id="entrada.idDetOrdPedido" v-model="escogerdetop">
                                                    <label class="custom-control-label" v-bind:for="entrada.idDetOrdPedido"></label>
                                                </td>
                                                <td>{{entrada.codigo}}</td>
                                                <td v-if="entrada.nombre" style="cursor:pointer;" @click="copiarcod(entrada.nombre)">
                                                    <template v-if="entrada.nombre!='undefined'">
                                                        <template v-if="entrada.nombre.length>=50">
                                                            <div class="tooltipss">
                                                                {{entrada.nombre.substring(0, 50)}}...
                                                                <span>{{entrada.nombre}}</span>
                                                            </div>
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
                                                <td>{{entrada.cantidad}}</td>
                                                <td>{{entrada.pendiente}}</td>
                                                <td>{{entrada.precioVenta}}</td>
                                                <td>{{entrada.precioVenta*entrada.pendiente}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </template>
                        <template v-if="entradasdetalle && tipoAccion==2">
                            <div class="col-lg-12 col-md-12 col-sm-12 mt-2">
                                <div class="table-responsive">
                                    <table class="table text-center tableborderw tabledtb">
                                        <thead>
                                            <tr>
                                                <th scope="col">Código</th>
                                                <th scope="col">Nombre</th>
                                                <th scope="col">Comentario</th>
                                                <th scope="col">Can.</th>
                                                <th scope="col">Precio</th>
                                                <th scope="col">Total</th>
                                                <th scope="col" v-if="sesion[0].IDUSUARIO==45"><i class="fas fa-window-close"></i></th>
                                            </tr>
                                        </thead>
                                        <tbody class="cambiable">
                                                <tr v-for="entrada in entradasdetalle">
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
                                                                    <span>{{entrada.descripcion}}</span>
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
                                                    <td v-if="entrada.comentario">
                                                        <template v-if="entrada.comentario!='undefined'">
                                                            <template v-if="entrada.comentario.length>=85">
                                                                <div class="tooltipss" >
                                                                    {{entrada.comentario.substring(0, 85)}}...
                                                                    <span>{{entrada.comentario}}</span>
                                                                </div>
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
                                                    <td>{{entrada.cantidad | dec1}}</td> 
                                                    <td v-if="entrada.costo">${{entrada.costo | dec}}</td>
                                                    <td v-else>$0.00</td>
                                                    <td>${{entrada.costo*entrada.cantidad | dec}}</td>
                                                    <td v-if="sesion[0].IDUSUARIO==45">
                                                        <a href="javascript:void(0)" title="Eliminar" @click="eliminardetalle(entrada.idDetCompra, entrada.idOrdCompra, entrada.cantidad, entrada.costo)"> <i class="fas fa-window-close text-danger"></i> </a>
                                                    </td>
                                                </tr>
                                        </tbody>
                                        <tfoot>
                                            </tr>
                                                <td class="b-0" colspan="2"></td>
                                                <td class="text-right b pr-2 p-0 b-1" colspan="2">SUBTOTAL</td>
                                                <td class="pr-2 p-0 b-1" colspan="2" v-if="subTotal">${{subTotal | decf}}</td>
                                                <td class="pr-2 p-0 b-1" colspan="2" v-else>$0.00</td>
                                            </tr>
                                            </tr>
                                                <td class="b-0" colspan="2"></td>
                                                <td class="text-right b pr-2 p-0 b-1" colspan="2">
                                                    <div style="position: absolute;margin-left: 7px;">
                                                        <input type="checkbox" class="form-check-input" id="subtotal1" v-model="siniva" @change="cambiariva()">
                                                        <label class="form-check-label" for="subtotal1">sin iva</label>
                                                    </div>
                                                    IVA
                                                </td>
                                                <td class="pr-2 p-0 b-1" colspan="2" v-if="iva && !siniva">${{iva | decf}}</td>
                                                <td class="pr-2 p-0 b-1" colspan="2" v-else>$0.00</td>
                                            </tr>
                                            </tr>
                                                <td class="b-0" colspan="2"></td>
                                                <td class="text-right b pr-2 p-0 b-1" colspan="2">TOTAL</td>
                                                <td class="pr-2 p-0 b-1" colspan="2" v-if="total && !siniva">${{total | decf}}</td>
                                                <td class="pr-2 p-0 b-1" colspan="2" v-else-if="total && siniva">${{subTotal | decf}}</td>
                                                <td class="pr-2 p-0 b-1" colspan="2" v-else-if="!total">$0.00</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </template>
                        <template v-if="recdetop.length && tipoAccion==2">
                            <div v-if="recdetop" class="col-lg-12 col-md-12 col-sm-12 mt-2">
                                <div class="table-responsive">
                                <table class="table text-center tableborderw tabledtb">
                                        <thead>
                                            <tr>
                                                <th scope="col">Código</th>
                                                <th scope="col">Nombre</th>
                                                <th scope="col">Cantidad</th>
                                                <th scope="col">Precio</th>
                                                <th scope="col">Total</th>
                                                <th scope="col" v-if="sesion[0].IDUSUARIO==45 || sesion[0].IDUSUARIO==15">Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody class="cambiable">
                                            <tr v-for="entrada in recdetop">
                                                <td>{{entrada.codigo}}</td>
                                                <td v-if="entrada.nombre">
                                                    <template v-if="entrada.nombre!='undefined'">
                                                        <template v-if="entrada.nombre.length>=50">
                                                            <div class="tooltipss">
                                                                {{entrada.nombre.substring(0, 50)}}...
                                                                <span>{{entrada.nombre}}</span>
                                                            </div>
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
                                                <td><input type="text" class="form-control text-center" style="width: 75px;" v-bind:value="entrada.cantidad" v-bind:name="'test'+entrada.id" @blur="cambiarcantdop(entrada.id, entrada.idoc)"></td>
                                                <td>{{entrada.precio}}</td>
                                                <td>{{entrada.precio*entrada.cantidad}}</td>
                                                <td v-if="sesion[0].IDUSUARIO==45 || sesion[0].IDUSUARIO==15">
                                                    <a href="javascript:void(0)" title="Eliminar" @click="eliminardelistadet(entrada.id, entrada.idoc)"> <i class="fas fa-window-close text-danger"></i> </a>
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
                    <button type="button" class="btn btn-primary" v-if="tipoAccion==2 && sesion[0].IDUSUARIO==15" @click="abrirmodelosmas()">Agregar Detalle</button>
                    <button type="button" class="btn btn-primary" v-if="tipoAccion==6 && (sesion[0].IDUSUARIO==45 || sesion[0].IDUSUARIO==15 || sesion[0].IDUSUARIO==28 || sesion[0].IDUSUARIO ==58)" @click="abrirmodelosmas1()">Agregar Detalle</button>
                    <button type="button" class="btn btn-primary" v-if="tipoAccion==3" @click="registrar(),tipoAccion=1">Guardar</button>
                    <button type="button" class="btn btn-primary" v-if="tipoAccion==3" @click="tipoAccion=1">Atras</button>
                    <button type="button" class="btn btn-primary" v-if="tipoAccion==4" @click="tipoAccion=2">Atras</button>
                    <button type="button" class="btn btn-primary" v-if="tipoAccion==6" @click="masatrasw">Atras</button>
                    <button type="button" class="btn btn-primary" v-if="tipoAccion==2 && sesion[0].IDUSUARIO==15" @click="tipoAccion=4">Agregar Producto</button>
                    <button type="button" class="btn btn-primary" v-if="tipoAccion==1 && (sesion[0].IDUSUARIO==45 || sesion[0].IDUSUARIO==15 || sesion[0].IDUSUARIO==28 || sesion[0].IDUSUARIO ==58 || sesion[0].IDUSUARIO ==76)" @click="tipoAccion=3">Agregar Producto</button>
                    <a v-bind:href="'./impresiones/compra.php?compra='+idOrdCompra" target="_blank" class="btn btn-primary" v-if="tipoAccion==2" @click="abririmpr(idOrdCompra)">Imprimir</a>
                    <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                    <button type="button" class="btn btn-primary" v-if="(sesion[0].IDUSUARIO==45 || sesion[0].IDUSUARIO==15 || sesion[0].IDUSUARIO==28 || sesion[0].IDUSUARIO ==58 || sesion[0].IDUSUARIO ==76) && tipoAccion==2" @click="actualizar()">Actualizar</button>
                    <button type="button" class="btn btn-primary" v-if="(sesion[0].IDUSUARIO==45 || sesion[0].IDUSUARIO==15 || sesion[0].IDUSUARIO==28 || sesion[0].IDUSUARIO ==58 || sesion[0].IDUSUARIO ==76) && tipoAccion==1" @click="registrar()">Guardar</button>
                    <button type="button" class="btn btn-primary" v-if="(sesion[0].IDUSUARIO==45 || sesion[0].IDUSUARIO==15 || sesion[0].IDUSUARIO==28 || sesion[0].IDUSUARIO ==58 || sesion[0].IDUSUARIO ==76) && tipoAccion==3" @click="guardardetops()">Agregar Producto</button>
                    <button type="button" class="btn btn-primary" v-if="(sesion[0].IDUSUARIO==45 || sesion[0].IDUSUARIO==15 || sesion[0].IDUSUARIO==28 || sesion[0].IDUSUARIO ==58 || sesion[0].IDUSUARIO ==76) && tipoAccion==4" @click="guardardetops1()">Agregar Producto</button>
                    <button type="button" class="btn btn-primary" v-if="(sesion[0].IDUSUARIO==45 || sesion[0].IDUSUARIO==15 || sesion[0].IDUSUARIO==28 || sesion[0].IDUSUARIO ==58 || sesion[0].IDUSUARIO ==76) && tipoAccion==5" @click="actualizardetuno()">Actualizar</button>
                </div>
            </div>
        </div>
    </div>
<?php
    include 'modulo/chat.php';
    include 'modulo/foot.php';
    include 'modulo/footer.php';
?> 
<script src="static/js/vueordcompra.js"></script> 
</div>
</body>
</html>