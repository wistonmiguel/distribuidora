<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Panel de Informes</div>

                    <div class="card-body">
                        <div class="col-12">

                            <div class="row pb-4">
                                <div class="col-2">
                                    <button @click="funcion" class="btn btn-primary">Pdf</button>
                                </div>
                                <div class="col-10" style="padding-top: 5px;">
                                    <span>COMPRAS A PROVEEDORES EN EL MES</span>
                                </div>
                            </div>

                            <div class="row pb-4">
                                <div class="col-2">
                                    <button @click="funcion2" class="btn btn-primary">Pdf</button>
                                </div>
                                <div class="col-10" style="padding-top: 5px;">
                                    <span>VENTAS A CLIENTES DEL PRODUCTO JABON DE BAÑO</span>
                                </div>
                            </div>

                            <div class="row pb-4">
                                <div class="col-2">
                                    <button @click="funcion3" class="btn btn-primary">Pdf</button>
                                </div>
                                <div class="col-10" style="padding-top: 5px;">
                                    <span>NO. FACTURA, CLIENTE Y VENDEDOR DE LAS DEVOLUCIONES</span>
                                </div>
                            </div>

                            <div class="row pb-4">
                                <div class="col-2">
                                    <button @click="funcion4" class="btn btn-primary">Pdf</button>
                                </div>
                                <div class="col-10" style="padding-top: 5px;">
                                    <span>CLIENTES DE COMPRAS AL MENUDEO</span>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
  created(){
  },
  methods:{
    funcion(){
        window.open('./compras/comprasMesPDF', 'Informe de Compras' , 'width=462,height=642,scrollbars=YES');
    },
    funcion2(){
        window.open('./ventas/ventasJabonBaño', 'Informe de Ventas' , 'width=462,height=642,scrollbars=YES');
    },
    funcion3(){
        window.open('./ventasdevolucion/devolucionesPDF', 'Informe de Devoluciones sobre Ventas' , 'width=462,height=642,scrollbars=YES');
    },
    funcion4(){
    alert("cargar informe 4");
    }
}
}
</script>
