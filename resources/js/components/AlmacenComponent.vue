<template>
  <div>
    <form @submit.prevent="editarAlmacen(almacen)" v-if="modoEditar">
      <h3>Editar almacen</h3>
      <input type="text" class="form-control mb-2" 
        placeholder="Nombre de la almacen" v-model="almacen.nombre">
      <input type="text" class="form-control mb-2" 
        placeholder="Descripción de la almacen" v-model="almacen.descripcion">
      <button class="btn btn-warning" type="submit">Editar</button>
      <button class="btn btn-danger" type="submit" 
        @click="cancelarEdicion">Cancelar</button>
    </form>
    <form @submit.prevent="agregar" v-else>
      <h3>Agregar almacen</h3>
      <input type="text" class="form-control mb-2" 
        placeholder="Nombre de la almacen" v-model="almacen.nombre">
      <input type="text" class="form-control mb-2" 
        placeholder="Descripción de la almacen" v-model="almacen.descripcion">
      <button class="btn btn-primary" type="submit">Agregar</button>
    </form>
    <hr>
    <h3>Lista de almacens:</h3>
    <ul class="list-group">
         <li class="list-group-item" 
            v-for="(item, index) in almacenes" :key="index" >
          <span class="badge badge-primary float-right">
            {{item.updated_at}}
          </span>
          <p>{{item.nombre}}</p>
          <p>{{item.descripcion}}</p>
          <p>
            <button class="btn btn-warning btn-sm" 
                @click="editarFormulario(item)">Editar</button>
            <button class="btn btn-danger btn-sm" 
                @click="eliminarAlmacen(item, index)">Eliminar</button>
          </p>
        </li>
    </ul>
  </div>
</template>

<script>
export default {
  data() {
    return {
      almacenes: [],
      modoEditar: false,
      almacen: {nombre: '', descripcion: ''}
    }
  },
  created(){
    axios.get('/almacenes').then(res=>{
      this.almacenes = res.data;
    })
  },
  methods:{
    agregar(){
      if(this.almacen.nombre.trim() === '' || this.almacen.descripcion.trim() === ''){
        alert('Debes completar todos los campos antes de guardar');
        return;
      }
      const almacenNuevo = this.almacen;
      this.almacen = {nombre: '', descripcion: ''};    
      axios.post('/almacenes', almacenNuevo)
        .then((res) =>{
          const almacenServidor = res.data;
          this.almacenes.push(almacenServidor);
        })
    },
    editarFormulario(item){
      this.almacen.nombre = item.nombre;
      this.almacen.descripcion = item.descripcion;
      this.almacen.id = item.id;
      this.modoEditar = true;
    },
    editarAlmacen(almacen){
      const params = {nombre: almacen.nombre, descripcion: almacen.descripcion};
      axios.put(`/almacenes/${almacen.id}`, params)
        .then(res=>{
          this.modoEditar = false;
          const index = this.almacenes.findIndex(item => item.id === almacen.id);
          this.almacenes[index] = res.data;
        })
    },
    eliminarAlmacen(almacen, index){
      const confirmacion = confirm(`Eliminar almacen ${almacen.nombre}`);
      if(confirmacion){
        axios.delete(`/almacenes/${almacen.id}`)
          .then(()=>{
            this.almacenes.splice(index, 1);
          })
      }
    },
    cancelarEdicion(){
      this.modoEditar = false;
      this.almacen = {nombre: '', descripcion: ''};
    }
  }
}
</script>
