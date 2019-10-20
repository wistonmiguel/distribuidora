<template>
<div class="card">
  <div class="card-header"><button class="btn btn-primary btn-sm" @click="crearFormulario()">☩</button> <b>GESTIÓN DE ALMACENES</b> </div>
    <div class="card-body">
  <div>
    <div v-if="modoEditar">
      <h3>Editar almacen</h3>
      <input type="text" class="form-control mb-2" placeholder="Nombre de la almacen" v-model="almacen.nombre">
      <button class="btn btn-warning" @click="editarAlmacen(almacen)">Editar</button>
      <button class="btn btn-danger" @click="cancelar">Cancelar</button>
    <hr>
    </div>

    <div v-if="modoCrear">
      <h3>Nuevo Almacen</h3>
      <input type="text" class="form-control mb-2" placeholder="Nombre de la almacen" v-model="almacen.nombre">
      <button class="btn btn-primary" @click="agregar">Guardar</button>
      <button class="btn btn-danger" @click="cancelar">Cancelar</button>
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
        <button class="btn btn-warning btn-sm" @click="editarFormulario(item)">✎ </button>
        <button class="btn btn-danger btn-sm" @click="eliminarAlmacen(item, index)">✕ </button>
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
      modoVista: true,
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
      if(this.almacen.nombre.length == 0){
        alert('Debes completar todos los campos antes de guardar');
        return;
      }
      const almacenNuevo = this.almacen;
      this.almacen = {nombre: ''};

      axios.post('./almacenes', almacenNuevo)
        .then((res) =>{
          const almacenServidor = res.data;
          this.modoCrear=false;
          modoEditar: false;
          this.modoVista=true;
          this.almacenes.push(almacenServidor);
        })
    },
    crearFormulario(){
      this.modoCrear = true;
      this.modoVista = false;
    },
    editarFormulario(item){
      this.almacen.nombre = item.nombre;
      this.almacen.idAlmacen = item.idAlmacen;
      this.modoEditar = true;
      this.modoVista = false;
    },
    editarAlmacen(almacen){
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
      this.modoVista = true;
      this.almacen = {nombre: ''};
    }
  }
}
</script>
