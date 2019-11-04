<template>
    <div class="card">
        <div class="card-header" v-if="modoVista">
            <button title="Nuevo" style="border-radius: 80%;" class="btn btn-primary btn-sm" @click="viewCreateForm()">✚</button>
            &nbsp;&nbsp;&nbsp;<b>TRANSACCIONES DE VENTAS</b>
        </div>
        <div class="card-header" v-if="modoCrear">
            <b>NUEVA VENTA</b>
        </div>
        <div class="card-header" v-if="modoCrearDetalle">
            <b>DETALLE DE LA VENTA</b>
        </div>
        <div class="card-header" v-if="modoDetalle">
            <div class="row">
                <div class="col-9" style="padding-top: 7px;">
                    &nbsp; <b>FACTURA <span style="color: red;"> No. {{ model.idTransaccion }} </span></b>
                </div>
                <div class="col-3 text-right">
                    <button class="btn btn-danger text-right" @click="realizarDevolucion">REALIZAR DEVOLUCIÓN</button>
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
                                      <b>TIPO DE PAGO</b>
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">{{ model.NTP }}</li>
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
                                    <td>C$ {{ formatCurrency(TotalVentas) }}</td>
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

                <div v-show="modoCrear">
                    <div class="form-group">
                        <!-- MODEL_ATTR -->
                        <input type="hidden" class="form-control mb-2" placeholder="Nombre del Producto" v-model="model.Fecha">
                        <label for="formGroupExampleInput">Tipo de Pago</label>
                        <!-- FK -->
                        <select v-model="model.idTipoPago" class="form-control">
                            <option v-for="item in fk1" :key="item" :value="item.idTipoPago">{{item.Nombre}}</option>
                        </select>
                        <label for="formGroupExampleInput">Estado</label>
                        <select v-model="model.Estado" class="form-control">
                            <option value="Cancelada">Cancelada</option>
                            <option value="Pendiente">Pendiente</option>
                        </select>
                        <label for="formGroupExampleInput">Vendedor</label>
                        <!-- FK -->
                        <select v-model="model.idVendedor" class="form-control">
                            <option v-for="item in fk2" :key="item" :value="item.idVendedor">{{item.Nombre}}</option>
                        </select>
                        <label for="formGroupExampleInput">Cliente</label>
                        <!-- FK -->
                        <select v-model="model.idCliente" class="form-control">
                            <option v-for="item in fk3" :key="item" :value="item.idCliente">{{item.Nombre}}</option>
                        </select>
                    </div>
                    <div class="form-group text-right">
                        <button class="btn btn-success" @click="nextForm">Siguiente</button>
                        <button class="btn btn-danger" @click="cancelForm">Cancelar</button>
                    </div>
                </div>

                <div v-if="modoCrearDetalle">
                    <div class="form-group col-12">
                        <!-- MODEL_ATTR -->

                        <div class="form-row align-items-center">
                            <div class="col-lg-7 col-md-6 col-xs-12">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                <div class="input-group-text">Producto</div>
                                </div>
                                <select @change="checkProductPrice($event)" class="custom-select" id="idProducto" v-model="Producto">
                                <option v-for="item in fk4" :key="item" :value="item.idProducto+','+item.Descripcion">{{item.Descripcion}}</option>
                            </select>
                            </div>
                            </div>
                            <div class="col-lg-2 col-md-6 col-xs-12">
                            <label class="sr-only" for="inlineFormInputGroup">Cantidad</label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                <div class="input-group-text">Cantidad</div>
                                </div>
                                <input type="text" class="form-control" id="inlineFormInputGroup" v-model="model2.Cantidad">
                            </div>
                            </div>
                            <div class="col-lg-2 col-md-6 col-xs-12">
                            <label class="sr-only" for="inlineFormInputGroup">Precio</label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                <div class="input-group-text">Precio</div>
                                </div>
                                <input type="text" class="form-control" id="inlineFormInputGroup" v-model="model2.Precio" disabled="disabled">
                            </div>
                            </div>
                            <div class="col-lg-1 col-md-6 col-xs-12">
                            <button @click="addItem" class="btn btn-primary mb-2 btn-block">✚</button>
                            </div>
                        </div>

                        <br>

                        <table class="table" id="tablaDetalle" v-if="modoCrearDetalle">
                            <thead class="thead-dark">
                                <tr>
                                <!-- MODEL_ATTR -->
                                <th>Codigo</th>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Precio de Venta</th>
                                <th>Total</th>

                                <th width="15%" scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-if="emptyTable">
                                    <td colspan="6"> Ingrese Productos a la Venta <hr></td>
                                </tr>
                                <tr v-for="(item, index) in models2" :key="item.idProducto">
                                <td>{{ item.idProducto }}</td>
                                <td>{{ item.Producto }}</td>
                                <td>{{ item.Cantidad }}</td>
                                <td>C$ {{ formatCurrency(item.Precio) }}</td>
                                <td>C$ {{ formatCurrency(item.Total) }}</td>
                                <td>
                                    <button title="Excluir" class="btn btn-danger btn-sm" @click="removeItem(item, index)"><b>-</b></button>
                                </td>
                                </tr>

                                <tr v-if="!emptyTable">
                                    <td colspan="3"></td>
                                    <td>Total</td>
                                    <td>C$ {{ formatCurrency(TotalVentas) }}</td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class=" text-right mt-4">
                            <button class="btn btn-success" @click="backForm">Volver</button>
                            <button class="btn btn-primary" @click="insertModel(pagination.current_page)">Realizar Venta</button>
                        </div>
                    </div>
                </div>

                <table class="table" v-if="modoVista">
                    <thead class="thead-dark">
                        <tr>
                        <!-- MODEL_ATTR -->
                        <th>Fecha</th>
                        <th>Cliente</th>
                        <th>Tipo de Pago</th>
                        <th>Estado</th>

                        <th width="15%" scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, index) in models" :key="index">

                        <!-- MODEL_ATTR -->
                        <td>{{item.FechaESP}}</td>
                        <td>{{item.NCli}}</td>
                        <td>{{item.NTP}}</td>
                        <td>{{item.Estado}}</td>

                        <td>
                            <button title="Ver Detalle" class="btn btn-success btn-sm" @click="viewDetails(item)"><b style='color: white;'>👁</b></button>
                            <button title="Eliminar" class="btn btn-danger btn-sm" @click="deleteModel(item, index, pagination.current_page)"><b>✕</b></button>
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
    fk1: [], //Tipo de Pago
    fk2: [], //Vendedores
    fk3: [], //Clientes
    fk4: [], //Productos
    models2: [], //Detalles
    modoDetalle: false,
    modoCrear: false,
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
      model: {Fecha: '', FechaESP: '', idTransaccion: '', Estado: '', NTP: '', idTipoPago: '', idVendedor: '', NCli: '', idProveedor: ''},
      model2: {idProducto: '', Producto: '', Cantidad: '', Precio: '', Total: ''}
    }
  },
  created(){
    axios.get('./ventas').then(res=>{
    this.models = null;
    this.models = res.data.model.data;
    this.pagination = res.data.pagination;
    });

    axios.get('./tipoPagos/getAll').then(res=>{
    this.fk1 = null;
    this.fk1 = res.data.model;
    });

    axios.get('./vendedores/getAll').then(res=>{
    this.fk2 = null;
    this.fk2 = res.data.model;
    });

    axios.get('./clientes/getAll').then(res=>{
    this.fk3 = null;
    this.fk3 = res.data.model;
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
    TotalVentas: function () {
        var sum = 0;
        this.models2.forEach(e => {
            sum += (e.Cantidad * e.Precio);
        });
        return sum
    }
  },
  methods:{
    getAllData(page){
    axios.get('./ventas?page='+page).then(res=>{
    this.models = null;
    this.models = res.data.model.data;
    this.pagination = res.data.pagination;
    })
    },
    insertModel(page){
      if(this.model.Fecha.length == 0){
        alert('Debes completar todos los campos antes de guardar');
        return;
      }
      const newModel = this.model;
      const newModel2 = this.models2;

      //MODEL_ATTR COMPRA + DETALLES DE COMPRA (DINAMICO)
      this.model = {Fecha: '', FechaESP: '', idTransaccion: '', Estado: '', NTP: '', idTipoPago: '', NVend: '', idVendedor: '', NCli: '', idCliente: ''};
      this.model2 = {idProducto: '', Producto: '', Cantidad: '', Precio: '', Total: ''}

      axios.post('./ventas', { newModel, newModel2 })
        .then((res) =>{
          this.modoCrear=false;
          this.modoCrearDetalle = false;
          this.modoDetalle=false;
          this.modoVista=true;

          this.changePage(1);
        })
    },
     formatCurrency(value) {
        let val = (value/1).toFixed(2);
        return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    },
    viewCreateForm(){
      this.modoCrear = true;
      this.modoCrearDetalle = false;
      this.modoDetalle = false;
      this.modoVista = false;

      var today = new Date();
      this.model.Fecha = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
    },
    viewDetails(item){
        //MODEL_ATTR
        this.model = {Fecha: '', FechaESP: '', idTransaccion: '', Estado: '', NTP: '', idTipoPago: '', NVend: '', idVendedor: '', NCli: '', idCliente: ''};

        this.model.FechaESP = item.FechaESP;
        this.model.idTransaccion = item.idTransaccion;
        this.model.Estado = item.Estado;
        this.model.NTP = item.NTP;
        this.model.idTipoPago = item.idTipoPago;
        this.model.NVend = item.NVend;
        this.model.idVendedor = item.idVendedor;
        this.model.NCli = item.NCli;
        this.model.idCliente = item.idCliente;

        this.modoDetalle = true;
        this.modoCrear = false;
        this.modoCrearDetalle = false;
        this.modoVista = false;

        axios.get('./detalleventas/getAll/', { params : {id: item.idTransaccion} } ).then (res => {
        this.models2 = null;
        this.models2 = res.data.model;

        // AQUI RECORRER models2 para sumar al detalle total
        //this.TotalCompra = TotalCompras();
    });
    },
    updateModel(model){
      if(this.model.Fecha.length == 0){
        alert('Debes completar todos los campos antes de Actualizar');
        return;
      }

      //MODEL_ATTR
      const params = {Fecha: model.Fecha, Estado: model.Estado, idTipoPago: model.idTipoPago, idVendedor: model.idVendedor, idCliente: model.idCliente};

      axios.put(`./ventas/${model.idTransaccion}`, params)
        .then(res=>{
          this.modoDetalle = false;
          this.modoCrearDetalle = false;
          this.modoCrear = false;
          this.modoVista = true;

          //MODEL_ATTR
          this.model = {Fecha: '', FechaESP: '', idTransaccion: '', Estado: '', NTP: '', idTipoPago: '', NVend: '', idVendedor: '', NCli: '', idCliente: ''};

          this.changePage(1);
        })
    },
    deleteModel(model, index, page){
      const confirmacion = confirm(`Eliminar la Venta con fecha ${model.FechaESP}`);
      if(confirmacion){
        axios.delete(`./ventas/${model.idTransaccion}`)
          .then(()=>{
            this.changePage(page);
          })
      }
    },
    realizarDevolucion(){
      const confirmacion = confirm(`Desea hacer la Devolución de esta Venta?`);
      if(confirmacion){
        var today = new Date();
        this.model.Fecha = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();

        const newModel = this.model;
        const newModel2 = this.models2;

        this.model = {Fecha: '', FechaESP: '', idTransaccion: '', Estado: '', NTP: '', idTipoPago: '', NVend: '', idVendedor: '', NCli: '', idCliente: ''};
        this.model2 = {idProducto: '', Producto: '', Cantidad: '', Precio: '', Total: ''}

        axios.post('./ventas/devAll', { newModel, newModel2 })
        .then((res) =>{
          this.modoCrear=false;
          this.modoCrearDetalle = false;
          this.modoDetalle=false;
          this.modoVista=true;

          this.changePage(1);
        })
      }
    },
    nextForm(){
      this.modoCrearDetalle = true;
      this.modoCrear = false;
      this.modoDetalle = false;
      this.modoVista = false;

      axios.get('./productos/getAll').then(res=>{
        this.fk4 = null;
        this.fk4 = res.data.model;
        });
    },
    backForm(){
      this.modoCrearDetalle = false;
      this.modoCrear = true;
      this.modoDetalle = false;
      this.modoVista = false;
      if(this.models2.length == 0)
      this.emptyTable = true;
    },
    cancelForm(){
      this.modoCrear = false;
      this.modoCrearDetalle = false;
      this.modoDetalle = false;
      this.modoVista = true;
      this.model = {Fecha: '', FechaESP: '', idTransaccion: '', Estado: '', NTP: '', idTipoPago: '', NVend: '', idVendedor: '', NCli: '', idCliente: ''};
      if(this.models2.length == 0)
      this.emptyTable = true;
      else
      this.models2.splice(0, this.models2.length);
    },
    changePage(page){
        this.pagination.current_page = page;
        this.getAllData(page);
    },
    checkProductPrice(event) {
        var array = event.target.value.split(',');

        axios.get('./inventarios/checkStock/', { params : {idProducto: array[0]} } ).then (res => {
            var Price = res.data.model[0].Precio;
            this.model2.idProducto = array[0];
            this.model2.Producto = array[1];
            this.model2.Precio = Price;
        });
        },
    addItem(){
      var NewModel2 = {
        idProducto: this.model2.idProducto,
        Producto: this.model2.Producto,
        Cantidad: this.model2.Cantidad,
        Precio: this.model2.Precio,
        Total: this.model2.Cantidad * this.model2.Precio
      };

      this.model2 = {idProducto: '', Producto: '', Cantidad: '', Precio: '', Total: ''}

      axios.get('./inventarios/checkStock/', { params : {idProducto: NewModel2.idProducto} } ).then (res => {
          var Stock = res.data.model[0].Stock;

        if(NewModel2.Cantidad <= Stock)
        {
            if(this.models2.length == 0)
            this.emptyTable = false;

            this.models2.push(NewModel2)

            this.idProducto = '';
            this.Producto = '';
            this.model2.Cantidad = '';
            this.Precio = '';
            this.Total = '';
        }
        else
        {
            alert("No hay tal cantidad en Inventario");
        }
        // AQUI RECORRER models2 para sumar al detalle total
        //this.TotalCompra = TotalCompras();
    });


    },
    removeItem(model2, index){

        if(this.models2.length == 1)
        this.emptyTable = true;

        this.models2.splice(index, 1);
    }
  }
}
</script>
