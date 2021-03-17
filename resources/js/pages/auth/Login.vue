<template>
<div>
    <navbar></navbar>

    <div class="container pt-5 mt-5">
        <div class="row justify-content-center">
            <div class="col-md-4 col-sm-12 card card-body shadow">
                <form @submit.prevent="Login">
                    <div class="form-group">
                        <img src="/logo.png" style="max-width: 120px;" class="d-block m-auto" alt="">
                        <h2 class="font-weight-bold text-center text-muted my-4">¡WELCOME BACK!</h2>
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold text-muted" for="email"><i class="fas fa-envelope-open-text"></i>&nbsp;Email</label>
                        <input type="email" v-model="user.email" :class="{ 'is-invalid': validation.hasError('user.email')}" class="form-control" placeholder="user@movietime.com">
                        <div class="text-danger font-weight-bold">{{ validation.firstError('user.email') }}</div>
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold text-muted" for="password"><i class="fas fa-unlock-alt"></i>&nbsp;Password</label>
                        <input type="password" v-model="user.password" :class="{ 'is-invalid': validation.hasError('user.password')}" class="form-control" placeholder="Type your password">
                        <div class="text-danger font-weight-bold">{{ validation.firstError('user.password') }}</div>
                    </div>

                    <div class="form-group my-3">
                        <p class="text-muted text-center">Don't you have an account yet? <router-link to="register" tag="a">Sign Up</router-link> </p>
                    </div>

                    <div class="form-group my-4">
                        <input type="submit" class="btn btn-block btn-primary" value="SIGN IN">
                    </div>

                    <div class="form-group my-4">
                        <router-link to="forgot-password" tag="button" class="btn btn-block btn-secondary">
                            FORGOT PASSWORD
                        </router-link>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</template>

<script>
import SimpleVueValidation from 'simple-vue-validator';
const Validator = SimpleVueValidation.Validator;
Vue.use(SimpleVueValidation);

export default {
    data: function () {
        return {
            user: {
                email: null,
                password: null
            }
        };
    },

    validators: {
        'user.email': function (value) {
            return Validator.value(value)
                .required('The email field is required.')
                .minLength(3, 'The email must be at least length 3.')
                .maxLength(255, 'The email must not be over 250 characters.')
                .email('Please type a correct email.');
        },

        'user.password': function (value) {
            return Validator.value(value)
                .required('The password field is required.')
                .minLength(8, 'The password must be at least length.');
        },
    },

    methods: {
        async Login() {
            var validation = await this.$validate();

            if(validation) {
                var formData = new FormData();
                formData.append('email', this.user.email);
                formData.append('password', this.user.password);

                axios.post('/api/v1/auth/login', formData)
                    .then((res) => {
                        localStorage.setItem('mt_token', res.data.access_token);
                        localStorage.setItem('mt_user', JSON.stringify(res.data.user));
                        this.$router.push('/');
                    })
                    .catch(function (error) {
                        Vue.swal({
                            toast: true,
                            icon: 'error',
                            title: '¡Ups!',
                            text: 'Authentication Error.',
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
