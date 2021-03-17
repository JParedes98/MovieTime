<template>
<div>
    <navbar></navbar>

    <div class="container pt-5 mt-5">
        <div class="row justify-content-center">
            <div class="col-md-4 col-sm-12 card card-body shadow">
                <form @submit.prevent="Register">
                    <div class="form-group">
                        <img src="/logo.png" style="max-width: 120px;" class="d-block m-auto" alt="">
                        <h2 class="font-weight-bold text-center text-muted my-4">¡NEW ACCOUNT!</h2>
                    </div>

                    <div class="form-group" v-if="email_verification">
                        <b-alert class="text-center my-4" variant="primary" show dismissible>
                            We sent you and email to verify your account.
                        </b-alert>
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold text-muted" for="name"><i class="far fa-user"></i>&nbsp;Name</label>
                        <input type="text" v-model="name" :class="{ 'is-invalid': validation.hasError('name')}" class="form-control" id="name" placeholder="Jose Paredes">
                        <div class="text-danger font-weight-bold">{{ validation.firstError('name') }}</div>
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold text-muted" for="email"><i class="fas fa-envelope-open-text"></i>&nbsp;Email</label>
                        <input type="email" v-model="email" :class="{ 'is-invalid': validation.hasError('email')}" class="form-control" id="email" placeholder="user@movietime.com">
                        <div class="text-danger font-weight-bold">{{ validation.firstError('email') }}</div>
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold text-muted" for="password"><i class="fas fa-unlock-alt"></i>&nbsp;Password</label>
                        <input type="password" v-model="password" :class="{ 'is-invalid': validation.hasError('password')}" class="form-control" id="password" placeholder="Type your password">
                        <div class="text-danger font-weight-bold">{{ validation.firstError('password') }}</div>
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold text-muted" for="repeat"><i class="fas fa-unlock-alt"></i>&nbsp;Confirm Password</label>
                        <input type="password" v-model="repeat" :class="{ 'is-invalid': validation.hasError('repeat')}" class="form-control" id="repeat" placeholder="Confirm your password">
                        <div class="text-danger font-weight-bold">{{ validation.firstError('repeat') }}</div>
                    </div>

                    <div class="form-group my-3">
                        <p class="text-muted text-center">I have an account already? <router-link to="login" tag="a">Sign In</router-link> </p>
                    </div>

                    <div class="form-group">
                        <input type="submit" class="btn btn-block btn-primary" value="REGISTER">
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
            name: '',
            email: '',
            password: '',
            repeat: '',
            email_verification: false,
        };
    },

    validators: {
        'name': function (value) {
            return Validator.value(value)
                .required('The name field is required.')
                .maxLength(250, 'The name must not be over 250 characters.');
        },

        'email': function (value) {
            return Validator.value(value)
                .required('The email field is required.')
                .minLength(3, 'The email must be at least length 3.')
                .maxLength(255, 'The email must not be over 250 characters.')
                .email('Please type a correct email.');
        },

        'password': function (value) {
            return Validator.value(value)
                .required('The password field is required.')
                .minLength(8, 'The password must be at least length.');
        },

        'repeat, password': function (repeat, password) {
            return Validator.value(repeat)
                .required('Plase confirm your password.')
                .match(password, 'Password confirmation do not match.');
        }
    },

    methods: {
        async Register() {
            var validation = await this.$validate();

            if(validation) {
                var formData = new FormData();
                formData.append('name', this.name);
                formData.append('email', this.email);
                formData.append('password', this.password);
                formData.append('password_confirmation', this.repeat);

                axios.post('/api/v1/auth/register', formData)
                    .then((res) => {
                        Vue.swal({
                            icon: 'success',
                            title: '¡Great!',
                            text: 'Welcome to Movie Time. We sent you an email verification, please verify your account.',
                            showConfirmButton: false,
                            timer: 5000,
                            timerProgressBar: true,
                        });
                        this.email_verification = true;
                    })
                    .catch(function (error) {
                        console.log(error);
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
