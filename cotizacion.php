<?php
    include 'modulo/head.php';
    include 'modulo/menu_top.php';
    include 'modulo/menu_left.php';
    include 'modulo/preloader.php';
?>
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0">Cotización</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="./">Inicio</a></li>
                <li class="breadcrumb-item active">Cotización</li>
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
                    <!--Principal vista de todas las cotizaciones-->
                    <div class="row mb-3" v-if="!agregarstocker">
                        <div class="col-lg-4 col-md-6 col-sm-12 form-material" >
                            <input type="text" class="form-control" v-on:keyup.enter="hj=1,listar()" v-model="buscar" placeholder="Buscar..." v-if="!vercotizacion"/>
                            <i class="fa fa-search imgbuscar" @click="hj=1,listar()" v-if="!vercotizacion"></i>
                            <template v-if="buscar" v-if="!vercotizacion"><i class="fa fa-times imgdelete" @click="buscar='',hj=1,listar()"></i></template> 
                            <button v-if="vercotizacion" type="button" class="btn btn-info btn-rounded mr-3"  @click="actualizarcotil()">
                                Actualizar Cotización
                            </button>
                            <!--<button type="button" v-if="vercotizacion && !agregarstocker" class="btn btn-primary">Actualizar Cotización</button>-->
                        </div>
                        <div class="col-lg-8 col-md-6 col-sm-12" v-if="!vercotizacion">
                            <button type="button" class="btn btn-info btn-rounded" style="float:right;" @click="abrirModal('cotizacion','registrar')">
                                Nueva cotización
                            </button>
                            <div class="btn-group mr-3" style="float:right;" v-if="sesion[0].IDUSUARIO==3 || sesion[0].IDUSUARIO ==5 || sesion[0].IDUSUARIO ==73">
                                <button type="button" class="btn btn-danger dropdown-toggle pl-5 pr-5" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-file"></i>  Archivos 
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" target="_top" href="modelo/cotizacion/reporte.php">Desc. Cotización</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8 col-md-6 col-sm-12" v-if="vercotizacion">
                            <button type="button" class="btn btn-info btn-rounded" style="float:right;" @click="buscarstock='',vercotizacion=2,agregarstocker=1,buscarfiltro='',buscargeneral='',cprecios='DIST',stockminimo= null,stockmaximo=null,costominimo=null,costomaximo=null,color='',listarstock()">
                                Agregar Producto
                            </button>
                            <button type="button" class="btn btn-info btn-rounded mr-3" style="float:right;" @click="vercotizacion=null">
                                Volver a Cotizaciones
                            </button>
                            <a class="btn btn-info btn-rounded mr-2" v-if="sesion[0].IDUSUARIO==51" v-bind:href="'http://<?=$_SERVER['HTTP_HOST']?>/impresiones/cotizacionp.php?cotizacion='+idCotizacion" target="_blank" title="Imprimir" v-tippy="{ position : 'top',  arrow: true, size: 'small' }" class="edit" style="float:right;"><i class="fas fa-print text-inverse" style="color:#fff!important;"></i> </a>
                            <a class="btn btn-info btn-rounded mr-2" v-if="sesion[0].IDUSUARIO!=51" v-bind:href="'http://<?=$_SERVER['HTTP_HOST']?>/impresiones/cotizacion.php?cotizacion='+idCotizacion" target="_blank" title="Imprimir" v-tippy="{ position : 'top',  arrow: true, size: 'small' }" class="edit" style="float:right;"><i class="fas fa-print text-inverse" style="color:#fff!important;"></i> </a>
                        </div>
                    </div>
                    <!--Principal vista de todas las cotizaciones-->
                    <div class="table-responsive" v-if="!vercotizacion">
                        <table class="table table-striped mb-0" style="font-size: 14px;">
                            <thead>
                                <tr>
                                    <th class="text-center">Número</th>
                                    <th class="text-center">Fecha de creación</th>
                                    <th>Empleado</th>
                                    <th>Cliente</th>
                                    <th>Contacto</th>
                                    <!--<th>Observacion</th>
                                    <th>Comentario</th>--> 
                                    <th>Subtotal</th> 
                                    <th class="text-center">Acciónes</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template v-if="$.trim(entradas.length)>=1")>
                                    <tr  v-for="entrada in entradas">
                                        <td class="text-center">{{entrada.idCotizacion}}</td>
                                        <td style="width: 13rem" class="text-center">{{moment(String(entrada.fecha)).format('LLL')}}</td>
                                        <td>{{entrada.empleado}}</td>
                                        <td>{{entrada.cliente}}</td>
                                        <td v-if="entrada.contacto" class="text-center">{{entrada.contacto}}</td>
                                        <td v-else class="text-center">-</td>
                                        <!--<td v-if="entrada.observacion"><span class="backgroundvista quest vermas" style="width: 90px!important;" v-tippy="{ html : '#observacion'  , interactive : true, reactive : true }">observación <vue-component-test id="observacion"><div style="white-space:pre-line;max-width:400px;">{{entrada.observacion}}</div></vue-component-test> </span></td>
                                        <td v-else class="text-center">-</td>
                                        <td v-if="entrada.comentario"><span class="backgroundvista quest vermas" style="width: 90px!important;" v-tippy="{ html : '#comentario'  , interactive : true, reactive : true }">comentario <vue-component-test id="comentario"><div style="white-space:pre-line;max-width:400px;">{{entrada.comentario}}</div></vue-component-test> </span></td>
                                        <td v-else class="text-center">-</td>-->
                                        <td v-if="entrada.subTotal">${{entrada.vsubt | dec1}}</td>
                                        <td v-else class="text-center">-</td> 
                                        <td class="text-nowrap p-0 m-0 text-center"> 
                                            <a href="javascript:void(0)" title="Editar" v-tippy="{ position : 'top',  arrow: true, size: 'small' }" class="edit" @click="vercotizacion=entrada.idCotizacion, datos(entrada),listardetalle(entrada.idCotizacion)"><i class="fas fa-pencil-alt text-inverse m-r-3"></i> </a>
                                            <a v-if="sesion[0].IDUSUARIO==51" v-bind:href="'http://<?=$_SERVER['HTTP_HOST']?>/impresiones/cotizacionp.php?cotizacion='+entrada.idCotizacion" target="_blank" title="Imprimir" v-tippy="{ position : 'top',  arrow: true, size: 'small' }" class="edit"><i class="fas fa-print text-inverse m-r-3"></i></a>
                                            <a v-else v-bind:href="'http://<?=$_SERVER['HTTP_HOST']?>/impresiones/cotizacion.php?cotizacion='+entrada.idCotizacion" target="_blank" title="Imprimir" v-tippy="{ position : 'top',  arrow: true, size: 'small' }" class="edit"><i class="fas fa-print text-inverse m-r-3"></i></a>
                                            <a v-if="sesion[0].IDUSUARIO!=51" v-bind:href="'http://<?=$_SERVER['HTTP_HOST']?>/impresiones/cotizaciond.php?cotizacion='+entrada.idCotizacion" @click="generarpdfc()" target="_top" title="Descargar" v-tippy="{ position : 'top',  arrow: true, size: 'small' }" class="edit"><i class="fas fa-save text-inverse m-r-3"></i></a>
                                            <a href="javascript:void(0)" title="Eliminar" v-tippy="{ position : 'top',  arrow: true, size: 'small' }" @click="eliminar(entrada.idCotizacion)" > <i class="fas fa-window-close text-danger"></i> </a>
                                        </td>
                                    </tr>
                                </template>
                                                                            <!--<a href="javascript:void(0)" title="Enviar por email" @click="correo(entrada.idCotizacion)" v-tippy="{ position : 'top',  arrow: true, size: 'small' }" class="edit"><i class="fas fa-envelope text-inverse m-r-3"></i> </a>-->
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
                    <div class="mt-4 text-center" v-if="!vercotizacion">
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
                    <!--Detalle ver la cotizacion actual-->
                    <div v-if="vercotizacion && !agregarstocker" class ="mt-4">
                        <div class="row form-material">
                            <div class="col-lg-2 col-md-6 col-sm-12">
                                <div class="form-group" style="margin-bottom: 20px;">
                                    <label for="exampleFormControlInput1">N° Cot.</label>
                                    <input type="text" class="form-control text-center" placeholder="N° Cot." v-model="idCotizacion" disabled>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-12">
                                <div class="form-group" style="margin-bottom: 20px;">
                                    <label for="exampleFormControlInput1">Fecha de creación</label>
                                    <input type="text" class="form-control text-center" placeholder="Fecha de creación" v-model="creacion" disabled>
                                </div>
                            </div>
                            <div class="col-lg-7 col-md-6 col-sm-12">
                                <div class="form-group" style="margin-bottom: 20px;">
                                    <label for="exampleFormControlInput1">Cliente</label>
                                    <input type="text" class="form-control" v-model="buscarclientes" @keyup="listarclientes()">
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
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-12">
                                <div class="form-group" style="margin-bottom: 20px;">
                                    <label for="exampleFormControlInput1">Forma de pago</label>
                                    <select class="form-control selectvend" id="formapagocotn" v-model="formaPago">    
                                        <option value="">Selecciona forma de pago</option>
                                        <option value="50% anticipo 50% contra entrega">50% anticipo 50% contra entrega</option>
                                        <option value="Credito">Credito</option>
                                        <option value="Contraentrega">Contraentrega</option>
                                        <option value="Por definir">Por definir</option>                                                        
                                        <option value="Contado">Contado</option>
                                        <option value="Sin forma de pago">Sin forma de pago</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-5 col-md-6 col-sm-12">
                                <div class="form-group" style="margin-bottom: 20px;">
                                    <label for="exampleFormControlInput1">Empleado</label>
                                    <select class="form-control" id="empleado" v-model="idEmpleado" disabled>
                                        <option v-for="empleado in empleados" v-bind:value="empleado.idempleado">{{empleado.nombres}} {{empleado.apellidos}}</option>  
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="form-group" style="margin-bottom: 20px;">
                                    <label for="exampleFormControlInput1">Contacto</label>
                                    <input type="text" class="form-control text-center" placeholder="Sin contacto" v-model="contacto">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group" style="margin-bottom: 20px;">
                                    <label for="exampleFormControlInput1">Observación (Se mostrará en impresión)</label>
                                    <textarea type="text" class="form-control" placeholder="Sin observación" rows="3" v-model="observacion"></textarea>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group" style="margin-bottom: 20px;">
                                    <label for="exampleFormControlInput1">Comentario</label>
                                    <textarea type="text" class="form-control" placeholder="Sin comentario" rows="3" v-model="comentario"></textarea>
                                </div>
                            </div>

                        </div>
                        <div class="row" v-if="detentradas">
                            <div class="col-lg-12 col-md-12 col-sm-12 mt-4">
                                <div class="table-responsive">
                                    <table class="table text-center tableborderw tabledtb">
                                        <thead>
                                            <tr>
                                                <th scope="col">Código</th>
                                                <th scope="col">Nombre</th>
                                                <th scope="col">Imagen</th>
                                                <th scope="col">Detalle</th>
                                                <th scope="col">Can.</th>
                                                <th scope="col">Precio</th>
                                                <th scope="col">Total</th>
                                                <th scope="col">Acciónes</th>
                                            </tr>
                                        </thead>
                                        <tbody class="cambiable">
                                            <tr v-for="entrada in detentradas">
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
                                                <td class="p-0 m-0" v-if="entrada.linkImagen">
                                                    <img v-bind:src="'imagenes/productossc/'+entrada.linkImagen" title="Ver imagen" v-tippy="{ position : 'top',  arrow: true, size: 'small' }" style="width:100px;height:55px;cursor:pointer;" @click="verimagensc(entrada.linkImagen)">
                                                </td>
                                                <td class="p-0 m-0" v-else>
                                                    <img v-if="entrada.imagen!='sinimagen'" v-bind:src="'imagenes/productos/'+entrada.imagen+'.jpg'" title="Ver imagen" v-tippy="{ position : 'top',  arrow: true, size: 'small' }" style="width:100px;height:55px;cursor:pointer;" @click="verimagen(entrada.codigo)">
                                                    <img v-else v-bind:src="'imagenes/productos/'+entrada.imagen+'.jpg'" style="width:100px;height:55px;"> 
                                                </td>
                                                <td class="text-center" v-if="entrada.detalle">
                                                    <template v-if="entrada.detalle!='undefined'">
                                                        <span v-if="entrada.detalle.length>=55">
                                                            {{entrada.detalle.substring(0, 55)}}... <span class="backgroundvista quest vermas" v-tippy="{ html : '#descripcion'  , interactive : true, reactive : true }">ver mas</span>
                                                            <vue-component-test id="descripcion">
                                                                <div style="white-space:pre-line;max-width:400px;">{{entrada.detalle}}</div>
                                                            </vue-component-test> 
                                                        </span>
                                                        <span v-else>{{entrada.detalle}}</span>
                                                    </template>
                                                    <template v-else>
                                                        Sin detalle
                                                    </template>
                                                </td>
                                                <td class="text-center" v-else>
                                                    Sin detalle
                                                </td>
                                                <td>{{entrada.cant_1}}</td>
                                                <td v-if="entrada.Pvp_1">${{entrada.Pvp_1 | dec}}</td>
                                                <td v-else>$0.00</td>
                                                <td>${{entrada.cant_1*entrada.Pvp_1 | dec}}</td>
                                                <td>
                                                    <a href="javascript:void(0)" v-if="entrada.codigo" title="Editar" v-tippy="{ position : 'top',  arrow: true, size: 'small' }" @click="abrirModal('cotizacion','editar',entrada)"> <i class="fas fa-pencil-alt text-inverse m-r-5"></i> </a>
                                                    <a href="javascript:void(0)" v-else title="Editar1" v-tippy="{ position : 'top',  arrow: true, size: 'small' }" @click="abrirModal('cotizacion','editarc',entrada)"> <i class="fas fa-pencil-alt text-inverse m-r-5"></i> </a>
                                                    <a href="javascript:void(0)" title="Eliminar" v-tippy="{ position : 'top',  arrow: true, size: 'small' }" @click="eliminardetalle(entrada.idDetCotizacion, entrada.idCotizacion,entrada.cant_1*entrada.Pvp_1)"> <i class="fas fa-window-close text-danger"></i> </a>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            </tr>
                                                <td class="b-0" colspan="5"></td>
                                                <td class="text-right b pr-2 p-0 b-1">SUBTOTAL</td>
                                                <td class="pr-2 p-0 b-1" colspan="2" v-if="subTotal">${{subtotalv | dec}}</td>
                                                <td class="pr-2 p-0 b-1" colspan="2" v-else>$0.00</td>
                                            </tr>
                                            </tr>
                                                <td class="b-0" colspan="5"></td>
                                                <td class="text-right b pr-2 p-0 b-1">IVA</td>
                                                <td class="pr-2 p-0 b-1" colspan="2" v-if="iva">${{ivav | dec}}</td>
                                                <td class="pr-2 p-0 b-1" colspan="2" v-else>$0.00</td>
                                            </tr>
                                            </tr>
                                                <td class="b-0" colspan="5"></td>
                                                <td class="text-right b pr-2 p-0 b-1">TOTAL</td>
                                                <td class="pr-2 p-0 b-1" colspan="2" v-if="total">${{totalv | dec}}</td> 
                                                <td class="pr-2 p-0 b-1" colspan="2" v-else>$0.00</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row" v-else>
                            <div class="col-lg-12 col-md-12 col-sm-12 mt-2">
                                <div class="alert alert-warning text-center" role="alert">
                                    SIN PRODUCTOS EN ESTA COTIZACIÓN
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Filtros de puede ver de stock-->
                    <div class="collapse" id="collapseExample" v-if="vercotizacion && agregarstocker">
                        <div class="card card-body">
                            <form method="GET" v-on:submit.prevent="buscarstock='',hjs=1,listarstock()">
                                <div class="row">
                                    <div class="col-lg-7 col-md-12 col-sm-12 form-material mb-3">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <select style="font-size:14px;" class="form-control pr-3" v-model="buscarfiltro" @change="buscargeneral=''">
                                                    <option value="">Debes escoger un filtro ...</option>
                                                    <option value="codigo">Buscar por código</option>
                                                    <option value="nombre">Buscar por nombre</option>
                                                    <option value="descripcion">Buscar por descripcion</option>
                                                    <option value="marca">Buscar por marca</option>
                                                    <option value="descripcion_Categoria">Buscar por categoría</option>
                                                </select>
                                            </div> 
                                            <select style="font-size:13px;" v-if="buscarfiltro=='descripcion_Categoria'" class="form-control pr-3" v-model="buscargeneral" @change="hj=1,listarstock()">
                                                <option value="">Seleccione una categoría</option>
                                                <option v-for="categoria in categorias" v_bind:value="categoria.idCategoria">{{categoria.descripcion}}</option>
                                            </select>
                                            <select style="font-size:13px;" v-else-if="buscarfiltro=='marca'" class="form-control pr-3" v-model="buscargeneral" @change="hj=1,listarstock()">
                                                    <option value="">Seleccione una marca ...</option>
                                                    <option v-for="marca in marcas" v_bind:value="marca.marca">{{marca.marca}}</option>
                                            </select>
                                            <input style="font-size:13px;" v-else type="text" class="form-control pl-3 pr-3" v-model="buscargeneral" placeholder="Buscar...">
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-12 col-sm-12 form-material mb-3">
                                        <input style="font-size:13px;" type="text" class="form-control text-center" v-model="color" placeholder="Buscar por color">
                                    </div>
                                    <div class="col-lg-1 col-md-6 col-sm-12 form-material mb-3">
                                        <button style="font-size:13px;padding: 7px 5px;width:100%" class="btn btn-info btn-roundeds mr-3">Buscar</button>
                                    </div>
                                    <div class="col-lg-2 col-md-6 col-sm-12 form-material mb-3">
                                        <button style="font-size:13px;padding: 7px 5px;width:100%" class="btn btn-info btn-roundeds mr-3" @click="hj=1,borraradv()">Borrar busquedas</button>
                                    </div>
                                    <div class="col-lg-4 col-md-12 col-sm-12 form-material">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">Stock</span>
                                            </div>
                                            <input type="text" class="form-control text-center" v-model="stockminimo" placeholder="Stock minimo">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1"> - </span>
                                            </div>
                                            <input type="text" class="form-control text-center" v-model="stockmaximo" placeholder="Stock máximo">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12 form-material">       
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">Costo</span>
                                            </div>
                                            <select class="form-control cambioasad1 pl-3" v-model="cprecios" style="margin:0;border-left: none;">
                                                <option>P12</option>
                                                <option>P25</option>
                                                <option>P50</option>
                                                <option>P75</option>
                                                <option>P100</option>
                                                <option>P105</option>
                                                <option>P200</option>
                                                <option>P210</option>
                                                <option>P225</option>
                                                <option>P250</option>
                                                <option>P500</option>
                                                <option>P525</option>
                                                <option>P1000</option>
                                                <option>P1050</option>
                                                <option>P2500</option>
                                                <option>P5000</option>
                                                <option>P10000</option>
                                                <option>DIST</option>
                                            </select>
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1"> - </span>
                                            </div>
                                            <input type="text" class="form-control text-center" v-model="costominimo" placeholder="Costo mínimo">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1"> - </span>
                                            </div>
                                            <input type="text" class="form-control text-center" v-model="costomaximo" placeholder="Costo máximo">
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-6 col-sm-12 form-material">
                                        <div class="form-check" style="position: absolute;top: -10px;left: -10px;">
                                            <input class="form-check-input" type="checkbox" id="prdencero" v-model="prdencero" @change="hjs=1,verespeciales()">
                                            <label class="form-check-label" style="font-size: 12px;" for="prdencero">
                                                Ignorar stock en 0
                                            </label>
                                        </div>
                                        <div class="form-check" style="position: absolute;top: 15px;left: -10px;">
                                            <input class="form-check-input" type="checkbox" id="prdennegativo" v-model="prdennegativo" @change="hjs=1,verespeciales()">
                                            <label class="form-check-label" style="font-size: 12px;" for="prdennegativo">
                                                Ignorar stock en negativo
                                            </label>
                                        </div>
                                    </div>        
                                </div>
                            </form>
                        </div>
                    </div>
                    <!--Stock, ver los productos y agregar en cotización-->
                    <div class="row" v-if="vercotizacion && agregarstocker">
                        <div class="col-12">
                            <div class="row mb-3">
                                <div class="col-lg-3 col-md-6 col-sm-12 form-material">
                                    <input type="text" class="form-control" v-on:keyup.enter="hjs=1,listarstock()" v-model="buscarstock" placeholder="Buscar..."/>
                                    <i class="fa fa-search imgbuscar" @click="hjs=1,listarstock()"></i>
                                    <template v-if="buscarstock"><i class="fa fa-times imgdelete" @click="buscarstock='',hjs=1,listarstock()"></i></template> 
                                </div>
                                <div class="col-lg-9 col-md-6 col-sm-12">
                                    <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                                        busqueda avanzada
                                    </a>
                                    <button type="button" class="btn btn-info btn-rounded" style="float:right;" @click="agregarstocker=0">
                                        Ver Detalles
                                    </button>
                                    <button type="button" class="btn btn-info btn-rounded mr-2" style="float:right;" @click="nuevos()">
                                        Nuevo productos
                                    </button>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped mb-0 ov-h">
                                    <thead>
                                        <tr>
                                            <th>Código</th>
                                            <th style="min-width: 170px;">Nombre</th>
                                            <th>Imagen</th>
                                            <th style="width: 26rem;">Descripción</th>
                                            <th title="Ordenar por stock" v-tippy="{ position : 'top',  arrow: true, size: 'small' }" @click="hjs=1,lisstockls(),listarstock()" style="cursor:pointer;">Stock<i class="fas fa-chevron-up ml-1" v-if="lisstockl==1"></i><i class="fas fa-chevron-down ml-1" v-if="lisstockl==2"></i></th> 
                                            <th class="text-center" style="width: 8rem;">Precio</th> 
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <template v-if="entradasstock">
                                            <tr v-for="entrada in entradasstock">
                                                <td class="backgroundvista quest text-center" @click="agregaracotizacion(entrada)" title="Agregar a cotización" v-tippy="{ position : 'top',  arrow: true, size: 'small' }">
                                                    {{entrada.codigo}}
                                                </td>
                                                <td v-if="entrada.nombre.length>=19">
                                                    {{entrada.nombre.substring(0, 19)}}... <span class="backgroundvista quest vermas" v-tippy="{ html : '#nombred'  , interactive : true, reactive : true }">ver mas</span>
                                                    <vue-component-test id="nombred">
                                                        <div style="white-space:pre-line;max-width:400px;">{{entrada.nombre}}</div>
                                                    </vue-component-test> 
                                                </td> 
                                                <td v-else>
                                                    {{entrada.nombre}}  
                                                </td>
                                                <td>
                                                    <img v-if="entrada.imagen!='sinimagen'" v-bind:src="'imagenes/productos/'+entrada.imagen+'.jpg'" title="Ver imagen" v-tippy="{ position : 'top',  arrow: true, size: 'small' }" style="width:100px;height:55px;cursor:pointer;" @click="verimagen(entrada.codigo)">
                                                    <img v-else v-bind:src="'imagenes/productos/'+entrada.imagen+'.jpg'" style="width:100px;height:55px;"> 
                                                </td > 
                                                <template v-if="entrada.descripcion">
                                                    <td v-if="entrada.descripcion.length>=63">
                                                        {{entrada.descripcion.substring(0, 63)}}... <span class="backgroundvista quest vermas" v-tippy="{ html : '#descripcion'  , interactive : true, reactive : true }">ver mas</span>
                                                        <vue-component-test id="descripcion">
                                                            <div style="white-space:pre-line;max-width:400px;">{{entrada.descripcion}}</div>
                                                        </vue-component-test> 
                                                    </td> 
                                                    <td v-else>{{entrada.descripcion}}</td>
                                                </template>
                                                <template v-else>
                                                    <td>Sin descripción</td>
                                                </template>
                                                <td class="text-center" v-if="entrada.dmuestras<=0">{{entrada.stock}}</td>
                                                <td class="text-center" v-tippy="{ html : '#vermuestra'  , interactive : true, reactive : true }" @mouseover="listarmuestras(entrada.idProducto)" v-else style="background: rgba(192, 202, 43, 0.54);">
                                                    {{entrada.stock}}
                                                    <vue-component-test id="vermuestra">
                                                        <div class="text-center mb-1">Muestras</div>
                                                        <div v-for="muestra in muestras" style="cursor:pointer">
                                                            <div class="mb-1">N.Entrega {{muestra.numero}} con Cantidad de {{muestra.salida - muestra.entrada}}</div>
                                                        </div>
                                                    </vue-component-test> 
                                                </td>
                                                <td class="backgroundvista text-center quest">
                                                    <span v-tippy="{ html : '#precio'  , interactive : true, reactive : true }">Ver precios</span>
                                                    <vue-component-test id="precio">
                                                        <template v-if="entrada.P12>0"><div class="col-lg-12">12 Unidades: <b>${{entrada.P12}}</b> </div></template>
                                                        <template v-if="entrada.P25>0"><div class="col-lg-12">25 Unidades: <b>${{entrada.P25}}</b> </div></template>
                                                        <template v-if="entrada.P50>0"><div class="col-lg-12">50 Unidades: <b>${{entrada.P50}}</b> </div></template>
                                                        <template v-if="entrada.P75>0"><div class="col-lg-12">75 Unidades: <b>${{entrada.P75}}</b> </div></template>
                                                        <template v-if="entrada.P100>0"><div class="col-lg-12">100 Unidades: <b>${{entrada.P100}}</b> </div></template>
                                                        <template v-if="entrada.P105>0"><div class="col-lg-12">105 Unidades: <b>${{entrada.P105}}</b> </div></template>
                                                        <template v-if="entrada.P200>0"><div class="col-lg-12">200 Unidades: <b>${{entrada.P200}}</b> </div></template>
                                                        <template v-if="entrada.P210>0"><div class="col-lg-12">210 Unidades: <b>${{entrada.P210}}</b> </div></template>
                                                        <template v-if="entrada.P225>0"><div class="col-lg-12">225 Unidades: <b>${{entrada.P225}}</b> </div></template>
                                                        <template v-if="entrada.P250>0"><div class="col-lg-12">250 Unidades: <b>${{entrada.P250}}</b> </div></template>
                                                        <template v-if="entrada.P300>0"><div class="col-lg-12">300 Unidades: <b>${{entrada.P300}}</b> </div></template>
                                                        <template v-if="entrada.P500>0"><div class="col-lg-12">500 Unidades: <b>${{entrada.P500}}</b> </div></template>
                                                        <template v-if="entrada.P525>0"><div class="col-lg-12">525 Unidades: <b>${{entrada.P525}}</b> </div></template>
                                                        <template v-if="entrada.P1000>0"><div class="col-lg-12">1000 Unidades: <b>${{entrada.P1000}}</b> </div></template>
                                                        <template v-if="entrada.P1050>0"><div class="col-lg-12">1050 Unidades: <b>${{entrada.P1050}}</b> </div></template>
                                                        <template v-if="entrada.P2500>0"><div class="col-lg-12">2500 Unidades: <b>${{entrada.P2500}}</b> </div></template>
                                                        <template v-if="entrada.P5000>0"><div class="col-lg-12">5000 Unidades: <b>${{entrada.P5000}}</b> </div></template>
                                                        <template v-if="entrada.P10000>0"><div class="col-lg-12">10000 Unidades: <b>${{entrada.P10000}}</b> </div></template> 
                                                        <template v-if="entrada.DIST>0"><div class="col-lg-12">Distribuidor: <b>${{entrada.DIST}}</b> </div></template>
                                                    </vue-component-test>
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
                                <nav aria-label="Page navigation example"style="display: inline-flex;" v-if="entradasstock">
                                    <ul class="pagination mb-0" v-if="entradasstock.lenght>=10">
                                        <template v-if="hjs!=1">
                                            <li class="page-item"><a class="page-link" @click="hjs--,listarstock()" href="javascript:void(0)" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>
                                        </template>
                                        <template v-for="pg in pags">
                                            <template v-if="hjs==pg">
                                                <li class="page-item active"><a class="page-link" @click="hjs=pg,listarstock()" href="javascript:void(0)" v-text="pg"></a></li>
                                            </template> 
                                            <template v-else>
                                                <li class="page-item"><a class="page-link" @click="hjs=pg,listarstock()" href="javascript:void(0)" v-text="pg"></a></li>
                                            </template> 
                                        </template>   
                                        <template v-if="hjs!=pags">
                                            <li class="page-item"><a class="page-link" @click="hjs++,listarstock()" href="javascript:void(0)" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>
                                        </template>
                                    </ul>
                                    <ul class="pagination mb-0" v-else>
                                        <template v-if="hjs!=1">
                                            <li class="page-item"><a class="page-link" @click="hjs--,listarstock()" href="javascript:void(0)" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>
                                        </template>
                                        <template v-else>
                                            <li class="page-item disabled"><a class="page-link" href="javascript:void(0)" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>
                                        </template>
                                        <template v-if="hjs>4">
                                            <li class="page-item"><a class="page-link" @click="hjs=1,listarstock()" href="javascript:void(0)" v-text="1"></a></li>
                                                <template v-if="hjs>10">
                                                    <li class="page-item"><a class="page-link" @click="hjs=hjs-10,listarstock()" href="javascript:void(0)">-10</a></li>
                                                </template>
                                            <li class="page-item disabled"><a class="page-link" @click="hjs=1,listarstock()" href="javascript:void(0)">...</a></li>
                                        </template>
                                        <template v-for="pg in pags">
                                            <template v-if="pg>hjs-3 && pg<hjs+3">
                                                <template v-if="hjs==pg">
                                                    <li class="page-item active"><a class="page-link" @click="hjs=pg,listarstock()" href="javascript:void(0)" v-text="pg"></a></li>
                                                </template>
                                                <template v-else>
                                                    <li class="page-item"><a class="page-link" @click="hjs=pg,listarstock()" href="javascript:void(0)" v-text="pg"></a></li>
                                                </template>   
                                            </template>
                                        </template>   
                                        <template v-if="hjs<pags-2">
                                            <li class="page-item disabled"><a class="page-link" @click="hjs=1,listarstock()" href="javascript:void(0)">...</a></li>
                                                <template v-if="hjs<pags-10">
                                                    <li class="page-item"><a class="page-link" @click="hjs=hjs+10,listarstock()" href="javascript:void(0)">+10</a></li>
                                                </template>
                                            <li class="page-item"><a class="page-link" @click="hjs=pags,listarstock()" href="javascript:void(0)" v-text="pags"></a></li>
                                        </template>
                                        <template v-if="hjs!=pags">
                                            <li class="page-item"><a class="page-link" @click="hjs++,listarstock()" href="javascript:void(0)" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>
                                        </template>
                                        <template v-else>
                                            <li class="page-item disabled"><a class="page-link" href="javascript:void(0)" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>
                                        </template>
                                    </ul>
                                </nav>
                                <div style="font-size: 11px;font-weight:bold;" v-if="entradasstock.length">{{hjs}} de {{pags}} / registos {{entradasstock[0].pag}}</div>
                                <div style="font-size: 11px;" v-else>Sin páginas</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade mirartopmodal" tabindex="-1" :class="{'show mirar':modal}" style="overflow:auto;" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="crmodal" v-if="tipoAccion==11" @click="cerrarModal()"></div>   
        <div class="modal-dialog modal-xl" style="display: flex;" role="document">
            <div class="modal-content" >
                <div class="modal-header"  v-if="tipoAccion!=11">
                    <h5 class="modal-title" id="exampleModalLabel" v-text="tituloModal"></h5>
                    <button type="button" class="close" @click="cerrarModal()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body form-material">
                    <div class="row" v-if="tipoAccion==11">
                        <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                            <img v-bind:src="'imagenes/productos/'+imagen" style="max-width: 100%;max-height: 600px;min-width:80%;" @click="verimagen(entrada.codigo)"> 
                        </div>
                    </div>
                    <div class="row" v-else-if="tipoAccion==12">
                        <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                            <img v-bind:src="'imagenes/productossc/'+imagen" style="max-width: 100%;max-height: 600px;min-width:80%;" @click="verimagen(entrada.codigo)"> 
                        </div>
                    </div>
                    <div class="row" v-else-if="tipoAccion==6">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Quien envía</label>
                                <input type="text" class="form-control" v-model="enviac">
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Quien Recibe</label>
                                <input type="text" class="form-control" v-model="recibec">
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Titulo del mensaje</label>
                                <input type="text" class="form-control" v-model="tituloc">
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Mensaje Para enviar</label>
                                <textarea type="text" class="form-control" rows="5" v-model="mensajec"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row" v-else-if="tipoAccion==5">
                        <div class="col-lg-6 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Cantidad</label>
                                <input type="text" class="form-control" v-model="cantf" onkeypress="return filterFloat(event,this);">
                                <div v-show="error">
                                    <div v-for="err in errorcantf" :key="err" v-text="err" class="errorcamp"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Precio</label>
                                <input type="text" class="form-control" v-model="preciof" onkeypress="return filterFloat(event,this);">
                                <div v-show="error">
                                    <div v-for="err in errorpreciof" :key="err" v-text="err" class="errorcamp"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Detalle</label>
                                <textarea type="text" class="form-control" rows="3" v-model="detallef"></textarea>
                            </div>
                        </div>
                    </div> 
                    <div class="row" v-else-if="tipoAccion==4 || tipoAccion==8">
                        <div class="col-lg-8 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Nombre del producto</label>
                                <input type="text" class="form-control" v-model="nombrenuevo">
                                <div v-show="error">
                                    <div v-for="err in errornombrenuevo" :key="err" v-text="err" class="errorcamp"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Cantidad</label>
                                <input type="text" class="form-control" v-model="cantidadnuevo" onkeypress="return filterFloat(event,this);">
                                <div v-show="error">
                                    <div v-for="err in errorcantidadnuevo" :key="err" v-text="err" class="errorcamp"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Precio</label>
                                <input type="text" class="form-control" v-model="precionuevo" onkeypress="return filterFloat(event,this);">
                                <div v-show="error">
                                    <div v-for="err in errorprecionuevo" :key="err" v-text="err" class="errorcamp"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Detalle</label>
                                <textarea type="text" class="form-control" rows="3" v-model="detallenuevo"></textarea>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Subir imagen</label>
                                <input type="file" @change="imagensubir" name="file" id="file" accept=".jpg,.jpeg,.png">
                            </div>
                        </div>
                    </div>
                    <div class="row" v-else-if="tipoAccion==3">
                        <div class="col-lg-6 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Cantidad</label>
                                <input type="text" class="form-control" v-model="cant_1" @keyup="recp(cant_1)" required onkeypress="return filterFloat(event,this);">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Precio</label>
                                <input type="text" class="form-control" v-model="Pvp_1" required onkeypress="return filterFloat(event,this);">
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Detalle</label>
                                <textarea type="text" class="form-control" rows="3" v-model="detalle"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row" v-else>
                        <div class="col-lg-4 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">fecha</label>
                                <input type="datetime-local" class="form-control" v-model="fecha" disabled>
                                <div v-show="error">
                                    <div v-for="err in errorfecha" :key="err" v-text="err" class="errorcamp"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8 col-md-6 col-sm-12">
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
                                    <div v-for="err in errorbuscarclientes" :key="err" v-text="err" class="errorcamp"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Vendedor</label>
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
                                <label for="exampleFormControlInput1">Contacto</label>
                                <input type="text" class="form-control" v-model="contacto">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Forma de pago</label>
                                <select class="form-control selectvend" id="formapagocotn" v-model="formaPago">    
                                    <option value="">Selecciona forma de pago</option>
                                    <option value="50% anticipo 50% contra entrega">50% anticipo 50% contra entrega</option>
                                    <option value="Credito">Credito</option>
                                    <option value="Contraentrega">Contraentrega</option>
                                    <option value="Por definir">Por definir</option>                                                        
                                    <option value="Contado">Contado</option>
                                    <option value="Sin forma de pago">Sin forma de pago</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Observacion (Se mostrará en impresión)</label>
                                <textarea type="text" class="form-control" rows="4" v-model="observacion"></textarea>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Comentario</label>
                                <textarea type="text" class="form-control" rows="4" v-model="comentario"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">  
                    <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                    <button type="button" class="btn btn-primary" v-if="tipoAccion==3" @click="agregaracotiz()">Agregar</button>
                    <button type="button" class="btn btn-primary" v-if="tipoAccion==1" @click="registrar()">Guardar</button>
                    <button type="button" class="btn btn-primary" v-if="tipoAccion==4" @click="registrarsc()">Agregar a la cotización</button>
                    <button type="button" class="btn btn-primary" v-if="tipoAccion==8" @click="editarc1()">Actualizar</button>
                    <button type="button" class="btn btn-primary" v-if="tipoAccion==5" @click="editarc()">Editar detalle</button>
                    <button type="button" class="btn btn-primary" v-if="tipoAccion==6" @click="enviarcorr()">Enviar correo</button>
                </div>
            </div>
            <div class="modal-content" v-if="tipoAccion==3" style="width:20rem;display:grid;padding-top:15px;">
                <div class="row">
                    <template v-if="P12>0"><div class="col-lg-12 text-center" style="height:35px;">12 Unidades: <b>${{P12}}</b> </div></template>
                    <template v-if="P25>0"><div class="col-lg-12 text-center" style="height:35px;">25 Unidades: <b>${{P25}}</b> </div></template>
                    <template v-if="P50>0"><div class="col-lg-12 text-center" style="height:35px;">50 Unidades: <b>${{P50}}</b> </div></template>
                    <template v-if="P75>0"><div class="col-lg-12 text-center" style="height:35px;">75 Unidades: <b>${{P75}}</b> </div></template>
                    <template v-if="P100>0"><div class="col-lg-12 text-center" style="height:35px;">100 Unidades: <b>${{P100}}</b> </div></template>
                    <template v-if="P105>0"><div class="col-lg-12 text-center" style="height:35px;">105 Unidades: <b>${{P105}}</b> </div></template>
                    <template v-if="P200>0"><div class="col-lg-12 text-center" style="height:35px;">200 Unidades: <b>${{P200}}</b> </div></template>
                    <template v-if="P210>0"><div class="col-lg-12 text-center" style="height:35px;">210 Unidades: <b>${{P210}}</b> </div></template>
                    <template v-if="P225>0"><div class="col-lg-12 text-center" style="height:35px;">225 Unidades: <b>${{P225}}</b> </div></template>
                    <template v-if="P250>0"><div class="col-lg-12 text-center" style="height:35px;">250 Unidades: <b>${{P250}}</b> </div></template>
                    <template v-if="P300>0"><div class="col-lg-12 text-center" style="height:35px;">300 Unidades: <b>${{P300}}</b> </div></template>
                    <template v-if="P500>0"><div class="col-lg-12 text-center" style="height:35px;">500 Unidades: <b>${{P500}}</b> </div></template>
                    <template v-if="P525>0"><div class="col-lg-12 text-center" style="height:35px;">525 Unidades: <b>${{P525}}</b> </div></template>
                    <template v-if="P1000>0"><div class="col-lg-12 text-center" style="height:35px;">1000 Unidades: <b>${{P1000}}</b> </div></template>
                    <template v-if="P1050>0"><div class="col-lg-12 text-center" style="height:35px;">1050 Unidades: <b>${{P1050}}</b> </div></template>
                    <template v-if="P2500>0"><div class="col-lg-12 text-center" style="height:35px;">2500 Unidades: <b>${{P2500}}</b> </div></template>
                    <template v-if="P5000>0"><div class="col-lg-12 text-center" style="height:35px;">5000 Unidades: <b>${{P5000}}</b> </div></template>
                    <template v-if="P10000>0"><div class="col-lg-12 text-center" style="height:35px;">10000 Unidades: <b>${{P10000}}</b> </div></template> 
                    <template v-if="DIST>0"><div class="col-lg-12 text-center" style="height:35px;">Distribuidor: <b>${{DIST}}</b> </div></template>
                </div>
            </div>
        </div>
    </div>
<?php
    include 'modulo/chat.php';
    include 'modulo/foot.php';
    include 'modulo/footer.php';
?> 
<script src="static/js/vuecotizacion.js"></script> 
</div>
</body>
</html>