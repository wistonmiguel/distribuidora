<template>
    <div class="card">
        <div class="card-header" v-if="modoVista">
            &nbsp;&nbsp;&nbsp;<b>DEVOLUCIONES EN VENTAS</b>
        </div>
        <div class="card-header" v-if="modoDetalle">
            <div class="row">
                <div class="col-8">
                    <b>DETALLE DE DEVOLUCION DE VENTA</b>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div>
                <div v-if="modoDetalle">
                    <div class="form-group">
                        <!-- MODEL_ATTR -->

                        <div class="row">

                        <div class="col-3">
                            <div class="card text-right">
                                <div class="card-header primary bg-dark text-white border-dark">
                                    <b>FECHA</b>
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">{{ model.FechaESP }}</li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-3">
                            <div class="card text-right">
                                <div class="card-header primary bg-dark text-white border-dark">
                                    <b>ESTADO</b>
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">{{ model.Estado }}</li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-3">
                            <div class="card text-right">
                                <div class="card-header primary bg-dark text-white border-dark">
                                    <b>CLIENTE</b>
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">{{ model.NCli }}</li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-3">
                            <div class="card text-right">
                                <div class="card-header primary bg-dark text-white border-dark">
                                      <b>VENDEDOR</b>
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">{{ model.NVend }}</li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-12 mt-4">
                            <table class="table" id="tablaDetalle" v-if="modoDetalle">
                                <thead class="thead-dark">
                                    <tr>
                                    <!-- MODEL_ATTR -->
                                    <th>Codigo</th>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th>Precio de Venta</th>
                                    <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="item in models2" :key="item">
                                    <td>{{ item.idProducto }}</td>
                                    <td>{{ item.Descripcion }}</td>
                                    <td>{{ item.Cantidad }}</td>
                                    <td>C$ {{ formatCurrency(item.Precio) }}</td>
                                    <td>C$ {{ formatCurrency(item.Cantidad * item.Precio) }}</td>
                                    </tr>
                                    <tr>
                                    <td colspan="3"></td>
                                    <td>Total</td>
                                    <td>C$ {{ formatCurrency(TotalCompras) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        </div>

                    </div>
                    <div class="form-group text-right">
                        <button class="btn btn-danger" @click="cancelForm">Volver</button>
                    </div>
                </div>

                <table class="table" v-if="modoVista">
                    <thead class="thead-dark">
                        <tr>
                        <!-- MODEL_ATTR -->
                        <th>Fecha</th>
                        <th>Cliente</th>
                        <th>Vendedor</th>
                        <th>Estado</th>

                        <th width="15%" scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, index) in models" :key="index">

                        <!-- MODEL_ATTR -->
                        <td>{{item.FechaESP}}</td>
                        <td>{{item.NCli}}</td>
                        <td>{{item.NVend}}</td>
                        <td>{{item.Estado}}</td>

                        <td>
                            <button title="Ver Detalle" class="btn btn-success btn-sm" @click="viewDetails(item)"><b style='color: white;'>👁</b></button>
                        </td>
                        </tr>
                    </tbody>
                </table>

                <hr v-if="modoVista" class="mb-4" style="margin-top: -16px;">

                <div v-if="modoVista" id="paginationContainer" style="float: right; margin-bottom: -20px;">
                    <nav aria-label="...">
                        <ul class="pagination">
                            <li v-if="pagination.current_page > 1">
                                <a class="page-link" href="#" @click.prevent="changePage(pagination.current_page - 1)" tabindex="-1">Atras</a>
                            </li>

                            <li v-for="page in pagesNumber" v-bind:key="page" v-bind:class="[ page == isActived ? 'page-item active' : '']">
                                <a class="page-link" href="#" @click.prevent="changePage(page)"> {{ page }} <span class="sr-only">(current)</span></a>
                            </li>

                            <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                <a class="page-link" href="#" @click.prevent="changePage(pagination.current_page + 1)" tabindex="-1">Siguiente</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
  data() {
    return {
    models: [],
    models2: [], //Detalles
    modoDetalle: false,
    modoDetalle: false,
    modoVista: true,
    emptyTable: true,
    pagination:{
    total: 0,
    current_page: 0,
    per_page: 0,
    last_page: 0,
    from: 0,
    to: 0
    },
    offset: 1,
      //MODEL_ATTR
      model: {Fecha: '', FechaESP: '', idTransaccion: '', Estado: '', NCli: '', idCliente: '', NVend: '', idVendedor: ''},
      model2: {idProducto: '', Producto: '', Cantidad: '', Precio: '', Total: ''}
    }
  },
  created(){
    axios.get('./ventasdevolucion').then(res=>{
    this.models = null;
    this.models = res.data.model.data;
    this.pagination = res.data.pagination;
    });
  },
  computed: {
    isActived(){
        return this.pagination.current_page;
    },
    pagesNumber(){
        if(!this.pagination.to){
            return [];
        }
        var from = this.pagination.current_page - this.offset;

        if(from < 1){
            from = 1;
        }

        var to = from + (this.offset * 2);

        if(to >= this.pagination.last_page){
            to = this.pagination.last_page;
        }

        var pagesArray = [];

        while(from <= to){
            pagesArray.push(from);
            from++;
        }
        return pagesArray;
    },
    TotalCompras: function () {
        var sum = 0;
        this.models2.forEach(e => {
            sum += (e.Cantidad * e.Precio);
        });
        return sum
    }
  },
  methods:{
    getAllData(page){
    axios.get('./ventasdevolucion?page='+page).then(res=>{
    this.models = null;
    this.models = res.data.model.data;
    this.pagination = res.data.pagination;
    })
    },
    insertModel(page){
    },
     formatCurrency(value) {
        let val = (value/1).toFixed(2);
        return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    },
    viewCreateForm(){
    },
    viewDetails(item){
        //MODEL_ATTR
        this.model = {Fecha: '', FechaESP: '', idTransaccion: '', Estado: '', NCli: '', idCliente: '', NVend: '', idVendedor: ''};

        this.model.FechaESP = item.FechaESP;
        this.model.idTransaccion = item.idTransaccion;
        this.model.Estado = item.Estado;
        this.model.NVend = item.NVend;
        this.model.idTipoPago = item.idTipoPago;
        this.model.idVendedor = item.idVendedor;
        this.model.NCli = item.NCli;
        this.model.idCliente = item.idCliente;

        this.modoDetalle = true;
        this.modoCrear = false;
        this.modoCrearDetalle = false;
        this.modoVista = false;

        //AQUI MOSTRAR EL DETALLE DE DEVOLUCION
        axios.get('./detalleventasdevolucion/getAll/', { params : {id: item.idTransaccion} } ).then (res => {
        this.models2 = null;
        this.models2 = res.data.model;

        // AQUI RECORRER models2 para sumar al detalle total
        //this.TotalCompra = TotalCompras();
    });
    },
    updateModel(model){
    },
    deleteModel(model, index, page){
    },
    cancelForm(){
      this.modoCrear = false;
      this.modoCrearDetalle = false;
      this.modoDetalle = false;
      this.modoVista = true;
      this.model = {Fecha: '', FechaESP: '', idTransaccion: '', Estado: '', NCli: '', idCliente: '', NVend: '', idVendedor: ''};
      if(this.models2.length == 0)
      this.emptyTable = true;
      else
      this.models2.splice(0, this.models2.length);
    },
    changePage(page){
        this.pagination.current_page = page;
        this.getAllData(page);
    }
  }
}
</script>
