<template>
<div>
    <navbar :user="user"></navbar>

    <div class="container pt-5 mt-5" v-if="movies.data.length > 0">
        <div class="row">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="text-primary font-weight-bold m-0 p-0">
                            ALL MOVIES
                        </h3>
                        <span class="text-secondary font-weight-bold p-0 m-0">{{ movies.from }}-{{ movies.to }} of {{ movies.total }} movies</span>
                    </div>

                    <b-button-group>
                        <b-button @click="GetMovies(1)" variant="secondary"><i class="fas fa-redo"></i></b-button>
                        <b-button v-b-modal.create_movie variant="primary"><i class="fas fa-plus"></i></b-button>
                        <b-button v-b-modal.sort_movies variant="success"><i class="fas fa-filter"></i> Sort</b-button>
                    </b-button-group>

                    <b-modal centered size="sm" hide-header hide-footer id="create_movie" ref="create_movie">
                        <Create-Movie v-on:MovieCreated="MovieCreated"></Create-Movie>
                    </b-modal>

                    <b-modal centered size="sm" hide-header hide-footer id="sort_movies" ref="sort_movies">
                        <form @submit.prevent="SortMovies()">
                            <div class="form-group">
                                <h2 class="text-muted font-weight-bold text-center">
                                    SORT <span class="text-primary">MOVIES</span>
                                </h2>
                            </div>

                            <br>

                            <div class="form-group">
                                <label class="text-muted font-weight-bold">Available/Unavailable</label>
                                <b-form-select v-model="sort_movies.availability">
                                    <b-form-select-option :value="true">Select Available Movies</b-form-select-option>
                                    <b-form-select-option :value="false">Select Unavailable Movies</b-form-select-option>
                                </b-form-select>
                            </div>

                            <div class="form-group" v-if="sort_movies.availability">
                                <label class="text-muted font-weight-bold">Sort By</label>
                                <b-form-select v-model="sort_movies.field">
                                    <b-form-select-option value="title">Sort By Title</b-form-select-option>
                                    <b-form-select-option value="popularity">Sort By Popularity</b-form-select-option>
                                </b-form-select>
                            </div>

                            <br>

                            <div class="form-group">
                                <input type="submit" class="btn btn-block btn-primary" value="SORT MOVIES">
                            </div>
                        </form>
                    </b-modal>
                </div>
            </div>
            <div class="col-md-12">
                <div class="d-flex justify-content-end align-items-center">
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

        <b-modal centered size="md" hide-header hide-footer id="show_movie_details" ref="show_movie_details">
            <Show-Movie :movie="selected_movie"></Show-Movie>
        </b-modal>
    </div>

    <div class="container" v-else>
        <div class="row vh-100 justify-content-center align-items-center">
            <div class="col-md-4 col-sm-12 text-center">
                <i class="fas fa-exclamation-triangle d-block text-primary" style="font-size: 4rem"></i>
                <br />
                <h4>
                    UPS!<br />
                    <small>No movies found.</small>
                </h4>
            </div>
        </div>
    </div>
</div>
</template>

<script>
    import Pagination from "laravel-vue-pagination";
    import ShowMovie from './Movies/ShowMovie';
    import CreateMovie from './Movies/CreateMovie';
    import UpdateMovie from './Movies/UpdateMovie';

    export default {
        components: {
            'pagination': Pagination,
            'Show-Movie': ShowMovie,
            'Create-Movie': CreateMovie,
            'Update-Movie': UpdateMovie,
        },

        data: function () {
            return {
                movies: {
                    data: []
                },
                selected_movie: null,
                user: null,

                sort_movies: {
                    availability: true,
                    field: 'title',
                }
            };
        },

        created() {
            this.GetMovies();
            this.user = JSON.parse(localStorage.getItem('mt_user'));
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
                            text: 'Movies not loaded',
                            position: 'bottom-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                        });
                    });
            },

            MovieCreated(new_movie) {
                this.movie.data.unshift(new_movie);
            },

            SortMovies(page = 1) {
                var formData = new FormData();
                formData.append('availability', this.sort_movies.availability);
                if(this.sort_movies.field == 'popularity') {
                    formData.append('popularity', true);
                }

                axios.get('/api/v1/admin/movies?page=' + page, formData)
                    .then((res) => {
                        this.movies = res.data;
                    })
                    .catch(function (error) {
                        console.log(error);
                        Vue.swal({
                            toast: true,
                            icon: 'error',
                            title: '¡Ups!',
                            text: 'Movies not loaded',
                            position: 'bottom-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                        });
                    });
            },

            ShowMovieDetails(movie) {
                this.selected_movie = movie;
                this.$bvModal.show('show_movie_details');
            }
        }
    }

</script>
