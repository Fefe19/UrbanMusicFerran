<template>
  <div class="container-fluid mt-5 mb-5">
    <h3 class="mb-4">Administrador de Canciones</h3>
    <div class="card card-default d-flex px-5 py-5">
      <div v-if="strSuccess" class="alert alert-success alert-dismissible fade show" role="alert">
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  <strong>{{strSuccess}}</strong>
              </div>
  
              <div v-if="strError" class="alert alert-danger alert-dismissible fade show" role="alert">
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  <strong>{{strError}}</strong>
              </div>
      <div class=" p-1">

        <div class="d-flex justify-content-between pb-2 mb-2">
          <h5 class="card-title mt-2">Listado Canciones Disponibles</h5>
          <div>
          <router-link :to="{name: 'formularioañadircanciones'}" class="nav-item nav-link mb-4">
            <div class="añadir mt-2" aria-label="añadir" ></div>
          </router-link>
        </div>
      </div>
        <input type="text" v-model="busqueda" placeholder="Buscar productos" class="form-control mb-5">
        <div class="table-responsive">
          <table class="table table-hover align-middle table-sm table-bordered">
            <thead class="bg-dark text-light">
              <tr>
                <th class="text-center" style="width: 5%;">#</th>
                <th class="text-center" style="width: 20%;">Nombre Canción</th>
                <th class="text-center" style="width: 20%">Canción</th>
                <th class="text-center" style="width: 5%">Imagen</th>
                <th class="text-center" style="width: 8%">Acción</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(cancion, index) in productosFiltrados" :key="index">
                <td class="text-center">{{index}}</td>
                <td class="text-center">{{cancion.name}}</td>
                <td class="text-center">{{cancion.audio}}</td>
                <td class="text-center">
                  <div v-if="cancion.image">
                    <img alt="cancion-img" width="100" v-bind:src="'/img/Music_Imagenes/' + cancion.image">
                  </div>
                </td>
                <td class="text-center">
                  <div class="d-flex justify-content-center">
                    <div v-if="hasUserRole('editar')" class="d-flex align-items-center">
                      <router-link :to="{ name: 'formularioeditarcanciones', params: { id: cancion.id } }" class="mx-2">
                        <div class="editar" aria-label="editar"></div>
                      </router-link>
                    </div>
                    <div  class="d-flex align-items-center">
                      <div v-if="hasUserRole('eliminar')" class="eliminar mx-2" @click="eliminarCancion(cancion.id)"></div>
                    </div>
                  </div>
                </td>

              </tr>
            </tbody>
          </table>
        </div>
        <div class="mt-3">
            <router-link to="/" class="nav-item nav-link">
              <button class="fondo-color tamaño_session2 mt-4">Volver al Inicio</button>
            </router-link>
        </div>
      </div>
    </div>
  </div>
</template>


<script>
export default {
  data() {
      return {
          isLoggedin: false,
          user: null,
          canciones: [],
          strSuccess: '',
          strError: '',
          busqueda: '',
          
      }
  },
  
  created() {
    if (window.Laravel.isLoggedin) {
      this.isLoggedin = true;
      this.user = window.Laravel.user;
    }

    this.$axios
      .get('/sanctum/csrf-cookie')
      .then(() => {
        this.$axios
          .get('/api/cancionesAdmin')
          .then(response => {
            this.canciones = response.data;
          })
          .catch(error => {
            if (error.response && error.response.status === 403) {
              this.strError = 'No tienes permiso para ver las canciones';
            } else {
              this.strError = 'Ocurrió un error al cargar las canciones';
            }
            console.log(error);
          });
      })
      .catch(error => {
        this.strError = 'Error al obtener el token CSRF';
        console.log(error);
      });
  },computed: {
  productosFiltrados() {
    if (this.busqueda.trim() === '') {
      return this.canciones;
    } else {
      return this.canciones.filter(cancion =>
        cancion.name.toLowerCase().includes(this.busqueda.toLowerCase())
      );
    }
  }
},
  methods: {
    eliminarCancion(id) {
  let existObj = this;
  this.$axios
    .delete('/api/cancionesAdmin/delete/' + id)
    .then(response => {
      existObj.strSuccess = response.data.success;
      
      this.$axios
        .get('/api/cancionesAdmin')
        .then(response => {
          existObj.canciones = response.data;
        })
        .catch(function(error) {
          console.log(error);
        });
    })
    .catch(error => {
      existObj.strError = error.response.data.error;
      existObj.strSuccess = '';
    });
},hasUserRole(role) {
    if (this.user && this.user.roles) {
      return this.user.roles.some(userRole => userRole.rol === role);
    }
    return false;
  }
  

  }, beforeRouteEnter(to, from, next) {
  if (!window.Laravel.isLoggedin) {
    window.location.href = "/";
  } else {
    let canAccesUser = false;

    // Bucle para comprobar si existe el rol 
    for (let role of window.Laravel.user.roles) {
      if (role.rol === 'accederAdmin') {
        canAccesUser = true;
      }

    }

    if (canAccesUser) {
      next();
    } else {
      next('/');
    }
  }
}
  
}

</script>