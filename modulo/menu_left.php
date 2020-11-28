<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- User profile -->
        <div class="user-profile" style="background: url(static/assets/images/background/user-info.jpg) no-repeat;">
            <!-- User profile image -->
            <div class="profile-img" style="display: flex;">  
                <figure class="snip1566" style="margin:0px!important;">
                    <img v-if="sesion[0].foto" v-bind:src="'imagenes/usuarios/'+sesion[0].foto" alt="sq-sample14" style="padding:3px!important;"/>
                    <img v-else src="imagenes/usuarios/null.png" alt="sq-sample14" style="padding:3px!important;"/>
                    <figcaption><i class="fas fa-plus" style="font-size: 1.6em!important;"></i></figcaption>
                    <a href="javascript:void(0)" id="subirfoto"  title="Subir mi Foto" v-tippy="{ position : 'top',  arrow: true, size: 'small' }"></a>
                    <input type="file" style="display:none" @change="subirimagenus" id="filemifoto" name="file" accept=".png,.jpg,jpeg">
                </figure>
                <p class="textadm">{{sesion[0].ROL}}</p> 
            </div>
            <!-- User profile text-->
            <div class="profile-text"> <a href="javascript:void(0)" class=" u-dropdown" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">{{sesion[0].razonSocialNombres}}</a>
            </div>
        </div>
        <!-- End User profile text-->
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li>
                    <a class="waves-effect waves-dark" href="./"><i class="fas fa-home"></i><span class="hide-menu"> Inicio</span></a>
                </li>
                <li>
                    <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fas fa-boxes"></i><span class="hide-menu"> Inventario</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li v-for="ds in sesion" v-if="ds.modulo=='INVENTARIO'"> <a v-bind:href="'http://<?=substr($_SERVER['HTTP_HOST'],0,-5)?>'+ds.link">{{ds.ACCESO}}</a></li>  
                    </ul>
                </li>

                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-laptop-windows"></i><span class="hide-menu"> Ventas</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li v-for="ds in sesion" v-if="ds.modulo=='VENTAS'"> <a v-bind:href="'http://<?=substr($_SERVER['HTTP_HOST'],0,-5)?>'+ds.link">{{ds.ACCESO}}</a></li>
                        <li v-if="sesion[0].IDUSUARIO==11"> <a href="stock">STOCK</a></li>                         
                        <!--<li><a v-if="sesion[0].IDUSUARIO==45" href="cotizacion">COTIZACION</a></li>
                        <li><a v-if="sesion[0].IDUSUARIO==45" href="ordPedido">ORD_PEDIDO</a></li>
                        <li><a v-if="sesion[0].IDUSUARIO==45" href="ordTrabajo">ORD_TRABAJO</a></li>
                        <li><a v-if="sesion[0].IDUSUARIO==45" href="guiaRemision">GUIA_REMISION</a></li>
                        <li><a v-if="sesion[0].IDUSUARIO==45" href="stock">STOCK</a></li><li><a href="http://186.69.26.234:8080/oresa2019/clientes">CLIENTES</a></li>-->
                    </ul>
                </li>
                <li>
                    <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-bullseye"></i><span class="hide-menu"> Diseño</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li v-for="ds in sesion" v-if="ds.modulo=='DISEÑO'"> <a v-bind:href="'http://<?=substr($_SERVER['HTTP_HOST'],0,-5)?>'+ds.link">{{ds.ACCESO}}</a></li>
                        <li v-if="sesion[0].IDUSUARIO==42"> <a href="clientes">Clientes</a></li>
                    </ul>
                </li>
                <li>
                    <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fas fa-people-carry"></i><span class="hide-menu"> Taller</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li v-for="ds in sesion" v-if="ds.modulo=='TALLER'"> <a v-bind:href="'http://<?=substr($_SERVER['HTTP_HOST'],0,-5)?>'+ds.link">{{ds.ACCESO}}</a></li>
                    </ul>
                </li>
                <li>
                    <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fas fa-shopping-cart"></i><span class="hide-menu"> Compras</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <template v-if="sesion[0].IDUSUARIO==70">  
                            <li><a v-bind:href="'http://<?=substr($_SERVER['HTTP_HOST'],0,-5)?>:8080/oresa2019/stock'">STOCK</a></li>  
                        </template>
                        <template v-else>
                            <li v-for="ds in sesion" v-if="ds.modulo=='COMPRAS'"> <a v-bind:href="'http://<?=substr($_SERVER['HTTP_HOST'],0,-5)?>'+ds.link">{{ds.ACCESO}}</a></li>      
                        </template>
                        <li v-if="sesion[0].IDUSUARIO==39 || sesion[0].IDUSUARIO==73"><a href="ordCompra">ORD_COMPRAS</a></li>
                    </ul>
                </li>
                <li>
                    <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fas fa-calculator"></i><span class="hide-menu"> Contabilidad</span></a>
                    <ul aria-expanded="false" class="collapse" v-if="sesion[0].IDUSUARIO==10">
                        <li><a href="http://<?=substr($_SERVER['HTTP_HOST'],0,-5)?>:8080/oresa2019/stock.php">STOCK</a></li>
                        <li v-if="sesion[0].IDUSUARIO==10"> <a href="pagos">PAGOS</a></li>
                        <li v-if="sesion[0].IDUSUARIO==10"> <a href="ordPedido">ORD_PEDIDO</a></li>
                    </ul>
                    <ul aria-expanded="false" class="collapse" v-else>
                        <li v-for="ds in sesion" v-if="ds.modulo=='CONTABILIDAD'"><a v-bind:href="'http://<?=substr($_SERVER['HTTP_HOST'],0,-5)?>'+ds.link">{{ds.ACCESO}}</a></li>
                    </ul>
                </li>
                <li>
                    <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fas fa-truck-loading"></i><span class="hide-menu">  Bodega</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li v-for="ds in sesion" v-if="ds.modulo=='BODEGA'"> <a v-bind:href="'http://<?=substr($_SERVER['HTTP_HOST'],0,-5)?>'+ds.link">{{ds.ACCESO}}</a></li>
                        <li v-if="sesion[0].ROL=='ADMINISTRADOR'"> <a href="ordbajas">ORDEN DE BAJAS</a></li>
                    </ul>
                </li>
                <li>
                    <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-widgets"></i><span class="hide-menu"> Logística</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li v-for="ds in sesion" v-if="ds.modulo=='LOGISTICA'"> <a v-bind:href="'http://<?=substr($_SERVER['HTTP_HOST'],0,-5)?>'+ds.link">{{ds.ACCESO}}</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!--<nav v-else>
            <ul id="sidebarnav">
                <li>
                    <a class="waves-effect waves-dark" href="./"><i class="mdi mdi-gauge"></i><span class="hide-menu">Inicio</span></a>
                </li>
                <li v-for="(ds,index) in sesion" v-if="ds.modulo=='INVENTARIO' && index==0">
                    <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-gauge"></i><span class="hide-menu">Inventario</span></a>
                    <ul aria-expanded="false" class="collapse" v-for="dss in sesion" v-if="dss.modulo=='INVENTARIO'">
                        <li> <a v-bind:href="dss.link">{{dss.ACCESO}}</a></li>  
                    </ul>
                </li>
                <li v-for="(ds,index) in sesion" v-if="ds.modulo=='VENTAS' && index==1"> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-laptop-windows"></i><span class="hide-menu">Ventas</span></a>
                    <ul aria-expanded="false" class="collapse" v-for="dss in sesion" v-if="dss.modulo=='VENTAS'">
                        <li> <a v-bind:href="dss.link">{{dss.ACCESO}}</a></li>
                    </ul>
                </li>
                <li v-for="(ds,index) in sesion" v-if="ds.modulo=='DISEÑO' && index==0">
                    <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-bullseye"></i><span class="hide-menu">Diseño</span></a>
                    <ul aria-expanded="false" class="collapse" v-for="dss in sesion" v-if="dss.modulo=='DISEÑO'">
                        <li> <a v-bind:href="dss.link">{{dss.ACCESO}}</a></li>
                    </ul>
                </li>
                <li v-for="(ds,index) in sesion" v-if="ds.modulo=='TALLER' && index==0">
                    <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-email"></i><span class="hide-menu">Taller</span></a>
                    <ul aria-expanded="false" class="collapse" v-for="dss in sesion" v-if="dss.modulo=='TALLER'">
                        <li> <a v-bind:href="dss.link">{{dss.ACCESO}}</a></li>
                    </ul>
                </li>
                <li v-for="(ds,index) in sesion" v-if="ds.modulo=='COMPRAS' && index==0">
                    <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-chart-bubble"></i><span class="hide-menu">Compras</span></a>
                    <ul aria-expanded="false" class="collapse" v-for="dss in sesion" v-if="dss.modulo=='COMPRAS'">
                        <li> <a v-bind:href="dss.link">{{dss.ACCESO}}</a></li>    
                           
                    </ul>
                </li>
                <li v-for="(ds,index) in sesion" v-if="ds.modulo=='CONTABILIDAD' && index==0">
                    <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-file"></i><span class="hide-menu">Contabilidad</span></a>
                    <ul aria-expanded="false" class="collapse" v-for="dss in sesion" v-if="dss.modulo=='CONTABILIDAD'">
                        <li><a v-bind:href="dss.link">{{dss.ACCESO}}</a></li>
                    </ul>
                </li>
                <li v-for="(ds,index) in sesion" v-if="ds.modulo=='BODEGA' && index==0">
                    <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-table"></i><span class="hide-menu">Bodega</span></a>
                    <ul aria-expanded="false" class="collapse" v-for="dss in sesion" v-if="dss.modulo=='BODEGA'">
                        <li> <a v-bind:href="dss.link">{{dss.ACCESO}}</a></li>
                    </ul>
                </li>
                <li v-for="(ds,index) in sesion" v-if="ds.modulo=='LOGISTICA' && index==0">
                    <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-widgets"></i><span class="hide-menu">Logística</span></a>
                    <ul aria-expanded="false" class="collapse" v-for="dss in sesion" v-if="dss.modulo=='LOGISTICA'">
                        <li> <a v-bind:href="dss.link">{{dss.ACCESO}}</a></li>
                    </ul>
                </li>
            </ul>
        </nav>-->
        
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll--> 
    <!-- Bottom points-->
    <div class="sidebar-footer">
        <!-- item-->
        <a href="javascript:void(0)" class="link right-side-toggle" style="position: initial!important;" data-toggle="tooltip" title="Configuración"><i class="ti-settings"></i></a>
        <!-- item-->
        <a href="mailto:" data-toggle="tooltip" title="Email"><i class="mdi mdi-gmail"></i></a>
        <!-- item-->
        <a href="" class="link" data-toggle="tooltip" title="Cerrar sesión" @click="salir()"><i class="mdi mdi-power"></i></a>
    </div>
    <!-- End Bottom points-->
</aside>