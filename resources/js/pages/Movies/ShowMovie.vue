<template>
<div>
    <navbar :user="user"></navbar>

    <div class="container pt-5 mt-5" v-if="movie">
        <div class="row">
            <div class="col-md-4">
                <div class="card movie_card">
                    <img :src="'/api/v1/movies/posters/' + movie.posters[0].id" class="card-img-top" alt="">
                    <div class="card-body">
                        <h4 class="text-primary text-center font-weight-bold">{{ movie.title }}</h4>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card movie_card w-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h4 class="text-primary text-center font-weight-bold">{{ movie.title }}</h4>
                            <h4 class="badge badge-primary">
                                {{ movie.stock }} in Stock
                            </h4>
                        </div>

                        <br>

                        <p class="text-muted" style="font-size: 18px;">{{ movie.description }}</p>

                        <div class="mt-5">
                            <span class="badge badge-primary" style="font-size: 18px;">
                                ${{ movie.rental_price }} (Rental Price) 
                            </span>

                            <span class="badge badge-primary" style="font-size: 18px;">
                                ${{ movie.rental_price }} (Rental Price) 
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-5" v-if="movie.posters && movie.posters.length > 1">
            <div class="col-md-4" v-for="(poster, index) in movie.posters" :key="index">
                <hr>
                <img :src="'/api/v1/movies/posters/' + poster.id" class="card-img-top" alt="">
            </div>
        </div>
    </div>
</div>
</template>

<script>
    export default {
        data: function () {
            return {
                user: null,
                movie: null
            };
        },

        created() {
            this.GetMovieDetails();
            this.user = JSON.parse(localStorage.getItem('mt_user'));
        },

        methods: {
            GetMovieDetails() {
                var movie_id = this.$route.params.movie_id;

                axios.get('/api/v1/movies/' + movie_id)
                    .then((res) => {
                        this.movie = res.data;
                    })
                    .catch(function (error) {
                        console.log(error);
                        Vue.swal({
                            toast: true,
                            icon: 'error',
                            title: '¡Ups!',
                            text: 'Movie not found.',
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
