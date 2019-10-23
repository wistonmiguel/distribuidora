<template>
    <div class="card">
        <div class="card-header" v-if="modoVista">
            <button title="Nuevo" style="border-radius: 80%;" class="btn btn-primary btn-sm" @click="viewCreateForm()">✚</button>
            &nbsp;&nbsp;&nbsp;<b>GESTIÓN DE PROVEEDORES</b>
        </div>
        <div class="card-header" v-if="modoCrear">
            <b>NUEVO PROVEEDOR</b>
        </div>
        <div class="card-header" v-if="modoEditar">
            <b>EDICIÓN DE PROVEEDOR</b>
        </div>
        <div class="card-body">
            <div>
                <div v-if="modoEditar">
                    <div class="form-group">
                        <label for="formGroupExampleInput">Nombre</label>
                        <input type="text" class="form-control mb-2" placeholder="Nombre del Proveedor" v-model="model.Nombre">
                        <label for="formGroupExampleInput">Telefono</label>
                        <input type="text" class="form-control mb-2" placeholder="Telefono del Proveedor" v-model="model.Telefono">
                        <label for="formGroupExampleInput">Direccion</label>
                        <input type="text" class="form-control mb-2" placeholder="Direccion del Proveedor" v-model="model.Direccion">
                    </div>
                    <div class="form-group">
                        <button class="btn btn-warning" @click="updateModel(model)">Actualizar</button>
                        <button class="btn btn-danger" @click="cancelForm">Cancelar</button>
                    </div>
                    <hr>
                </div>

                <div v-if="modoCrear">
                    <div class="form-group">
                        <label for="formGroupExampleInput">Nombre</label>
                        <input type="text" class="form-control mb-2" placeholder="Nombre del Proveedor" v-model="model.Nombre">
                        <label for="formGroupExampleInput">Telefono</label>
                        <input type="text" class="form-control mb-2" placeholder="Telefono del Proveedor" v-model="model.Telefono">
                        <label for="formGroupExampleInput">Direccion</label>
                        <input type="text" class="form-control mb-2" placeholder="Direccion del Proveedor" v-model="model.Direccion">
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary" @click="insertModel(pagination.current_page)">Guardar</button>
                        <button class="btn btn-danger" @click="cancelForm">Cancelar</button>
                    </div>
                    <hr>
                </div>

                <table class="table" v-if="modoVista">
                    <thead class="thead-dark">
                        <tr>
                        <th width="10%" scope="col">#</th>
                        <th>Nombre</th>
                        <th>Telefono</th>
                        <th>Direccion</th>
                        <th width="15%" scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, index) in models" :key="index">
                        <th scope="row">{{item.idProveedor}}</th>
                        <td>{{item.Nombre}}</td>
                        <td>{{item.Telefono}}</td>
                        <td>{{item.Direccion}}</td>
                        <td>
                            <button title="Editar" class="btn btn-success btn-sm" @click="viewUpdateForm(item)"><b style='color: white;'>✎</b></button>
                            <button title="Eliminar" class="btn btn-danger btn-sm" @click="deleteModel(item, index, pagination.current_page)"><b>✕</b></button>
                        </td>
                        </tr>
                    </tbody>
                </table>

                <hr class="mb-4" style="margin-top: -16px;">

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
      model: {Nombre: '', Telefono: '', Direccion: ''}
    }
  },
  created(){
    axios.get('./proveedores').then(res=>{
    this.models = res.data.model.data;
    this.pagination = res.data.pagination;
    })
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
    axios.get('./proveedores?page='+page).then(res=>{
    this.models = res.data.model.data;
    this.pagination = res.data.pagination;
    })
    },
    insertModel(page){
      if(this.model.Nombre.length == 0){
        alert('Debes completar todos los campos antes de guardar');
        return;
      }
      const newModel = this.model;
      this.model = {Nombre: '', Telefono: '', Direccion: ''};

      axios.post('./proveedores', newModel)
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
        this.model.idProveedor = item.idProveedor;
        this.model.Nombre = item.Nombre;
        this.model.Telefono = item.Telefono;
        this.model.Direccion = item.Direccion;
        this.modoEditar = true;
        this.modoCrear = false;
        this.modoVista = false;
    },
    updateModel(model){
      if(this.model.Nombre.length == 0){
        alert('Debes completar todos los campos antes de Actualizar');
        return;
      }
      const params = {Nombre: model.Nombre, Telefono: model.Telefono, Direccion: model.Direccion};
      axios.put(`./proveedores/${model.idProveedor}`, params)
        .then(res=>{
          this.modoEditar = false;
          this.modoCrear = false;
          this.modoVista = true;
          this.model.Nombre = '';
          this.model.Telefono = '';
          this.model.Direccion = '';

          const index = this.models.findIndex(item => item.idProveedor === model.idProveedor);
          this.models[index] = res.data;
        })
    },
    deleteModel(model, index, page){
      const confirmacion = confirm(`Eliminar ${model.Nombre}`);
      if(confirmacion){
        axios.delete(`./proveedores/${model.idProveedor}`)
          .then(()=>{
        //this.models.splice(index, 1);
            this.changePage(page);
          })
      }
    },
    cancelForm(){
      this.modoCrear = false;
      this.modoEditar = false;
      this.modoVista = true;
      this.model = {Nombre: ''};
    },
    changePage(page){
        //alert(page);
        this.pagination.current_page = page;
        this.getAllData(page);
    }
  }
}
</script>
