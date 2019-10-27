<template>
    <div class="card">
        <div class="card-header" v-if="modoVista">
            <button title="Nuevo" style="border-radius: 80%;" class="btn btn-primary btn-sm" @click="viewCreateForm()">✚</button>
            &nbsp;&nbsp;&nbsp;<b>GESTIÓN DE INVENTARIO</b>
        </div>
        <div class="card-header" v-if="modoCrear">
            <b>NUEVA ENTRADA DE PRODUCTO</b>
        </div>
        <div class="card-header" v-if="modoEditar">
            <b>EDICIÓN DE PRODUCTOS EN INVENTARIO</b>
        </div>
        <div class="card-body">
            <div>
                <div v-if="modoEditar">
                    <div class="form-group">
                        <!-- MODEL_ATTR -->
                        <label for="formGroupExampleInput">Stock</label>
                        <input type="text" class="form-control mb-2" placeholder="Cantidad de Producto" v-model="model.Stock">
                        <label for="formGroupExampleInput">Medida</label>
                        <select v-model="model.Und_Medida" class="form-control">
                            <option value="ml">ml</option>
                            <option value="gr">gr</option>
                            <option value="lt">lt</option>
                            <option value="yd">yd</option>
                            <option value="cm">cm</option>
                            <option value="mt">mt</option>
                            <option value="Galon">Galon</option>
                            <option value="Unidad">Unidad</option>
                        </select>
                        <label for="formGroupExampleInput">Presentacion</label>
                        <select v-model="model.Presentacion" class="form-control">
                            <option value="Granel">Granel</option>
                            <option value="Bolsa">Bolsa</option>
                            <option value="Frasco">Frasco</option>
                            <option value="Barra">Barra</option>
                            <option value="Caja">Caja</option>
                            <option value="Caja 12 Piezas">Caja 12 Piezas</option>
                            <option value="Caja 24 Piezas">Caja 24 Piezas</option>
                            <option value="Caja 100 Piezas">Caja 100 Piezas</option>
                        </select>
                        <label for="formGroupExampleInput">Producto</label>
                        <select v-model="model.idProducto" class="form-control">
                            <option v-for="item1 in fk1" :key="item1" :value="item1.idProducto">{{item1.Descripcion}}</option>
                        </select>
                        <label for="formGroupExampleInput">Almacen</label>
                        <select v-model="model.idAlmacen" class="form-control">
                            <option v-for="item2 in fk2" :key="item2" :value="item2.idAlmacen">{{item2.Nombre}}</option>
                        </select>
                        <!-- <input type="text" class="form-control mb-2" placeholder="Proveedor del Producto" v-model="model.idProveedor"> -->
                    </div>
                    <div class="form-group">
                        <button class="btn btn-warning" @click="updateModel(model)">Actualizar</button>
                        <button class="btn btn-danger" @click="cancelForm">Cancelar</button>
                    </div>
                </div>

                <div v-if="modoCrear">
                    <div class="form-group">
                        <!-- MODEL_ATTR -->
                        <label for="formGroupExampleInput">Cantidad</label>
                        <input type="text" class="form-control mb-2" placeholder="Cantidad del Producto" v-model="model.Stock">
                        <label for="formGroupExampleInput">Medida</label>

                        <select v-model="model.Und_Medida" class="form-control">
                            <option value="ml">ml</option>
                            <option value="gr">gr</option>
                            <option value="lt">lt</option>
                            <option value="yd">yd</option>
                            <option value="cm">cm</option>
                            <option value="mt">mt</option>
                            <option value="Galon">Galon</option>
                            <option value="Unidad">Unidad</option>
                        </select>

                        <label for="formGroupExampleInput">Presentacion</label>
                        <select v-model="model.Presentacion" class="form-control">
                            <option value="Granel">Granel</option>
                            <option value="Bolsa">Bolsa</option>
                            <option value="Frasco">Frasco</option>
                            <option value="Barra">Barra</option>
                            <option value="Caja">Caja</option>
                            <option value="Caja 12 Piezas">Caja 12 Piezas</option>
                            <option value="Caja 24 Piezas">Caja 24 Piezas</option>
                            <option value="Caja 100 Piezas">Caja 100 Piezas</option>
                        </select>
                        <label for="formGroupExampleInput">Producto</label>
                        <!-- FK1 -->
                        <select v-model="model.idProducto" class="form-control">
                            <option v-for="item in fk1" :key="item" :value="item.idProducto">{{item.Descripcion}}</option>
                        </select>
                        <label for="formGroupExampleInput">Almacen</label>
                        <!-- FK2 -->
                        <select v-model="model.idAlmacen" class="form-control">
                            <option v-for="item in fk2" :key="item" :value="item.idAlmacen">{{item.Nombre}}</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary" @click="insertModel(pagination.current_page)">Guardar</button>
                        <button class="btn btn-danger" @click="cancelForm">Cancelar</button>
                    </div>
                </div>

                <table class="table" v-if="modoVista">
                    <thead class="thead-dark">
                        <tr>
                        <th width="10%" scope="col">#</th>

                        <!-- MODEL_ATTR -->
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Almacen</th>

                        <th width="15%" scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, index) in models" :key="index">

                        <!-- MODEL_ATTR -->
                        <th scope="row">{{item.idInventario}}</th>
                        <td>{{item.Descripcion}}</td>
                        <td>{{item.Stock}}</td>
                        <td>{{item.Nombre}}</td>

                        <td>
                            <button title="Editar" class="btn btn-success btn-sm" @click="viewUpdateForm(item)"><b style='color: white;'>✎</b></button>
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
    fk1: [], //productos
    fk2: [], //almacenes
    modoEditar: false,
    modoCrear: false,
    modoVista: true,
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
      model: {Stock: '', Und_Medida: '', Presentacion: '', idProducto: '', idProveedor: ''}
    }
  },
  created(){
    axios.get('./inventarios').then(res=>{
    this.models = null;
    this.models = res.data.model.data;
    this.pagination = res.data.pagination;
    });

    axios.get('./productos/getAll').then(res=>{
    this.fk1 = null;
    this.fk1 = res.data.model;
    });

    axios.get('./almacenes/getAll').then(res=>{
    this.fk2 = null;
    this.fk2 = res.data.model;
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
    }
  },
  methods:{
    getAllData(page){
    axios.get('./inventarios?page='+page).then(res=>{
    this.models = null;
    this.models = res.data.model.data;
    this.pagination = res.data.pagination;
    })
    },
    insertModel(page){
      if(this.model.Stock.length == 0){
        alert('Debes completar todos los campos antes de guardar');
        return;
      }
      const newModel = this.model;

      //MODEL_ATTR
      this.model = {Stock: '', Und_Medida: '', Presentacion: '', idProducto: '', idAlmacen: ''};

      axios.post('./inventarios', newModel)
        .then((res) =>{
          this.modoCrear=false;
          this.modoEditar=false;
          this.modoVista=true;

          this.changePage(1);
        })
    },
    viewCreateForm(){
      this.modoCrear = true;
      this.modoEditar = false;
      this.modoVista = false;
    },
    viewUpdateForm(item){
        //MODEL_ATTR
        this.model.idInventario = item.idInventario;
        this.model.Stock = item.Stock;
        this.model.Und_Medida = item.Und_Medida;
        this.model.Presentacion = item.Presentacion;
        this.model.idProducto = item.idProducto;
        this.model.idAlmacen = item.idAlmacen;

        this.modoEditar = true;
        this.modoCrear = false;
        this.modoVista = false;
    },
    updateModel(model){
      if(this.model.Stock.length == 0){
        alert('Debes completar todos los campos antes de Actualizar');
        return;
      }

      //MODEL_ATTR
      const params = {Stock: model.Stock, Und_Medida: model.Und_Medida, Presentacion: model.Presentacion, idProducto: model.idProducto, idAlmacen: model.idAlmacen};

      axios.put(`./inventarios/${model.idInventario}`, params)
        .then(res=>{
          this.modoEditar = false;
          this.modoCrear = false;
          this.modoVista = true;

          //MODEL_ATTR
          this.model.Stock = '';
          this.model.Und_Medida = '';
          this.model.Presentacion = '';
          this.model.idProducto = '';
          this.model.idAlmacen = '';

          this.changePage(1);
        })
    },
    deleteModel(model, index, page){
      const confirmacion = confirm(`Eliminar la entrada de ${model.Descripcion}`);
      if(confirmacion){
        axios.delete(`./inventarios/${model.idInventario}`)
          .then(()=>{
            this.changePage(page);
          })
      }
    },
    cancelForm(){
      this.modoCrear = false;
      this.modoEditar = false;
      this.modoVista = true;
      this.model = {Stock: '', Und_Medida: '', Presentacion: '', idProducto: '', idAlmacen: ''};
    },
    changePage(page){
        this.pagination.current_page = page;
        this.getAllData(page);
    }
  }
}
</script>
