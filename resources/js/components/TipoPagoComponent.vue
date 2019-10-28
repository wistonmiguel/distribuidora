<template>
    <div class="card">
        <div class="card-header" v-if="modoVista">
            <button title="Nuevo" style="border-radius: 80%;" class="btn btn-primary btn-sm" @click="viewCreateForm()">✚</button>
            &nbsp;&nbsp;&nbsp;<b>GESTIÓN DE TIPOS DE PAGO</b>
        </div>
        <div class="card-header" v-if="modoCrear">
            <b>NUEVO TIPO DE PAGO</b>
        </div>
        <div class="card-header" v-if="modoEditar">
            <b>EDICIÓN DE TIPOS DE PAGO</b>
        </div>
        <div class="card-body">
            <div>
                <div v-if="modoEditar">
                    <div class="form-group">
                        <label for="formGroupExampleInput">Nombre del Tipo</label>
                        <input type="text" class="form-control mb-2" placeholder="Nombre del Tipo de Pago" v-model="model.Nombre">
                    </div>
                    <div class="form-group">
                        <button class="btn btn-warning" @click="updateModel(model, pagination.current_page)">Actualizar</button>
                        <button class="btn btn-danger" @click="cancelForm">Cancelar</button>
                    </div>
                </div>

                <div v-if="modoCrear">
                    <div class="form-group">
                        <label for="formGroupExampleInput">Nombre del Tipo de Pago</label>
                        <input type="text" class="form-control mb-2" placeholder="Nombre del Tipo de Pago" v-model="model.Nombre">

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
                        <th>Nombre</th>
                        <th width="15%" scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, index) in models" :key="index">
                        <th scope="row">{{item.idTipoPago}}</th>
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
      model: {Nombre: ''}
    }
  },
  created(){
    axios.get('./tipoPagos').then(res=>{
    this.models = null;
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
    axios.get('./tipoPagos?page='+page).then(res=>{
    this.models = null;
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
      this.model = {Nombre: ''};

      axios.post('./tipoPagos', newModel)
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
      this.model.Nombre = item.Nombre;
      this.model.idTipoPago = item.idTipoPago;
      this.modoEditar = true;
      this.modoCrear = false;
      this.modoVista = false;
    },
    updateModel(model, page){
      if(this.model.Nombre.length == 0){
        alert('Debes completar todos los campos antes de Actualizar');
        return;
      }
      const params = {Nombre: model.Nombre};
      axios.put(`./tipoPagos/${model.idTipoPago}`, params)
        .then(res=>{
          this.modoEditar = false;
          this.modoCrear = false;
          this.modoVista = true;
          this.model.Nombre = '';
          this.changePage(page);
        })
    },
    deleteModel(model, index, page){
      const confirmacion = confirm(`Eliminar ${model.Nombre}`);
      if(confirmacion){
        axios.delete(`./tipoPagos/${model.idTipoPago}`)
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
        this.pagination.current_page = page;
        this.getAllData(page);
    }
  }
}
</script>
