<template>
    <div class="card">
        <div class="card-header" v-if="modoVista">
            <button title="Nuevo" style="border-radius: 80%;" class="btn btn-primary btn-sm" @click="crearFormulario()">✚</button>
            &nbsp;&nbsp;&nbsp;<b>GESTIÓN DE ALMACENES</b>
        </div>
        <div class="card-header" v-if="modoCrear">
            <b>NUEVO ALMACEN</b>
        </div>
        <div class="card-header" v-if="modoEditar">
            <b>EDICIÓN DE ALMACEN</b>
        </div>
        <div class="card-body">
            <div>
                <div v-if="modoEditar">
                    <div class="form-group">
                        <label for="formGroupExampleInput">Nombre del Almacen</label>
                        <input type="text" class="form-control mb-2" placeholder="Nombre del Almacen" v-model="almacen.nombre">
                    </div>
                    <div class="form-group">
                        <button class="btn btn-warning" @click="actualizarAlmacen(almacen)">Actualizar</button>
                        <button class="btn btn-danger" @click="cancelar">Cancelar</button>
                    </div>
                    <hr>
                </div>

                <div v-if="modoCrear">
                    <div class="form-group">
                        <label for="formGroupExampleInput">Nombre del Almacen</label>
                        <input type="text" class="form-control mb-2" placeholder="Nombre de la almacen" v-model="almacen.nombre">
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary" @click="agregar(pagination.current_page)">Guardar</button>
                        <button class="btn btn-danger" @click="cancelar">Cancelar</button>
                    </div>
                    <hr>
                </div>

                <table class="table" v-if="modoVista">
                    <thead class="thead-dark">
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, index) in almacenes" :key="index">
                        <th scope="row">{{item.idAlmacen}}</th>
                        <td>{{item.nombre}}</td>
                        <td>
                            <button title="Editar" class="btn btn-success btn-sm" @click="editarFormulario(item)"><b style='color: white;'>✎</b></button>
                            <button title="Eliminar" class="btn btn-danger btn-sm" @click="eliminarAlmacen(item, index, pagination.current_page)"><b>✕</b></button>
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
    almacenes: [],
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
      almacen: {nombre: ''}
    }
  },
  created(){
    axios.get('./almacenes').then(res=>{
    this.almacenes = res.data.almacen.data;
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
    getAlmacenes(page){
    axios.get('./almacenes?page='+page).then(res=>{
    this.almacenes = res.data.almacen.data;
    this.pagination = res.data.pagination;
    })
    },
    agregar(page){
      if(this.almacen.nombre.length == 0){
        alert('Debes completar todos los campos antes de guardar');
        return;
      }
      const almacenNuevo = this.almacen;
      this.almacen = {nombre: ''};

      axios.post('./almacenes', almacenNuevo)
        .then((res) =>{
          //const almacenServidor = res.data;
          this.modoCrear=false;
          this.modoEditar=false;
          this.modoVista=true;

          this.changePage(1);
          //this.almacenes.push(almacenServidor);
        })
    },
    crearFormulario(){
      this.modoCrear = true;
      this.modoEditar = false;
      this.modoVista = false;
    },
    editarFormulario(item){
      this.almacen.nombre = item.nombre;
      this.almacen.idAlmacen = item.idAlmacen;
      this.modoEditar = true;
      this.modoCrear = false;
      this.modoVista = false;
    },
    actualizarAlmacen(almacen){
      if(this.almacen.nombre.length == 0){
        alert('Debes completar todos los campos antes de Actualizar');
        return;
      }
      const params = {nombre: almacen.nombre};
      axios.put(`./almacenes/${almacen.idAlmacen}`, params)
        .then(res=>{
          this.modoEditar = false;
          this.modoCrear = false;
          this.modoVista = true;
          this.almacen.nombre = '';

          const index = this.almacenes.findIndex(item => item.idAlmacen === almacen.idAlmacen);
          this.almacenes[index] = res.data;
        })
    },
    eliminarAlmacen(almacen, index, page){
      const confirmacion = confirm(`Eliminar ${almacen.nombre}`);
      if(confirmacion){
        axios.delete(`./almacenes/${almacen.idAlmacen}`)
          .then(()=>{
        //this.almacenes.splice(index, 1);
            this.changePage(page);
          })
      }
    },
    cancelar(){
      this.modoCrear = false;
      this.modoEditar = false;
      this.modoVista = true;
      this.almacen = {nombre: ''};
    },
    changePage(page){
        //alert(page);
        this.pagination.current_page = page;
        this.getAlmacenes(page);
    }
  }
}
</script>
