<?php
    include 'modulo/head.php';
    include 'modulo/menu_top.php';
    include 'modulo/menu_left.php';
    include 'modulo/preloader.php';
?>
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0">Factura</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                <li class="breadcrumb-item active">Facturas detalladas</li>
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
                            <div class="btn-group mr-3" style="float:right;">
                                <button type="button" class="btn btn-danger dropdown-toggle pl-5 pr-5" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-file"></i>  Archivos 
                                </button>
                                <div class="dropdown-menu"> 
                                    <a class="dropdown-item" target="_top" href="modelo/facturas/bajarexcel.php">Descargar excel</a>
                                    <!--<a class="dropdown-item" target="_top" href="modelo/facturas/bajarexcelop.php">Descargar OP.Reporte</a>-->
                                    <!--<a class="dropdown-item" target="_top" id="GenerarPDF" href="javascript:void(0)">Descargar PDF</a>-->
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item updateexcel" href="javascript:void(0)">Factura Contabilidad</a>
                                    <a class="dropdown-item updateexcel1" href="javascript:void(0)">Factura Sra. Nazira</a>
                                </div>  
                            </div>
                                <input type="file" style="display:none;" @change="getImage" name="file" id="file" accept=".xls,.xlsx">
                                <button @click="updateAvatar" data-toggle="tooltip" data-placement="top" data-original-title="Subir Excel" style="display:none;" id="submit" name="import" class="btn btn-success mr-1 subirupdateexcel"><i class="fa fa-check"></i></button>

                                <input type="file" style="display:none;" @change="getImage1" name="file" id="file1" accept=".xls,.xlsx">
                                <button @click="updateAvatar1" data-toggle="tooltip" data-placement="top" data-original-title="Subir Excel" style="display:none;" id="submit" name="import" class="btn btn-success mr-1 subirupdateexcel1"><i class="fa fa-check"></i></button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped mb-0" style="font-size: 13px;">
                            <thead>
                                <tr>
                                    <th class="text-center">O.pedido</th>
                                    <!--<th>email_cliente</th>-->
                                    <th>Nombre del cliente</th>
                                    <th>Nombre del empleado</th>
                                    <th>Fecha de creación</th>
                                    <th>Sub_B</th> 
                                    <th>Sub_N</th> 
                                    <th>Sub_C</th>
                                    <th class="text-nowrap">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                            
                                <template v-if="entradas">
                                    <tr  v-for="entrada in entradas">
                                        <td>{{entrada.ordPedido}}</td>
                                        <td>{{entrada.cliente}}</td>
                                        <td>{{entrada.NOM_EMPLE}}</td>
                                        <td>{{moment(String(entrada.fechaCreacion)).format('LLL')}}</td>
                                        <td>${{entrada.sumatotal | dec}}</td>
                                        <td>${{entrada.valornazira | dec}}</td>
                                        <td v-if="entrada.valorconta">${{entrada.valorconta | dec}}</td>
                                        <td v-else class="text-center"> - </td>
                                        <td class="text-nowrap"> 
                                            <a href="javascript:void(0)" title="Editar" v-tippy="{ position : 'top',  arrow: true, size: 'small' }" class="edit" @click="abrirModal('cxc','actualizar',entrada)"> <i class="fas fa-pencil-alt text-inverse m-r-10"></i> </a>
                                            <a href="javascript:void(0)" title="Eliminar" v-tippy="{ position : 'top',  arrow: true, size: 'small' }" @click="eliminar(entrada.id)" > <i class="fas fa-window-close text-danger"></i> </a>
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
    <div class="modal fade" tabindex="-1" :class="{'show mirar':modal}" style="overflow:auto;" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div @click="cerrarModal()" class="crmodal"></div>
        <div class="modal-dialog modaledit modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel" v-text="tituloModal"></h5>
                    <button type="button" class="close" @click="cerrarModal()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body form-material">
                    <div class="row" v-if="tipoAccion==3">
                        <template v-if="entradasop">
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
                                    <table class="table text-center tableborderw">
                                        <thead>
                                            <tr>
                                                <th scope="col">Código</th>
                                                <th scope="col">Nombre</th>
                                                <th scope="col">Descripción</th>
                                                <th scope="col">Can.</th>
                                                <th scope="col">Pend.</th>
                                                <th scope="col">Precio</th>
                                                <th scope="col">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <template v-if="entradasop.length">
                                                <tr  v-for="entrada in entradasop">
                                                    <td v-if="entrada.codigo">
                                                        <template v-if="entrada.codigo!='undefined'">
                                                            {{entrada.codigo}}
                                                        </template>
                                                        <template v-else>
                                                            Sin código
                                                        </template>
                                                    </td>
                                                    <td v-else>Sin código</td>
                                                    <td>{{entrada.nombrep}}</td>
                                                    <td v-if="entrada.descripcionp" @click="numvista=99999, etc=''">
                                                        <template v-if="entrada.descripcionp!='undefined'">
                                                            <template v-if="entrada.descripcionp.length>=85">
                                                                {{entrada.descripcionp.substring(0, numvista)}}{{etc}}
                                                            </template>
                                                            <template v-else>
                                                                {{entrada.descripcionp}}
                                                            </template>
                                                        </template>
                                                        <template v-else>
                                                            Sin descripción
                                                        </template>
                                                    </td>
                                                    <td v-else>Sin descripción</td>
                                                    <td>{{entrada.cantidad}}</td>
                                                    <td>{{entrada.pendiente}}</td>
                                                    <td>${{entrada.precioVenta | dec}}</td>
                                                    <td>${{entrada.precioVenta*entrada.cantidad | dec}}</td>
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
                                                <td class="b-0" colspan="3"></td>
                                                <td class="text-right b pr-2 p-0 b-1" colspan="2">SUBTOTAL</td>
                                                <td v-text="'$'+entradasop[0].subTotal" colspan="2" class="pr-2 p-0 b-1"></td>
                                            </tr>
                                            </tr>
                                                <td class="b-0" colspan="3"></td>
                                                <td class="text-right b pr-2 p-0 b-1" colspan="2">IVA</td>
                                                <td v-text="'$'+entradasop[0].iva" colspan="2" class="pr-2 p-0 b-1"></td>
                                            </tr>
                                            </tr>
                                                <td class="b-0" colspan="3"></td>
                                                <td class="text-right b pr-2 p-0 b-1" colspan="2">TOTAL</td>
                                                <td v-text="'$'+entradasop[0].total" colspan="2" class="pr-2 p-0 b-1"></td>
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
                    <div class="row" v-else-if="tipoAccion==4">
                        <div class="col-lg-2 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Clave</label>
                                <input type="text" class="form-control" v-model="clave_cliente">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Email</label>
                                <input type="text" class="form-control" v-model="email_cliente">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Direccion</label>
                                <input type="text" class="form-control" v-model="direccion">
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Telefono</label>
                                <input type="text" class="form-control" v-model="telefono">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Nombre cliente</label>
                                <input type="text" class="form-control" v-model="nombre_cliente">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Nombre</label>
                                <input type="text" class="form-control" v-model="nombre">
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Nombre de bodega</label>
                                <input type="text" class="form-control" v-model="nombre_bodega">
                            </div>
                        </div>
                        <div class="col-lg-1 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Tipo</label>
                                <input type="text" class="form-control" v-model="tipo">
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Factura</label>
                                <input type="text" class="form-control" v-model="factura">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Autorizacion</label>
                                <input type="text" class="form-control" v-model="autorizacion">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Clave de acceso</label>
                                <input type="text" class="form-control" v-model="clave_acceso">
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Fecha</label>
                                <input type="text" class="form-control" v-model="moment(String(fecha)).format('LL')">
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">O.pedido</label> 
                                <input type="text" class="form-control" v-model="op">
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Comentario</label> 
                                <textarea type="text" rows="3" class="form-control" v-model="comentario"></textarea>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 mt-2">
                            <div class="table-responsive">
                                <table class="table text-center tableborderw">
                                    <thead>
                                        <tr>
                                            <th scope="col">Código</th>
                                            <th scope="col">Nombre</th>
                                            <th scope="col">Can.</th>
                                            <th scope="col">Precio</th>
                                            <th scope="col">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <template v-if="entradasfactura.length">
                                            <tr  v-for="entrada in entradasfactura">
                                                <td v-if="entrada.improducto">
                                                    <template v-if="entrada.improducto!='undefined'">
                                                        {{entrada.improducto}}
                                                    </template>
                                                    <template v-else>
                                                        Sin código
                                                    </template>
                                                </td>
                                                <td v-else>Sin código</td>
                                                <td>{{entrada.imnombre}}</td>
                                                <td>{{entrada.cantidad}}</td>
                                                <td>${{entrada.precio_unitario | dec}}</td>
                                                <td>${{entrada.precio_unitario*entrada.cantidad | dec}}</td>
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
                                    <tfoot v-if="entradasfactura.length">
                                        </tr>
                                            <td class="b-0" colspan="2"></td>
                                            <td class="text-right b pr-2 p-0 b-1" colspan="2">SUBTOTAL</td>
                                            <td v-text="'$'+sumtotal" class="pr-2 p-0 b-1"></td>
                                        </tr>
                                        </tr>
                                            <td class="b-0" colspan="2"></td>
                                            <td class="text-right b pr-2 p-0 b-1" colspan="2">IVA</td>
                                            <td v-text="'$'+ivatotal" class="pr-2 p-0 b-1"></td>
                                        </tr>
                                        </tr>
                                            <td class="b-0" colspan="2"></td>
                                            <td class="text-right b pr-2 p-0 b-1" colspan="2">TOTAL</td>
                                            <td v-text="'$'+totaltotal" class="pr-2 p-0 b-1"></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row" v-else>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Subtotal</label>
                                <input type="text" class="form-control" v-model="valor_nazira">
                                <div v-show="error">
                                    <div v-for="err in errorvalor_nazira" :key="err" v-text="err" class="errorcamp"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Comentario</label>
                                <textarea type="text" class="form-control" rows="4" v-model="comentarion"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                    <button type="button" class="btn btn-primary" v-if="tipoAccion==2" @click="actualizar()">Actualizar</button>
                </div>
            </div>
        </div>
    </div>
<?php
    include 'modulo/chat.php';
    include 'modulo/foot.php';
    include 'modulo/footer.php';
?> 
<script src="static/js/vuefacturas.js"></script>
</div>
</body>
</html>