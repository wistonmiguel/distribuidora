<template>
    <div class="card">
        <div class="card-header" v-if="modoVista">
            <button title="Nuevo" style="border-radius: 80%;" class="btn btn-primary btn-sm" @click="viewCreateForm()">✚</button>
            &nbsp;&nbsp;&nbsp;<b>TRANSACCIONES DE COMPRAS</b>
        </div>
        <div class="card-header" v-if="modoCrear">
            <b>NUEVA COMPRA</b>
        </div>
        <div class="card-header" v-if="modoEditar">
            <b>EDICIÓN DE TRANSACCIÓN DE COMPRA</b>
        </div>
        <div class="card-body">
            <div>
                <div v-if="modoEditar">
                    <div class="form-group">
                        <!-- MODEL_ATTR -->
                        <label for="formGroupExampleInput">Nombre</label>
                        <input type="text" class="form-control mb-2" placeholder="Nombre del Producto" v-model="model.Fecha">
                        <label for="formGroupExampleInput">Marca</label>
                        <input type="text" class="form-control mb-2" placeholder="Marca del Producto" v-model="model.Activa">
                        <label for="formGroupExampleInput">Proveedor</label>
                        <select v-model="model.idProveedor" class="form-control">
                            <option v-for="item in fk1" :key="item" :value="item.idProveedor">{{item.Nombre}}</option>
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
                        <label for="formGroupExampleInput">Nombre</label>
                        <input type="text" class="form-control mb-2" placeholder="Nombre del Producto" v-model="model.Fecha">
                        <label for="formGroupExampleInput">Marca</label>
                        <input type="text" class="form-control mb-2" placeholder="Marca del Producto" v-model="model.Activa">
                        <label for="formGroupExampleInput">Proveedor</label>
                        <!-- FK -->
                        <select v-model="model.idProveedor" class="form-control">
                            <option v-for="item in fk1" :key="item" :value="item.idProveedor">{{item.Nombre}}</option>
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
                        <th>Fecha</th>
                        <th>Estado</th>
                        <th>Tipo de Pago</th>

                        <th width="15%" scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, index) in models" :key="index">

                        <!-- MODEL_ATTR -->
                        <th scope="row">{{item.idTransaccion}}</th>
                        <td>{{item.Fecha}}</td>
                        <td>{{item.Estado}}</td>
                        <td>{{item.Nombre}}</td>

                        <td>
                            <button title="Editar" class="btn btn-success btn-sm" @click="viewUpdateForm(item)"><b style='color: white;'>✎</b></button>
                            <button title="Eliminar" class="btn btn-danger btn-sm" @click="deleteModel(item, index, pagination.current_page)"><b>✕</b></button>
                        </td>
                        </tr>
                    </tbody>
                </table>

                <hr v-if="modoVista" class="mb-4" style="margin-top: -16px;">

                <div id="paginationContainer" style="float: right; margin-bottom: -20px;">
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
    fk1: [], //
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
      model: {Descripcion: '', Marca: '', idProveedor: ''}
    }
  },
  created(){
    axios.get('./compras').then(res=>{
    this.models = null;
    this.models = res.data.model.data;
    this.pagination = res.data.pagination;
    });

    axios.get('./proveedores/getAll').then(res=>{
    this.fk1 = null;
    this.fk1 = res.data.model;
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
    axios.get('./compras?page='+page).then(res=>{
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

      //MODEL_ATTR COMPRA + DETALLES DE COMPRA (DINAMICO)
      this.model = {Descripcion: '', Marca: '', idProveedor: ''};

      axios.post('./compras', newModel)
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
        this.model.idTransaccion = item.idTransaccion;
        this.model.Fecha = item.Fecha;
        this.model.Activa = item.Activa;
        this.model.idProveedor = item.idProveedor;

        this.modoEditar = true;
        this.modoCrear = false;
        this.modoVista = false;
    },
    updateModel(model){
      if(this.model.Fecha.length == 0){
        alert('Debes completar todos los campos antes de Actualizar');
        return;
      }

      //MODEL_ATTR
      const params = {Descripcion: model.Fecha, Marca: model.Activa, idProveedor: model.idProveedor};

      axios.put(`./compras/${model.idTransaccion}`, params)
        .then(res=>{
          this.modoEditar = false;
          this.modoCrear = false;
          this.modoVista = true;

          //MODEL_ATTR
          this.model.Fecha = '';
          this.model.Activa = '';
          this.model.idProveedor = '';

          this.changePage(1);
        })
    },
    deleteModel(model, index, page){
      const confirmacion = confirm(`Eliminar ${model.Fecha}`);
      if(confirmacion){
        axios.delete(`./compras/${model.idTransaccion}`)
          .then(()=>{
            this.changePage(page);
          })
      }
    },
    cancelForm(){
      this.modoCrear = false;
      this.modoEditar = false;
      this.modoVista = true;
      this.model = {Descripcion: '', Marca: '', idProveedor: ''};
    },
    changePage(page){
        this.pagination.current_page = page;
        this.getAllData(page);
    }
  }
}
</script>
