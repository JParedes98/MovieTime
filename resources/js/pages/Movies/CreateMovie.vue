<template>
<form @submit.prevent="CreateMovie">
    <div class="form-group">
        <h2 class="text-muted text-center font-weight-bold">NEW <span class="text-primary">MOVIE</span></h2>
    </div>

    <div class="form-group">
        <label class="text-muted font-weight-bold" for="movie.title">Title</label>
        <input type="text" v-model="movie.title" id="movie.title" :class="{ 'is-invalid': validation.hasError('movie.')}" class="form-control" placeholder="Type here the movie title">
        <div class="text-danger font-weight-bold">{{ validation.firstError('movie.title') }}</div>
    </div>

    <div class="form-group">
        <label class="text-muted font-weight-bold" for="movie.description">Description</label>
        <textarea type="text" rows="3" v-model="movie.description" id="movie.description" :class="{ 'is-invalid': validation.hasError('movie.description')}" class="form-control" placeholder="Type here the Movie description..."></textarea>
        <div class="text-danger font-weight-bold">{{ validation.firstError('movie.description') }}</div>
    </div>

    <div class="form-group text-center">
        <label class="switch">
            <input type="checkbox" v-model="movie.availability" id="is_parent" name="is_parent" checked />
            <span class="slider round"></span>
        </label>
        <span class="text-muted">Movie is available?</span>
        <div class="text-danger font-weight-bold">{{ validation.firstError('movie.availability') }}</div>
    </div>

    <div class="form-group">
        <label class="text-muted font-weight-bold" for="movie.stock">Stock</label>
        <input type="number" v-model="movie.stock" id="movie.stock" :class="{ 'is-invalid': validation.hasError('movie.stock')}" class="form-control" placeholder="Type here the movie stock">
        <div class="text-danger font-weight-bold">{{ validation.firstError('movie.stock') }}</div>
    </div>

    <div class="form-group">
        <label class="text-muted font-weight-bold" for="movie.rental_price">Rental Price</label>
        <input type="number" step="0.01" v-model="movie.rental_price" id="movie.rental_price" :class="{ 'is-invalid': validation.hasError('movie.rental_price')}" class="form-control" placeholder="Type here the movie Rental Price">
        <div class="text-danger font-weight-bold">{{ validation.firstError('movie.rental_price') }}</div>
    </div>

    <div class="form-group">
        <label class="text-muted font-weight-bold" for="movie.sale_price">Sale Price</label>
        <input type="number" step="0.01" v-model="movie.sale_price" id="movie.sale_price" :class="{ 'is-invalid': validation.hasError('movie.sale_price')}" class="form-control" placeholder="Type here the movie Sale Price">
        <div class="text-danger font-weight-bold">{{ validation.firstError('movie.sale_price') }}</div>
    </div>

    <div class="form-group">
        <label class="text-muted font-weight-bold">Movie Posters</label>
        <b-form-file
            v-model="movie.posters"
            placeholder="Choose a file..."
            drop-placeholder="Drop file here..."
        ></b-form-file>
        <div class="text-danger font-weight-bold">{{ validation.firstError('movie.posters') }}</div>
    </div>

    <br>

    <div class="form-group">
        <input type="submit" class="btn btn-block btn-primary" value="CREATE MOVIE">
    </div>
</form>
</template>

<script>
import SimpleVueValidation from 'simple-vue-validator';
const Validator = SimpleVueValidation.Validator;
Vue.use(SimpleVueValidation);

export default {
    data: function () {
        return {
            movie: {
                title: null,
                description: null,
                availability: false,
                stock: null,
                rental_price: null,
                sale_price: null,
                posters: null
            }
        };
    },

    validators: {
        'movie.title': function (value) {
            return Validator.value(value)
                .required('The movie title field is required.')
                .minLength(3, 'The movie title must be at least length 3.')
                .maxLength(250, 'The movie title must not be over 250 characters.');
        },

        'movie.description': function (value) {
            return Validator.value(value)
                .required('The movie description field is required.')
                .minLength(3, 'The movie description must be at least length 3.')
                .maxLength(750, 'The movie description must not be over 750 characters.');
        },

        'movie.stock': function (value) {
            return Validator.value(value)
                .required('The movie description field is required.')
                .integer('Only integer numbers are allowed.');
        },

        'movie.rental_price': function (value) {
            return Validator.value(value)
                .required('The movie rental price field is required.')
                .float('Only numbers are allowed.');
        },

        'movie.sale_price': function (value) {
            return Validator.value(value)
                .required('The movie rental price field is required.')
                .float('Only integer numbers are allowed.');
        },
        'movie.posters': function (value) {
            return Validator.value(value)
                .required('The movie posters are required.');
        },
    },

    methods: {
        async CreateMovie() {
            var validation = await this.$validate();

            if(validation) {
                var formData = new FormData();
                formData.append('title', this.movie.title);
                formData.append('description', this.movie.description);
                formData.append('availability', this.movie.availability ? 1 : 0);
                formData.append('stock', this.movie.stock);
                formData.append('rental_price', this.movie.rental_price);
                formData.append('sale_price', this.movie.sale_price);
                formData.append('posters', this.movie.posters);

                var token = localStorage.getItem('mt_token');

                const config = {
                    headers: { Authorization: `Bearer ${token}` }
                };

                axios.post('/api/v1/admin/movies', formData, config)
                    .then((res) => {
                        Vue.swal({
                            icon: 'success',
                            title: '¡Great!',
                            text: 'Movie Created succesfully.',
                            showConfirmButton: false,
                            timer: 1500,
                            timerProgressBar: true,
                        });
                        this.$emit('MovieCreated');
                    })
                    .catch(function (error) {
                        Vue.swal({
                            toast: true,
                            icon: 'error',
                            title: '¡Ups!',
                            text: 'Error creating movie.',
                            position: 'bottom-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                        });
                    });
            }
        }
    }
}
</script>