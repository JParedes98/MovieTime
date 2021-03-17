<template>
<div>
    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Repudiandae a ullam autem quibusdam rerum corrupti non repellat quaerat ad impedit, voluptatum velit architecto, sed natus, quisquam nostrum consequatur praesentium laboriosam.
</div>
</template>

<script>
    export default {
        props: [
            'movie', 'user'
        ],

        methods: {
            // GetMovies(page = 1) {
            //     axios.get('/api/v1/movies?page=' + page)
            //         .then((res) => {
            //             this.movies = res.data;
            //         })
            //         .catch(function (error) {
            //             console.log(error);
            //             Vue.swal({
            //                 toast: true,
            //                 icon: 'error',
            //                 title: '¡Ups!',
            //                 text: 'No se pudo cargar su informacion.',
            //                 position: 'bottom-end',
            //                 showConfirmButton: false,
            //                 timer: 3000,
            //                 timerProgressBar: true,
            //             });
            //         });
            // }
        }
    }

</script>
