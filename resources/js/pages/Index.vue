<template>
<div>
    <navbar></navbar>

    <div class="container pt-5 mt-5" v-if="movies">
        <div class="row">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="text-primary font-weight-bold m-0 p-0">
                            ALL MOVIES
                        </h3>
                        <span class="text-secondary font-weight-bold p-0 m-0">{{ movies.from }}-{{ movies.to }} of {{ movies.total }} movies</span>
                    </div>
                    <pagination :limit="-1" show-disabled :data="movies" @pagination-change-page="GetMovies">
                        <span slot="prev-nav"><i class="fas fa-angle-left"></i> Prev</span>
                        <span slot="next-nav"><i class="fas fa-angle-right"></i> Next</span>
                    </pagination>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">

            <div class="card movie_card" v-for="(movie, index) in movies.data" :key="index">
                <img src="https://www.joblo.com/assets/images/joblo/posters/2019/02/detective-pikachu-trailer-poster-main.jpg" class="card-img-top" alt="">
                <div class="card-body">
                    <i class="fas fa-play play_button">
                    </i>
                    <br>
                    <h5 class="card-title">{{ movie.title }}</h5>
                    <span class="movie_info">2019</span>
                    <span class="movie_info float-right"><i class="fas fa-star"></i></span>
                </div>
            </div>
        </div>
    </div>

    <b-modal centered size="sm" hide-header hide-footer id="show_movie_details" ref="show_movie_details">
        <p class="my-4">Hello from modal!</p>
    </b-modal>
</div>
</template>

<script>
    import Pagination from "laravel-vue-pagination";

    export default {
        components: {
            pagination: Pagination,
        },

        data: function () {
            return {
                movies: null,
                selected_movie: null,
            };
        },

        created() {
            this.GetMovies();
        },

        methods: {
            GetMovies(page = 1) {
                axios.get('/api/v1/movies?page=' + page)
                    .then((res) => {
                        this.movies = res.data;
                    })
                    .catch(function (error) {
                        console.log(error);
                        Vue.swal({
                            toast: true,
                            icon: 'error',
                            title: '¡Ups!',
                            text: 'No se pudo cargar su informacion.',
                            position: 'bottom-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                        });
                    });
            }
        }
    }

</script>
