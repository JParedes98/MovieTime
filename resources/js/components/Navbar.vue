<template>
    <nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-primary shadow">
        <div class="container">
            <router-link class="navbar-brand" tag="a" to="/">
                <img src="/logo.png" width="35px" alt="">
                <span class="font-weight-bolder" style="vertical-align: middle; font-size: 18px;">MOVIE TIME</span>
            </router-link>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item" v-show="user && user.is_admin">
                        <router-link tag="a" to="/users" class="nav-link" style="font-size: 18px;">
                            Admin Users |
                        </router-link>
                    </li>

                    <li class="nav-item" v-show="!user">
                        <router-link tag="a" to="/login" class="nav-link" style="font-size: 18px;">
                            Login |
                        </router-link>
                    </li>
                    <li class="nav-item dropdown" v-show="!user">
                        <router-link tag="a" to="/register" class="nav-link" style="font-size: 18px;">
                            Register
                        </router-link>
                    </li>
                    <li class="nav-item dropdown" v-show="user">
                        <a href="#" @click="Logout" class="nav-link" style="font-size: 18px;">
                            Logout
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script>
    export default {
        props: ['user'],

        methods: {
            Logout() {
                axios.post('/api/v1/auth/logout')
                    .then((res) => {
                        localStorage.removeItem('mt_token');
                        localStorage.removeItem('mt_user');
                        this.$router.push('/login');
                    })
                    .catch(function (error) {
                        console.log(error);
                        Vue.swal({
                            toast: true,
                            icon: 'error',
                            title: '¡Ups!',
                            text: 'Error signing out.',
                            position: 'bottom-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                        });
                    });
            }
        },
    }

</script>
