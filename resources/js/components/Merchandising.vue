<template>
    <div class="container-fluid mt-5 mb-5">
        <h3 class="mb-4">Merchandising</h3>
        <div class="row">
          <div class="col-md-4" v-for="(categoria, index) in categorias" :key="index">
              <div class="card mb-5">
                <router-link :to="{ name: 'Productos', params: { id_categoria: categoria.id } }" >
                  <img class="card-img-top3 image" v-bind:src="'/img/Artistas/' + categoria.image" alt="Portada de la canción">
                </router-link>
                  <div class="card-body d-flex justify-content-between">
                      <h5 class="card-title">{{ categoria.name }}</h5>
                      <router-link :to="{ name: 'Productos', params: { id_categoria: categoria.id } }" class="mx-2">
                        <button class="fondo-color tamaño_session mt-1">Acceder</button>
                      </router-link>
                  </div>
              </div>
          </div>
      </div>
        <div class="row">
            <div class="col-md-4">
                <div class="card espaciado-foto mb-5 container">
                    <router-link to="/merchandising/BadBunny"><img src="../../img/Artistas/badbunny.webp" class="card-img-top3 image" alt="Merchandising Bad Bunny"></router-link>
                    <div class="card-body d-flex justify-content-between">
                        <h5 class="card-title p-2">Bad Bunny</h5>
                        <router-link to="/merchandising/BadBunny" class="nav-item nav-link"><button class="fondo-color tamaño_session mt-1">Acceder</button></router-link>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card espaciado-foto mb-5 container">
                    <router-link to="/merchandising/Rosalia"><img src="../../img/Artistas/rosalia.webp" class="card-img-top3 image" alt="Merchandising Rosalia"></router-link>
                    <div class="card-body d-flex justify-content-between">
                        <h5 class="card-title p-2">Rosalia</h5>
                        <router-link to="/merchandising/Rosalia" class="nav-item nav-link"><button class="fondo-color tamaño_session mt-1">Acceder</button></router-link>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card espaciado-foto mb-5 container">
                    <router-link to="/merchandising/EladioCarrion"><img src="../../img/Artistas/eladio.webp" class="card-img-top3 image" alt="Merchandising Eladio Carrión"></router-link>
                    <div class="card-body d-flex justify-content-between">
                        <h5 class="card-title p-2">Eladio Carrión</h5>
                        <router-link to="/merchandising/EladioCarrion" class="nav-item nav-link"><button class="fondo-color tamaño_session mt-1">Acceder</button></router-link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
  
 
<script>
export default {
   data() {
       return {
           categorias: [],
           strSuccess: '',
           strError: ''
       }
   },
   created() {
       this.$axios.get('/sanctum/csrf-cookie').then(response => {
           this.$axios.get('/api/categoria') 
               .then(response => {
                   this.categorias = response.data;
               })
               .catch(function (error) {
                   console.log(error);
               });
           }
       );
   },
   methods: {

   }
}
</script>

<style scoped>

</style>
 
 