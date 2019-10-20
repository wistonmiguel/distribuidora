<template>
<div class="card">
  <div class="card-header"><b>GESTIÓN DE ALMACENES</b> <button class="btn btn-primary btn-sm" @click="crearFormulario()">+</button> </div>
    <div class="card-body">
  <div>
    <div v-if="modoEditar">
    <form @submit.prevent="editarAlmacen(almacen)">
      <h3>Editar almacen</h3>
      <input type="text" class="form-control mb-2" placeholder="Nombre de la almacen" v-model="almacen.nombre">
      <button class="btn btn-warning" type="submit">Editar</button>
      <button class="btn btn-danger" @click="cancelar">Cancelar</button>
    </form>
    <hr>
    </div>
    
    <div v-if="modoCrear">
      <form @submit.prevent="agregar()">
      <h3>Nuevo Almacen</h3>
      <input type="text" class="form-control mb-2" placeholder="Nombre de la almacen" v-model="almacen.nombre">
      <button class="btn btn-warning" type="submit">Editar</button>
      <button class="btn btn-danger" @click="cancelar">Cancelar</button>
    </form>

    </div>

    <table class="table table-dark">
  <thead>
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
        <button class="btn btn-warning btn-sm" @click="editarFormulario(item)">Editar</button>
        <button class="btn btn-danger btn-sm" @click="eliminarAlmacen(item, index)">Eliminar</button>
      </td>
    </tr>
  </tbody>
</table>
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
      almacen: {nombre: ''}
    }
  },
  created(){
    axios.get('./almacenes').then(res=>{
      this.almacenes = res.data;
    })
  },
  methods:{
    agregar(){
      if(this.almacen.nombre.trim() === ''){
        alert('Debes completar todos los campos antes de guardar');
        return;
      }
      const almacenNuevo = this.almacen;
      this.almacen = {nombre: ''};    
      
      axios.post('./almacenes', almacenNuevo)
        .then((res) =>{
          const almacenServidor = res.data;
          this.modoCrear=true;
          this.almacenes.push(almacenServidor);
        })
    },
    crearFormulario(){
      this.modoCrear = true;
    },
    editarFormulario(item){
      this.almacen.nombre = item.nombre;
      this.almacen.idAlmacen = item.idAlmacen;
      this.modoEditar = true;
    },
    editarAlmacen(almacen){
      const params = {nombre: almacen.nombre};
      axios.put(`./almacenes/${almacen.idAlmacen}`, params)
        .then(res=>{
          this.modoEditar = false;
          this.almacen.nombre = '';
          const index = this.almacenes.findIndex(item => item.idAlmacen === almacen.idAlmacen);
          this.almacenes[index] = res.data;
        })
    },
    eliminarAlmacen(almacen, index){
      const confirmacion = confirm(`Eliminar ${almacen.nombre}`);
      if(confirmacion){
        axios.delete(`./almacenes/${almacen.idAlmacen}`)
          .then(()=>{
            this.almacenes.splice(index, 1);
          })
      }
    },
    cancelar(){
      this.modoCrear = false;
      this.modoEditar = false;
      this.almacen = {nombre: ''};
    }
  }
}
</script>