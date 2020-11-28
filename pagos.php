<?php
    include 'modulo/head.php';
    include 'modulo/menu_top.php';
    include 'modulo/menu_left.php';
    include 'modulo/preloader.php';
?>
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0">Pagos</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                <li class="breadcrumb-item active">Pagos</li>
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
                            <button type="button" class="btn btn-info btn-rounded" style="float:right;" @click="abrirModal('pagos','registrar')">
                                    Nuevo Pago
                            </button>
                            <div class="btn-group mr-3" style="float:right;">
                                <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-file"></i>  Archivos 
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" target="_top" href="modelo/pagos/bajarexcel.php">Descargar excel</a>
                                    <!--<a class="dropdown-item" target="_top" id="GenerarPDF" href="javascript:void(0)">Descargar PDF</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item updateexcel" href="javascript:void(0)">Subir Excel a la base</a>-->
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
                                    <th>fecha</th>
                                    <th>Cliente</th>
                                    <th class="text-center">O.pedido</th>
                                    <th>Forma de pago</th>
                                    <th>Documento</th>
                                    <th>Comentario</th>
                                    <th>Valor</th>
                                    <th class="text-nowrap">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template v-if="entradas.length">
                                    <tr  v-for="entrada in entradas">
                                        <td>{{moment(String(entrada.fecha)).format('LLL')}}</td>
                                        <td>{{entrada.cliente}}</td>
                                        <!--<td @click="abrirop(entrada.idOrdPedido)" class="clickop text-center" title="Ver orden de pedido" v-tippy="{ position : 'top',  arrow: true, size: 'small' }">{{entrada.idOrdPedido}}</td>-->
                                        <td class="text-center backgroundvista quest" title="Ver Op" v-tippy="{ position : 'top',  arrow: true, size: 'small' }" @click="abrirop(entrada.op)">{{entrada.op}}</td>
                                        <td>{{entrada.formaPago}}</td>
                                        <td>{{entrada.documento}}</td>
                                        <td v-if="entrada.comentario">{{entrada.comentario}}</td>
                                        <td v-else> - </td>
                                        <td>{{entrada.valor}}</td>
                                        <td class="text-nowrap">
                                            <a href="javascript:void(0)" title="Editar" v-tippy="{ position : 'top',  arrow: true, size: 'small' }" @click="abrirModal('pagos','actualizar',entrada)"> <i class="fas fa-pencil-alt text-inverse m-r-10"></i> </a>
                                            <a href="javascript:void(0)" title="Eliminar" v-tippy="{ position : 'top',  arrow: true, size: 'small' }" @click="eliminar(entrada.idPagos)" > <i class="fas fa-window-close text-danger"></i> </a>
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
    <div class="modal fade" tabindex="-1" :class="{'show mirar':modal}" style="overflow:auto;" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div @click="cerrarModal()" class="crmodal"></div>
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content" id="mydiv">
                <div class="modal-header" id="mydivheader">
                    <h5 class="modal-title" id="exampleModalLabel" v-text="tituloModal"></h5>
                    <button type="button" class="close" @click="cerrarModal()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body form-material">
                    <div class="row" v-if="tipoAccion==3">
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
                                                <td class="pr-2 p-0 b-1">{{ entradasop[0].vsubt | dec }}</td>
                                            </tr>
                                            </tr>
                                                <td class="b-0" colspan="5"></td>
                                                <td class="text-right b pr-2 p-0 b-1" colspan="2">IVA</div>
                                                <td class="pr-2 p-0 b-1">{{ entradasop[0].vsubt*0.12 | dec }}</td> 
                                            </tr>
                                            </tr>
                                                <td class="b-0" colspan="5"></td>
                                                <td class="text-right b pr-2 p-0 b-1" colspan="2">TOTAL</td>
                                                <td class="pr-2 p-0 b-1">{{ parseFloat(entradasop[0].vsubt)+parseFloat(entradasop[0].vsubt*0.12) | dec }}</td>
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
                    <div class="row" v-else>
                        <div class="col-lg-6 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Fecha</label>
                                <input type="datetime-local" class="form-control" v-model="fecha">
                                <div v-show="error">
                                    <div v-for="err in errorfecha" :key="err" v-text="err" class="errorcamp"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Id Ord.pedido</label>
                                <input type="text" class="form-control" v-model="idordpedido">
                                <div v-show="error">
                                    <div v-for="err in erroridordpedido" :key="err" v-text="err" class="errorcamp"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Forma de pago</label>
                                <select class="form-control selectvend" v-model="$.trim(formaPago)" @change="escrd()">
                                    <option value="">Selecciona una forma de pago</option> 
                                    <option value="EFECTIVO">EFECTIVO</option> 
                                    <option value="CHEQUE">CHEQUE</option> 
                                    <option value="VOUCHER">VOUCHER</option> 
                                    <option value="TRASNFERENCIA">TRANSFERENCIA</option>  
                                    <option value="CRUCE CTA">CRUCE CTA</option> 
                                    
                                    <option value="CRUCECUENTA">CRUCE DE CUENTA</option> 
                                    <option value="ANULADO">ANULADO</option> 
                                    <option value="CONTRAENTREGA">CONTRA ENTREGA</option> 
                                </select>
                                <div v-show="error">
                                    <div v-for="err in errorformaPago" :key="err" v-text="err" class="errorcamp"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Docuemento</label>
                                <input type="text" class="form-control nomv" v-model="documento">
                                <div v-show="error">
                                    <div v-for="err in errordocumento" :key="err" v-text="err" class="errorcamp"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Valor</label>
                                <input type="text" class="form-control nomv" v-model="valor">
                                <div v-show="error">
                                    <div v-for="err in errorvalor" :key="err" v-text="err" class="errorcamp"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Comentario</label>
                                <textarea type="text" rows="4" class="form-control" v-model="comentario"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                    <button type="button" class="btn btn-primary" v-if="tipoAccion==1" @click="registrar()">Guardar</button>
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
<script src="static/js/vuepago.js"></script>
</div>
</body>
</html>