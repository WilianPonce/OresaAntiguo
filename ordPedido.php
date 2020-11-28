<?php
    include 'modulo/head.php';
    include 'modulo/menu_top.php';
    include 'modulo/menu_left.php';
    include 'modulo/preloader.php';
?>
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0">Orden de Pedido</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                <li class="breadcrumb-item active">Orden de Pedido</li>
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
                        <div class="col-lg-3 col-md-6 col-sm-12 form-material">
                            <input type="text" class="form-control" v-on:keyup.enter="buscarempleados='',hj=1,listar()" v-model="buscar" placeholder="Buscar..."/>
                            <i class="fa fa-search imgbuscar" @click="buscarempleados='',hj=1,listar()"></i>
                            <template v-if="buscar"><i class="fa fa-times imgdelete" @click="buscar='',hj=1,listar()"></i></template> 
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-12 form-material">
                            <select class="form-control" v-if="sesion[0].IDUSUARIO==3 || sesion[0].IDUSUARIO ==5 || sesion[0].IDUSUARIO ==15 || sesion[0].IDUSUARIO ==28 || sesion[0].IDUSUARIO ==58 || sesion[0].IDUSUARIO ==73" id="exampleFormControlSelect1" v-model="buscarempleados" @change="buscar='',listar()">
                                <option value="">Seleccione el vendedor</option>
                                <template v-for="empleado in empleados">
                                    <option v-bind:value="empleado.nombres">{{empleado.nombres}} {{empleado.apellidos}}</option>  
                                </template>
                            </select>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12">
                            <button type="button" v-if="sesion[0].IDUSUARIO ==15 || sesion[0].IDUSUARIO ==28 || sesion[0].ROL =='VENTAS' || sesion[0].IDUSUARIO ==58 || sesion[0].IDUSUARIO ==73" class="btn btn-info btn-rounded" style="float:right;" @click="abrirModal('op','registrar')">
                                Nueva OP
                            </button>
                            <div class="btn-group mr-3" style="float:right;" v-if="sesion[0].IDUSUARIO==3 || sesion[0].IDUSUARIO ==15 || sesion[0].IDUSUARIO==5 || sesion[0].ROL =='CONTABILIDAD' || sesion[0].IDUSUARIO ==28 || sesion[0].IDUSUARIO ==58 || sesion[0].IDUSUARIO ==73">
                                <button type="button" class="btn btn-danger dropdown-toggle pl-5 pr-5" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-file"></i>  Archivos 
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" target="_top" href="modelo/op/reporte.php">Descargar OP</a>
                                    <a class="dropdown-item" target="_top" href="modelo/op/reportea.php">Descargar OP Antiguos</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>O.P.</th>
                                    <!--<th>email_cliente</th>-->
                                    <th style="width: 12rem;">Fecha_emisión</th>
                                    <th>Nombre del Cliente</th>
                                    <th>Subtotal</th>
                                    <th>Iva</th>
                                    <th>Total</th>
                                    <th>Empleado</th> 
                                    <th style="width:6rem">Pagos</th>
                                    <th class="text-center" v-if="sesion[0].IDUSUARIO==15 || sesion[0].IDUSUARIO==28 || sesion[0].IDUSUARIO ==58 || sesion[0].IDUSUARIO ==10 || sesion[0].IDUSUARIO ==57 || sesion[0].IDUSUARIO ==77">Acciónes</th>
                                    <th class="text-nowrap text-center" v-else>Ver</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template v-if="$.trim(entradas)!='error'">
                                    <tr v-for="entrada in entradas" :class="{'faltante':entrada.p-entrada.c<0,'retirado':entrada.p==0}">
                                        <td v-if="entrada.estado_desp" style="background:red;">{{entrada.idOrdPedido}}</td>
                                        <td v-else>{{entrada.idOrdPedido}}</td>
                                        <td>{{entrada.ordPedido}}</td>
                                        <!-- <td style="display:block;width: 175px;">{{entrada.email_cliente}}</td>-->
                                        <td class="text-center">{{moment(String(entrada.fechaEmision)).format('LLL')}}</td>
                                        <td>{{entrada.NOM_CLIENTE}} {{entrada.APE_CLIENTE}}</td>
                                        <td>${{entrada.vsubt | dec1}}</td>
                                        <td>${{(entrada.vsubt*0.12) | dec1}}</td>
                                        <td>${{(parseFloat(entrada.vsubt) + parseFloat(entrada.vsubt*0.12)) | dec1}}</td>
                                        <td>{{entrada.NOM_EMPLE}}</td>
                                        <!--<template v-if="entrada.formaPago=='CREDITO'">
                                            <td style="background: rgba(5, 173, 33, 0.6);text-align: center;color: #fff;" v-if="entrada.mora>=1">{{entrada.mora}} días</td>
                                            <td style="background: rgba(156, 167, 1, 0.6);text-align: center;color: #fff;" v-else-if="entrada.mora==0">Ultimo</td>
                                            <td style="background: rgba(158, 12, 12, 0.6);text-align: center;color: #fff;" v-else-if="entrada.mora==-1">{{entrada.mora.substr(1, 10)}} día</td>
                                            <td style="background: rgba(158, 12, 12, 0.6);text-align: center;color: #fff;" v-else>{{entrada.mora.substr(1, 10)}} días</td>
                                        </template>   
                                        <template v-else>
                                            <td>Sin mora</td>
                                        </template>-->
                                        <td v-if="entrada.fpagos =='CONTRAENTREGA'" class="text-center pagado" style="font-size:11px;padding: 0;margin: 0;">CONTRAENTREGA</td> 
                                        <td v-else-if="entrada.fpagos =='CREDITO'" class="text-center pagado">CRÉDITO</td>
                                        <td v-else-if="entrada.fpagos =='CRUCECUENTA'" class="text-center pagado">CRUCE CTA</td>
                                        <td v-else-if="entrada.fpagos =='ANULADO'" class="text-center pagado">OP ANULADA</td>
                                        <td v-else-if="entrada.pagos" :class="{'pagado':(parseFloat(entrada.pagos)).toFixed(2)>=(parseFloat(entrada.vsubt) + parseFloat(entrada.vsubt*0.12)).toFixed(2),'incompleto':(parseFloat(entrada.pagos)).toFixed(2)<(parseFloat(entrada.vsubt)+parseFloat(entrada.vsubt*0.12)).toFixed(2)}" class="text-center">${{entrada.pagos}}</td>
                                        <td v-else class="text-center sinpago">sin pago</td>   
                                        <td class="text-nowrap" v-if="sesion[0].IDUSUARIO==15 || sesion[0].IDUSUARIO==28 || sesion[0].IDUSUARIO ==58 || sesion[0].IDUSUARIO ==55 || sesion[0].IDUSUARIO ==57 || sesion[0].IDUSUARIO ==10">
                                            <a href="javascript:void(0)" title="Editar" v-tippy="{ position : 'top',  arrow: true, size: 'small' }" @click="abrirModal('op','actualizar',entrada), listarop(entrada.idOrdPedido)"> <i class="fas fa-pencil-alt text-inverse m-r-3"></i> </a>
                                            <a href="javascript:void(0)" title="Agregar pago" v-tippy="{ position : 'top',  arrow: true, size: 'small' }" @click="abrirModal('op','pagar',entrada)"> <i class="fab fa-cc-amazon-pay text-inverse m-r-3"></i> </a>
                                            <a v-bind:href="'modelo/op/excel.php?id='+entrada.idOrdPedido" target="_TOP" v-if="sesion[0].IDUSUARIO==15 || sesion[0].IDUSUARIO ==28 || sesion[0].IDUSUARIO ==58 || sesion[0].IDUSUARIO ==55 || sesion[0].IDUSUARIO ==57 || sesion[0].IDUSUARIO ==10" title="Descargar Excel" v-tippy="{ position : 'top',  arrow: true, size: 'small' }"> <i class="fas fa-table text-inverse m-r-3"></i> </a>
                                            <!--<a href="javascript:void(0)" title="Eliminar" v-tippy="{ position : 'top',  arrow: true, size: 'small' }" @click="eliminar(entrada.idOrdPedido,entrada.ordPedido)" > <i class="fas fa-window-close text-danger"></i> </a>-->
                                        </td>
                                        <td class="text-nowrap text-center" v-else>
                                            <a href="javascript:void(0)" title="Visualizar" v-tippy="{ position : 'top',  arrow: true, size: 'small' }" @click="abrirModal('op','actualizar',entrada), listarop(entrada.idOrdPedido)"> <i class="fas fa-eye text-inverse"></i> </a>
                                            <a v-bind:href="'modelo/op/excel.php?id='+entrada.idOrdPedido" target="_TOP" v-if="sesion[0].IDUSUARIO=73" title="Descargar Excel" v-tippy="{ position : 'top',  arrow: true, size: 'small' }"> <i class="fas fa-table text-inverse m-r-3"></i> </a>
                                            <a v-bind:href="'modelo/op/excel.php?id='+entrada.idOrdPedido" target="_TOP" title="Descargar Excel" v-tippy="{ position : 'top',  arrow: true, size: 'small' }"> <i class="fas fa-table text-inverse m-r-3"></i> </a>
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
                        <nav aria-label="Page navigation example" style="display: inline-flex;" v-if="$.trim(entradas)!='error'">
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
    <div class="modal fade mirartopmodal" tabindex="-1" :class="{'show mirar':modal}" style="overflow:auto;" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <template v-if="sesion[0].IDUSUARIO==27">
            <div class="crmodal" @click="cerrarModal()"></div>
        </template>
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content" id="mydiv">
                <div class="modal-header" id="mydivheader">
                    <h5 class="modal-title" id="exampleModalLabel" v-text="tituloModal"></h5>
                    <button type="button" class="btn btn-primary" style="position: absolute;right: 75px;top: 10px;" v-if="tipoAccion==7 && cambiarlista==0" @click="guardardetops()">Agregar Productos</button>
                    <button type="button" class="close" @click="cerrarModal()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body form-material">
                    <div style="display:none" class="errorww alert alert-warning alert-dismissible fade show" role="alert">
                        <div class="erroresexistentes">
                            <div class="erroresexistentesmas"></div>
                            <div style="display:none" class="aerrorww modal-footer m-0 pt-2 p-0">
                                <span style="position: absolute;left: 25px;">Si estas de acuerdo en que quede en negativo, tiene {{espera}} segundos para continuar</span>
                                <button type="button" class="btn btn-secondary" @click="$('.aerrorww').hide()">Cancelar</button> 
                                <button type="button" class="btn btn-primary" @click="permiso='si',registrar()">Guardar</button> 
                            </div>
                        </div>
                        <button type="button" class="close" @click="$('.errorww').hide()">
                            <span aria-hidden="true" >&times;</span>
                        </button>
                    </div>
                    <div class="row" v-if="tipoAccion == 50">
                        <div class="col-lg-2 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Ord. Pedido</label>
                                <input type="text" class="form-control" v-bind:value="ordPedido" readonly> 
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Cliente</label>
                                <input type="text" class="form-control" v-bind:value="buscarclientes" readonly> 
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Vendedor</label>
                                <input type="text" class="form-control" v-bind:value="NOM_EMPLE" readonly> 
                            </div>
                        </div>
                        <div class="col-lg-9 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Sucursal</label>
                                <input type="text" class="form-control" v-model="sucursualguia" @keyup="listarsucursales()">
                                <template v-if="sucursualguia.length">
                                    <div class="menuw" v-if="listsucursales=='sin'">
                                        <div class="nohay">Ingresa min 3 caracteres</div>
                                    </div>
                                    <div class="menuw" v-else-if="$.trim(listsucursales)=='no'">
                                        <div class="nohay">Sin coincidencias</div> 
                                    </div>
                                    <div class="menuw" v-else-if="listsucursales.length">
                                        <div class="select" v-for="listsucursale in listsucursales" @click="seleccionarsucursal(listsucursale),listsucursales=[]">
                                            {{listsucursale.direccion}}
                                        </div>
                                    </div>
                                    <i class="fa fa-times bscdelete" v-if="buscarproductos.length" @click="sucursualguia='', listarsucursales()"></i>
                                </template> 
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Número de guia</label>
                                <input type="text" class="form-control" v-model="numeroguia" onkeypress="return filterFloat(event,this);">
                                <div v-show="error">
                                    <div v-for="err in errornumeroguia" :key="err" v-text="err" class="errorcamp"></div>
                                </div> 
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Comentario (Se mostrara en la impresiòn)</label>
                                <textarea type="text" class="form-control" rows="3" v-model="comentarioguia"></textarea>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Observaciones</label>
                                <textarea type="text" class="form-control" rows="3" v-model="observacionguia"></textarea>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table text-center tableborderw tabledtb">
                                <thead>
                                    <tr>
                                        <th scope="col">Sel</th>
                                        <th scope="col">Código</th>
                                        <th scope="col">Nombre</th>
                                        <th scope="col">Imagen</th>
                                        <th scope="col">Comentario</th>
                                        <th scope="col">Pend.</th>
                                        <th scope="col">cant.</th>
                                        <th scope="col">Precio</th>
                                        <th scope="col">Total</th>
                                    </tr>
                                </thead>
                                <tbody class="cambiable">
                                    <template v-if="entradasdetop.length">
                                        <tr v-for="(entrada,index) in entradasdetop" :key="entrada.idDetOrdPedido"> 
                                            <td>
                                                <input type="checkbox" class="form-check-input" @change="maxten()" v-model="guialista" :value="entrada" v-bind:id="entrada.idDetOrdPedido">
                                                <label class="custom-control-label" v-bind:for="entrada.idDetOrdPedido"></label>
                                            </td>
                                            <template v-if="sesion[0].IDUSUARIO==15 || sesion[0].IDUSUARIO==28 || sesion[0].IDUSUARIO ==58">
                                                <td v-if="entrada.codigo" @click="copiarcod(entrada.codigo)" style="cursor:pointer;">
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
                                                <td v-else-if="entrada.codigo && entrada.detxg>0" @click="verguias(entrada.idDetOrdPedido)" style="background: #ff00008c;color: #fff;cursor:help;" title="Ver Los números de guia" v-tippy="{ placement : 'top',  arrow: true }" data-toggle="modal" data-target="#guia">
                                                    <template v-if="entrada.codigo!='undefined'">
                                                        {{entrada.codigo}}
                                                    </template>
                                                    <template v-else>
                                                        Sin_código
                                                    </template>
                                                </td>
                                                <td v-else>Sin_código</td>
                                            </template>
                                            <td v-if="entrada.nombre" @click="copiar(entrada.nombre)" style="cursor:pointer;">
                                                <template v-if="entrada.nombre!='undefined'">
                                                    <template v-if="entrada.nombre.length>=55">
                                                        <div class="tooltipss" >
                                                            {{entrada.nombre.substring(0, 55)}}...
                                                            <span>{{entrada.nombre | salto}}</span>
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
                                            <td class="p-0 m-0"><img v-bind:src="'imagenes/productos/'+entrada.imagen+'.jpg'" class="imgopprd2"/></td>
                                            <td v-if="entrada.comentarios" >
                                                {{entrada.comentarios}}
                                            </td>
                                            <td v-else>  
                                                    Sin comentario
                                            </td>
                                            <td>{{entrada.pendiente1}}</td>
                                            <td>    
                                                <input type="text" class="form-control text-center" style="width: 4rem;" v-model="entrada.pendiente">
                                            </td>
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
                            </table>
                        </div> 
                        <div class="text-center w-100" v-if="pagt>1">
                            <nav aria-label="Page navigation example"style="display: inline-flex;" v-if="entradasdetop.length">
                                <ul class="pagination mb-0" v-if="entradasdetop.lenght>=5">
                                    <template v-if="hjt!=1">
                                        <li class="page-item"><a class="page-link" @click="hjt--,listarop(idOrdPedido)" href="javascript:void(0)" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>
                                    </template>
                                    <template v-for="pg in pagt">
                                        <template v-if="hjt==pg">
                                            <li class="page-item active"><a class="page-link" @click="hjt=pg,listarop(idOrdPedido)" href="javascript:void(0)" v-text="pg"></a></li>
                                        </template> 
                                        <template v-else>
                                            <li class="page-item"><a class="page-link" @click="hjt=pg,listarop(idOrdPedido)" href="javascript:void(0)" v-text="pg"></a></li>
                                        </template> 
                                    </template>   
                                    <template v-if="hjt!=pagt">
                                        <li class="page-item"><a class="page-link" @click="hjt++,listarop(idOrdPedido)" href="javascript:void(0)" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>
                                    </template>
                                </ul>
                                <ul class="pagination mb-0" v-else>
                                    <template v-if="hjt!=1">
                                        <li class="page-item"><a class="page-link" @click="hjt--,listarop(idOrdPedido)" href="javascript:void(0)" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>
                                    </template>
                                    <template v-else>
                                        <li class="page-item disabled"><a class="page-link" href="javascript:void(0)" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>
                                    </template>
                                    <template v-if="hjt>4">
                                        <li class="page-item"><a class="page-link" @click="hjt=1,listarop(idOrdPedido)" href="javascript:void(0)" v-text="1"></a></li>
                                            <template v-if="hjt>10">
                                                <li class="page-item"><a class="page-link" @click="hjt=hjt-10,listarop(idOrdPedido)" href="javascript:void(0)">-10</a></li>
                                            </template>
                                        <li class="page-item disabled"><a class="page-link" @click="hjt=1,listarop(idOrdPedido)" href="javascript:void(0)">...</a></li>
                                    </template>
                                    <template v-for="pg in pagt">
                                        <template v-if="pg>hjt-3 && pg<hjt+3">
                                            <template v-if="hjt==pg">
                                                <li class="page-item active"><a class="page-link" @click="hjt=pg,listarop(idOrdPedido)" href="javascript:void(0)" v-text="pg"></a></li>
                                            </template>
                                            <template v-else>
                                                <li class="page-item"><a class="page-link" @click="hjt=pg,listarop(idOrdPedido)" href="javascript:void(0)" v-text="pg"></a></li>
                                            </template>   
                                        </template>
                                    </template>   
                                    <template v-if="hjt<pagt-2">
                                        <li class="page-item disabled"><a class="page-link" @click="hjt=1,listarop(idOrdPedido)" href="javascript:void(0)">...</a></li>
                                            <template v-if="hjt<pagt-10">
                                                <li class="page-item"><a class="page-link" @click="hjt=hjt+10,listarop(idOrdPedido)" href="javascript:void(0)">+10</a></li>
                                            </template>
                                        <li class="page-item"><a class="page-link" @click="hjt=pagt,listarop(idOrdPedido)" href="javascript:void(0)" v-text="pagt"></a></li>
                                    </template>
                                    <template v-if="hjt!=pagt">
                                        <li class="page-item"><a class="page-link" @click="hjt++,listarop(idOrdPedido)" href="javascript:void(0)" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>
                                    </template>
                                    <template v-else>
                                        <li class="page-item disabled"><a class="page-link" href="javascript:void(0)" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>
                                    </template>
                                </ul>
                            </nav>
                            <div style="font-size: 11px;font-weight:bold;" v-if="entradasdetop.length">{{hjt}} de {{pagt}} / registos {{entradasdetop[0].pag}}</div>
                            <div style="font-size: 11px;" v-else>Sin páginas</div>
                        </div>
                    </div>
                    <div class="row" v-else-if="tipoAccion == 3 || tipoAccion == 5">
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Código</label>
                                <input v-if="tipoAccion == 3" type="text" class="form-control" v-model="codigodet" readonly>
                                <input v-if="tipoAccion == 5" type="text" class="form-control" v-model="buscarproductos" @keyup="listarproductos()">
                                <template v-if="buscarproductos.length && tipoAccion == 5">
                                    <div class="menuw" v-if="listproductos=='sin'">
                                        <div class="nohay">Ingresa min 2 ...</div>
                                    </div>
                                    <div class="menuw" v-else-if="$.trim(listproductos)=='no'">
                                        <div class="nohay">Sin coincidencias</div> 
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
                                <label for="exampleFormControlInput1">Nombres</label>
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
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Descripción</label>
                                <textarea v-if="tipoAccion == 3" type="text" rows="8" class="form-control" v-model="descripciondet"></textarea>
                                <textarea v-if="tipoAccion == 5" type="text" rows="4" class="form-control" v-model="descripciondet"></textarea>  
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Comentario</label>
                                <textarea type="text" rows="4" class="form-control" v-model="comentariosdet"></textarea>  
                            </div>
                        </div>
                        <template v-if="tipoAccion==5">
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
                                                <th scope="col" v-if="sesion[0].IDUSUARIO==15 || sesion[0].IDUSUARIO==28 || sesion[0].IDUSUARIO ==58 || sesion[0].IDUSUARIO ==77">Opciones</th>
                                                <th scope="col" v-else>Opc.</th>
                                            </tr>
                                        </thead>
                                        <tbody class="cambiable">
                                            <template v-if="entradasdetop.length">
                                                <tr v-for="entrada in entradasdetop">
                                                    <td v-if="entrada.codigo && entrada.detg<=0">
                                                        <template v-if="entrada.codigo!='undefined'">
                                                            {{entrada.codigo}}
                                                        </template>
                                                        <template v-else>
                                                            Sin_código
                                                        </template>
                                                    </td>
                                                    <td v-else-if="entrada.codigo && entrada.detg>0" @click="verguias(entrada.idDetOrdPedido)" style="background: #ff00008c;color: #fff;cursor:help;" title="Ver Los números de guia" v-tippy="{ placement : 'top',  arrow: true }">
                                                        <template v-if="entrada.codigo!='undefined'">
                                                            {{entrada.codigo}}
                                                        </template>
                                                        <template v-else>
                                                            Sin_código
                                                        </template>
                                                    </td>
                                                    <td v-else>Sin_código</td>
                                                    <td v-if="entrada.nombre" >
                                                        <template v-if="entrada.nombre!='undefined'">
                                                            <template v-if="entrada.nombre.length>=55">
                                                                <div class="tooltipss" >
                                                                    {{entrada.nombre.substring(0, 55)}}...
                                                                    <span>{{entrada.nombre | salto}}</span>
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
                                                    <td class="p-0 m-0"><img v-bind:src="'imagenes/productos/'+entrada.imagen+'.jpg'" class="imgopprd2"/></td>
                                                    <td v-if="entrada.comentarios.length>1" >
                                                        {{entrada.comentarios}}
                                                    </td>
                                                    <td v-else> 
                                                            Sin comentario
                                                    </td>
                                                    <td>{{entrada.cantidad}}</td>
                                                    <td>{{entrada.pendiente}}</td>
                                                    <td>${{entrada.precioVenta | dec}}</td>
                                                    <td>${{entrada.precioVenta*entrada.cantidad | dec}}</td>
                                                    <td>
                                                        <a href="javascript:void(0)" title="Editar" v-if="sesion[0].IDUSUARIO==15 || sesion[0].IDUSUARIO==28 || sesion[0].IDUSUARIO ==58 || sesion[0].IDUSUARIO ==57 || sesion[0].IDUSUARIO ==10 || sesion[0].IDUSUARIO ==77" v-tippy="{ position : 'top',  arrow: true, size: 'small' }" @click="verdetop(entrada)"> <i class="fas fa-pencil-alt text-inverse m-r-5"></i> </a>
                                                        <a href="javascript:void(0)" title="Opciones"> <i class="fas fa-cog text-inverse m-r-5" style="opacity:.0"></i> </a>
                                                        <div class="btn-group" role="group" style="position:absolute;margin-left:-25px">
                                                            <a href="javascript:void(0)" title="Mas Opciones" v-tippy="{ position : 'top',  arrow: true, size: 'small' }" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fas fa-cog text-inverse"></i> </a>
                                                            <div class="dropdown-menu" aria-labelledby="btnGroupDrop1" style="padding: 0;">
                                                                <a class="dropdown-item" href="javascript:void(0)" @click="abrirModal('op', 'ordcompra', entrada)">Ord. compra</a>
                                                                <a class="dropdown-item" href="javascript:void(0)" @click="abrirModal('op', 'ordtrabajo', entrada)">Ord. trabajo</a>
                                                                <a class="dropdown-item" href="javascript:void(0)" @click="abrirModal('op', 'guiaremision', entrada)">Guia remisión</a>
                                                                <a class="dropdown-item" href="javascript:void(0)" v-if="sesion[0].IDUSUARIO==3 || sesion[0].IDUSUARIO ==5 || sesion[0].IDUSUARIO ==15 || sesion[0].IDUSUARIO==28 || sesion[0].IDUSUARIO ==58 || sesion[0].IDUSUARIO ==57 || sesion[0].IDUSUARIO ==10 || sesion[0].IDUSUARIO ==77" @click="abrirModal('op', 'bajas', entrada)">Bajas</a>
                                                            </div>
                                                        </div>
                                                        <template v-if="entrada.cantidad==entrada.pendiente">
                                                            <a href="javascript:void(0)" v-if="sesion[0].IDUSUARIO==15 || sesion[0].IDUSUARIO==28 || sesion[0].IDUSUARIO ==58 || sesion[0].IDUSUARIO ==57 || sesion[0].IDUSUARIO ==10 || sesion[0].IDUSUARIO ==77" title="Eliminar" v-tippy="{ position : 'top',  arrow: true, size: 'small' }" @click="eliminardetop(entrada.idDetOrdPedido, entrada.idOrdPedido, entrada.cantidad, entrada.precioVenta, entrada.codigo, subTotal, entrada.idProducto, ordPedido, sesion[0].IDUSUARIO)"> <i class="fas fa-window-close text-danger"></i> </a>
                                                        </template>
                                                        <template v-else>
                                                            <a v-if="sesion[0].IDUSUARIO==15 || sesion[0].IDUSUARIO==28 || sesion[0].IDUSUARIO ==58 || sesion[0].IDUSUARIO ==57 || sesion[0].IDUSUARIO ==10 || sesion[0].IDUSUARIO ==77" href="javascript:void(0)" @click="errorpyc" readonly><i class="fas fa-window-close"></i> </a> 
                                                        </template>
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
                                        <tfoot v-if="entradasdetop.length">
                                            </tr>
                                                <td class="b-0" colspan="6"></td>
                                                <td class="text-right b pr-2 p-0 b-1" colspan="2">SUBTOTAL</td>
                                                <td class="pr-2 p-0 b-1">${{subTotal | dec}}</td>
                                            </tr>
                                            </tr>
                                                <td class="b-0" colspan="6"></td>
                                                <td class="text-right b pr-2 p-0 b-1" colspan="2">IVA</td>
                                                <td class="pr-2 p-0 b-1">${{iva | dec}}</td>
                                            </tr>
                                            </tr>
                                                <td class="b-0" colspan="6"></td>
                                                <td class="text-right b pr-2 p-0 b-1" colspan="2">TOTAL</td>
                                                <td class="pr-2 p-0 b-1">${{total | dec}}</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </template>
                    </div>
                    <div class="row" v-else-if="tipoAccion == 7">
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Código</label>
                                <input type="text" class="form-control" v-model="buscarproductos" @keyup="listarproductos()">
                                <template v-if="buscarproductos.length">
                                    <div class="menuw" v-if="listproductos=='sin'">
                                        <div class="nohay">Ingresa min 2 ...</div>
                                    </div>
                                    <div class="menuw" v-else-if="$.trim(listproductos)=='no'">
                                        <div class="nohay">Sin coincidencias</div> 
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
                        <div class="col-lg-5 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Nombres</label>
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
                                        <span class="input-group-text" id="basic-addon1">$</span>
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
                                                <th scope="col">Descripcion</th>
                                                <th scope="col">Can.</th>
                                                <th scope="col">Pend.</th>
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
                                                            Sin_código
                                                        </template>
                                                    </td>
                                                    <td v-else>Sin_código</td>
                                                    <td v-if="entrada.nombre">
                                                        <template v-if="entrada.nombre!='undefined'">
                                                            <template v-if="entrada.nombre.length>=50">
                                                                <div class="tooltipss" >
                                                                    {{entrada.nombre.substring(0, 50)}}...
                                                                    <span>{{entrada.nombre | salto}}</span>
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
                                                    <td class="p-0 m-0"><img v-bind:src="'imagenes/productos/'+entrada.codigo+'.jpg'" class="imgopprd"/></td>
                                                    <td v-if="entrada.descripcion">
                                                        
                                                        <template v-if="entrada.descripcion!='undefined'">
                                                            <template v-if="entrada.descripcion.length>=85">
                                                                <div class="tooltipss" >
                                                                    {{entrada.descripcion.substring(0, 85)}}...
                                                                    <span>{{entrada.descripcion | salto}}</span>
                                                                </div>
                                                            </template>
                                                            <template v-else>
                                                                {{entrada.descripcion}}
                                                            </template>
                                                        </template>
                                                        <template v-else>
                                                            Sin descripción
                                                        </template>
                                                    </td>
                                                    <td v-else>
                                                        Sin descripción
                                                    </td>
                                                    <td>{{entrada.cantidad}}</td>
                                                    <td>{{entrada.pendiente}}</td>
                                                    <td>${{entrada.precioVenta | dec}}</td>
                                                    <td>${{entrada.precioVenta*entrada.cantidad | dec}}</td>
                                                    <td>
                                                        <a href="javascript:void(0)" title="Eliminar" @click="eliminarlista(index)"> <i class="fas fa-window-close text-danger"></i> </a>
                                                        <a href="javascript:void(0)" style="color:#000;" title="Editar" @click="abrirlista(entrada,index)"> <i class="fas fa-pencil-alt m-r-3"></i> </a>
                                                    </td>
                                                </tr>
                                        </tbody>
                                        <tfoot>
                                            </tr>
                                                <td class="b-0" colspan="6"></td>
                                                <td class="text-right b pr-2 p-0 b-1" colspan="2">SUBTOTAL</td>
                                                <td class="pr-2 p-0 b-1">${{subTotal | dec1}}</td>
                                            </tr>
                                            </tr>
                                                <td class="b-0" colspan="6"></td>
                                                <td class="text-right b pr-2 p-0 b-1" colspan="2">IVA</td>
                                                <td class="pr-2 p-0 b-1">${{iva | dec1}}</td>
                                            </tr>
                                            </tr>
                                                <td class="b-0" colspan="6"></td>
                                                <td class="text-right b pr-2 p-0 b-1" colspan="2">TOTAL</td>
                                                <td class="pr-2 p-0 b-1">${{total | dec1}}</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </template>
                    </div>
                    <div class="row" v-else-if="tipoAccion == 4">
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Fecha</label>
                                <input type="datetime-local" class="form-control" v-model="fechapago"> 
                                <div v-show="error">
                                    <div v-for="err in errorfechapago" :key="err" v-text="err" class="errorcamp"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Forma de pago</label> 
                                <select class="form-control selectvend" @change="escrd()" v-model="formapago">
                                    <option value="">Selecciona forma de pago</option> 
                                    <option value="EFECTIVO">EFECTIVO</option> 
                                    <option value="CHEQUE">CHEQUE</option> 
                                    <option value="VOUCHER">VOUCHER</option> 
                                    <option value="TRASNFERENCIA">TRANSFERENCIA</option>  

                                    <option value="CREDITO">CREDITO</option> 
                                    <option value="CRUCECUENTA">CRUCE DE CUENTA</option> 
                                    <option value="ANULADO">ANULADO</option> 
                                    <option value="CONTRAENTREGA">CONTRA ENTREGA</option> 
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Documento</label>
                                <input type="text" class="form-control nomv" v-model="documentopago"> 
                                <div v-show="error">
                                    <div v-for="err in errordocumentopago" :key="err" v-text="err" class="errorcamp"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Valor</label>
                                <input type="text" class="form-control nomv" v-model="valorpago" onkeypress="return filterFloat(event,this);"> 
                                <div v-show="error">
                                    <div v-for="err in errorvalorpago" :key="err" v-text="err" class="errorcamp"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Comentario</label>
                                <textarea type="text" rows="4" class="form-control" v-model="comentariopago"></textarea>  
                            </div>
                        </div>
                    </div>
                    <div class="row" v-else-if="tipoAccion == 6">
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Orden de pedido</label>
                                <input type="text" class="form-control" v-bind:value="ordPedido" readonly>  
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Cantidad Actual</label>
                                <input type="text" class="form-control" v-bind:value="cantidaddet" readonly onkeypress="return filterFloat(event,this);">  
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Cantidad de baja</label>
                                <input type="text" class="form-control" v-model="cantidadbaja" onkeypress="return filterFloat(event,this);">  
                                <div v-show="error">
                                    <div v-for="err in errorcantidadbaja" :key="err" v-text="err" class="errorcamp"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Comentario</label>
                                <textarea type="text" rows="4" class="form-control" v-model="comentariobaja"></textarea>  
                            </div>
                        </div>
                    </div>
                    <div class="row" v-else-if="tipoAccion == 8">
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Ord. Pedido</label>
                                <input type="text" class="form-control" v-bind:value="ordPedido" readonly> 
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Cliente</label>
                                <input type="text" class="form-control" v-bind:value="buscarclientes" readonly> 
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Código</label>
                                <input type="text" class="form-control" v-if="codigodet" v-bind:value="codigodet" readonly> 
                                <input type="text" class="form-control" v-else value="Sin código" readonly> 
                            </div>
                        </div>
                        <!--<div class="col-lg-2 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Código auxiliar</label>
                                <input type="text" class="form-control" v-if="idAuxProducto" v-bind:value="idAuxProducto" readonly> 
                                <input type="text" class="form-control" v-else value="Sin código Aux" readonly> 
                            </div>
                        </div>-->
                        <div class="col-lg-5 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Nombre producto</label>
                                <input type="text" class="form-control" v-bind:value="nombredet" readonly> 
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Precio</label>
                                <input type="text" class="form-control" v-bind:value="preciodet" readonly> 
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Vendedor</label>
                                <input type="text" class="form-control" v-bind:value="NOM_EMPLE" readonly> 
                            </div>
                        </div>
                        <div class="col-lg-7 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Sucursal</label>
                                <input type="text" class="form-control" v-model="sucursualguia" @keyup="listarsucursales()">
                                <template v-if="sucursualguia.length">
                                    <div class="menuw" id="container" v-if="listsucursales=='sin'">
                                        <div class="nohay">Ingresa min 3 caracteres</div>
                                    </div>
                                    <div class="menuw" id="container" v-else-if="$.trim(listsucursales)=='no'">
                                        <div class="nohay">Sin coincidencias</div> 
                                    </div>
                                    <div class="menuw" id="container" v-else-if="listsucursales.length">
                                        <div class="select" v-for="listsucursale in listsucursales" @click="seleccionarsucursal(listsucursale),listsucursales=[]">
                                            {{listsucursale.direccion}}
                                        </div>
                                    </div>
                                    <i class="fa fa-times bscdelete" v-if="buscarproductos.length" @click="sucursualguia='', listarsucursales()"></i>
                                </template> 
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Número de guia</label>
                                <input type="text" class="form-control" v-model="numeroguia" onkeypress="return filterFloat(event,this);">
                                <div v-show="error">
                                    <div v-for="err in errornumeroguia" :key="err" v-text="err" class="errorcamp"></div>
                                </div> 
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Cantidad</label>
                                <input type="text" class="form-control" v-model="cantidaddet" onkeypress="return filterFloat(event,this);"> 
                                <div v-show="error">
                                    <div v-for="err in errorcantidaddet" :key="err" v-text="err" class="errorcamp"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Comentario</label>
                                <textarea type="text" class="form-control" rows="3" v-model="comentarioguia"></textarea>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Observaciones</label>
                                <textarea type="text" class="form-control" rows="3" v-model="observacionguia"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row" v-else-if="tipoAccion == 9">
                        <div class="col-lg-2 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Orden de pedido</label>
                                <input type="text" class="form-control" v-bind:value="ordPedido" readonly> 
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Cliente</label>
                                <input type="text" class="form-control" v-bind:value="buscarclientes" readonly> 
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Código</label>
                                <input type="text" class="form-control" v-if="codigodet" v-bind:value="codigodet" readonly> 
                                <input type="text" class="form-control" v-else value="Sin código" readonly> 
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Código auxiliar</label>
                                <input type="text" class="form-control" v-if="idAuxProducto" v-bind:value="idAuxProducto" readonly> 
                                <input type="text" class="form-control" v-else value="Sin código Aux" readonly> 
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Nombre producto</label>
                                <input type="text" class="form-control" v-bind:value="nombredet" readonly> 
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Precio</label>
                                <input type="text" class="form-control" v-bind:value="preciodet" readonly> 
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Vendedor</label>
                                <input type="text" class="form-control" v-bind:value="NOM_EMPLE" readonly> 
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Fecha</label>
                                <input type="datetime-local" class="form-control" v-model="fechatrabajo">
                                <div v-show="error">
                                    <div v-for="err in errorfechatrabajo" :key="err" v-text="err" class="errorcamp"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Cantidad</label>
                                <input type="text" class="form-control" v-model="cantidaddet" onkeypress="return filterFloat(event,this);"> 
                                <div v-show="error">
                                    <div v-for="err in errorcantidaddet" :key="err" v-text="err" class="errorcamp"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-10 col-md-12 col-sm-12" :class="{'col-lg-12':tipotrabajo=='Repujado' || tipotrabajo=='Grabado' || tipotrabajo=='Sublimado' || tipotrabajo==''}">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Tipo de trabajo</label>
                                <select class="form-control" v-model="tipotrabajo" @change="solocolor=''">
                                    <option value="">Escoge un tipo trabajo</option>
                                    <option value="Serigrafía">Serigrafía</option>
                                    <option value="Tampografía">Tampografía</option>
                                    <option value="Repujado">Repujado</option>
                                    <option value="Grabado">Grabado</option>
                                    <option value="Bordado">Bordado</option>
                                    <option value="Sublimado">Sublimado</option>
                                    <option value="Impresión UV">Impresión UV</option>
                                </select>
                                <div v-show="error">
                                    <div v-for="err in errortipotrabajo" :key="err" v-text="err" class="errorcamp"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-12 col-sm-12">
                            <div v-if="tipotrabajo =='Serigrafía' || tipotrabajo =='Tampografía'">
                                <label for="exampleFormControlInput1">N° de colores</label>
                                <input type="text" max="7" maxlength="1" class="form-control text-center" v-model="solocolor" onkeypress="return filterFloat(event,this);">
                                <div v-show="error">
                                    <div v-for="err in errorsolocolor" :key="err" v-text="err" class="errorcamp"></div>
                                </div>
                            </div>
                            <div v-if="tipotrabajo =='Bordado' || tipotrabajo =='Impresión UV'">
                                <label for="exampleFormControlInput1">Tipo de Color</label>
                                <select class="form-control" v-model="solocolor">
                                    <option value="">Escoge color</option>
                                    <option value="1 color">1 color</option>
                                    <option value="Full color">Full color</option>
                                </select>
                                <div v-show="error">
                                    <div v-for="err in errorsolocolor" :key="err" v-text="err" class="errorcamp"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-6 col-sm-12"> 
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Comentario</label>
                                <textarea type="text" class="form-control" rows="3" v-model="comentariotrabajo"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row" v-else-if="tipoAccion == 10">
                        <div class="col-lg-2 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Orden de pedido</label>
                                <input type="text" class="form-control" v-bind:value="ordPedido" readonly> 
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Cliente</label>
                                <input type="text" class="form-control" v-bind:value="buscarclientes" readonly> 
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Código</label>
                                <input type="text" class="form-control" v-if="codigodet" v-bind:value="codigodet" readonly> 
                                <input type="text" class="form-control" v-else value="Sin código" readonly> 
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Código auxiliar</label>
                                <input type="text" class="form-control" v-if="idAuxProducto" v-bind:value="idAuxProducto" readonly> 
                                <input type="text" class="form-control" v-else value="Sin código Aux" readonly> 
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Nombre producto</label>
                                <input type="text" class="form-control" v-bind:value="nombredet" readonly> 
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Precio</label>
                                <input type="text" class="form-control" v-bind:value="preciodet" readonly> 
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Vendedor</label>
                                <input type="text" class="form-control" v-bind:value="NOM_EMPLE" readonly> 
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Fecha que se solicita</label>
                                <input type="datetime-local" class="form-control" v-model="fechacompra">
                                <div v-show="error">
                                    <div v-for="err in errorfechacompra" :key="err" v-text="err" class="errorcamp"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Cantidad</label>
                                <input type="text" class="form-control" v-model="cantidaddet" onkeypress="return filterFloat(event,this);"> 
                                <div v-show="error">
                                    <div v-for="err in errorcantidaddet" :key="err" v-text="err" class="errorcamp"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-6 col-sm-12"> 
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Comentario</label>
                                <textarea type="text" class="form-control" rows="3" v-model="comentariocompra"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row" v-else>
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Orden de pedido</label>
                                <input type="text" class="form-control" v-model="ordPedido" onkeypress="return filterFloat(event,this);">
                                <div v-show="error">
                                    <div v-for="err in errorordPedido" :key="err" v-text="err" class="errorcamp"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Fecha</label>
                                <input type="datetime-local" class="form-control" v-model="fechaEmision">
                                <div v-show="error">
                                    <div v-for="err in errorfechaEmision" :key="err" v-text="err" class="errorcamp"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Vendedor</label>
                                <select class="form-control" id="exampleFormControlSelect1" v-model="idEmpleado">
                                    <option value="">Seleccione el vendedor</option>
                                    <template v-for="empleado in empleados">
                                        <option v-bind:value="empleado.idempleado">{{empleado.nombres}} {{empleado.apellidos}}</option>  
                                    </template>
                                </select>
                                <div v-show="error">
                                    <div v-for="err in erroridEmpleado" :key="err" v-text="err" class="errorcamp"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-10 col-md-6 col-sm-12">
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
                        <div class="col-lg-2 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Ruc</label>
                                <input type="text" class="form-control" placeholder="Sin RUC" v-bind:value="RUC" readonly>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Dirección</label>
                                <input type="text" class="form-control" placeholder="Sin dirección" v-bind:value="direccion" readonly>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Teléfono</label>
                                <input type="text" class="form-control" placeholder="Sin teléfono" v-bind:value="telefono1" readonly>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Celular</label>
                                <input type="text" class="form-control" placeholder="Sin celular" v-bind:value="celular" readonly>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Contacto</label>
                                <input type="text" class="form-control" v-model="nombrecontacto">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Forma de pago</label>
                                <select class="form-control" v-model="formaPago">
                                    <option value="">Selecciona una forma de pago</option> 
                                    <option value="EFECTIVO">EFECTIVO</option> 
                                    <option value="CHEQUE">CHEQUE</option> 
                                    <option value="VOUCHER">VOUCHER</option>  
                                    <option value="TRASNFERENCIA">TRANSFERENCIA</option>  
                                    <option value="CRUCE CTA">CRUCE CTA</option> 
                                    <option value="CREDITO">CREDITO</option> 
                                    <option value="ANULADO">ANULADO</option> 
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Dias de crédito</label>
                                <input type="text" class="form-control" v-model="diasCredito" onkeypress="return filterFloat(event,this);">
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Comentario</label>
                                <textarea type="text" class="form-control" rows="3" v-model="comentario"></textarea>
                            </div>
                        </div>
                        <template v-if="tipoAccion==2">
                            <div class="col-lg-12 col-md-12 col-sm-12 mt-2">
                                <div class="col-lg-4 col-md-6 col-sm-12 form-material mb-2 pl-0">
                                    <input type="text" class="form-control" v-on:keyup.enter="hjt=1,listarop(idOrdPedido)" v-model="buscart" placeholder="Buscar..."/>
                                    <i class="fa fa-search imgbuscar" @click="hjt=1,listarop(idOrdPedido)"></i>
                                    <template v-if="buscart"><i class="fa fa-times imgdelete" @click="buscart='',hjt=1,listarop(idOrdPedido)"></i></template> 
                                </div>
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
                                                <th scope="col" v-if="sesion[0].IDUSUARIO==15 || sesion[0].IDUSUARIO==28 || sesion[0].IDUSUARIO ==58">Opciones</th>
                                                <th scope="col" v-else>Opc.</th>
                                            </tr>
                                        </thead>
                                        <tbody class="cambiable">
                                            <template v-if="entradasdetop.length">
                                                <tr v-for="entrada in entradasdetop">
                                                    <template v-if="sesion[0].IDUSUARIO==15 || sesion[0].IDUSUARIO==28 || sesion[0].IDUSUARIO ==58">
                                                        <td v-if="entrada.codigo" @click="copiarcod(entrada.codigo)" style="cursor:pointer;">
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
                                                        <td v-else-if="entrada.codigo && entrada.detxg>0" @click="verguias(entrada.idDetOrdPedido)" style="background: #ff00008c;color: #fff;cursor:help;" title="Ver Los números de guia" v-tippy="{ placement : 'top',  arrow: true }" data-toggle="modal" data-target="#guia">
                                                            <template v-if="entrada.codigo!='undefined'">
                                                                {{entrada.codigo}}
                                                            </template>
                                                            <template v-else>
                                                                Sin_código
                                                            </template>
                                                        </td>
                                                        <td v-else>Sin_código</td>
                                                    </template>
                                                    <td v-if="entrada.nombre" @click="copiar(entrada.nombre)" style="cursor:pointer;">
                                                        <template v-if="entrada.nombre!='undefined'">
                                                            <template v-if="entrada.nombre.length>=55">
                                                                <div class="tooltipss" >
                                                                    {{entrada.nombre.substring(0, 55)}}...
                                                                    <span>{{entrada.nombre | salto}}</span>
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
                                                    <td>
                                                        <a href="javascript:void(0)" title="Editar" v-if="sesion[0].IDUSUARIO==15 || sesion[0].IDUSUARIO==28 || sesion[0].IDUSUARIO ==58 || sesion[0].IDUSUARIO ==57 || sesion[0].IDUSUARIO ==10 || sesion[0].IDUSUARIO ==77" v-tippy="{ position : 'top',  arrow: true, size: 'small' }" @click="verdetop(entrada)"> <i class="fas fa-pencil-alt text-inverse m-r-5"></i> </a>
                                                        <a href="javascript:void(0)" title="Opciones"> <i class="fas fa-cog text-inverse m-r-5" style="opacity:.0"></i> </a>
                                                        <div class="btn-group" role="group" style="position:absolute;margin-left:-25px">
                                                            <a href="javascript:void(0)" title="Mas Opciones" v-tippy="{ position : 'top',  arrow: true, size: 'small' }" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fas fa-cog text-inverse"></i> </a>
                                                            <div class="dropdown-menu" aria-labelledby="btnGroupDrop1" style="padding: 0;">
                                                                <a class="dropdown-item" href="javascript:void(0)" @click="abrirModal('op', 'ordcompra', entrada)">Ord. compra</a>
                                                                <a class="dropdown-item" href="javascript:void(0)" @click="abrirModal('op', 'ordtrabajo', entrada), tipotrabajo='', solocolor=''">Ord. trabajo</a>
                                                                <a class="dropdown-item" href="javascript:void(0)" @click="abrirModal('op', 'guiaremision', entrada)">Guia remisión</a>
                                                                <a class="dropdown-item" href="javascript:void(0)" v-if="sesion[0].IDUSUARIO==3 || sesion[0].IDUSUARIO==5 || sesion[0].IDUSUARIO==15 || sesion[0].IDUSUARIO==28 || sesion[0].IDUSUARIO ==58 || sesion[0].IDUSUARIO ==57 || sesion[0].IDUSUARIO ==10 || sesion[0].IDUSUARIO ==77" @click="abrirModal('op', 'bajas', entrada)">Bajas</a>
                                                            </div>
                                                        </div>
                                                        <template v-if="entrada.cantidad==entrada.pendiente">
                                                            <a href="javascript:void(0)" v-if="sesion[0].IDUSUARIO==15 || sesion[0].IDUSUARIO==28 || sesion[0].IDUSUARIO ==58 || sesion[0].IDUSUARIO ==57 || sesion[0].IDUSUARIO ==10 || sesion[0].IDUSUARIO ==77" title="Eliminars" v-tippy="{ position : 'top',  arrow: true, size: 'small' }" @click="eliminardetop(entrada.idDetOrdPedido, entrada.idOrdPedido, entrada.cantidad, entrada.precioVenta, entrada.codigo, subTotal, entrada.idProducto, ordPedido, sesion[0].IDUSUARIO)"> <i class="fas fa-window-close text-danger"></i> </a>
                                                        </template>
                                                        <template v-else>
                                                            <a v-if="sesion[0].IDUSUARIO==15 || sesion[0].IDUSUARIO==28 || sesion[0].IDUSUARIO ==58 || sesion[0].IDUSUARIO ==57 || sesion[0].IDUSUARIO ==10 || sesion[0].IDUSUARIO ==77" href="javascript:void(0)" @click="errorpyc" readonly><i class="fas fa-window-close"></i> </a> 
                                                        </template>
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
                                        <tfoot v-if="entradasdetop.length">
                                            </tr>
                                                <td class="b-0" colspan="6"></td>
                                                <td class="text-right b pr-2 p-0 b-1" colspan="2">SUBTOTAL</td>
                                                <td class="pr-2 p-0 b-1">${{subTotal | dec1}}</td>
                                            </tr>
                                            </tr>
                                                <td class="b-0" colspan="6"></td>
                                                <td class="text-right b pr-2 p-0 b-1" colspan="2">IVA</td>
                                                <td class="pr-2 p-0 b-1">${{iva | dec1}}</td>
                                            </tr>
                                            </tr>
                                                <td class="b-0" colspan="6"></td>
                                                <td class="text-right b pr-2 p-0 b-1" colspan="2">TOTAL</td>
                                                <td class="pr-2 p-0 b-1">${{total | dec1}}</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <div class="text-center" style="margin-top: -80px;margin-bottom: 25px;" v-if="pagt>1">
                                    <nav aria-label="Page navigation example"style="display: inline-flex;" v-if="entradasdetop.length">
                                        <ul class="pagination mb-0" v-if="entradasdetop.lenght>=5">
                                            <template v-if="hjt!=1">
                                                <li class="page-item"><a class="page-link" @click="hjt--,listarop(idOrdPedido)" href="javascript:void(0)" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>
                                            </template>
                                            <template v-for="pg in pagt">
                                                <template v-if="hjt==pg">
                                                    <li class="page-item active"><a class="page-link" @click="hjt=pg,listarop(idOrdPedido)" href="javascript:void(0)" v-text="pg"></a></li>
                                                </template> 
                                                <template v-else>
                                                    <li class="page-item"><a class="page-link" @click="hjt=pg,listarop(idOrdPedido)" href="javascript:void(0)" v-text="pg"></a></li>
                                                </template> 
                                            </template>   
                                            <template v-if="hjt!=pagt">
                                                <li class="page-item"><a class="page-link" @click="hjt++,listarop(idOrdPedido)" href="javascript:void(0)" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>
                                            </template>
                                        </ul>
                                        <ul class="pagination mb-0" v-else>
                                            <template v-if="hjt!=1">
                                                <li class="page-item"><a class="page-link" @click="hjt--,listarop(idOrdPedido)" href="javascript:void(0)" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>
                                            </template>
                                            <template v-else>
                                                <li class="page-item disabled"><a class="page-link" href="javascript:void(0)" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>
                                            </template>
                                            <template v-if="hjt>4">
                                                <li class="page-item"><a class="page-link" @click="hjt=1,listarop(idOrdPedido)" href="javascript:void(0)" v-text="1"></a></li>
                                                    <template v-if="hjt>10">
                                                        <li class="page-item"><a class="page-link" @click="hjt=hjt-10,listarop(idOrdPedido)" href="javascript:void(0)">-10</a></li>
                                                    </template>
                                                <li class="page-item disabled"><a class="page-link" @click="hjt=1,listarop(idOrdPedido)" href="javascript:void(0)">...</a></li>
                                            </template>
                                            <template v-for="pg in pagt">
                                                <template v-if="pg>hjt-3 && pg<hjt+3">
                                                    <template v-if="hjt==pg">
                                                        <li class="page-item active"><a class="page-link" @click="hjt=pg,listarop(idOrdPedido)" href="javascript:void(0)" v-text="pg"></a></li>
                                                    </template>
                                                    <template v-else>
                                                        <li class="page-item"><a class="page-link" @click="hjt=pg,listarop(idOrdPedido)" href="javascript:void(0)" v-text="pg"></a></li>
                                                    </template>   
                                                </template>
                                            </template>   
                                            <template v-if="hjt<pagt-2">
                                                <li class="page-item disabled"><a class="page-link" @click="hjt=1,listarop(idOrdPedido)" href="javascript:void(0)">...</a></li>
                                                    <template v-if="hjt<pagt-10">
                                                        <li class="page-item"><a class="page-link" @click="hjt=hjt+10,listarop(idOrdPedido)" href="javascript:void(0)">+10</a></li>
                                                    </template>
                                                <li class="page-item"><a class="page-link" @click="hjt=pagt,listarop(idOrdPedido)" href="javascript:void(0)" v-text="pagt"></a></li>
                                            </template>
                                            <template v-if="hjt!=pagt">
                                                <li class="page-item"><a class="page-link" @click="hjt++,listarop(idOrdPedido)" href="javascript:void(0)" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>
                                            </template>
                                            <template v-else>
                                                <li class="page-item disabled"><a class="page-link" href="javascript:void(0)" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>
                                            </template>
                                        </ul>
                                    </nav>
                                    <div style="font-size: 11px;font-weight:bold;" v-if="entradasdetop.length">{{hjt}} de {{pagt}} / registos {{entradasdetop[0].pag}}</div>
                                    <div style="font-size: 11px;" v-else>Sin páginas</div>
                                </div>
                            </div>
                        </template>
                        <template v-else>
                            <template v-if="arrayop.length">
                                <div class="col-lg-12 col-md-12 col-sm-12 mt-2">
                                    <div class="table-responsive">
                                        <table class="table text-center tableborderw tabledtb">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Código</th>
                                                    <th scope="col">Nombre</th>
                                                    <th scope="col">Imagen</th>
                                                    <th scope="col">Descripcion</th>
                                                    <th scope="col">Can.</th>
                                                    <th scope="col">Pend.</th>
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
                                                                Sin_código
                                                            </template>
                                                        </td>
                                                        <td v-else>Sin_código</td>
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
                                                        <td class="p-0 m-0"><img v-bind:src="'imagenes/productos/'+entrada.codigo+'.jpg'" class="imgopprd"/></td>
                                                        <td v-if="entrada.descripcion">
                                                            
                                                            <template v-if="entrada.descripcion!='undefined'">
                                                                <template v-if="entrada.descripcion.length>=85">
                                                                    <div class="tooltipss" >
                                                                        {{entrada.descripcion.substring(0, 85)}}...
                                                                        <span>{{entrada.descripcion}}</span>
                                                                    </div>
                                                                </template>
                                                                <template v-else>
                                                                    {{entrada.descripcion}}
                                                                </template>
                                                            </template>
                                                            <template v-else>
                                                                Sin descripción
                                                            </template>
                                                        </td>
                                                        <td v-else>
                                                            Sin descripción
                                                        </td>
                                                        <td>{{entrada.cantidad}}</td>
                                                        <td>{{entrada.pendiente}}</td>
                                                        <td>${{entrada.precioVenta | dec}}</td>
                                                        <td>${{entrada.precioVenta*entrada.cantidad | dec}}</td>
                                                        <td>
                                                            <a href="javascript:void(0)" title="Eliminar" @click="eliminarlista(index)"> <i class="fas fa-window-close text-danger"></i> </a>
                                                            <a href="javascript:void(0)" style="color:#000;" title="Editar" @click="abrirlista(entrada,index)"> <i class="fas fa-pencil-alt m-l-5"></i> </a>
                                                        </td>
                                                    </tr>
                                            </tbody>
                                            <tfoot>
                                                </tr>
                                                    <td class="b-0" colspan="6"></td>
                                                    <td class="text-right b pr-2 p-0 b-1" colspan="2">SUBTOTAL</td>
                                                    <td class="pr-2 p-0 b-1">${{subTotal | dec1}}</td>
                                                </tr>
                                                </tr>
                                                    <td class="b-0" colspan="6"></td>
                                                    <td class="text-right b pr-2 p-0 b-1" colspan="2">IVA</td>
                                                    <td class="pr-2 p-0 b-1">${{iva | dec1}}</td>
                                                </tr>
                                                </tr>
                                                    <td class="b-0" colspan="6"></td>
                                                    <td class="text-right b pr-2 p-0 b-1" colspan="2">TOTAL</td>
                                                    <td class="pr-2 p-0 b-1">${{total | dec1}}</td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </template> 
                        </template>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="btn-group" role="group" style="background: #7460ee;border: 1px solid #7460ee;padding: 5.5px 9px;border-radius: 6px;">
                        <a href="javascript:void(0)" title="Mas Opciones" v-tippy="{ position : 'top',  arrow: true, size: 'small' }" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fas fa-cog text-inverse" style="color:#fff!important;"></i> </a>
                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1" style="padding: 0;">
                            <a class="dropdown-item" href="javascript:void(0)" @click="enviarguia()">Guia remisión</a>
                        </div>
                    </div>
                    <a class="btn btn-primary" v-if="tipoAccion==2 && (sesion[0].IDUSUARIO==72 || sesion[0].IDUSUARIO==5 || sesion[0].IDUSUARIO==3 || sesion[0].IDUSUARIO==15 || sesion[0].IDUSUARIO==28 || sesion[0].IDUSUARIO ==58 || sesion[0].ROL =='VENTAS' || sesion[0].IDUSUARIO ==55 || sesion[0].IDUSUARIO ==57 || sesion[0].IDUSUARIO ==10 || sesion[0].IDUSUARIO ==62 || sesion[0].IDUSUARIO== 73 || sesion[0].IDUSUARIO== 77)" v-bind:href="'Impresiones/ordpedido.php?buscar='+idOrdPedido" target="_BLANK">Imprimir</a>
                    <a class="btn btn-primary" v-if="tipoAccion==2 && sesion[0].IDEMPLEADO==38" v-bind:href="'modelo/op/generarexcel.php?op='+ordPedido" target="_TOP">Generar Excel</a>
                    <button type="button" class="btn btn-primary" v-if="tipoAccion==1" @click="agregardetops()">Agregar Productoss</button>
                    <template v-if="sesion[0].IDUSUARIO==15 || sesion[0].IDUSUARIO==28 || sesion[0].IDUSUARIO ==58 || sesion[0].IDUSUARIO ==55 || sesion[0].IDUSUARIO ==57 || sesion[0].IDUSUARIO ==10 || sesion[0].IDUSUARIO== 77"><button type="button" class="btn btn-primary" v-if="tipoAccion==2" @click="agregardetop()">Agregar Productosss</button></template>
                    <button type="button" class="btn btn-primary" v-if="tipoAccion>=3 && tipoAccion!=4 && tipoAccion!=7" @click="tipoAccion=2, tituloModal='Actualizar Orden de Pedido '+ordPedido">Volver</button>
                    <button type="button" class="btn btn-primary" v-if="tipoAccion==7 && cambiarlista==0" @click="tipoAccion=1, tituloModal='Registrar Orden de Pedido'">Volver1</button>
                    <button type="button" class="btn btn-secondary" v-if="cambiarlista==0" @click="cerrarModal()">Cerrar</button> 
                    <button type="button" class="btn btn-primary" v-if="tipoAccion==1" @click="registrar()">Guardar</button>
                    <template v-if="sesion[0].IDUSUARIO==15 || sesion[0].IDUSUARIO==28 || sesion[0].IDUSUARIO ==58 || sesion[0].IDUSUARIO ==55 || sesion[0].IDUSUARIO ==57 || sesion[0].IDUSUARIO ==10 || sesion[0].IDUSUARIO== 77"><button type="button" class="btn btn-primary" v-if="tipoAccion==2" @click="actualizar()">Actualizar</button></template>
                    <button type="button" class="btn btn-primary" v-if="tipoAccion==3" @click="actualizardetop()">Actualizar Producto</button>
                    <button type="button" class="btn btn-primary" v-if="tipoAccion==4" @click="guardarpago()">Guardar Pago</button>
                    <button type="button" class="btn btn-primary" v-if="tipoAccion==5" @click="guardardetop()">Guardar Producto</button>
                    <button type="button" class="btn btn-primary" v-if="tipoAccion==6" @click="crearbaja()">Dar de baja</button>
                    <button type="button" class="btn btn-primary" v-if="tipoAccion==7 && cambiarlista==0" @click="guardardetops()">Agregar Productossss</button>
                    <button type="button" class="btn btn-primary" v-if="tipoAccion==8" @click="guardarguia()">Crear Guia</button>
                    <button type="button" class="btn btn-primary" v-if="tipoAccion==9" @click="guardartrabajo()">Crear Ord. Trabajo</button>
                    <button type="button" class="btn btn-primary" v-if="tipoAccion==10" @click="guardarcompra()">Crear Ord. Compra</button>

                    <button type="button" class="btn btn-secondary" v-if="cambiarlista==1" @click="tipoAccion=1, cambiarlista=0">Cancelar</button>
                    <button type="button" class="btn btn-primary" v-if="tipoAccion==7 && cambiarlista==1" @click="editarlista()">Editar</button>
                    <button type="button" class="btn btn-primary" v-if="tipoAccion==50" @click="crearguiamas()">Guardar guia</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade mirartopmodal" tabindex="-1" :class="{'show mirar':modal1}"  style="background: rgba(0, 0, 0, 0.5);" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="crmodal" @click="cerrarModal1()"></div>
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Guia de remisión</h5>
                <button type="button" class="close" @click="cerrarModal1()">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table text-center tableborderw tabledtb">
                    <thead>
                        <tr>
                            <th scope="col">N° Guia</th>
                            <th scope="col">Cantidad</th>
                        </tr>
                    </thead>
                    <tbody class="cambiable">
                        <tr v-for="entradasdetguia in entradasdetguias">
                            <td>{{entradasdetguia.numeroGuia}}</td>
                            <td>{{entradasdetguia.cantidad}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" @click="cerrarModal1()">Cerrar</button>
            </div>
            </div>
        </div>
    </div>
<?php
    include 'modulo/chat.php';
    include 'modulo/foot.php';
    include 'modulo/footer.php';
?> 
<script src="static/js/vueop.js"></script>
</div>
</body>
</html>
