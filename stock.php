<?php
    include 'modulo/head.php';
    include 'modulo/menu_top.php';
    include 'modulo/menu_left.php';
    include 'modulo/preloader.php';
?>
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0">Stock <!--<button v-if="sesion[0].IDUSUARIO==15" type="button" style="font-size:13px;padding: 7px 5px;width:100%" class="btn btn-info btn-roundeds mr-3" @click="nuevosprd()">nuevos</button>--></h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                <li class="breadcrumb-item active">
                    Stock 
                    <a target="_BLANK" href="modelo/stock/imprimirtodo.php">Descargar todos los productos</a>
                    <!--<br><a target="_BLANK" v-if="sesion[0].IDUSUARIO==15" href="modelo/stock/pequeimagenes.php">Mejorar img</a> -->
                </li>
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
    <div class="collapse" id="collapseExample">
        <div class="card card-body">
            <form method="GET" v-on:submit.prevent="buscar='',hj=1,listar()">
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
                            <select style="font-size:13px;" v-if="buscarfiltro=='descripcion_Categoria'" class="form-control pr-3" v-model="buscargeneral" @change="hj=1,listar()">
                                <option value="">Seleccione una categoría</option>
                                <option v-for="categoria in categorias" v_bind:value="categoria.idCategoria">{{categoria.descripcion}}</option>
                            </select>
                            <select style="font-size:13px;" v-else-if="buscarfiltro=='marca'" class="form-control pr-3" v-model="buscargeneral" @change="hj=1,listar()">
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
                                <span style="font-size:13px;" class="input-group-text" id="basic-addon1">Stock</span>
                            </div>
                            <input style="font-size:13px;" type="text" class="form-control text-center" v-model="stockminimo" placeholder="Stock minimo">
                            <div class="input-group-prepend">
                                <span style="font-size:13px;" class="input-group-text" id="basic-addon1"> - </span>
                            </div>
                            <input style="font-size:13px;" type="text" class="form-control text-center" v-model="stockmaximo" placeholder="Stock máximo">
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-12 form-material">       
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span style="font-size:13px;" class="input-group-text" id="basic-addon1">Costo</span>
                            </div>
                            <select style="font-size:15px;" class="form-control cambioasad1 pl-3" v-model="cprecios" style="margin:0;border-left: none;">
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
                            <input style="font-size:13px;" type="text" class="form-control text-center" v-model="costominimo" placeholder="Costo mínimo">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"> - </span>
                            </div>
                            <input style="font-size:13px;" type="text" class="form-control text-center" v-model="costomaximo" placeholder="Costo máximo">
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-6 col-sm-12 form-material">
                        <div class="form-check" style="position: absolute;top: -10px;left: -10px;">
                            <input class="form-check-input" type="checkbox" id="prdencero" v-model="prdencero" @change="hj=1,verespeciales()">
                            <label class="form-check-label" style="font-size: 11px;" for="prdencero">
                                Ignorar stock en 0
                            </label>
                        </div>
                        <div class="form-check" style="position: absolute;top: 15px;left: -10px;">
                            <input class="form-check-input" type="checkbox" id="prdennegativo" v-model="prdennegativo" @change="hj=1,verespeciales()">
                            <label class="form-check-label" style="font-size: 11px;" for="prdennegativo">
                                Ignorar stock en negativo
                            </label>
                        </div>
                    </div>  
                    <div class="col-lg-12 col-md-12 col-sm-12 form-material">  
                        <button type="button" class="btn btn-primary" @click="abrircamisas()">
                            CONSULTAR EL PRECIO DE CAMISETAS POR UNIDAD
                        </button>  
                    </div>  
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-lg-3 col-md-6 col-sm-12 form-material">
                            <input type="text" class="form-control" v-on:keyup.enter="hj=1,listar()" v-model="buscar" placeholder="Buscar..."/>
                            <i class="fa fa-search imgbuscar" @click="hj=1,listar()"></i>
                            <template v-if="buscar"><i class="fa fa-times imgdelete" @click="buscar='',hj=1,listar()"></i></template> 
                        </div>
                        <div class="col-lg-9 col-md-6 col-sm-12">
                            <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                                busqueda avanzada
                            </a>
                            <button type="button" v-if="sesion[0].IDUSUARIO==3 || sesion[0].IDUSUARIO ==5 || sesion[0].IDUSUARIO ==15 || sesion[0].IDUSUARIO==28 || sesion[0].IDUSUARIO ==73 || sesion[0].IDUSUARIO ==77 || sesion[0].IDUSUARIO==74" class="btn btn-info btn-roundeds mr-3" style="float:right;" @click="abrirModal('stock','registrar')">
                                Nuevo producto
                            </button>
                            <input type="checkbox" id="checkbox" v-model="veruba">
                            <label for="checkbox">Ver Ub.A.</label>
                            <button  title="Ver mas opciones" v-if="sesion[0].IDUSUARIO==3 || sesion[0].IDUSUARIO ==5 || sesion[0].IDUSUARIO ==15 || sesion[0].IDUSUARIO==28 || sesion[0].IDUSUARIO ==73 || sesion[0].IDUSUARIO ==77 || sesion[0].IDUSUARIO==74" v-tippy="{ position : 'top',  arrow: true, size: 'small' }" type="button" class="btn btn-info mr-3" style="float:right;" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-cog"></i></button>                    
                            <div class="dropdown-menu" v-if="sesion[0].IDUSUARIO==3 || sesion[0].IDUSUARIO ==5 || sesion[0].IDUSUARIO ==15 || sesion[0].IDUSUARIO==28 || sesion[0].IDUSUARIO ==73 || sesion[0].IDUSUARIO ==77 || sesion[0].IDUSUARIO==74" aria-labelledby="btnGroupDrop1" style="padding: 0;">
                                <a class="dropdown-item" href="javascript:void(0)" @click="abrirModal('stock', 'bodega')">Agregar bodega</a>
                                <a class="dropdown-item" href="javascript:void(0)" @click="abrirModal('stock', 'precio')">Agregar precio</a>
                                <a class="dropdown-item" href="javascript:void(0)" @click="abrirModal('stock', 'categoria')">Agregar categoría</a>
                            </div>
                            <div class="btn-group mr-3" style="float:right;" v-if="sesion[0].IDUSUARIO==3 || sesion[0].IDUSUARIO ==5 || sesion[0].IDUSUARIO ==15 || sesion[0].IDUSUARIO==28 || sesion[0].IDUSUARIO==64 || sesion[0].IDUSUARIO ==73 || sesion[0].IDUSUARIO ==77 || sesion[0].IDUSUARIO==74">
                                <button type="button" class="btn btn-danger dropdown-toggle pl-5 pr-5" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-file"></i>  Archivos 
                                </button> 
                                <div class="dropdown-menu">
                                    <!--<a class="dropdown-item" target="_BLANK" href="modelo/stock/imprimirtodo.php">Descargar Inventario</a>-->
                                    <a class="dropdown-item" target="_top" v-if="sesion[0].ROL=='CONTABILIDAD' || sesion[0].IDUSUARIO==15 || sesion[0].IDUSUARIO==28 || sesion[0].IDUSUARIO ==77" href="modelo/stock/reporteall.php">Descargar Stock</a>
                                    <a class="dropdown-item" target="_top" v-if="sesion[0].ROL=='CONTABILIDAD' || sesion[0].IDUSUARIO==15 || sesion[0].IDUSUARIO==28 || sesion[0].IDUSUARIO ==77" href="modelo/stock/reporteall3.php">Reporte Costo</a>
                                    <a class="dropdown-item" target="_top" v-else href="modelo/stock/reporteall1.php">Descargar Stock</a>
                                    <a class="dropdown-item" target="_top" href="modelo/stock/reporteegresoseingresos.php">Reporte Inventario</a>
                                    <a class="dropdown-item" target="_top" href="modelo/stock/bajarexcel.php">Reporte Ubicación</a>
                                    <a class="dropdown-item" target="_top" download href="files/productosnf.txt">Prod. inexistentes</a>
                                    <a class="dropdown-item" target="_top" href="modelo/stock/prdsinimagenes.php">Prod. sin imagen</a> 
                                    <div class="dropdown-divider"></div>
                                    <!--<a class="dropdown-item updateexcel" href="javascript:void(0)">Subir Principal</a>-->
                                    <a class="dropdown-item" target="_BLANK" href="http://64.46.87.43/ViaClienteWeb">Abrir V_EXPRESS</a>
                                    <a class="dropdown-item updateexcel2" href="javascript:void(0)">Subir stock</a>
                                    <a class="dropdown-item updateexcel3" v-if="sesion[0].IDUSUARIO==15 || sesion[0].IDUSUARIO==3 || sesion[0].IDUSUARIO==5 || sesion[0].IDUSUARIO==28 || sesion[0].IDUSUARIO ==77" href="javascript:void(0)">Subir nuevostock</a>
                                    <a class="dropdown-item updateexcel4" v-if="sesion[0].IDUSUARIO==3 || sesion[0].IDUSUARIO==15 || sesion[0].IDUSUARIO ==73 || sesion[0].IDUSUARIO==74 || sesion[0].IDUSUARIO ==77 || sesion[0].IDUSUARIO==28" href="javascript:void(0)">Subir Ubicación</a>
                                </div>
                            </div> 
                            <input type="file" style="display:none;" @change="getImage" name="file" id="file" accept=".xls,.xlsx"> 
                            <button @click="updateAvatar" data-toggle="tooltip" data-placement="top" data-original-title="Subir Excel" style="display:none;" id="submit" name="import" class="btn btn-success mr-1 subirupdateexcel"><i class="fa fa-check"></i></button>
                            
                            <input type="file" style="display:none;" @change="getImage1" name="file1" id="file1" accept=".xls,.xlsx">
                            <button @click="updateAvatar1" data-toggle="tooltip" data-placement="top" data-original-title="Subir Excel" style="display:none;" id="submit" name="import" class="btn btn-success mr-1 subirupdateexcel1"><i class="fa fa-check"></i></button>

                            <input type="file" style="display:none;" @change="getImage2" name="file2" id="file2" accept=".xls,.xlsx">
                            <button @click="updateAvatar2" data-toggle="tooltip" data-placement="top" data-original-title="Subir Excel" style="display:none;" id="submit" name="import" class="btn btn-success mr-1 subirupdateexcel2"><i class="fa fa-check"></i></button>

                            <input type="file" style="display:none;" v-if="sesion[0].IDUSUARIO==3 || sesion[0].IDUSUARIO==15 || sesion[0].IDUSUARIO ==73 || sesion[0].IDUSUARIO==74 || sesion[0].IDUSUARIO==28 || sesion[0].IDUSUARIO ==77" @change="getImage3" name="file3" id="file3" accept=".xls,.xlsx">
                            <button @click="updateAvatar3" style="display:none;" data-toggle="tooltip" v-if="sesion[0].IDUSUARIO==3 || sesion[0].IDUSUARIO==15 || sesion[0].IDUSUARIO ==73" data-placement="top" data-original-title="Subir Excel" id="submit" name="import" class="btn btn-success mr-1 subirupdateexcel3"><i class="fa fa-check"></i></button>
                            
                            <input type="file" style="display:none;" v-if="sesion[0].IDUSUARIO==3 || sesion[0].IDUSUARIO==15 || sesion[0].IDUSUARIO ==73 || sesion[0].IDUSUARIO==74 || sesion[0].IDUSUARIO==28 || sesion[0].IDUSUARIO ==77" @change="getImage4" name="file4" id="file4" accept=".xls,.xlsx">
                            <button @click="updateAvatar4" data-toggle="tooltip" data-placement="top" data-original-title="Subir Excel" style="display:none;" id="submit" name="import" class="btn btn-success mr-1 subirupdateexcel4"><i class="fa fa-check"></i></button>
                            
                            <button type="button" v-if="sesion[0].ROL=='DISEÑO'" class="btn btn-info btn-roundeds mr-3" style="float:right;" @click="abrirModal('stock','subirimg')">
                                Subir Imagenes
                            </button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped mb-0 ov-h">
                            <thead>
                                <tr>
                                    <th v-if="!estadoc">Código</th>
                                    <th style="min-width: 170px;">Nombre</th>
                                    <th>Imagen</th>
                                    <th style="width: 26rem;">Descripción</th>
                                    <th title="Ordenar por stock" style="width: 85px;" v-tippy="{ position : 'top',  arrow: true, size: 'small' }" @click="hjs=1,lisstockls(),listar()" style="cursor:pointer;">Stock<i class="fas fa-chevron-up ml-1" v-if="lisstockl==1"></i><i class="fas fa-chevron-down ml-1" v-if="lisstockl==2"></i></th>
                                    <th v-if="sesion[0].ROL=='CONTABILIDAD' || sesion[0].IDUSUARIO==15 || sesion[0].IDUSUARIO==28 || sesion[0].IDUSUARIO ==58 || sesion[0].IDUSUARIO ==56 || sesion[0].IDUSUARIO ==77">Costo</th> 
                                    <th class="text-center" style="width: 8rem;">Precio</th> 
                                    <th>Ub.actual</th> 
                                    <template v-if="veruba">
                                        <th>Ub.Anterior</th> 
                                    </template>
                                    <th v-if="sesion[0].IDUSUARIO==15 || sesion[0].IDUSUARIO==28 || sesion[0].IDUSUARIO ==58 || sesion[0].IDUSUARIO ==77" class="text-nowrap">Acción</th>
                                    <th v-else class="text-nowrap">Ver</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template v-if="entradas.length">
                                    <tr v-for="entrada in entradas" :class="{'stocklisto':entrada.nuevo==1}"> 
                                        <template v-if="!entrada.estadoc">
                                            <td v-if="sesion[0].ROL!='CONTABILIDAD' && sesion[0].IDUSUARIO!=15 && sesion[0].IDUSUARIO!=28 && sesion[0].IDUSUARIO!=58 || sesion[0].IDUSUARIO ==77" class="backgroundvista quest text-center" @click="bodega(entrada.idProducto)" title="Ver ubicación de este producto" v-tippy="{ position : 'top',  arrow: true, size: 'small' }">
                                                {{entrada.codigo}}
                                            </td>
                                            <td v-else class="backgroundvista quest text-center" @click="copiarcod(entrada.codigo)" title="Copiar código" v-tippy="{ position : 'top',  arrow: true, size: 'small' }">
                                                {{entrada.codigo}}
                                            </td>
                                        </template>
                                        <td v-if="entrada.nombre.length>=19">
                                            {{entrada.nombre.substring(0, 19)}}... <span @click="copiar(entrada.nombre)" class="backgroundvista quest vermas" v-tippy="{ html : '#nombred'  , interactive : true, reactive : true }">ver mas</span>
                                            <vue-component-test id="nombred">
                                                <div style="white-space:pre-line;max-width:400px;">{{entrada.nombre}}</div>
                                            </vue-component-test> 
                                        </td> 
                                        <td v-else>
                                            {{entrada.nombre}}  
                                        </td>
                                        <td>
                                            <img v-if="entrada.imagen!='sinimagen'" v-bind:src="'imagenes/productos/'+$.trim(entrada.imagen)+'.jpg'" title="Ver imagen" v-tippy="{ position : 'top',  arrow: true, size: 'small' }" style="width:100px;height:55px;cursor:pointer;" @click="verimagen(entrada.codigo)">
                                            <img v-else v-bind:src="'imagenes/productos/'+$.trim(entrada.imagen)+'.jpg'" style="width:100px;height:55px;"> 
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
                                                    <div class="mb-1">Nº Entrega <a v-bind:href="'muestras?id='+muestra.numero" target="_blank" style="color:#7fff00 -weight bold">{{muestra.idMuestras}}</a> con Cantidad de {{muestra.salida - muestra.entrada}}</div>
                                                </div>
                                            </vue-component-test> 
                                        </td>
                                        <td v-if="sesion[0].ROL=='CONTABILIDAD' || sesion[0].IDUSUARIO==15 || sesion[0].IDUSUARIO==28 || sesion[0].IDUSUARIO ==58 || sesion[0].IDUSUARIO ==56 || sesion[0].IDUSUARIO ==77">${{entrada.costosActual}}</td>
                                        <td class="backgroundvista text-center quest" @click="copiarprec(entrada.P12,entrada.P25,entrada.P50,entrada.P75,entrada.P100,entrada.P105,entrada.P200,entrada.P210,entrada.P225,entrada.P250,entrada.P300,entrada.P500,entrada.P525,entrada.P1000,entrada.P1050,entrada.P2500,entrada.P5000,entrada.P10000,entrada.DIST)">
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
                                        <td v-if="entrada.ubicacionactual">{{entrada.ubicacionactual}}</td>
                                        <td v-else>sin Ubic.</td> 
                                        <template v-if="veruba">
                                            <td>{{entrada.ubicacion}}</td>
                                        </template>
                                        <td class="text-nowrap" v-if="sesion[0].IDUSUARIO==15 || sesion[0].IDUSUARIO==28 || sesion[0].IDUSUARIO ==58 || sesion[0].IDUSUARIO ==77"> 
                                            <a href="javascript:void(0)" title="Editar" v-tippy="{ position : 'top',  arrow: true, size: 'small' }" class="edit" @click="abrirModal('stock','actualizar',entrada)"> <i class="fas fa-pencil-alt text-inverse m-r-10"></i> </a>
                                            <a href="javascript:void(0)" title="Eliminar" v-tippy="{ position : 'top',  arrow: true, size: 'small' }" @click="eliminar(entrada.idProducto)" > <i class="fas fa-window-close text-danger"></i> </a>
                                        </td>
                                        <td class="text-nowrap text-center" v-else> 
                                            <a href="javascript:void(0)" title="Visualizar" v-tippy="{ position : 'top',  arrow: true, size: 'small' }" class="edit" @click="abrirModal('stock','actualizar',entrada)"> <i class="fas fa-eye text-inverse m-r-10"></i> </a>
                                            <a href="javascript:void(0)" v-if="(sesion[0].IDUSUARIO==3 || sesion[0].IDUSUARIO==5 || sesion[0].IDUSUARIO ==73 || sesion[0].IDUSUARIO==74 || sesion[0].IDUSUARIO ==77) && entrada.stock==0" title="Eliminar" v-tippy="{ position : 'top',  arrow: true, size: 'small' }" @click="eliminar(entrada.idProducto)" > <i class="fas fa-window-close text-danger"></i> </a>
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
        <div class="crmodal" v-if="tipoAccion==11" @click="cerrarModal()"></div>
        <div class="espera" style="display:none">
            <div class="espr">
                <div class="campoes">
                    <img src="imagenes/load.gif" style="width:300px;">
                    <img src="imagenes/logo.png" style="width: 232px;margin-top: -360px;margin-left: 35px;">
                    <svg viewbox="0 0 100 20" style="width: 400px;margin-left: -75px;">
                        <defs>
                            <linearGradient id="gradient" x1="0" x2="0" y1="0" y2="1">
                            <stop offset="5%" stop-color="#326384"/>
                            <stop offset="95%" stop-color="#123752"/>
                            </linearGradient>
                            <pattern id="wave" x="0" y="0" width="120" height="20" patternUnits="userSpaceOnUse">
                            <path id="wavePath" d="M-40 9 Q-30 7 -20 9 T0 9 T20 9 T40 9 T60 9 T80 9 T100 9 T120 9 V20 H-40z" mask="url(#mask)" fill="url(#gradient)"> 
                                <animateTransform
                                    attributeName="transform"
                                    begin="0s"
                                    dur="1.5s"
                                    type="translate"
                                    from="0,0"
                                    to="40,0"
                                    repeatCount="indefinite" />
                            </path>
                            </pattern>
                        </defs>
                        <text text-anchor="middle" x="50" y="15" font-size="17" fill="url(#wave)"  fill-opacity="0.6">SUBIENDO IMAGENES</text>
                        <text text-anchor="middle" x="50" y="15" font-size="17" fill="url(#gradient)" fill-opacity="0.1">SUBIENDO IMAGENES</text>
                    </svg>
                </div>
            </div>
        </div>
        <div class="modal-dialog modaledit" v-bind:class="[ancho]" role="document">
            <div class="modal-content" id="mydiv">
                <div class="modal-header" id="mydivheader" v-if="tipoAccion!=11">
                    <h5 class="modal-title" id="exampleModalLabel" v-text="tituloModal"></h5>  
                    <button type="button" style="position:absolute;top:10px;left:9rem;" class="btn btn-primary ml-3" v-if="tipoAccion==20" @click="darclickaimg()">Ecoger Imagenes</button> 
                    <input type="file" style="display:none" v-if="tipoAccion==20" id="filetodomas" @change="subirimagenes" name="filetodo[]" multiple> 
                    <button type="button" class="close" @click="cerrarModal()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div> 
                <div class="modal-body form-material">
                    
                    <div class="row" v-if="tipoAccion==99">
                        <div class="erroresexistentesmas"></div>
                    </div> 
                    <div class="row" v-else-if="tipoAccion==25">
                        <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                            <table class="table" style="font-size:12px;">
                                <thead class="thead-light">
                                    <tr>
                                    <th scope="col">Cuello redondo (c1)</th>
                                    <th scope="col">P25</th>
                                    <th scope="col">P50</th>
                                    <th scope="col">P105</th>
                                    <th scope="col">P210</th>
                                    <th scope="col">P525</th>
                                    <th scope="col">P1050 "EN ADELANTE"</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row">CAMISETA COLORES</th>
                                        <td>$4,63</td>
                                        <td>$5,53</td>
                                        <td>$3,90</td>
                                        <td>$3,80</td>
                                        <td>$3,57</td>
                                        <td>$3,52</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">CAMISETA BLANCA</th>
                                        <td>$4,20</td>
                                        <td>$3,90</td>
                                        <td>$3,60</td>
                                        <td>$3,40</td>
                                        <td>$3,30</td>
                                        <td>$3,20</td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="table" style="font-size:12px;">
                                <thead class="thead-light">
                                    <tr>
                                    <th scope="col">Cuello redondo (c2)</th>
                                    <th scope="col">P25</th>
                                    <th scope="col">P50</th>
                                    <th scope="col">P90</th>
                                    <th scope="col">P180</th>
                                    <th scope="col">P540</th>
                                    <th scope="col">P1080 "EN ADELANTE"</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row">CAMISETA COLORES</th>
                                        <td>$4,92</td>
                                        <td>$4,82</td>
                                        <td>$4,48</td>
                                        <td>$4,23</td>
                                        <td>$4,11</td>
                                        <td>$3,99</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">CAMISETA BLANCA</th>
                                        <td>$4,50</td>
                                        <td>$4,20</td>
                                        <td>$3,90</td>
                                        <td>$3,80</td>
                                        <td>$3,70</td>
                                        <td>$3,60</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row" v-else-if="tipoAccion==20">
                        <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                            <div v-if="attachment<=2" class="alert alert-warning text-center" role="alert">
                                DEBES ESCOGER AL MENOS UNA IMAGEN PARA SUBIR
                            </div>
                            <div id="respuesta" style="text-align:initial;"></div>  
                            <div id="vista-previa" class="row mt-3"></div>
                        </div>
                    </div>
                    <div class="row" v-else-if="tipoAccion==11">
                        <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                            <img v-bind:src="'imagenes/productos/'+$.trim(imagen)" style="max-width:65%;min-width:65%;" @click="verimagen(entrada.codigo)"> 
                        </div>
                    </div>
                    <div class="row" v-else-if="tipoAccion==10">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="b" for="exampleFormControlInput1">Descripción</label>
                                <input type="text" class="form-control" v-model="descripcionprecio"/>
                                <div v-show="error">
                                    <div v-for="err in errordescripcionprecio" :key="err" v-text="err" class="errorcamp"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12">
                            <div class="form-group">
                                <label class="b" for="exampleFormControlInput1">Matríz</label>
                                <input type="text" class="form-control" v-model="matrizprecio"/>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12">
                            <div class="form-group">
                                <label class="b" for="exampleFormControlInput1">Aux</label>
                                <input type="text" class="form-control" v-model="auxprecio"/>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label class="b" for="exampleFormControlInput1">Comentario</label>
                                <textarea rows="4" class="form-control" v-model="comentarioprecio"></textarea>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="b" for="exampleFormControlInput1">p_12</label>
                                <input type="text" class="form-control" v-model="P_12"/>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="b" for="exampleFormControlInput1">p_25</label>
                                <input type="text" class="form-control" v-model="P_25"/>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="b" for="exampleFormControlInput1">P_50</label>
                                <input type="text" class="form-control" v-model="P_50"/>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="b" for="exampleFormControlInput1">P_75</label>
                                <input type="text" class="form-control" v-model="P_75"/>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="b" for="exampleFormControlInput1">p_100</label>
                                <input type="text" class="form-control" v-model="P_100"/>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="b" for="exampleFormControlInput1">p_105</label>
                                <input type="text" class="form-control" v-model="P_105"/>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="b" for="exampleFormControlInput1">P_200</label>
                                <input type="text" class="form-control" v-model="P_200"/>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="b" for="exampleFormControlInput1">P_210</label>
                                <input type="text" class="form-control" v-model="P_210"/>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="b" for="exampleFormControlInput1">p_250</label>
                                <input type="text" class="form-control" v-model="P_250"/>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="b" for="exampleFormControlInput1">P_300</label>
                                <input type="text" class="form-control" v-model="P_300"/>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="b" for="exampleFormControlInput1">P_500</label>
                                <input type="text" class="form-control" v-model="P_500"/>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="b" for="exampleFormControlInput1">p_525</label>
                                <input type="text" class="form-control" v-model="P_525"/>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="b" for="exampleFormControlInput1">p_1000</label>
                                <input type="text" class="form-control" v-model="P_1000"/>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="b" for="exampleFormControlInput1">P_1050</label>
                                <input type="text" class="form-control" v-model="P_1050"/>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="b" for="exampleFormControlInput1">P_2500</label>
                                <input type="text" class="form-control" v-model="P_2500"/>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="b" for="exampleFormControlInput1">p_5000</label>
                                <input type="text" class="form-control" v-model="P_5000"/>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="b" for="exampleFormControlInput1">p_10000</label>
                                <input type="text" class="form-control" v-model="P_10000"/>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="b" for="exampleFormControlInput1">P_DIST</label>
                                <input type="text" class="form-control" v-model="P_DIST"/>
                            </div>
                        </div>
                    </div>
                    <div class="row" v-else-if="tipoAccion==9">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="b" for="exampleFormControlInput1">Descripción</label>
                                <input type="text" class="form-control" v-model="descripcionprecio"/>
                                <div v-show="error">
                                    <div v-for="err in errordescripcionprecio" :key="err" v-text="err" class="errorcamp"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12">
                            <div class="form-group">
                                <label class="b" for="exampleFormControlInput1">Matríz</label>
                                <input type="text" class="form-control" v-model="matrizprecio"/>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12">
                            <div class="form-group">
                                <label class="b" for="exampleFormControlInput1">Aux</label>
                                <input type="text" class="form-control" v-model="auxprecio"/>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label class="b" for="exampleFormControlInput1">Comentario</label>
                                <textarea rows="4" class="form-control" v-model="comentarioprecio"></textarea>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="b" for="exampleFormControlInput1">p_12</label>
                                <input type="text" class="form-control" v-model="P_12"/>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="b" for="exampleFormControlInput1">p_25</label>
                                <input type="text" class="form-control" v-model="P_25"/>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="b" for="exampleFormControlInput1">P_50</label>
                                <input type="text" class="form-control" v-model="P_50"/>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="b" for="exampleFormControlInput1">P_75</label>
                                <input type="text" class="form-control" v-model="P_75"/>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="b" for="exampleFormControlInput1">p_100</label>
                                <input type="text" class="form-control" v-model="P_100"/>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="b" for="exampleFormControlInput1">p_105</label>
                                <input type="text" class="form-control" v-model="P_105"/>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="b" for="exampleFormControlInput1">P_200</label>
                                <input type="text" class="form-control" v-model="P_200"/>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="b" for="exampleFormControlInput1">P_210</label>
                                <input type="text" class="form-control" v-model="P_210"/>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="b" for="exampleFormControlInput1">p_250</label>
                                <input type="text" class="form-control" v-model="P_250"/>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="b" for="exampleFormControlInput1">P_300</label>
                                <input type="text" class="form-control" v-model="P_300"/>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="b" for="exampleFormControlInput1">P_500</label>
                                <input type="text" class="form-control" v-model="P_500"/>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="b" for="exampleFormControlInput1">p_525</label>
                                <input type="text" class="form-control" v-model="P_525"/>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="b" for="exampleFormControlInput1">p_1000</label>
                                <input type="text" class="form-control" v-model="P_1000"/>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="b" for="exampleFormControlInput1">P_1050</label>
                                <input type="text" class="form-control" v-model="P_1050"/>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="b" for="exampleFormControlInput1">P_2500</label>
                                <input type="text" class="form-control" v-model="P_2500"/>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="b" for="exampleFormControlInput1">p_5000</label>
                                <input type="text" class="form-control" v-model="P_5000"/>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="b" for="exampleFormControlInput1">p_10000</label>
                                <input type="text" class="form-control" v-model="P_10000"/>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="b" for="exampleFormControlInput1">P_DIST</label>
                                <input type="text" class="form-control" v-model="P_DIST"/>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 mt-2">
                            <div class="table-responsive">
                                <table class="table text-center tableborderw tabledtb">
                                    <thead>
                                        <tr>
                                            <th scope="col">N°</th>
                                            <th scope="col">Descripción</th>
                                            <th scope="col">Comentario</th>
                                            <th scope="col" style="width:8rem;">Precio</th>
                                            <th scope="col">Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody class="cambiable">
                                        <tr v-for="(precio,index) in precios">
                                            <td>
                                                {{index+1}}
                                            </td>    
                                            <td>
                                                {{precio.descripcion}}
                                            </td>
                                            <td>
                                                {{precio.comentario}}
                                            </td>
                                            <td v-tippy="{ html : '#preciospp'  , interactive : true, reactive : true }" class="backgroundvista text-center quest">
                                                Ver precios
                                                <vue-component-test id="preciospp">
                                                    <template v-if="precio.P_12"><div class="col-lg-12">12 Unidades: <b>${{precio.P_12}}</b> </div></template>
                                                    <template v-if="precio.P_25"><div class="col-lg-12">25 Unidades: <b>${{precio.P_25}}</b> </div></template>
                                                    <template v-if="precio.P_50"><div class="col-lg-12">50 Unidades: <b>${{precio.P_50}}</b> </div></template>
                                                    <template v-if="precio.P_75"><div class="col-lg-12">75 Unidades: <b>${{precio.P_75}}</b> </div></template>
                                                    <template v-if="precio.P_100"><div class="col-lg-12">100 Unidades: <b>${{precio.P_100}}</b> </div></template>
                                                    <template v-if="precio.P_105"><div class="col-lg-12">105 Unidades: <b>${{precio.P_105}}</b> </div></template>
                                                    <template v-if="precio.P_200"><div class="col-lg-12">200 Unidades: <b>${{precio.P_200}}</b> </div></template>
                                                    <template v-if="precio.P_210"><div class="col-lg-12">210 Unidades: <b>${{precio.P_210}}</b> </div></template>
                                                    <template v-if="precio.P_225"><div class="col-lg-12">225 Unidades: <b>${{precio.P_225}}</b> </div></template>
                                                    <template v-if="precio.P_250"><div class="col-lg-12">250 Unidades: <b>${{precio.P_250}}</b> </div></template>
                                                    <template v-if="precio.P_300"><div class="col-lg-12">300 Unidades: <b>${{precio.P_300}}</b> </div></template>
                                                    <template v-if="precio.P_500"><div class="col-lg-12">500 Unidades: <b>${{precio.P_500}}</b> </div></template>
                                                    <template v-if="precio.P_525"><div class="col-lg-12">525 Unidades: <b>${{precio.P_525}}</b> </div></template>
                                                    <template v-if="precio.P_1000"><div class="col-lg-12">1000 Unidades: <b>${{precio.P_1000}}</b> </div></template>
                                                    <template v-if="precio.P_1050"><div class="col-lg-12">1050 Unidades: <b>${{precio.P_1050}}</b> </div></template>
                                                    <template v-if="precio.P_2500"><div class="col-lg-12">2500 Unidades: <b>${{precio.P_2500}}</b> </div></template>
                                                    <template v-if="precio.P_5000"><div class="col-lg-12">5000 Unidades: <b>${{precio.P_5000}}</b> </div></template>
                                                    <template v-if="precio.P_10000"><div class="col-lg-12">10000 Unidades: <b>${{precio.P_10000}}</b> </div></template> 
                                                    <template v-if="precio.P_DIST"><div class="col-lg-12">Distribuidor: <b>${{precio.P_DIST}}</b> </div></template>
                                                </vue-component-test>
                                            </td>
                                            <td>
                                                <a href="javascript:void(0)" title="Editar" v-tippy="{ position : 'top',  arrow: true, size: 'small' }" class="edit" @click="abrirModal('stock','actualizarprecio',precio)"> <i class="fas fa-pencil-alt text-inverse m-r-10"></i> </a>
                                                <a href="javascript:void(0)" title="Eliminar" v-tippy="{ position : 'top',  arrow: true, size: 'small' }" @click="eliminarprecio(precio.idListaPrecio)"> <i class="fas fa-window-close text-danger"></i> </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row" v-else-if="tipoAccion==8">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label class="b" for="exampleFormControlInput1">Nombre de la categoría</label>
                                <input type="text" class="form-control" v-model="nombrecategoria"/>
                                <div v-show="error">
                                    <div v-for="err in errornombrecategoria" :key="err" v-text="err" class="errorcamp"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" v-else-if="tipoAccion==7">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label class="b" for="exampleFormControlInput1">Nombre de la categoría</label>
                                <input type="text" class="form-control" v-model="nombrecategoria"/>
                                <div v-show="error">
                                    <div v-for="err in errornombrecategoria" :key="err" v-text="err" class="errorcamp"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 mt-2">
                            <div class="table-responsive">
                                <table class="table text-center tableborderw tabledtb">
                                    <thead>
                                        <tr>
                                            <th scope="col">N°</th>
                                            <th scope="col">Descripción</th>
                                            <th scope="col">Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody class="cambiable">
                                        <tr v-for="(categoria,index) in categorias">
                                            <td>
                                                {{index+1}}
                                            </td>    
                                            <td>
                                                {{categoria.descripcion}}
                                            </td>
                                            <td>
                                                <a href="javascript:void(0)" title="Editar" v-tippy="{ position : 'top',  arrow: true, size: 'small' }" class="edit" @click="abrirModal('stock','actualizarcategoria',categoria)"> <i class="fas fa-pencil-alt text-inverse m-r-10"></i> </a>
                                                <a href="javascript:void(0)" title="Eliminar" v-tippy="{ position : 'top',  arrow: true, size: 'small' }" @click="eliminarcategoria(categoria.idCategoria)"> <i class="fas fa-window-close text-danger"></i> </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row" v-else-if="tipoAccion==6">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label class="b" for="exampleFormControlInput1">Nombre de la bodega</label>
                                <input type="text" class="form-control" v-model="nombrebodega"/>
                                <div v-show="error">
                                    <div v-for="err in errornombrebodega" :key="err" v-text="err" class="errorcamp"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" v-else-if="tipoAccion==5">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label class="b" for="exampleFormControlInput1">Nombre de la bodega</label>
                                <input type="text" class="form-control" v-model="nombrebodega"/>
                                <div v-show="error">
                                    <div v-for="err in errornombrebodega" :key="err" v-text="err" class="errorcamp"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 mt-2">
                            <div class="table-responsive">
                                <table class="table text-center tableborderw tabledtb">
                                    <thead>
                                        <tr>
                                            <th scope="col">N°</th>
                                            <th scope="col">Descripción</th>
                                            <th scope="col">Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody class="cambiable">
                                        <tr v-for="(bodega,index) in bodegas">
                                            <td>
                                                {{index+1}}
                                            </td>    
                                            <td>
                                                {{bodega.descripcion}}
                                            </td>
                                            <td>
                                                <a href="javascript:void(0)" title="Editar" v-tippy="{ position : 'top',  arrow: true, size: 'small' }" class="edit" @click="abrirModal('stock','actualizarbodega',bodega)"> <i class="fas fa-pencil-alt text-inverse m-r-10"></i> </a>
                                                <a href="javascript:void(0)" title="Eliminar" v-tippy="{ position : 'top',  arrow: true, size: 'small' }" @click="eliminarbodega(bodega.idbodega)"> <i class="fas fa-window-close text-danger"></i> </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row" v-else-if="tipoAccion==4">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label class="b" for="exampleFormControlInput1">Bodega</label> 
                                <select class="form-control" id="exampleFormControlSelect1" v-model="bodegast">
                                    <option value="">Seleccione una bodega</option> 
                                    <template v-for="bodega in bodegas">
                                        <option v-bind:value="bodega.idbodega">{{bodega.descripcion}}</option>  
                                    </template>
                                </select>
                                <div v-show="error">
                                    <div v-for="err in errorbodegast" :key="err" v-text="err" class="errorcamp"></div>
                                </div>

                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label class="b" for="exampleFormControlInput1">Ubicación</label>
                                <input type="text" class="form-control" v-model="ubicacion"/>
                                <div v-show="error">
                                    <div v-for="err in errorubicacion" :key="err" v-text="err" class="errorcamp"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="b" for="exampleFormControlInput1">Cantidad</label>
                                <input type="text" class="form-control" v-model="cantidadbodega"/>
                                <div v-show="error">
                                    <div v-for="err in errorubicacion" :key="err" v-text="err" class="errorcamp"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="b" for="exampleFormControlInput1">Cajas</label>
                                <input type="text" class="form-control" v-model="cajasbodega"/>
                                <div v-show="error">
                                    <div v-for="err in errorubicacion" :key="err" v-text="err" class="errorcamp"></div>
                                </div>
                            </div>
                        </div>
                    </div>  
                    <div class="row" v-else-if="tipoAccion==3">
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="b" for="exampleFormControlInput1">Fecha inical</label>
                                <input type="date" class="form-control" v-model="fechaimpresionmas"/>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="b" for="exampleFormControlInput1">Fecha final</label>
                                <input type="date" class="form-control" v-model="fechaimpresionmenos"/>

                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="b" for="exampleFormControlInput1">Stock inicial</label>
                                <input type="text" class="form-control" v-model="stockmas"/>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="b" for="exampleFormControlInput1">Stock final</label>
                                <input type="text" class="form-control" v-model="stockmenos"/>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <label for="basic-url">Ingresa una busqueda</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <select class="form-control" v-model="buscartipoimpresion">
                                        <option value="">Escoge un filtro de busqueda...</option>
                                        <option value="codigo">Buscar por código</option>
                                        <option value="nombre">Buscar por nombre</option>
                                        <option value="descripcion">Buscar por descripcion</option>
                                        <option value="marca">Buscar por marca</option>
                                        <option value="descripcion_Categoria">Buscar por categoría</option>
                                    </select>
                                </div>
                                <input type="text" class="form-control" v-model="buscarimpresion">
                            </div>
                        </div>
                    </div>                          
                    <div class="row" v-else>
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="b" for="exampleFormControlInput1">Código safi</label>
                                <input type="text" class="form-control" v-model="Safi" :disabled="sesion[0].IDUSUARIO!=3 && sesion[0].IDUSUARIO !=15 && sesion[0].IDUSUARIO !=28 && sesion[0].IDUSUARIO !=77"/>
                                <div v-show="error">
                                    <div v-for="err in errorSafi" :key="err" v-text="err" class="errorcamp"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="b" for="exampleFormControlInput1">Código importación</label>
                                <input type="text" class="form-control" v-model="codigo" :disabled="sesion[0].IDUSUARIO!=3 && sesion[0].IDUSUARIO !=15 && sesion[0].IDUSUARIO !=28 && sesion[0].IDUSUARIO !=77"/>
                                <div v-show="error">
                                    <div v-for="err in errorcodigo" :key="err" v-text="err" class="errorcamp"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="b" for="exampleFormControlInput1">Nombre del producto</label>
                                <input type="text" class="form-control" v-model="nombre" :disabled="sesion[0].IDUSUARIO!=3 && sesion[0].IDUSUARIO !=15 && sesion[0].IDUSUARIO !=28 && sesion[0].IDUSUARIO !=77"/>
                                <div v-show="error">
                                    <div v-for="err in errornombre" :key="err" v-text="err" class="errorcamp"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="b" for="exampleFormControlInput1">Precio final</label>
                                <input type="text" class="form-control" v-model="pvpp" :disabled="sesion[0].IDUSUARIO!=3 && sesion[0].IDUSUARIO !=15 && sesion[0].IDUSUARIO !=28 && sesion[0].IDUSUARIO !=77"/>
                                <div v-show="error">
                                    <div v-for="err in errorpvpp" :key="err" v-text="err" class="errorcamp"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="b" for="exampleFormControlInput1">Precio dist.</label>
                                <input type="text" class="form-control" v-model="ppdist" :disabled="sesion[0].IDUSUARIO!=3 && sesion[0].IDUSUARIO !=15 && sesion[0].IDUSUARIO !=28 && sesion[0].IDUSUARIO !=77"/>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="b" for="exampleFormControlInput1">Marca</label>
                                <input type="text" class="form-control" v-model="marca" :disabled="sesion[0].IDUSUARIO!=3 && sesion[0].IDUSUARIO !=15 && sesion[0].IDUSUARIO !=28 && sesion[0].IDUSUARIO !=77"/>
                                <div v-show="error">
                                    <div v-for="err in errormarca" :key="err" v-text="err" class="errorcamp"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label class="b" for="exampleFormControlInput1">Proveedor</label>
                                <select class="form-control" id="exampleFormControlSelect1" v-model="idProveedor" :disabled="sesion[0].IDUSUARIO!=3 && sesion[0].IDUSUARIO !=15 && sesion[0].IDUSUARIO !=28 && sesion[0].IDUSUARIO !=77">
                                    <option value="">Seleccione un proveedor</option> 
                                    <template v-for="proveedor in proveedores">
                                        <option v-bind:value="proveedor.idProveedor">{{proveedor.razonSocialNombres}} {{proveedor.razonComercialApellidos}}</option>  
                                    </template>
                                </select>
                                <div v-show="error">
                                    <div v-for="err in erroridProveedor" :key="err" v-text="err" class="errorcamp"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="b" for="exampleFormControlInput1">Cantidad</label>
                                <input type="text" class="form-control" v-bind:value="cantidad" v-if="sesion[0].IDUSUARIO!=3 && sesion[0].IDUSUARIO !=15 && sesion[0].IDUSUARIO !=28 && sesion[0].IDUSUARIO !=77"/>
                                <input type="text" class="form-control" v-model="cantidad" v-else/>
                                <!-- Cantidad de cambio solo administradores -->
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="b" for="exampleFormControlInput1">Costo</label>
                                <input type="text" class="form-control" v-model="costo" :disabled="sesion[0].IDUSUARIO!=3 && sesion[0].IDUSUARIO !=15 && sesion[0].IDUSUARIO !=28 && sesion[0].IDUSUARIO !=77"/>
                                <div v-show="error">
                                    <div v-for="err in errorcosto" :key="err" v-text="err" class="errorcamp"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="b" for="exampleFormControlInput1">Tipo de producto</label>
                                <select class="form-control selectvend" v-model="tipoProducto" :disabled="sesion[0].IDUSUARIO!=3 && sesion[0].IDUSUARIO !=15 && sesion[0].IDUSUARIO !=28 && sesion[0].IDUSUARIO !=77"> 
                                    <option value="">Selecciona un tipo</option>
                                    <option value="1">STOCK</option>
                                    <option value="0">COMPRAS</option>                                                    
                                </select> 
                                <div v-show="error">
                                    <div v-for="err in errortipoProducto" :key="err" v-text="err" class="errorcamp"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <div class="form-group"> 
                                <label class="b" for="exampleFormControlInput1">Stock</label>
                                <input type="text" class="form-control" v-model="stock" v-if="sesion[0].IDUSUARIO==15 || sesion[0].IDUSUARIO ==28"/>
                                <input type="text" class="form-control" v-bind:value="stock" disabled v-else/>
                                <!-- Stock de cambio solo administradores -->
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="b" for="exampleFormControlInput1">Precios</label>
                                <select class="form-control" id="exampleFormControlSelect1" v-model="preciost" :disabled="sesion[0].IDUSUARIO!=3 && sesion[0].IDUSUARIO !=15 && sesion[0].IDUSUARIO !=28 && sesion[0].IDUSUARIO !=77 ">
                                    <option value="">Seleccione un precio</option> 
                                    <template v-for="(precio,index) in precios">
                                        <option v-bind:value="precio.idListaPrecio">{{index+1}} - {{precio.descripcion}}</option>  
                                    </template>
                                </select>
                                <div v-show="error">
                                    <div v-for="err in errorpreciost" :key="err" v-text="err" class="errorcamp"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="b" for="exampleFormControlInput1">Categoría</label>
                                <select class="form-control" id="exampleFormControlSelect1" v-model="categoriast" :disabled="sesion[0].IDUSUARIO!=3 && sesion[0].IDUSUARIO !=15 && sesion[0].IDUSUARIO !=28 && sesion[0].IDUSUARIO !=77">
                                    <option value="">Seleccione una categoría</option> 
                                    <template v-for="(categoria,index) in categorias">
                                        <option v-bind:value="categoria.idCategoria">{{index+1}} - {{categoria.descripcion}}</option>  
                                    </template>
                                </select>
                                <div v-show="error">
                                    <div v-for="err in errorcategoriast" :key="err" v-text="err" class="errorcamp"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12" v-if="tipoAccion==1">
                            <div class="form-group">
                                <label class="b" for="exampleFormControlInput1">Bodega</label>
                                <select class="form-control" id="exampleFormControlSelect1" v-model="bodegast" :disabled="sesion[0].IDUSUARIO!=3 && sesion[0].IDUSUARIO !=15 && sesion[0].IDUSUARIO !=28 && sesion[0].IDUSUARIO !=77">
                                    <option value="">Seleccione una bodega</option> 
                                    <template v-for="bodega in bodegas">
                                        <option v-bind:value="bodega.idbodega">{{bodega.descripcion}}</option>  
                                    </template>
                                </select>
                                <div v-show="error">
                                    <div v-for="err in errorbodegast" :key="err" v-text="err" class="errorcamp"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12" v-if="tipoAccion==1">
                            <div class="form-group">
                                <label class="b" for="exampleFormControlInput1">Ubicación de la bodega</label>
                                <input type="text" class="form-control" v-model="ubicacion" :disabled="sesion[0].IDUSUARIO!=3 && sesion[0].IDUSUARIO !=15 && sesion[0].IDUSUARIO !=28 && sesion[0].IDUSUARIO !=77"/>
                                <div v-show="error">
                                    <div v-for="err in errorubicacion" :key="err" v-text="err" class="errorcamp"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label class="b" for="exampleFormControlInput1">Descripción</label>
                                <textarea class="form-control" rows="4" v-model="descripcion"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <!--<div role="group" v-if="tipoAccion==2">
                        <button  class="btn btn-primary" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-plus"></i></button>                    
                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1" style="padding: 0;">
                            <a class="dropdown-item" href="javascript:void(0)" @click="abrirModal('stock', 'precios', entrada)">Listas de precios</a>
                            <a class="dropdown-item" href="javascript:void(0)" @click="abrirModal('stock', 'categorias', entrada)">Categorías</a>
                            <a class="dropdown-item" href="javascript:void(0)" @click="abrirModal('stock', 'bodegas', entrada)">Bodegas</a>
                        </div>
                    </div>-->
                    <button type="button" class="btn btn-secondary" v-if="tipoAccion==20" @click="borrarimagenesmase()">Borrar Imagenes</button>
                    <button type="submit" class="btn btn-primary" v-if="tipoAccion==10 && (sesion[0].IDUSUARIO==3 || sesion[0].IDUSUARIO==5 || sesion[0].IDUSUARIO==15 || sesion[0].IDUSUARIO==28 || sesion[0].IDUSUARIO ==58 || sesion[0].IDUSUARIO ==73 || sesion[0].IDUSUARIO ==28 || sesion[0].IDUSUARIO ==77)" @click="tipoAccion=9,idListaPrecio = null,errordescripcionprecio = [],descripcionprecio = '',comentarioprecio = '',matrizprecio = null,auxprecio = null,P_12 = null,P_25 = null,P_50 = null,P_75 = null,P_100 = null,P_105 = null,P_200 = null,P_210 = null,P_225 = null,P_250 = null,P_300 = null,P_500 = null,P_525 = null,P_1000 = null,P_1050 = null,P_2500 = null,P_5000 = null,P_10000 = null,P_DIST = null">Atras</button>
                    <button type="submit" class="btn btn-primary" v-if="tipoAccion==8 && (sesion[0].IDUSUARIO==3 || sesion[0].IDUSUARIO==5 || sesion[0].IDUSUARIO==15 || sesion[0].IDUSUARIO==28 || sesion[0].IDUSUARIO ==58 || sesion[0].IDUSUARIO ==73 || sesion[0].IDUSUARIO ==28 || sesion[0].IDUSUARIO ==77)" @click="tipoAccion=7,nombrecategoria='',idcategoria=null">Atras</button>
                    <button type="submit" class="btn btn-primary" v-if="tipoAccion==6 && (sesion[0].IDUSUARIO==3 || sesion[0].IDUSUARIO==5 || sesion[0].IDUSUARIO==15 || sesion[0].IDUSUARIO==28 || sesion[0].IDUSUARIO ==58 || sesion[0].IDUSUARIO ==73 || sesion[0].IDUSUARIO ==28 || sesion[0].IDUSUARIO ==77)" @click="tipoAccion=5,nombrebodega='',idbodega=null">Atras</button>
                    <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                    <button type="submit" class="btn btn-primary" v-if="tipoAccion==2 && (sesion[0].IDUSUARIO==3 || sesion[0].IDUSUARIO==5 || sesion[0].IDUSUARIO==15 || sesion[0].IDUSUARIO==28 || sesion[0].IDUSUARIO ==58 || sesion[0].IDUSUARIO ==73 || sesion[0].IDUSUARIO ==28 || sesion[0].IDUSUARIO ==77)" @click="actualizar()">Actualizar producto</button>
                    <button type="submit" class="btn btn-primary" v-if="tipoAccion==1 && (sesion[0].IDUSUARIO==3 || sesion[0].IDUSUARIO==5 || sesion[0].IDUSUARIO==15 || sesion[0].IDUSUARIO==28 || sesion[0].IDUSUARIO ==58 || sesion[0].IDUSUARIO ==73 || sesion[0].IDUSUARIO ==28 || sesion[0].IDUSUARIO ==77)" @click="registrar()">Guardar producto</button>
                    <button type="submit" class="btn btn-primary" v-if="tipoAccion==3 && (sesion[0].IDUSUARIO==3 || sesion[0].IDUSUARIO==5 || sesion[0].IDUSUARIO==15 || sesion[0].IDUSUARIO==28 || sesion[0].IDUSUARIO ==58 || sesion[0].IDUSUARIO ==73 || sesion[0].IDUSUARIO ==28 || sesion[0].IDUSUARIO ==77)" @click="imprimir()">Imprimir</button>
                    <button type="submit" class="btn btn-primary" v-if="tipoAccion==4 && (sesion[0].IDUSUARIO==3 || sesion[0].IDUSUARIO==5 || sesion[0].IDUSUARIO==15 || sesion[0].IDUSUARIO==28 || sesion[0].IDUSUARIO ==58 || sesion[0].IDUSUARIO ==73 || sesion[0].IDUSUARIO ==28 || sesion[0].IDUSUARIO ==77)" @click="actualizarbodega()">Actualizar bodega</button>
                    <button type="submit" class="btn btn-primary" v-if="tipoAccion==5 && (sesion[0].IDUSUARIO==3 || sesion[0].IDUSUARIO==5 || sesion[0].IDUSUARIO==15 || sesion[0].IDUSUARIO==28 || sesion[0].IDUSUARIO ==58 || sesion[0].IDUSUARIO ==73 || sesion[0].IDUSUARIO ==28 || sesion[0].IDUSUARIO ==77)" @click="crearbodega()">Crear bodega</button>
                    <button type="submit" class="btn btn-primary" v-if="tipoAccion==6 && (sesion[0].IDUSUARIO==3 || sesion[0].IDUSUARIO==5 || sesion[0].IDUSUARIO==15 || sesion[0].IDUSUARIO==28 || sesion[0].IDUSUARIO ==58 || sesion[0].IDUSUARIO ==73 || sesion[0].IDUSUARIO ==28 || sesion[0].IDUSUARIO ==77)" @click="actualizartbodega()">Actualizar bodega</button>
                    <button type="submit" class="btn btn-primary" v-if="tipoAccion==7 && (sesion[0].IDUSUARIO==3 || sesion[0].IDUSUARIO==5 || sesion[0].IDUSUARIO==15 || sesion[0].IDUSUARIO==28 || sesion[0].IDUSUARIO ==58 || sesion[0].IDUSUARIO ==73 || sesion[0].IDUSUARIO ==28 || sesion[0].IDUSUARIO ==77)" @click="crearcategoria()">Crear categoría</button>
                    <button type="submit" class="btn btn-primary" v-if="tipoAccion==8 && (sesion[0].IDUSUARIO==3 || sesion[0].IDUSUARIO==5 || sesion[0].IDUSUARIO==15 || sesion[0].IDUSUARIO==28 || sesion[0].IDUSUARIO ==58 || sesion[0].IDUSUARIO ==73 || sesion[0].IDUSUARIO ==28 || sesion[0].IDUSUARIO ==77)" @click="actualizartcategoria()">Actualizar categoría</button>
                    <button type="submit" class="btn btn-primary" v-if="tipoAccion==9 && (sesion[0].IDUSUARIO==3 || sesion[0].IDUSUARIO==5 || sesion[0].IDUSUARIO==15 || sesion[0].IDUSUARIO==28 || sesion[0].IDUSUARIO ==58 || sesion[0].IDUSUARIO ==73 || sesion[0].IDUSUARIO ==28 || sesion[0].IDUSUARIO ==77)" @click="crearprecio()">Crear precio</button>
                    <button type="submit" class="btn btn-primary" v-if="tipoAccion==10 && (sesion[0].IDUSUARIO==3 || sesion[0].IDUSUARIO==5 || sesion[0].IDUSUARIO==15 || sesion[0].IDUSUARIO==28 || sesion[0].IDUSUARIO ==58 || sesion[0].IDUSUARIO ==73 || sesion[0].IDUSUARIO ==28 || sesion[0].IDUSUARIO ==77)" @click="actualizartprecio()">Actualizar precio</button>
                    <button type="button" class="btn btn-primary" v-if="tipoAccion==20" @click="uploadimagen()">Subir imagenes</button>
                </div>
            </div>
        </div>
    </div>
<?php
    include 'modulo/chat.php';
    include 'modulo/foot.php';
    include 'modulo/footer.php';
?> 
<script src="static/js/vuestock.js"></script>
<script>
    $(function() {
    $('input[name="daterange"]').daterangepicker({
        opens: 'left'
    }, function(start, end, label) {
        console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
    });
    });
</script>
</div>
</body>
</html>